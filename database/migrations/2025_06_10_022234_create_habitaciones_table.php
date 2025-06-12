<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('habitaciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hotel_id');
            $table->unsignedBigInteger('tipo_habitacion_id');
            $table->unsignedBigInteger('acomodacion_id');
            $table->string('cantidad');
            $table->tinyInteger('estado');
            $table->timestamps();

            $table->foreign('hotel_id')->references('id')->on('hoteles');
            $table->foreign('tipo_habitacion_id')->references('id')->on('tipo_habitaciones');
            $table->foreign('acomodacion_id')->references('id')->on('acomodaciones');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('habitaciones');
    }
};
