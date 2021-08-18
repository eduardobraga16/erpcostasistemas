<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AberturacaixaModel extends Model
{
    use HasFactory;
    protected $table='abertura_caixa';
    protected $fillable= [
    	'saldo_inicial','id_usuario','id_funcionario','id_estabelecimento','created_at','updated_at','id_caixa','fechado','fechamento_avista','fechamento_credito','fechamento_debito','fechamento_pix','cartao_credito','cartao_debito','pix','saldo_em_caixa'
    ];

     
}
