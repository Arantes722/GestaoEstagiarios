<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Presenca;

class Estagio extends Model
{
    use HasFactory;

    protected $table = 'estagios';

    protected $fillable = [
        'estagiario_id',
        'orientador',
        'supervisor',
        'horas_cumprir',
        'horas_cumpridas',            
        'data_inicio',
        'data_fim',
        'escola',
        'instituicao_acolhimento',
        'plano_estagio',
    ];

    protected $casts = [
        'data_inicio' => 'date',
        'data_fim' => 'date',
    ];

    public function estagiario()
    {
        return $this->belongsTo(Estagiario::class, 'estagiario_id');
    }

    public function horasCumpridas()
    {
        return $this->horas_cumpridas ?? 0;
    }

    public function totalPresencas()
    {
        return Presenca::where('utilizador_id', $this->estagiario_id)->count();
    }

    public function estado()
    {
        return $this->horasCumpridas() >= $this->horas_cumprir ? 'Concluído' : 'Ativo';
    }
}
