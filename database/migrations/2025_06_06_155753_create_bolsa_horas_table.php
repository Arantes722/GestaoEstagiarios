<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBolsaHorasTable extends Migration
{
    public function up()
    {
        Schema::create('bolsa_horas', function (Blueprint $table) {
            $table->id();
            $table->date('data');
            $table->string('descricao');
            $table->integer('horas');
            $table->string('nomeUtilizador');
            $table->string('status')->default('pendente');
            $table->timestamp('dataRegisto')->useCurrent();
            $table->text('comentariosAdmin')->nullable();
            $table->string('local')->nullable();
            $table->time('hora_inicio')->nullable();
            $table->time('hora_fim')->nullable();
            $table->string('nome')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bolsa_horas');
    }
}
