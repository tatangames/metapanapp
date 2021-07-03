<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudPartidaNacimiento extends Model
{
    use HasFactory;
    protected $table = 'solicitud_partida_nacimiento';
    public $timestamps = false;

}
