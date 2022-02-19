<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::all();

        if (count($clients) > 0) {            

            return response()->json([
                'code' => "200",
                'data' => $clients,
                'message' => "Listado de Clientes"
            ]);
        }
        return response()->json([
            'code' => "200",
            'message' => "No hay Clientes para mostar"
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
        if (!$request->input('name') || !$request->input('ci'))
        {
            return response()->json([
                'errors'=>array([
                    'code'=>422,'message'=>'El nombre o el ci del cliente no pueden ser vacio.'])],422);
        }
        
        $clientFind = $request->input('ci');

        $clients = Client::where("ci","=",$clientFind)->first();

        if ($clients) {
            return response()->json([
                'message'=>'No se puede insertar porque este cliente ya existe.'
            ]);
        }

        $client = new Client();
        $client->name = $request->input('name');
        $client->ci = $request->input('ci');
        $client->save();

        return response()->json([
            'code' => "201",
            'data' => $client,
            'message' => "El cliente fue insertado satisfactoriamente"
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show($ci)
    {
        $clientFind = Client::where("ci","=",$ci)->first();

        if (!$clientFind) {
            return response()->json([
                'code' => "404",
                'message' => "No existe el cliente especificado"
            ]);
        }

        return response()->json([
            'code' => "200",
            'data' => $clientFind,
            'message' => "La información del cliente se cargó satisfactoriamente"
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $ci)
    {
        if (!$request->input('name') || !$request->input('ci'))
        {
            return response()->json([
                'errors'=>array([
                    'code'=>422,'message'=>'El nombre o el ci del cliente no pueden ser vacio.'])],422);
        }

        $clientFind = Client::where("ci","=",$ci)->first();

        if (!$clientFind) {
            return response()->json([
                'code' => "404",
                'message' => "No existe el cliente especificado"
            ]);
        }
        
        $clientFind->name = $request->input('name');
        $clientFind->ci = $request->input('ci');
        $clientFind->save();

        return response()->json([
            'code' => "200",
            'data' => $clientFind,
            'message' => "El cliente fue modificado satisfactoriamente"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy($ci)
    {
        $client = Client::where("ci","=",$ci)->first();

        if (!$client) {
            return response()->json([
                'code' => "404",
                'message' => "No existe el cliente especificado"
            ]);
        }

        $client->delete();

        return response()->json([
            'code' => "204",
            'message' => "El cliente fue eliminado satisfactoriamente"
        ]);
    }
}
