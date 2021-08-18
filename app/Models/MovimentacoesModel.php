<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovimentacoesModel extends Model
{
    use HasFactory;
    protected $table='movimentacoes';
    protected $fillable = [
    	'tipo','valor','id_usuario','id_funcionario','id_estabelecimento','id_caixa','id_abertura_caixa','motivo'
    ];

}
