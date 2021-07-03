<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListaDenunciasMultiple extends Model
{
    use HasFactory;
    protected $table = 'lista_denuncias_multiple';
    public $timestamps = false;
}
