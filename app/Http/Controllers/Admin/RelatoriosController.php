<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class RelatoriosController extends Controller
{
    public function index()
    {
        return view('admin.relatorios.index');
    }
}
