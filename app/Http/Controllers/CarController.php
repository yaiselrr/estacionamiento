<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cars = Car::all();

        if (count($cars) > 0) {            

            return response()->json([
                'code' => "200",
                'data' => $cars,
                'message' => "Listado de vehículos."
            ]);
        }
        return response()->json([
            'code' => "200",
            'message' => "No hay vehículos para mostar."
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
        if (!$request->input('enrollment') || !$request->input('type_car_id') || !$request->input('client_id'))
        {
            return response()->json([
                'errors'=>array([
                    'code'=>422,'message'=>'La matrícula, el tipo de vehículo o el cliente no pueden ser vacio.'])],422);
        }
        
        $carFind = $request->input('enrollment');

        $cars = Car::where("enrollment","=",$carFind)->first();

        if ($cars) {
            return response()->json([
                'message'=>'No se puede insertar porque este vehículo ya existe.'
            ]);
        }

        $car = new Car();
        $car->enrollment = $request->input('enrollment');
        $car->type_car_id = $request->input('type_car_id');
        $car->client_id = $request->input('client_id');
        $car->state = "noEstacionado";

        if ($car->save()) {
            return response()->json([
            'code' => "201",
            'data' => $car,
            'message' => "El vehículo fue insertado satisfactoriamente."
        ]);
        }

        return response()->json([
            'code' => "400",
            'message' => "El vehículo no pudo ser insertado satisfactoriamente."
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function show($enrollment)
    {
        $carFind = Car::where("enrollment","=",$enrollment)->first();

        if (!$carFind) {
            return response()->json([
                'code' => "404",
                'message' => "No existe el vehículo especificado."
            ]);
        }

        return response()->json([
            'code' => "200",
            'data' => $carFind,
            'message' => "La información del vehículo se cargó satisfactoriamente."
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function edit(Car  $car)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $enrollment)
    {
        if (!$request->input('enrollment') || !$request->input('type_car_id') || !$request->input('client_id'))
        {
            return response()->json([
                'errors'=>array([
                    'code'=>422,'message'=>'La matrícula, el tipo de vehículo o el cliente no pueden ser vacio.'])],422);
        }

        $carFind = Car::where("enrollment","=",$enrollment)->first();

        if (!$carFind) {
            return response()->json([
                'code' => "404",
                'message' => "No existe el vehículo especificado."
            ]);
        }
        
        $carFind->enrollment = $request->input('enrollment');
        $carFind->type_car_id = $request->input('type_car_id');
        $carFind->client_id = $request->input('client_id');
        $carFind->state = "noEstacionado";

        if ($carFind->save()) {
            return response()->json([
            'code' => "200",
            'data' => $carFind,
            'message' => "El vehículo fue modificado satisfactoriamente."
        ]);
        }

        return response()->json([
            'code' => "400",
            'message' => "El vehículo no pudo ser modificado satisfactoriamente."
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function destroy($enrollment)
    {
        $car = Car::where("enrollment","=",$enrollment)->first();

        if (!$car) {
            return response()->json([
                'code' => "404",
                'message' => "No existe el vehículo especificado."
            ]);
        }

        if ($car->delete()) {
            return response()->json([
                'code' => "204",
                'message' => "El vehículo fue eliminado satisfactoriamente."
            ]);
        }

        return response()->json([
            'code' => "400",
            'message' => "El vehículo no pudo ser eliminado satisfactoriamente."
        ]);
    }
}
