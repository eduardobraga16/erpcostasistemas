<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendasitemsModel extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table='vendas_items';
    protected $fillable= [
    	'qtde','preco','observacoes','id_venda','id_produto','editar'
    ];
}
