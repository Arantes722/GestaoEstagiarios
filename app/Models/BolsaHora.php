<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BolsaHora extends Model
{
    use HasFactory;

    protected $table = 'bolsa_horas'; 

    protected $fillable = [
        'data',
        'descricao',
        'horas',
        'nomeUtilizador',
        'status',
        'dataRegisto',
        'comentariosAdmin',
        'local',
        'hora_inicio',
        'hora_fim',
        'nome'
    ];

    protected $casts = [
        'data' => 'date',
        'dataRegisto' => 'datetime',
        'hora_inicio' => 'datetime:H:i',
        'hora_fim' => 'datetime:H:i',
    ];
}
