<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FuncionariosModel extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table='funcionarios';
    protected $fillable = [
    	'nome','usuario','administrador','id_usuario','id_estabelecimento','senha','operando','token'
    ];
}
