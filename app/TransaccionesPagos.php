<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransaccionesPagos extends Model
{
    protected $table = 'transacciones_pagos';
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'ref_payco', 'payment_method_id', 'codigo_respuesta', 'respuesta', 'amount', 'data', 'user_id',
    ];

}
