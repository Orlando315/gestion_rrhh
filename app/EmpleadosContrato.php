<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmpleadosContrato extends Model
{
  protected $fillable = [
    'empleado_id',
    'sueldo',
    'inicio',
    'fin',
    'jornada',
    'dias_laborables',
    'dias_descanso'
  ];

  public $timestamps = false;

  public function setInicioAttribute($date)
  {
    $this->attributes['inicio'] = $date ? date('Y-m-d', strtotime($date)) : null;
  }

  public function setFinAttribute($date)
  {
    $this->attributes['fin'] = $date ? date('Y-m-d', strtotime($date)) : null;
  }

  public function getInicioAttribute($date)
  {
    return date('d-m-Y', strtotime($date));
  }

  public function getFinAttribute($date)
  {
    return $date ? date('d-m-Y', strtotime($date)) : null;
  }
}
