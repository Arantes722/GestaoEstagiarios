<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Presenca;
use Illuminate\Http\Request;

class PresencaController extends Controller
{
    public function index()
    {
        $presencas = Presenca::whereRaw('LOWER(TRIM(status)) = ?', ['pendente'])
            ->orderBy('dataRegisto', 'desc')
            ->paginate(10, ['*'], 'pendentes_page');

        $todasPresencas = Presenca::orderBy('dataRegisto', 'desc')
            ->paginate(10, ['*'], 'todas_page');

        return view('admin.presencas.pendentes', compact('presencas', 'todasPresencas'))
            ->with('activePage', 'admin-presencas-index');
    }


    public function pendentes()
    {
        $presencas = Presenca::whereRaw('LOWER(TRIM(status)) = ?', ['pendente'])
            ->orderBy('dataRegisto', 'desc')
            ->paginate(10);

        return view('admin.presencas.pendentes', compact('presencas'))
            ->with('activePage', 'admin-presencas-pendentes');
    }

    public function aprovar($id)
    {
        $presenca = Presenca::findOrFail($id);
        $presenca->status = 'aprovado';
        $presenca->save();

        return redirect()->back()->with('success', 'Presença aprovada com sucesso.');
    }

    public function rejeitar($id)
    {
        $presenca = Presenca::findOrFail($id);
        $presenca->status = 'rejeitado';
        $presenca->save();

        return redirect()->back()->with('success', 'Presença rejeitada com sucesso.');
    }
}
