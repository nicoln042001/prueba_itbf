<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoHabitacion extends Model
{
    protected $table = 'tipo_habitaciones';
    protected $fillable = [
        'nombre',
        'estado'
    ];
}
