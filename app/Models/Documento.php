<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Utilizador;  

class Documento extends Model
{
    protected $fillable = [
        'titulo',
        'tipo',
        'tamanho',
        'utilizador_id',
        'caminho',
        'status'
    ];

    public function getPathAttribute()
    {
        return $this->attributes['caminho'];
    }

    public function setPathAttribute($value)
    {
        $this->attributes['caminho'] = $value;
    }

    public function utilizador()
    {
        return $this->belongsTo(Utilizador::class, 'utilizador_id');
    }
}
