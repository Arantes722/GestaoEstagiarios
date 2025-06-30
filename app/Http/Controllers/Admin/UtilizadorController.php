<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Utilizador;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Estagiario;


class UtilizadorController extends Controller
{
    public function index()
    {
        $utilizadores = Utilizador::paginate(6);
        return view('admin.utilizadores.index', compact('utilizadores'));
    }

    public function create()
    {
        return view('admin.utilizadores.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:utilizadores,email',
            'senha' => 'required|string|confirmed|min:6',
            'tipo_utilizador' => 'required|in:administrador,estagiario',
            'foto' => 'nullable|image|max:2048',
            // Validação dos campos estagiário:
            'horas_a_cumprir' => 'nullable|numeric|min:0',
            'curso' => 'nullable|string|max:255',
            'orientador' => 'nullable|string|max:255',
        ]);

        $data = [
            'nome' => $request->nome,
            'email' => $request->email,
            'senha' => bcrypt($request->senha),
            'tipo_utilizador' => $request->tipo_utilizador,
            'email_verificado_em' => null,
            'remember_token' => Str::random(10),
        ];

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('fotos_utilizadores', 'public');
        }

        // Cria o utilizador
        $utilizador = Utilizador::create($data);

        // Se for estagiário, cria o registo na tabela estagiarios
        if ($utilizador->tipo_utilizador === 'estagiario') {
            Estagiario::create([
                'utilizador_id' => $utilizador->utilizador_id,
                'horas_cumprir' => $request->horas_cumprir ?? 0,
                'curso' => $request->curso ?? null,
                'orientador' => $request->orientador ?? null,
                'data_inicio' => $request->data_inicio ?? null,
                'data_fim' => $request->data_fim ?? null,
                'entidade_acolhimento' => $request->entidade_acolhimento ?? null,
                'registo_completo' => false, 
            ]);
        }


        return redirect()->route('admin.utilizadores.index')->with('success', 'Utilizador criado com sucesso.');
    }
    public function edit($id)
    {
        $utilizador = Utilizador::findOrFail($id);
        return view('admin.utilizadores.edit', compact('utilizador'));
    }

    public function update(Request $request, $id)
    {
        $utilizador = Utilizador::findOrFail($id);

        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:utilizadores,email,' . $utilizador->utilizador_id . ',utilizador_id',
            'foto' => 'nullable|image|max:2048',
            'senha' => 'nullable|string|min:6|confirmed',
            'tipo_utilizador' => 'required|in:administrador,estagiario',
        ]);

        $utilizador->nome = $validated['nome'];
        $utilizador->email = $validated['email'];
        $utilizador->tipo_utilizador = $validated['tipo_utilizador'];

        if (!empty($validated['senha'])) {
            $utilizador->senha = bcrypt($validated['senha']);
        }

        if ($request->hasFile('foto')) {
            if (!empty($utilizador->foto)) {
                Storage::disk('public')->delete($utilizador->foto);
            }
            $utilizador->foto = $request->file('foto')->store('fotos_utilizadores', 'public');
        }

        $utilizador->save();

        return redirect()->route('admin.utilizadores.index')->with('success', 'Utilizador atualizado com sucesso.');
    }

    public function destroy($id)
    {
        $utilizador = Utilizador::findOrFail($id);

        if (!empty($utilizador->foto)) {
            Storage::disk('public')->delete($utilizador->foto);
        }

        $utilizador->delete();

        return redirect()->route('admin.utilizadores.index')->with('success', 'Utilizador eliminado com sucesso.');
    }
}
