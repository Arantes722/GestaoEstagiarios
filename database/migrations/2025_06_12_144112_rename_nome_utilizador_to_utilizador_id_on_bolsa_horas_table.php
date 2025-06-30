<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('bolsa_horas', function (Blueprint $table) {
            // Renomear a coluna nomeUtilizador para utilizador_id
            $table->renameColumn('nomeUtilizador', 'utilizador_id');
        });
    }

    public function down()
    {
        Schema::table('bolsa_horas', function (Blueprint $table) {
            // Reverter o nome da coluna para o original
            $table->renameColumn('utilizador_id', 'nomeUtilizador');
        });
    }
};
