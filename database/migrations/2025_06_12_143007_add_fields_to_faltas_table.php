<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('faltas', function (Blueprint $table) {
            $table->string('nomeUtilizador')->nullable();
            $table->enum('tipo_falta', ['justificada', 'injustificada'])->default('injustificada');
            $table->enum('status', ['pendente', 'aprovado', 'rejeitado'])->default('pendente');
            $table->date('data')->nullable();
            // Adiciona outros campos que achares necessários aqui
        });
    }

    public function down()
    {
        Schema::table('faltas', function (Blueprint $table) {
            $table->dropColumn(['nomeUtilizador', 'tipo_falta', 'status', 'data']);
        });
    }

};
