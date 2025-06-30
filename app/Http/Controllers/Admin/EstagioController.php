<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Estagio;
use App\Models\Estagiario;
use App\Models\Presenca;

class EstagioController extends Controller
{
    /**
     * Mostrar todos os estágios.
     */
    public function index(Request $request)
    {
        $query = Estagio::with('estagiario');

        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('estagiario', function ($q) use ($search) {
                $q->where('nome', 'like', '%' . $search . '%');
            })->orWhere('orientador', 'like', '%' . $search . '%');
        }

        if ($request->has('order') && in_array($request->order, ['asc', 'desc'])) {
            $query->orderBy('created_at', $request->order);
        } else {
            $query->latest();
        }

        $estagios = $query->paginate(10);
        $estagiarios = Estagiario::all();

        // Adicionar dinamicamente as horas e presenças aprovadas
        foreach ($estagios as $estagio) {
            if ($estagio->estagiario) {
                $userId = $estagio->estagiario->user_id;

                $presencas = Presenca::where('utilizador_id', $userId)
                    ->where('status', 'aprovado')
                    ->get();

                $estagio->horas_cumpridas = $presencas->sum('horas');
                $estagio->presencas_registadas = $presencas->count();
            } else {
                $estagio->horas_cumpridas = 0;
                $estagio->presencas_registadas = 0;
            }
        }

        return view('admin.estagios.index', compact('estagios', 'estagiarios'));
    }

    /**
     * Guardar um novo estágio.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'estagiario_id' => 'required|exists:estagiarios,id|unique:estagios,estagiario_id',
            'orientador' => 'required|string|max:255',
            'supervisor' => 'nullable|string|max:255',
            'horas_cumprir' => 'required|numeric|min:1',
            'horas_cumpridas' => 'nullable|numeric|min:0',
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after_or_equal:data_inicio',
            'escola' => 'nullable|string|max:255',
            'instituicao_acolhimento' => 'nullable|string|max:255',
            'presencas_registadas' => 'nullable|string',
        ]);

        Estagio::create($validated);

        return redirect()->route('admin.estagios.index')->with('success', 'Estágio criado com sucesso.');
    }

    /**
     * Atualizar um estágio.
     */
    public function update(Request $request, string $id)
    {
        $estagio = Estagio::findOrFail($id);

        $validated = $request->validate([
            'orientador' => 'required|string|max:255',
            'supervisor' => 'nullable|string|max:255',
            'horas_cumprir' => 'required|numeric|min:1',
            'horas_cumpridas' => 'nullable|numeric|min:0',
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after_or_equal:data_inicio',
            'escola' => 'nullable|string|max:255',
            'instituicao_acolhimento' => 'nullable|string|max:255',
            'presencas_registadas' => 'nullable|string',
        ]);

        $estagio->update($validated);

        return redirect()->route('admin.estagios.index')->with('success', 'Estágio atualizado com sucesso.');
    }

    /**
     * Mostrar os detalhes de um estágio.
     */
    public function show(string $id)
    {
        $estagio = Estagio::findOrFail($id);
        return view('admin.estagios.show', compact('estagio'));
    }

    /**
     * Mostrar o formulário de edição de um estágio.
     */
    public function edit(string $id)
    {
        $estagio = Estagio::findOrFail($id);
        return view('admin.estagios.edit', compact('estagio'));
    }

    /**
     * Eliminar um estágio.
     */
    public function destroy(string $id)
    {
        $estagio = Estagio::findOrFail($id);
        $estagio->delete();

        return redirect()->route('admin.estagios.index')->with('success', 'Estágio eliminado com sucesso.');
    }
}
