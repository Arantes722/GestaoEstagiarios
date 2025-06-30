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
        Schema::table('estagiarios', function (Blueprint $table) {
            $table->boolean('registo_completo')->default(false)->after('entidade_acolhimento');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('estagiarios', function (Blueprint $table) {
            $table->dropColumn('registo_completo');
        });
    }

};
