<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePresencasTable extends Migration
{
    public function up()
    {
        Schema::create('presencas', function (Blueprint $table) {
            $table->id();
            $table->date('data');
            $table->string('descricao')->nullable();
            $table->decimal('horas', 5, 2); // exemplo: 3.50 horas
            $table->string('nomeUtilizador');
            $table->string('status')->nullable();
            $table->timestamp('dataRegisto')->nullable();
            $table->text('comentariosAdmin')->nullable();
            $table->string('local')->nullable();
            $table->time('hora_inicio')->nullable();
            $table->time('hora_fim')->nullable();
            $table->string('nome')->nullable();
            $table->timestamps(); // created_at e updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('presencas');
    }
}
