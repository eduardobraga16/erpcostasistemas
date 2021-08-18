<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstabelecimentosModel extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table='estabelecimentos';
    protected $fillable= [
    	'nome','endereco','complemento','bairro','numero','id_cidade','id_usuario'
    ];
}
