<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class Utilizador extends Authenticatable
{
    use Notifiable;

    protected $table = 'utilizadores';

    protected $primaryKey = 'utilizador_id';

    protected $fillable = [
        'nome',
        'email',
        'senha',
        'tipo_utilizador',
        'email_verified_at',
    ];

    protected $hidden = [
        'senha',
        'remember_token',
    ];

    /**
     * Retorna a senha para autenticação.
     */
    public function getAuthPassword()
    {
        return $this->senha;
    }

    /**
     * Faz hash automático da senha ao atribuir.
     */
    public function setSenhaAttribute($value)
    {
        if (!empty($value)) {
            if (Hash::needsRehash($value)) {
                $this->attributes['senha'] = bcrypt($value);
            } else {
                $this->attributes['senha'] = $value;
            }
        }
    }

    /**
     * Verifica se o utilizador é administrador.
     */
    public function isAdmin()
    {
        return $this->tipo_utilizador === 'administrador';
    }

    /**
     * Verifica se o utilizador é estagiário.
     */
    public function isEstagiario()
    {
        return $this->tipo_utilizador === 'estagiario';
    }

    /**
     * Relação 1:1 com estagiário (informações específicas).
     */
    public function estagiario()
    {
        return $this->hasOne(Estagiario::class, 'utilizador_id', 'utilizador_id');
    }
}
