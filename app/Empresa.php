<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Empresa extends Authenticatable
{
  protected $fillable = [
    'nombre',
    'rut',
    'representante',
    'email',
    'telefono',
    'usuario'
  ];

  protected $hidden = [
    'password'
  ];

  public function getUsuarioAttribute($usuario)
  {
    return ucfirst($usuario);
  }

  public function configuracion()
  {
    return $this->hasOne('App\ConfiguracionEmpresa');
  }

  public function empleados()
  {
    return $this->hasMany('App\Empleado');
  }
}
