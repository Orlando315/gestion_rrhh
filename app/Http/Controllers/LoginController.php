<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Empleado;

class LoginController extends Controller
{
    public function dashboard()
    {
      $empleados = Empleado::all();

      return view('dashboard', ['empleados' => $empleados]);
    }

	 public function auth(Request $request)
	 {
	 		/*----------- LOGIN MANUAL , MODIFICABLE ----------*/
    	$this->validate($request, [
    		'usuario' =>'required',
    		'password' => 'required',
    	]);

      if(Auth::attempt($request->only(['usuario', 'password']))){
      	return redirect()->intended('dashboard');
      }else{
      	return redirect()->route('login.view')->withErrors('¡Combinación de usuario y clave incorrecta!');
      }
	 }

	 public function logout()
	 {
	 		Auth::logout();

	 		return redirect()->route('login.view');
	 }
    
}
