<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    protected $table = 'funcionarios';

    protected $fillable = [
        'utilizador_id',
        'cargo',
        'departamento',
        'data_admissao',
    ];

    public function utilizador()
    {
        return $this->belongsTo(Utilizador::class);
    }
}

