<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovimentacoesModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movimentacoes', function (Blueprint $table) {
            $table->id();
            $table->string('tipo',1);
            $table->float('valor',10,2);
            $table->integer('id_usuario');
            $table->unsignedBigInteger('id_funcionario');
            $table->unsignedBigInteger('id_estabelecimento');
            $table->unsignedBigInteger('id_caixa');

            $table->timestamps();

            $table->foreign('id_funcionario')->references('id')->on('funcionarios');
            $table->foreign('id_estabelecimento')->references('id')->on('estabelecimentos');
            $table->foreign('id_caixa')->references('id')->on('caixas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movimentacoes');
    }
}
