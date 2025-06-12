<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Acomodaciones extends Model
{
    protected $table = 'acomodaciones';
    protected $fillable = [
        'nombre',
        'estado'
    ];
}
