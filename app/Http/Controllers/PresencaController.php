<?php

namespace App\Http\Controllers;

use App\Models\Presenca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PresencaController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();

        $query = Presenca::where('utilizador_id', $userId);

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('local', 'like', "%{$search}%")
                    ->orWhere('descricao', 'like', "%{$search}%");
            });
        }

        if ($dateStart = $request->input('date_start')) {
            $query->whereDate('data', '>=', $dateStart);
        }

        if ($dateEnd = $request->input('date_end')) {
            $query->whereDate('data', '<=', $dateEnd);
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $order = $request->input('order', 'desc');
        $order = in_array($order, ['asc', 'desc']) ? $order : 'desc';

        $presencas = $query->orderBy('data', $order)->paginate(4)->withQueryString();

        $baseQuery = Presenca::where('utilizador_id', $userId);

        if ($search) {
            $baseQuery->where(function ($q) use ($search) {
                $q->where('local', 'like', "%{$search}%")
                    ->orWhere('descricao', 'like', "%{$search}%");
            });
        }

        if ($dateStart) {
            $baseQuery->whereDate('data', '>=', $dateStart);
        }

        if ($dateEnd) {
            $baseQuery->whereDate('data', '<=', $dateEnd);
        }

        if ($status) {
            $baseQuery->where('status', $status);
        }

        $totalHoras = (clone $baseQuery)->where('status', 'aprovado')->sum('horas');
        $totalDias = (clone $baseQuery)->where('status', 'aprovado')->distinct('data')->count('data');
        $totalAceites = (clone $baseQuery)->where('status', 'aprovado')->count();
        $totalRecusadas = (clone $baseQuery)->where('status', 'recusado')->count();
        $totalPendentes = (clone $baseQuery)->where('status', 'pendente')->count();

        $presencasTodas = $query->get();

        $eventos = $presencasTodas->map(function ($p) {
            return [
                'title' => trim($p->descricao . ' - ' . ($p->nome ?? '')),
                'start' => $p->data . 'T' . Carbon::parse($p->hora_inicio)->format('H:i:s'),
                'end' => $p->hora_fim ? $p->data . 'T' . Carbon::parse($p->hora_fim)->format('H:i:s') : null,
                'color' => $p->status === 'aprovado' ? '#198754' : ($p->status === 'pendente' ? '#ffc107' : '#dc3545'),
            ];
        })->toArray();  



        return view('presencas.index', [
            'presencas' => $presencas,
            'eventos' => $eventos,
            'totalHoras' => $totalHoras,
            'totalDias' => $totalDias,
            'totalAceites' => $totalAceites,
            'totalRecusadas' => $totalRecusadas,
            'totalPendentes' => $totalPendentes,
            'activePage' => 'presencas',
        ]);
    }

    public function store(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->withErrors('Precisas estar autenticado para registar presença.');
        }

        $request->validate([
            'data' => 'required|date',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fim' => 'required|date_format:H:i|after:hora_inicio',
            'local' => 'required|string|max:255',
            'descricao' => 'required|string|max:255',
        ]);

        $utilizadorId = Auth::id();
        $data = $request->input('data');

        $presencaExistente = Presenca::where('utilizador_id', $utilizadorId)
            ->whereDate('data', $data)
            ->exists();

        if ($presencaExistente) {
            return redirect()->route('presencas.index')->with('message', [
                'type' => 'danger',
                'text' => 'Já registaste uma presença hoje.'
            ]);
        }

        $horas = round(
            Carbon::parse($request->hora_inicio)->diffInMinutes(Carbon::parse($request->hora_fim)) / 60,
            2
        );

        Presenca::create([
            'data' => $data,
            'hora_inicio' => $request->hora_inicio,
            'hora_fim' => $request->hora_fim,
            'local' => $request->local,
            'descricao' => $request->descricao,
            'status' => 'pendente',
            'dataRegisto' => now(),
            'nome' => auth()->user()->nome,
            'utilizador_id' => $utilizadorId,
            'horas' => $horas,
            'comentariosAdmin' => $request->input('comentariosAdmin'),
        ]);

        return redirect()->route('presencas.index')->with('message', [
            'type' => 'warning',
            'text' => 'Presença registada com sucesso! Está pendente e aguarda aprovação do administrador.'
        ]);
    }

    public function cancelar($id)
    {
        $presenca = Presenca::findOrFail($id);

        if ($presenca->utilizador_id !== Auth::id() || strtolower($presenca->status) !== 'pendente') {
            return redirect()->back()->with('message', [
                'type' => 'danger',
                'text' => 'Não tem permissão para cancelar esta presença.',
            ]);
        }

        $presenca->delete();

        return redirect()->back()->with('message', [
            'type' => 'success',
            'text' => 'Presença pendente cancelada com sucesso.',
        ]);
    }
}
