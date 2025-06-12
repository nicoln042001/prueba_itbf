<?php

namespace Database\Seeders;

use App\Models\Acomodaciones;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AcomodacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Acomodaciones::updateOrCreate([
            'nombre' => 'Sencilla'
        ], [
            'estado' => 1
        ]);
        Acomodaciones::updateOrCreate([
            'nombre' => 'Triple'
        ], [
            'estado' => 1
        ]);
        Acomodaciones::updateOrCreate([
            'nombre' => 'Doble'
        ], [
            'estado' => 1
        ]);
    }
}
