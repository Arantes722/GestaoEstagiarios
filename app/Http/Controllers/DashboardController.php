<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estagiario;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $estagiario = Auth::guard('estagiario')->user()->load('estagio');

        if (!$estagiario) {
            abort(403, 'Não autorizado');
        }

        $estagio = $estagiario->estagio;

        if (!$estagio) {
            abort(404, 'Estágio não encontrado para este estagiário');
        }

        $horasCumprir = $estagio->horas_cumprir;

        $horasRegistadas = $estagiario->presencas()
            ->where('status', 'aprovado')
            ->sum('horas');

        $presencasRegistadas = $estagiario->presencas()
            ->where('status', 'aprovado')
            ->get();

        $totalPresencas = $presencasRegistadas->count();

        $horasRestantes = max($horasCumprir - $horasRegistadas, 0);

        $horasHojeFormatado = $estagiario->horasHojeFormatado();
        $diffHojeOntemTexto = $estagiario->diffHojeOntemTexto();
        $diffPresencasSemanaTexto = $estagiario->diffPresencasSemanaTexto();

        return view('dashboard.index', [
            'estagiario' => $estagiario,
            'estagio' => $estagio,
            'horasCumprir' => $horasCumprir,
            'horasRegistadas' => $horasRegistadas,
            'horasRestantes' => $horasRestantes,
            'horasHojeFormatado' => $horasHojeFormatado,
            'diffHojeOntemTexto' => $diffHojeOntemTexto,
            'diffPresencasSemanaTexto' => $diffPresencasSemanaTexto,
            'presencasRegistadas' => $presencasRegistadas,
            'totalPresencas' => $totalPresencas,
        ]);
    }

}
