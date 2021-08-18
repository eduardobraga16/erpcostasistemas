<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdutosModel extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table='produtos';
    protected $fillable = [
    	'nome','descricao','preco','ativo','id_categoria','id_usuario','imagem'
    ];

    public function categoria(){
		return $this->belongsTo(CategoriasModel::class, 'id_categoria','id');
    }
}
