<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Habitacion;
use App\Models\Hotel;
use App\Models\TipoHabitacion;
use App\Models\Acomodaciones;

class HabitacionController extends Controller
{
    // Listar todas las habitaciones
    public function index()
    {
        $habitaciones = Habitacion::with('acomodacion','tipoHabitacion')->get();
        return response()->json($habitaciones, 200);
    }

    // Mostrar una habitación específica
    public function show($id)
    {
        $habitacion = Habitacion::find($id);
        if (!$habitacion) {
            return response()->json(['mensaje' => 'Habitación no encontrada'], 404);
        }
        return response()->json($habitacion, 200);
    }

    // Crear una nueva habitación
    public function store(Request $request)
    {
        $data = $request->all();
        $errores = [];

        // Validaciones manuales
        if (empty($data['hotel_id']) || !is_numeric($data['hotel_id'])) {
            $errores['hotel_id'] = 'El hotel es requerido y debe ser un número válido.';
        }
        if (empty($data['tipo_habitacion_id']) || !is_numeric($data['tipo_habitacion_id'])) {
            $errores['tipo_habitacion_id'] = 'El tipo de habitación es requerido y debe ser un número válido.';
        }
        if (empty($data['acomodacion_id']) || !is_numeric($data['acomodacion_id'])) {
            $errores['acomodacion_id'] = 'La acomodación es requerida y debe ser un número válido.';
        }
        if (empty($data['cantidad']) || !is_numeric($data['cantidad']) || $data['cantidad'] < 1) {
            $errores['cantidad'] = 'La cantidad es requerida y debe ser un número mayor a 0.';
        }

        if (!empty($errores)) {
            return response()->json(['errores' => $errores], 422);
        }

        // Validar existencia de relaciones
        $tipo = TipoHabitacion::find($data['tipo_habitacion_id']);
        $acomodacion = Acomodaciones::find($data['acomodacion_id']);
        $hotel = Hotel::find($data['hotel_id']);

        if (!$tipo) {
            return response()->json(['mensaje' => 'Tipo de habitación no encontrado'], 404);
        }
        if (!$acomodacion) {
            return response()->json(['mensaje' => 'Acomodación no encontrada'], 404);
        }
        if (!$hotel) {
            return response()->json(['mensaje' => 'Hotel no encontrado'], 404);
        }

        // Validar relación tipo de habitación y acomodación
        $reglas = [
            'Estandar' => ['Sencilla', 'Doble'],
            'Junior' => ['Triple', 'Cuádruple'],
            'Suite' => ['Sencilla', 'Doble', 'Triple'],
        ];

        if (!isset($reglas[$tipo->nombre]) || !in_array($acomodacion->nombre, $reglas[$tipo->nombre])) {
            return response()->json(['mensaje' => 'La acomodación seleccionada no es válida para el tipo de habitación'], 422);
        }

        // Validar que no exista una combinación repetida para el mismo hotel
        $existe = Habitacion::where('hotel_id', $data['hotel_id'])
            ->where('tipo_habitacion_id', $data['tipo_habitacion_id'])
            ->where('acomodacion_id', $data['acomodacion_id'])
            ->exists();

        if ($existe) {
            return response()->json(['mensaje' => 'Ya existe una habitación con ese tipo y acomodación para este hotel'], 422);
        }

        // Validar que la suma de habitaciones no supere el máximo del hotel
        $totalHabitaciones = Habitacion::where('hotel_id', $data['hotel_id'])->sum('cantidad');
        if (($totalHabitaciones + $data['cantidad']) > $hotel->numero_habitaciones) {
            return response()->json(['mensaje' => 'La cantidad total de habitaciones supera el máximo permitido para este hotel'], 422);
        }

        $habitacion = Habitacion::create($data);
        return response()->json( $habitacion, 201);
    }

    // Actualizar una habitación existente
    public function update(Request $request, $id)
    {
        $habitacion = Habitacion::find($id);
        if (!$habitacion) {
            return response()->json(['mensaje' => 'Habitación no encontrada'], 404);
        }

        $validated = $request->validate([
            'hotel_id' => 'sometimes|integer|exists:hoteles,id',
            'tipo_habitacion_id' => 'sometimes|integer|exists:tipo_habitaciones,id',
            'acomodacion_id' => 'sometimes|integer|exists:acomodaciones,id',
            'cantidad' => 'sometimes|integer|min:1',
            'estado' => 'sometimes|string|max:255'
        ]);

        // Obtener los valores actuales o los nuevos si se actualizan
        $tipo_habitacion_id = $validated['tipo_habitacion_id'] ?? $habitacion->tipo_habitacion_id;
        $acomodacion_id = $validated['acomodacion_id'] ?? $habitacion->acomodacion_id;

        $tipo = TipoHabitacion::find($tipo_habitacion_id);
        $acomodacion = Acomodaciones::find($acomodacion_id);

        $reglas = [
            'Estandar' => ['Sencilla', 'Doble'],
            'Junior' => ['Triple', 'Cuádruple'],
            'Suite' => ['Sencilla', 'Doble', 'Triple'],
        ];

        if (!isset($reglas[$tipo->nombre]) || !in_array($acomodacion->nombre, $reglas[$tipo->nombre])) {
            return response()->json(['mensaje' => 'La acomodación seleccionada no es válida para el tipo de habitación'], 422);
        }

        // Validar que la suma de habitaciones no supere el máximo del hotel
        $hotel = Hotel::find($validated['hotel_id'] ?? $habitacion->hotel_id);
        $totalHabitaciones = Habitacion::where('hotel_id', $validated['hotel_id'] ?? $habitacion->hotel_id)
            ->where('id', '!=', $habitacion->id)
            ->sum('cantidad');
        $nuevaCantidad = $validated['cantidad'] ?? $habitacion->cantidad;

        if (($totalHabitaciones + $nuevaCantidad) > $hotel->numero_habitaciones) {
            return response()->json(['mensaje' => 'La cantidad total de habitaciones supera el máximo permitido para este hotel'], 422);
        }

        $habitacion->update($validated);
        return response()->json($habitacion, 201);
    }

    // Eliminar una habitación
    public function destroy($id)
    {
        $habitacion = Habitacion::find($id);
        if (!$habitacion) {
            return response()->json(['mensaje' => 'Habitación no encontrada'], 404);
        }
        $habitacion->estado;
        $habitacion->save();
        
        return response()->json(['mensaje' => 'Habitación eliminada correctamente'], 200);
    }

    public function getAcomodaciones(){
        return response()->json(Acomodaciones::all());
    }

    public function getTipoHabitaciones(){
        return response()->json(TipoHabitacion::all());
    }
}
