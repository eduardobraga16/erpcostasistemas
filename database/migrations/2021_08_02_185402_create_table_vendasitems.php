<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableVendasitems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendas_items', function (Blueprint $table) {
            $table->id();
            $table->integer('qtde');
            $table->float(10,2);
            $table->string('observacoes');
            $table->unsignedBigInteger('id_venda');
            $table->unsignedBigInteger('id_produto');

            $table->foreign('id_venda')->references('id')->on('vendas');
            $table->foreign('id_produto')->references('id')->on('produtos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendas_items');
    }
}
