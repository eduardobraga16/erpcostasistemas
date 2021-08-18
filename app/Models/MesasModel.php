<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MesasModel extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table='mesas';
    protected $fillable = [
    	'numero','ocupada','id_usuario'
    ];
}
