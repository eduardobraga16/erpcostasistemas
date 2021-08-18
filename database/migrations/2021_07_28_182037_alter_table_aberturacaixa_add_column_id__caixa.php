<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableAberturacaixaAddColumnIdCaixa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('abertura_caixa', function (Blueprint $table) {
            $table->unsignedBigInteger('id_caixa');
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
        Schema::table('abertura_caixa', function (Blueprint $table) {
            //
        });
    }
}
