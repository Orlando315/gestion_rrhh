<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empleado extends Model
{
  use SoftDeletes;

  protected $fillable = [
    'nombres',
    'apellidos',
    'rut',
    'direccion',
    'telefono',
    'email',
    'talla_zapato',
    'talla_pantalon'
  ];
  
  protected $dates = ['deleted_at'];

  protected $guarded = ['empresa_id'];

  public function contrato()
  {
    return $this->hasOne('App\EmpleadosContrato');
  }

  public function banco()
  {
    return $this->hasOne('App\EmpleadosBanco');
  }

  public function documentos()
  {
    return $this->hasMany('App\EmpleadosDocumento');
  }

  public function empresa()
  {
    return $this->belongsTo('App\Empresa');
  }
}
