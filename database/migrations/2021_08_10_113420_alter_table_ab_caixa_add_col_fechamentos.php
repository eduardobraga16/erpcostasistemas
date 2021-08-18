<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableAbCaixaAddColFechamentos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('abertura_caixa', function (Blueprint $table) {
            $table->float('fechamento_credito',10,2)->nullable();
            $table->float('fechamento_debito',10,2)->nullable();
            $table->float('fechamento_pix',10,2)->nullable();
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
