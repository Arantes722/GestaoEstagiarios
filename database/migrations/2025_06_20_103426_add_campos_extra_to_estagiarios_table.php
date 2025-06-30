<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('estagiarios', function (Blueprint $table) {
            $table->string('telemovel')->nullable();
            $table->text('morada')->nullable();
            $table->date('data_nascimento')->nullable();
            $table->string('documento_identificacao')->nullable();
            $table->enum('genero', ['Masculino', 'Feminino', 'Outro'])->nullable();
            $table->string('nif', 9)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('estagiarios', function (Blueprint $table) {
            $table->dropColumn([
                'telemovel',
                'morada',
                'data_nascimento',
                'documento_identificacao',
                'genero',
                'nif',
            ]);
        });
    }

};
