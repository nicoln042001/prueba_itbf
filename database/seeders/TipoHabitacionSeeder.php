<?php

namespace Database\Seeders;

use App\Models\TipoHabitacion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoHabitacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TipoHabitacion::updateOrCreate([
            'nombre' => 'Estandar'
        ], [
            'estado' => true
        ]);
        TipoHabitacion::updateOrCreate([
            'nombre' => 'Junior'
        ], [
            'estado' => true
        ]);
        TipoHabitacion::updateOrCreate([
            'nombre' => 'Suite'
        ], [
            'estado' => true
        ]);
    }
}
