<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EmpleadosEvento;
use App\Empleado;

class EmpleadosEventosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request, Empleado $empleado)
    {
      $this->validate($request, [
        'tipo' => 'required',
        'fecha' => 'nullable|date_format:Y-m-d',
      ]);

      if($evento = $empleado->eventos()->create($request->all())){
        $response = ['response' => true, 'evento' => $evento, 'data'=> $evento->eventoData()];
      }else{
        $response = ['response' => false];
      }

      return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\EmpleadosEvento  $empleadosEvento
     * @return \Illuminate\Http\Response
     */
    public function show(EmpleadosEvento $empleadosEvento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\EmpleadosEvento  $empleadosEvento
     * @return \Illuminate\Http\Response
     */
    public function edit(EmpleadosEvento $empleadosEvento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\EmpleadosEvento  $empleadosEvento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EmpleadosEvento $empleadosEvento)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\EmpleadosEvento  $empleadosEvento
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmpleadosEvento $evento)
    {
      if($evento->delete()){
        $response = ['response' => true, 'evento' => $evento];
      }else{
        $response = ['response' => false];
      }

      return $response;
    }
}
