<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendasModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status_venda', function (Blueprint $table) {
            $table->id();
            $table->string('status');
        });
        Schema::create('mesas', function (Blueprint $table) {
            $table->id();
            $table->integer('numero');
            $table->string('ocupada',1);
            $table->integer('id_usuario');
        });
        Schema::create('vendas', function (Blueprint $table) {
            $table->id();
            $table->string('nome_cliente', 70);
            $table->string('finalizado', 70);
            $table->float('total', 70);
            $table->string('forma_pagamento', 70);
            $table->float('dinheiro_recebido', 70);
            $table->float('troco', 70);
            

            $table->integer('id_usuario');
            $table->unsignedBigInteger('id_estabelecimento');
            $table->unsignedBigInteger('id_mesa');
            $table->unsignedBigInteger('id_status');

            $table->foreign('id_estabelecimento')->references('id')->on('estabelecimentos');
            $table->foreign('id_status')->references('id')->on('status_venda');
            $table->foreign('id_mesa')->references('id')->on('mesas');
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
        Schema::dropIfExists('vendas_models');
    }
}
