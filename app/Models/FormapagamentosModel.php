<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormapagamentosModel extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table='forma_pagamento';
    protected $fillable = [
    	'forma'
    ];
}
