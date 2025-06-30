<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('estagios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estagiario_id')->constrained('estagiarios')->onDelete('cascade');
            $table->string('orientador');
            $table->integer('horas_cumprir');
            $table->integer('horas_cumpridas')->default(0);
            $table->date('data_inicio');
            $table->date('data_fim');
            $table->string('escola');
            $table->string('instituicao_acolhimento');
            $table->integer('presencas_registadas')->default(0);
            $table->text('plano_estagio')->nullable();
            $table->string('avaliacao_final')->nullable();
            $table->enum('estado', ['Ativo', 'Concluído', 'Cancelado'])->default('Ativo');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('estagios');
    }

};
