<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class HotelController extends Controller
{
    /**
     * Listar todos los hoteles
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(){
        $hoteles = Hotel::all();

        return response()->json($hoteles, Response::HTTP_OK);
    }

    /**
     * Consultar un hotel por id
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id){
        $hotel = Hotel::find($id);
        if (!$hotel) {
            return response()->json(['msg' => 'Hotel no encontrado'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($hotel, Response::HTTP_OK);
    }

    /**
     * Crear un nuevo hotel
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'ciudad' => 'required|string|max:255',
            'nit' => 'required|string|max:50|unique:hoteles,nit',
            'numero_habitaciones' => 'required|integer|min:1',
            'estado' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $hotel = Hotel::create($validator->validated());

        return response()->json(['msg' => 'Se ha creado el hotel correctamente', 'hotel' => $hotel], Response::HTTP_CREATED);
    }

    /**
     * Actualizar un hotel existente
     * @param int $id
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, Request $request){
        $hotel = Hotel::find($id);
        if (!$hotel) {
            return response()->json(['msg' => 'Hotel no encontrado'], Response::HTTP_NOT_FOUND);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'sometimes|required|string|max:255',
            'direccion' => 'sometimes|required|string|max:255',
            'ciudad' => 'sometimes|required|string|max:255',
            'nit' => 'sometimes|required|string|max:50|unique:hoteles,nit,'.$hotel->id,
            'numero_habitaciones' => 'sometimes|required|integer|min:1',
            'estado' => 'sometimes|required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $hotel->update($validator->validated());

        return response()->json(['msg' => 'Se ha modificado el hotel correctamente', 'hotel' => $hotel], Response::HTTP_OK);
    }

    /**
     * Eliminar (cambiar estado a inactivo) un hotel
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id){
        $hotel = Hotel::find($id);
        if (!$hotel) {
            return response()->json(['msg' => 'Hotel no encontrado'], Response::HTTP_NOT_FOUND);
        }
        $hotel->delete();
        $hotel->save();
        return response()->json(['msg' => 'Se ha eliminado el hotel correctamente'], Response::HTTP_OK);
    }
}
