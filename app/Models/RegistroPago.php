<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroPago extends Model
{
    use HasFactory;
    protected $table = 'registro_pago';
    public $timestamps = false;
}
