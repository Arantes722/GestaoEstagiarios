<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Estagiario extends Authenticatable
{
    protected $table = 'estagiarios';

    protected $fillable = [
        'nome',
        'email',
        'password',
        'telemovel',
        'morada',
        'data_nascimento',
        'documento_identificacao',
        'nif',
        'curso',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function estagio()
    {
        return $this->hasOne(Estagio::class, 'estagiario_id');
    }

    public function registoCompleto()
    {
        $estagio = $this->estagio;

        if (!$estagio) {
            return false;
        }

        $camposObrigatorios = [
            'orientador',
            'supervisor',
            'horas_cumprir',
            'data_inicio',
            'data_fim',
            'escola',
            'instituicao_acolhimento',
        ];

        foreach ($camposObrigatorios as $campo) {
            if (empty($estagio->$campo)) {
                return false;
            }
        }

        return true;
    }

    public function horasHojeFormatado()
    {
        $hoje = Carbon::today()->toDateString();

        $horas = DB::table('presencas')
            ->where('utilizador_id', $this->id)
            ->where('data', $hoje)
            ->where('status', 'aprovado')
            ->sum('horas');

        return $this->formatarHoras($horas);
    }

    public function diffHojeOntemTexto()
    {
        $hoje = Carbon::today()->toDateString();
        $ontem = Carbon::yesterday()->toDateString();

        $horasHoje = DB::table('presencas')
            ->where('utilizador_id', $this->id)
            ->where('data', $hoje)
            ->where('status', 'aprovado')
            ->sum('horas');

        $horasOntem = DB::table('presencas')
            ->where('utilizador_id', $this->id)
            ->where('data', $ontem)
            ->where('status', 'aprovado')
            ->sum('horas');

        $diff = $horasHoje - $horasOntem;

        return $this->formatarDiferencaHoras($diff);
    }

    public function horasRestantesFormatado()
    {
        $total = $this->totalHoras(); 

        $cumpridas = DB::table('presencas')
            ->where('utilizador_id', $this->id)
            ->where('status', 'aprovado')
            ->sum('horas');

        $restantes = max($total - $cumpridas, 0);

        return $this->formatarHoras($restantes);
    }

    public function presencasRegistadas()
    {
        return DB::table('presencas')
            ->where('utilizador_id', $this->id)
            ->where('status', 'aprovado')   
            ->count();
    }

    public function diffPresencasSemanaTexto()
    {
        $inicioSemanaAtual = Carbon::now()->startOfWeek()->toDateString();
        $fimSemanaAtual = Carbon::now()->endOfWeek()->toDateString();

        $inicioSemanaAnterior = Carbon::now()->subWeek()->startOfWeek()->toDateString();
        $fimSemanaAnterior = Carbon::now()->subWeek()->endOfWeek()->toDateString();

        $presencasSemanaAtual = DB::table('presencas')
            ->where('utilizador_id', $this->id)   
            ->whereBetween('data', [$inicioSemanaAtual, $fimSemanaAtual])
            ->count();

        $presencasSemanaAnterior = DB::table('presencas')
            ->where('utilizador_id', $this->id)  
            ->whereBetween('data', [$inicioSemanaAnterior, $fimSemanaAnterior])
            ->count();

        $diff = $presencasSemanaAtual - $presencasSemanaAnterior;

        if ($diff > 0) {
            return "+{$diff}";
        } elseif ($diff < 0) {
            return (string) $diff;
        }

        return "0";
    }

    public function totalHoras()
    {
        $estagio = $this->estagio;
        if ($estagio && !empty($estagio->horas_cumprir)) {
            return (float) $estagio->horas_cumprir;
        }
        return 0;
    }

    private function formatarHoras($horasDecimal)
    {
        $horas = floor($horasDecimal);
        $minutos = round(($horasDecimal - $horas) * 60);

        $resultado = '';

        if ($horas > 0) {
            $resultado .= $horas . 'h';
        }

        if ($minutos > 0) {
            if ($resultado !== '') {
                $resultado .= ' ';
            }
            $resultado .= $minutos . 'm';
        }

        if ($resultado === '') {
            $resultado = '0h';
        }

        return $resultado;
    }

    private function formatarDiferencaHoras($diffDecimal)
    {
        if ($diffDecimal == 0) {
            return '0h';
        }

        $sinal = $diffDecimal > 0 ? '+' : '-';
        $diffDecimal = abs($diffDecimal);

        $horas = floor($diffDecimal);
        $minutos = round(($diffDecimal - $horas) * 60);

        $resultado = $sinal;

        if ($horas > 0) {
            $resultado .= $horas . 'h';
        }

        if ($minutos > 0) {
            if ($horas > 0) {
                $resultado .= ' ';
            }
            $resultado .= $minutos . 'm';
        }

        return $resultado;
    }

    public function presencas()
    {
        return $this->hasMany(Presenca::class, 'utilizador_id', 'id');
    }
}
