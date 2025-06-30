<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Presenca;
use App\Models\Estagiario;
use App\Models\Utilizador;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = Presenca::query();

        if ($request->filled('search_nome')) {
            $query->where('nome', 'like', '%' . $request->search_nome . '%');
        }

        if ($request->filled('filter_status')) {
            $query->where('status', $request->filter_status);
        }

        $ultimosRegistos = $query->latest('dataRegisto')->take(20)->get();

        return view('admin.dashboard', [
            'totalEstagiarios' => Estagiario::count(),
            'presencasPendentes' => Presenca::where('status', 'pendente')->count(),
            'totalHorasRegistadas' => Presenca::where('status', 'aprovado')->sum('horas'),
            'ultimosRegistos' => $ultimosRegistos,
        ]);
    }

    public function aprovar($id)
    {
        $registro = Presenca::findOrFail($id);
        $registro->status = 'aprovado';
        $registro->save();

        return redirect()->route('admin.dashboard')->with('success', 'Presença aprovada com sucesso.');
    }

    public function rejeitar($id)
    {
        $registro = Presenca::findOrFail($id);
        $registro->status = 'rejeitado';
        $registro->save();

        return redirect()->route('admin.dashboard')->with('success', 'Presença rejeitada.');
    }
}
