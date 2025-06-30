<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Administrador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdministradorController extends Controller
{
    public function index(Request $request)
    {
        $query = Administrador::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nome', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->order === 'asc') {
            $query->orderBy('created_at', 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $administradores = $query->paginate(10);

        return view('admin.administradores.index', compact('administradores'));
    }


    public function create()
    {
        return view('admin.administradores.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:administradores,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        Administrador::create([
            'nome' => $request->nome,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.administradores.index')->with('success', 'Administrador criado com sucesso!');
    }

    public function edit(Administrador $administrador)
    {
        return view('admin.administradores.edit', compact('administrador'));
    }

    public function update(Request $request, Administrador $administrador)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:administradores,email,' . $administrador->id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $administrador->nome = $request->nome;
        $administrador->email = $request->email;

        if ($request->filled('password')) {
            $administrador->password = Hash::make($request->password);
        }

        $administrador->save();

        return redirect()->route('admin.administradores.index')->with('success', 'Administrador atualizado com sucesso!');
    }

    public function destroy(Administrador $administrador)
    {
        $administrador->delete();
        return redirect()->route('admin.administradores.index')->with('success', 'Administrador eliminado com sucesso!');
    }
}
