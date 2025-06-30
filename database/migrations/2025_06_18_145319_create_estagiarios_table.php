<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('estagiarios', function (Blueprint $table) {
            $table->id();
            $table->string('nome'); // se quiseres guardar nome aqui
            $table->string('curso');
            $table->string('orientador');
            $table->integer('horas_cumprir');
            $table->date('data_inicio');
            $table->date('data_fim')->nullable();
            $table->string('entidade_acolhimento');
            $table->string('escola');
            $table->boolean('registo_completo')->default(false);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estagiarios');
    }
};
