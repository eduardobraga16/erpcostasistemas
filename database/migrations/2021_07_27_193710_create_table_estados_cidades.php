<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableEstadosCidades extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estados', function (Blueprint $table) {
            $table->bigIncrements('id_estado');
            $table->string('nome_estado', 70);
            $table->string('uf_estado', 3);
            $table->string('codigo_estado', 3);

            $table->timestamps();
        });

        Schema::create('cidades', function(Blueprint $table){
            $table->bigIncrements('id_cidade');
            $table->unsignedBigInteger('id_estado');
            $table->string('nome_cidade', 90);
            $table->string('ibge_cidade', 9);

            $table->foreign('id_estado')->references('id_estado')->on('estados');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_estados_cidades');
    }
}
