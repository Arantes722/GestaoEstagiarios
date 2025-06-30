<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Estagiario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EstagiarioController extends Controller
{
    protected $validationRules = [
        'nome' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'telemovel' => 'nullable|string|max:20',
        'morada' => 'nullable|string',
        'data_nascimento' => 'nullable|date',
        'documento_identificacao' => 'nullable|string|max:255',
        'nif' => 'nullable|string|size:9|regex:/^[0-9]+$/',
        'curso' => 'required|string|max:255',
    ];

    protected $validationMessages = [
        'required' => 'O campo :attribute é obrigatório.',
        'email' => 'O :attribute deve ser um endereço de e-mail válido.',
        'max' => 'O campo :attribute não pode ter mais que :max caracteres.',
        'date' => 'O campo :attribute deve ser uma data válida.',
        'nif.size' => 'O NIF deve ter exatamente 9 dígitos.',
        'nif.regex' => 'O NIF deve conter apenas números.',
        'unique' => 'Este :attribute já está em uso.',
        'min' => 'O campo :attribute deve ter pelo menos :min caracteres.',
    ];

    public function index()
    {
        $estagiarios = Estagiario::orderBy('nome')->paginate(10);
        return view('admin.estagiarios.index', compact('estagiarios'));
    }

    public function create()
    {
        return view('admin.estagiarios.create');
    }

    public function store(Request $request)
    {
        try {
            $this->validationRules['email'] = 'required|email|unique:estagiarios,email|max:255';
            $this->validationRules['password'] = 'required|string|min:6|max:255';

            $validated = $request->validate($this->validationRules, $this->validationMessages);

            $validated['password'] = bcrypt($validated['password']);

            Log::info('Tentativa de criar estagiário com dados:', $validated);

            $estagiario = Estagiario::create($validated);

            Log::info('Estagiário criado com ID: ' . $estagiario->id);

            return redirect()->route('admin.estagiarios.index')
                ->with('success', 'Estagiário criado com sucesso!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Erro de validação ao criar estagiário: ' . $e->getMessage());
            return back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            Log::error('Erro ao criar estagiário: ' . $e->getMessage());
            return back()->with('error', 'Erro ao criar estagiário. Por favor, tente novamente.')->withInput();
        }
    }

    public function edit(Estagiario $estagiario)
    {
        return view('admin.estagiarios.edit', compact('estagiario'));
    }

    public function update(Request $request, Estagiario $estagiario)
    {
        try {
            $this->validationRules['email'] = 'required|email|max:255|unique:estagiarios,email,' . $estagiario->id;
            $this->validationRules['password'] = 'nullable|string|min:6|max:255';

            $validated = $request->validate($this->validationRules, $this->validationMessages);

            if (!empty($validated['password'])) {
                $validated['password'] = bcrypt($validated['password']);
            } else {
                unset($validated['password']);
            }

            Log::info('Atualizando estagiário ID: ' . $estagiario->id . ' com dados:', $validated);

            $estagiario->update($validated);

            return redirect()->route('admin.estagiarios.index')
                ->with('success', 'Estagiário atualizado com sucesso!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Erro de validação ao atualizar estagiário ID: ' . $estagiario->id . ' - ' . $e->getMessage());
            return back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar estagiário ID: ' . $estagiario->id . ' - ' . $e->getMessage());
            return back()->with('error', 'Erro ao atualizar estagiário. Por favor, tente novamente.')->withInput();
        }
    }

    public function destroy(Estagiario $estagiario)
    {
        try {
            Log::info('Excluindo estagiário ID: ' . $estagiario->id);

            $estagiario->delete();

            return redirect()->route('admin.estagiarios.index')
                ->with('success', 'Estagiário excluído com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao excluir estagiário ID: ' . $estagiario->id . ' - ' . $e->getMessage());
            return back()->with('error', 'Erro ao excluir estagiário. Por favor, tente novamente.');
        }
    }
}
