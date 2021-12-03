<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendasModel extends Model
{
    use HasFactory;

    protected $table='vendas';
    protected $fillable = [
    	'nome_cliente','finalizado','baixa','total','forma_pagamento','dinheiro_recebido','troco','id_usuario','id_estabelecimento','id_mesa','id_status','id_caixa','id_abertura_caixa','id_funcionario'
    ];

    //public function categoria(){
		//return $this->belongsTo(CategoriasModel::class, 'id_categoria','id');
    //}
}
