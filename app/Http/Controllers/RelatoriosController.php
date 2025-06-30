<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Estagio;
use App\Models\Presenca;
use App\Models\Relatorio;
use App\Models\Falta;
use Barryvdh\DomPDF\Facade\Pdf;

class RelatoriosController extends Controller
{
    public function index()
    {
        $estagiarioId = auth()->user()->id;

        $estagio = \DB::table('estagios')
            ->where('estagiario_id', $estagiarioId)
            ->first();

        $totalHoras = \DB::table('presencas')
            ->where('utilizador_id', $estagiarioId)
            ->where('status', 'aprovado')
            ->sum('horas');

        $totalPresencas = \DB::table('presencas')
            ->where('utilizador_id', $estagiarioId)
            ->where('status', 'aprovado')
            ->count();

        $faltasJustificadas = \DB::table('faltas')
            ->where('utilizador_id', $estagiarioId)
            ->where('tipo_falta', 'justificada')
            ->where('status', 'aprovado')
            ->count();

        $faltasInjustificadas = \DB::table('faltas')
            ->where('utilizador_id', $estagiarioId)
            ->where('tipo_falta', 'injustificada')
            ->where('status', 'aprovado')
            ->count();

        $historicoRelatorios = Relatorio::where('utilizador_id', $estagiarioId)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('relatorios.index', compact(
            'estagio',
            'totalHoras',
            'totalPresencas',
            'faltasJustificadas',
            'faltasInjustificadas',
            'historicoRelatorios'
        ));
    }

    public function exportarPDF()
    {
        $user = Auth::user();

        $estagio = Estagio::where('estagiario_id', $user->id)->first();

        $totalHoras = Presenca::where('utilizador_id', $user->id)
            ->where('status', 'aprovado')
            ->sum('horas');

        $totalPresencas = Presenca::where('utilizador_id', $user->id)
            ->where('status', 'aprovado')
            ->count();

        $faltasJustificadas = Falta::where('utilizador_id', $user->id)
            ->where('tipo_falta', 'justificada')
            ->where('status', 'aprovado')
            ->count();

        $faltasInjustificadas = Falta::where('utilizador_id', $user->id)
            ->where('tipo_falta', 'injustificada')
            ->where('status', 'aprovado')
            ->count();

        $presencas = Presenca::where('utilizador_id', $user->id)
            ->orderBy('data', 'desc')->get();

        $dados = compact(
            'estagio',
            'totalHoras',
            'totalPresencas',
            'faltasJustificadas',
            'faltasInjustificadas',
            'presencas'
        );

        $pdf = Pdf::loadView('relatorios.pdf', $dados);

        $nomeRelatorio = 'relatorio_estagio_' . now()->format('Ymd_His') . '.pdf';
        $caminho = $user->id . '/' . $nomeRelatorio;

        Storage::disk('relatorios')->put($caminho, $pdf->output());

        Relatorio::create([
            'estagiario_id' => $user->id,
            'nome' => $nomeRelatorio,
            'caminho' => $caminho,
            'status' => 'gerado',
        ]);

        return response()->download(storage_path('app/relatorios/' . $caminho));
    }

    public function download($id)
    {
        $userId = auth()->id();

        $relatorio = Relatorio::where('id', $id)
            ->where('estagiario_id', $userId)
            ->firstOrFail();

        $filePath = storage_path('app/' . $relatorio->caminho);

        if (!file_exists($filePath)) {
            abort(404, 'Ficheiro não encontrado.');
        }

        return response()->download($filePath, $relatorio->nome);
    }

    public function visualizar($id)
    {
        $userId = auth()->id();

        $relatorio = Relatorio::where('id', $id)
            ->where('estagiario_id', $userId)
            ->firstOrFail();

        $filePath = storage_path('app/' . $relatorio->caminho);

        if (!file_exists($filePath)) {
            abort(404, 'Ficheiro não encontrado.');
        }

        return response()->file($filePath, [
            'Content-Type' => mime_content_type($filePath),
            'Content-Disposition' => 'inline; filename="' . basename($filePath) . '"'
        ]);
    }

    public function showRelatorio()
    {
        $user = auth()->user();
        $estagio = Estagio::where('user_id', $user->id)->first();

        // Se quiser, conte as presenças aprovadas e some horas:
        $presencas = Presenca::where('user_id', $user->id)
            ->where('status', 'aprovado')
            ->get();

        $horasCumpridas = $presencas->sum('horas');
        $presencasRegistadas = $presencas->count();

        return view('relatorio', [
            'estagio' => $estagio,
            'horasCumpridas' => $horasCumpridas,
            'presencasRegistadas' => $presencasRegistadas,
        ]);
    }
}
