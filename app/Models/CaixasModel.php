<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaixasModel extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table='caixas';
    protected $fillable= [
    	'caixa','id_usuario','id_estabelecimento','fechado'
    ];
}
