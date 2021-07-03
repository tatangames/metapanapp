<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DenunciaRealizada extends Model
{
    use HasFactory;
    protected $table = 'denuncia_realizada';
    public $timestamps = false;
}
