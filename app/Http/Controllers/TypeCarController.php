<?php

namespace App\Http\Controllers;

use App\Models\TypeCar;
use Illuminate\Http\Request;

class TypeCarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $typesCars = TypeCar::all();

        if (count($typesCars) > 0) {            

            return response()->json([
                'code' => "200",
                'data' => $typesCars,
                'message' => "Listado de Tipos de Vehículos"
            ]);
        }
        return response()->json([
            'code' => "200",
            'message' => "No hay Tipos de Vehículos para mostar"
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->input('type'))
        {
            return response()->json([
                'errors'=>array([
                    'code'=>422,'message'=>'El tipo de vehículo no puede ser vacio.'])],422);
        }

        $typeFind = $request->input('type');

        $typeCar = TypeCar::where("type","=",$typeFind)->first();

        if ($typeCar) {
            return response()->json([
                'message'=>'No se puede insertar porque este tipo de vehículo ya existe.'
            ]);
        }


        $typesCars = new TypeCar($request->all());
        $typesCars->type = $request->input('type');
        $typesCars->save();

        return response()->json([
            'code' => "201",
            'data' => $typesCars,
            'message' => "El tipo de vehículo fue insertado satisfactoriamente"
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TypeCar  $typeCar
     * @return \Illuminate\Http\Response
     */
    public function show($type)
    {
        //$typesCars = TypeCar::all()->find($id);
        //$typesCars = TypeCar::find($type);
        $typeCar = TypeCar::where("type","=",$type)->first();

        if (!$typeCar) {
            return response()->json([
                'code' => "404",
                'message' => "No existe el tipo de vehículo especificado"
            ]);
        }

        return response()->json([
            'code' => "200",
            'data' => $typeCar,
            'message' => "La información del tipo de vehículo se cargó satisfactoriamente"
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TypeCar  $typeCar
     * @return \Illuminate\Http\Response
     */
    public function edit(TypeCar $typeCar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TypeCar  $typeCar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $type)
    {
        if (!$request->input('type'))
        {
            return response()->json([
                'errors'=>array([
                    'code'=>422,'message'=>'El tipo de vehículo no puede ser vacio.'])],422);
        }

        $typesCars = TypeCar::where("type","=",$type)->first();

        if (!$typesCars) {
            return response()->json([
                'code' => "404",
                'message' => "No existe el tipo de vehículo especificado"
            ]);
        }
        
        $typesCars->type = $request->input('type');
        $typesCars->save();

        return response()->json([
            'code' => "200",
            'data' => $typesCars,
            'message' => "El tipo de vehículo fue modificado satisfactoriamente"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TypeCar  $typeCar
     * @return \Illuminate\Http\Response
     */
    public function destroy($type)
    {
        $typesCars = TypeCar::where("type","=",$type)->first();

        if (!$typesCars) {
            return response()->json([
                'code' => "404",
                'message' => "No existe el tipo de vehículo especificado"
            ]);
        }

        $typesCars->delete();

        return response()->json([
            'code' => "204",
            'message' => "El tipo de vehículo fue eliminado satisfactoriamente"
        ]);
    }
}
