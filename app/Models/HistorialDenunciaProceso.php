<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialDenunciaProceso extends Model
{
    use HasFactory;
    protected $table = 'historial_denuncia_proceso';
    public $timestamps = false;
}
