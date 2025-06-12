<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Habitacion extends Model
{
    protected $table = 'habitaciones';
    protected $fillable = [
        'hotel_id',
        'tipo_habitacion_id',
        'acomodacion_id',
        'cantidad',
        'estado'
    ];

    public function acomodacion(){
        return $this->belongsTo(Acomodaciones::class);
    }
    public function tipoHabitacion(){
        return $this->belongsTo(TipoHabitacion::class);
    }
}
