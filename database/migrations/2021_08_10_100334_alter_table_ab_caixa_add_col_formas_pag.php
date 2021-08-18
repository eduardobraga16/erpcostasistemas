<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableAbCaixaAddColFormasPag extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('abertura_caixa', function (Blueprint $table) {
            $table->float('cartao_credito',10,2);
            $table->float('cartao_debito',10,2);
            $table->float('pix',10,2);
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
