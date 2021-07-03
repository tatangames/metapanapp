<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoPartida extends Model
{
    use HasFactory;
    protected $table = 'estado_partida';
    public $timestamps = false;
}
