<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Empresa;
use App\ConfiguracionEmpresa;

class EmpresasController extends Controller
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
      return view('empresas.create');
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
        'usuario' => 'required|alpha_num|unique:empresas,usuario',
        'nombre' => 'required|string',
        'rut' => 'required|string',
        'representante' => 'required|string',
        'email' => 'required|email|unique:empresas,email',
        'telefono' => 'required',
        'jornada' => 'required',
        'password' => 'required|confirmed',
        'password_confirmation' => 'required'
      ]);

      $empresa = new Empresa;
      $empresa->fill($request->all());
      $empresa->password = bcrypt($request->input('password'));

      if($empresa->save()){
        $config = new ConfiguracionEmpresa;
        $config->fill($request->all());

        $empresa->configuracion()->save($config);

        return redirect('login')->with([
          'flash_message' => 'Registro completado con exito.',
          'flash_class' => 'alert-success'
          ]);
      }else{
        return redirect('login')->with([
          'flash_message' => 'Ha ocurrido un error.',
          'flash_class' => 'alert-danger',
          'flash_important' => true
          ]);
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
      return view('empresas.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
      $this->validate($request, [
        'usuario' => 'required|alpha_num|unique:empresas,usuario,' . Auth::user()->id . ',id',
        'nombre' => 'required|alpha_num',
        'rut' => 'required|string',
        'representante' => 'required|string',
        'email' => 'required|email|unique:empresas,email,' . Auth::user()->id . ',id',
        'telefono' => 'required',
        'jornada' => 'required'
      ]);

      $empresa = Empresa::find(Auth::user()->id);
      $empresa->fill($request->all());

      if($empresa->save()){
        return redirect('perfil')->with([
          'flash_message' => 'Perfil modificado correctamente.',
          'flash_class' => 'alert-success'
          ]);
      }else{
        return redirect('perfil')->with([
          'flash_message' => 'Ha ocurrido un error.',
          'flash_class' => 'alert-danger',
          'flash_important' => true
          ]);
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function perfil(){
      return view('empresas.perfil');
    }
}
