<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presenca extends Model
{
    protected $table = 'presencas';

    protected $fillable = [
        'data',
        'hora_inicio',
        'hora_fim',
        'local',
        'descricao',
        'status',
        'data_registo',      
        'nome',
        'utilizador_id',
        'horas',
        'comentarios_admin', 
    ];

    protected $casts = [
        'data' => 'date',
        'hora_inicio' => 'datetime:H:i:s',
        'hora_fim' => 'datetime:H:i:s',
        'data_registo' => 'datetime',
    ];

    // Relacionamento opcional para o estagiário (ou utilizador)
    public function estagiario()
    {
        return $this->belongsTo(Estagiario::class, 'utilizador_id', 'id');
    }
}
