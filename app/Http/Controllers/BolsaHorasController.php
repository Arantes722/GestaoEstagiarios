<?php

namespace App\Http\Controllers;

use App\Models\BolsaHoras;

class BolsaHorasController extends Controller
{
    public function pendentes()
    {
        $presencasPendentes = BolsaHoras::where('status', 'pendente')->get();
        return view('admin.presencas.pendentes', compact('presencasPendentes'));
    }
}
