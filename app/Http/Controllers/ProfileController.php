<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function create()
    {
        $user = Auth::user();

        // Corrigido: procurar estagio pelo estagiario_id = user->id
        $estagio = DB::table('estagios')->where('estagiario_id', $user->id)->first();

        return view('pages.profile', [
            'user' => $user,
            'estagio' => $estagio,
        ]);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $attributes = $request->validate([
            // Usar id em vez de utilizador_id para a chave primária
            'email' => 'required|email|unique:utilizadores,email,' . $user->id . ',id',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:10',
            'about' => 'required|string|max:150',
            'location' => 'required|string|max:255',
        ]);

        $user->update($attributes);

        return back()->with('status', 'Perfil atualizado com sucesso.');
    }

    public function uploadPhoto(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        if ($request->hasFile('foto')) {
            if ($user->foto && Storage::disk('public')->exists($user->foto)) {
                Storage::disk('public')->delete($user->foto);
            }

            $fotoPath = $request->file('foto')->store('fotos_perfil', 'public');
            $user->foto = $fotoPath;
            $user->save();
        }

        return redirect()->back()->with('success', 'Foto de perfil atualizada com sucesso!');
    }
}
