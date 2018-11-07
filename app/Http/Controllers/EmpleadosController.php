<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Empleado;
use App\EmpleadosBanco;
use App\EmpleadosContrato;
use Box\Spout\Writer\WriterFactory;
use Box\Spout\Common\Type;

class EmpleadosController extends Controller
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
      return view('empleados.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->validate($request, [
        'nombres' => 'required|string',
        'apellidos' => 'required|string',
        'rut' => 'required|string|unique:empleados,rut',
        'direccion' => 'required|string',
        'telefono' => 'required|string',
        'email' => 'required|email|unique:empleados,email',
        'talla_zapato' => 'required|numeric',
        'talla_pantalon' => 'required|integer',
        'nombre' => 'required|string',
        'tipo_cuenta' => 'required',
        'cuenta' => 'required|string',
        'sueldo' => 'required|numeric',
        'inicio' => 'required|date_format:d-m-Y',
        'fin' => 'nullable|date_format:d-m-Y',
        'jornada' => 'nullable',
      ]);

      if(!$request->jornada){
        $request->merge(['jornada' => Auth::user()->configuracion->jornada]);
      }

      $empleado = new Empleado($request->all());

      if($emplado = Auth::user()->empleados()->save($empleado)){
        
        $empleado->contratos()->create($request->all());

        $empleado->banco()->create($request->all());

        return redirect('empleados/' . $emplado->id)->with([
          'flash_message' => 'Empleado registrado exitosamente.',
          'flash_class' => 'alert-success'
          ]);
      }else{
        return redirect('empleados/create')->with([
          'flash_message' => 'Ha ocurrido un error.',
          'flash_class' => 'alert-danger',
          'flash_important' => true
          ]);
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function show(Empleado $empleado)
    {
      return view('empleados.show', ['empleado' => $empleado]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function edit(Empleado $empleado)
    {
      return view('empleados.edit', ['empleado' => $empleado]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Empleado $empleado)
    {
      $this->validate($request, [
        'nombres' => 'required|string',
        'apellidos' => 'required|string',
        'rut' => 'required|string|unique:empleados,rut,' . $empleado->id . ',id',
        'direccion' => 'required|string',
        'telefono' => 'required|string',
        'email' => 'required|email|unique:empleados,email,' . $empleado->id . ',id',
        'talla_zapato' => 'required|numeric',
        'talla_pantalon' => 'required|integer',
        'nombre' => 'required|string',
        'tipo_cuenta' => 'required',
        'cuenta' => 'required|string',
        'sueldo' => 'required|numeric',
        'inicio' => 'required|date_format:d-m-Y',
        'fin' => 'nullable|date_format:d-m-Y',
        'jornada' => 'nullable',
        'dias_laborables' => 'nullable',
        'dias_descanso' => 'nullable'
      ]);

      if(!$request->jornada){
        $request->merge(['jornada' => Auth::user()->configuracion->jornada]);
      }

      $empleado->fill($request->all());
      $empleado->contratos->first()->fill($request->all());
      $empleado->banco->fill($request->all());

      if($empleado->push()){
        return redirect('empleados/' . $empleado->id)->with([
          'flash_message' => 'Empleado modificado exitosamente.',
          'flash_class' => 'alert-success'
          ]);
      }else{
        return redirect('empleados/create')->with([
          'flash_message' => 'Ha ocurrido un error.',
          'flash_class' => 'alert-danger',
          'flash_important' => true
          ]);
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function destroy(Empleado $empleado)
    {
      if($empleado->delete()){

        //Storage::deleteDirectory('Empleado' . $empleado->id);

        return redirect('dashboard')->with([
          'flash_class'   => 'alert-success',
          'flash_message' => 'Empleado eliminado exitosamente.'
        ]);
      }else{
        return redirect('dashboard')->with([
          'flash_class'     => 'alert-danger',
          'flash_message'   => 'Ha ocurrido un error.',
          'flash_important' => true
        ]);
      }
    }

    public function cambio($empleado)
    {
      return view('empleados.cambio', ['empleado'=>$empleado]);
    }

    public function cambioStore(Request $request, Empleado $empleado)
    {
      $this->validate($request, [
        'inicio' => 'required|date_format:d-m-Y',
        'fin' => 'nullable|date_format:d-m-Y',
        'jornada' => 'nullable',
      ]);
      $lastContrato = $empleado->contratos->last();

      if(!$request->jornada){
        $request->merge(['jornada' => Auth::user()->configuracion->jornada]);
      }
      $request->merge(['sueldo' => $lastContrato->sueldo]);

      if($empleado->contratos()->create($request->all())){
        $lastContrato->fin = $request->inicio;
        $lastContrato->save();

        return redirect('empleados/' . $empleado->id)->with([
          'flash_message' => 'Cambio de jornada exitoso.',
          'flash_class' => 'alert-success'
          ]);
      }else{
        return redirect('empleados/' . $empleado->id . '/cambio')->with([
          'flash_message' => 'Ha ocurrido un error.',
          'flash_class' => 'alert-danger',
          'flash_important' => true
          ]);
      }
    }
    
    public function export(Empleado $empleado)
    {
      $this->exportExcel($empleado->getDataAsArray(), 'Empleado' . $empleado->id);
    }

    public function exportAll()
    {
      $this->exportExcel(Empleado::exportAll(), 'Jornadas');
    }

    protected function exportExcel($data, $nombre)
    {
      $writer = WriterFactory::create(Type::XLSX);
      $writer->openToBrowser("{$nombre}.xlsx");
      $writer->addRows($data);

      $writer->close(); 
    }
}
