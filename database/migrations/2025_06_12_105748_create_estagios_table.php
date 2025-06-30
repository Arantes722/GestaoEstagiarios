<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('estagios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('utilizador_id'); // FK para o utilizador
            $table->string('curso');
            $table->date('data_inicio');
            $table->date('data_fim');
            $table->string('orientador');
            $table->string('supervisor')->nullable();
            $table->integer('horas_a_cumprir')->nullable();
            $table->timestamps();

            $table->foreign('utilizador_id')->references('id')->on('utilizadores')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estagios');
    }
};
