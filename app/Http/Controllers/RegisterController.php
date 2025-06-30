<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Utilizador;

class RegisterController extends Controller
{
    public function create()
    {
        return view('register.create');
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'nome' => 'required|max:255',
            'email' => 'required|email|max:255|unique:utilizadores,email',
            'senha' => 'required|min:5|max:255',
        ]);

        $utilizador = Utilizador::create([
            'nome' => $attributes['nome'],
            'email' => $attributes['email'],
            'senha' => bcrypt($attributes['senha']),
        ]);

        auth()->login($utilizador);

        return redirect('/dashboard');
    }
}
