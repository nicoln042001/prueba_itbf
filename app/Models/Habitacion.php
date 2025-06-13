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

    
    /**
     * Get the acomodacion that owns the habitacion.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function acomodacion(){
        return $this->belongsTo(Acomodaciones::class);
    }
    /**
     * Get the tipoHabitacion that owns the habitacion.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipoHabitacion(){
        return $this->belongsTo(TipoHabitacion::class);
    }
}
