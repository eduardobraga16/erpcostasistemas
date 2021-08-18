<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableAberturaCaixa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('funcionarios', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 50);
            $table->string('administrador', 1);
            $table->integer('id_usuario');
            $table->unsignedBigInteger('id_estabelecimento');

            $table->foreign('id_estabelecimento')->references('id')->on('estabelecimentos');
        });

        Schema::create('caixas', function (Blueprint $table) {
            $table->id();
            $table->float('saldo_inicial');
            $table->integer('id_usuario');
            $table->unsignedBigInteger('id_estabelecimento');

            $table->foreign('id_estabelecimento')->references('id')->on('estabelecimentos');
        });

        Schema::create('abertura_caixa', function (Blueprint $table) {
            $table->id();
            $table->float('saldo_inicial');
            $table->integer('id_usuario');
            $table->unsignedBigInteger('id_funcionario');
            $table->unsignedBigInteger('id_estabelecimento');

            $table->foreign('id_funcionario')->references('id')->on('funcionarios');
            $table->foreign('id_estabelecimento')->references('id')->on('estabelecimentos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_abertura_caixa');
    }
}
