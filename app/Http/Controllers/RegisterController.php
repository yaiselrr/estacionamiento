<?php

namespace App\Http\Controllers;

use App\Models\Register;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function registerInput(Request $request)
    {
        if (!$request->input('enrollment'))
        {
            return response()->json([
                'errors'=>array([
                    'code'=>422,'message'=>'Se necesita una matrícula no puede ser vacio.'])],422);
        }
        
        $hora = time();

        $carFind = $request->input('enrollment');

        $cars = Car::where("enrollment","=",$carFind)->first();

        if (!$cars) {
            return response()->json([
                'code'=>'404',
                'message'=>'No se puede realizar la operación porque este vehículo no existe.'
            ]);
        }

        if ($cars->state == "estacionado") {
            return response()->json([
                'message'=>'No se puede realizar la operación porque este vehículo está estacionado.',
                'data'=> $cars
            ]);
        }

        $input = new Register();
        $input->enrollment = $request->input('enrollment');        
        $input->time_input = $hora;
        $input->time_output = 0;
        $input->state = "open";
        
        if ($input->save()) {

            $cars->state = "estacionado";
            $cars->save();

            return response()->json([
                'code' => "201",
                'data' => $input,
                'message' => "Al vehículo se le dio entrada satisfactoriamente."
            ]);
        }

        return response()->json([
            'code' => "400",
            'message'=>'La operacion no se pudo realizar satisfactoriamente.'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Input  $input
     * @return \Illuminate\Http\Response
     */
    public function registerOutput($enrollment)
    {
        $time = time();

        $cars = Register::where("enrollment",$enrollment)
            ->where('state','open')
            ->first();

        if (!$cars) {
            return response()->json([
                'code'=>'404',
                'message'=>'No se puede realizar la operación porque este vehículo no está estacionado.'
            ]);
        }

        $cars->time_output = $time;
        $cars->state = 'close';
        
        if ($cars->save()) {
            $carEdit = Car::where("enrollment",$enrollment)->first();
            $carEdit->state = "noEstacionado";
            $carEdit->save();

            return response()->json([
                'code' => "200",
                'data' => $cars,
                'message' => "Al vehículo se le dio salida satisfactoriamente."
            ]);
        }       

        return response()->json([
            'code' => "400",
            'message' => "La operacion no se pudo realizar satisfactoriamente."
        ]);
    }

    
    public function listOfClients()
    {
        $data = DB::table('registers')
            ->select(DB::raw('enrollment as numEnrollment,  abs(sum(time_input - time_output)/60) as timeParking, ROUND(abs((sum(time_input - time_output)/60)*0.5),2) as payment'))
            ->groupBy('enrollment')
            ->orderBy('payment','desc')
            ->get();

        if (count($data)>0) {

            return response()->json([
                'code' => "200",
                'data' => $data,
                'message' => "Informe de Clientes."
            ]);
        }
        return response()->json([
            'code' => "200",
            'data' => $data,
            'message' => "No hay información para mostrar"
        ]);
    }

    public function listEnrollmentsMax()
    {
        $data = DB::table('registers')
            ->select(DB::raw('enrollment as numEnrollment,  abs(sum(time_input - time_output)/60) as timeParking'))
            ->groupBy('enrollment')
            ->take(3)
            ->orderBy('timeParking','desc')
            ->get();

        if (count($data)>0) {

            return response()->json([
                'code' => "200",
                'data' => $data,
                'message' => "Informe de Clientes."
            ]);
        }
        return response()->json([
            'code' => "200",
            'data' => $data,
            'message' => "No hay información para mostrar"
        ]);
    }
}
