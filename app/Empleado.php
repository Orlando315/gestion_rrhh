<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

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

  public function eventos()
  {
    return $this->hasMany('App\EmpleadosEvento');
  }

  public function proyectarJornada()
  {
    $eventDate = $contratoStart = new Carbon(date('Y-m-d', strtotime($this->contrato->inicio)));
    $contratoEnd = $this->contrato->fin ? new Carbon(date('Y-m-d', strtotime($this->contrato->fin))) : $contratoStart->addMonths(6);
    
    $diffInDays = $contratoStart->diffInDays($contratoEnd);
    
    $jornada = $this->jornada();
    $interval = (int) ceil($diffInDays / $jornada->interval);

    $events = ['trabajo' => [], 'descanso'=>[]];

    for ($i=0; $i <= $interval; $i++){
      $trabajo = [
        'title' => 'Trabajo',
        'start' => $eventDate->toDateString(),
        'end' => $eventDate->addDays($jornada->trabajo)->toDateString(),
        'allday' => true
      ];
      $events['trabajo'][] = $trabajo;

      $descanso = [
        'title' => 'Descanso',
        'start' => $eventDate->toDateString(),
        'end' => $eventDate->addDays($jornada->descanso)->toDateString(),
        'allday' => true,
      ];
      $events['descanso'][] = $descanso;
    }

    return $events;
  }

  protected function jornada()
  {
    switch ($this->contrato->jornada) {
      case '5x2':
        $dias = ['trabajo'=>5, 'descanso'=>2, 'interval'=>7];
        break;
      case '4x3':
        $dias = ['trabajo'=>4, 'descanso'=>3, 'interval'=>7];
        break;
      case '7x7':
        $dias = ['trabajo'=>7, 'descanso'=>7, 'interval'=>14];
        break;
      case '10x10':
        $dias = ['trabajo'=>10, 'descanso'=>10, 'interval'=>20];
        break;
      case '12x12':
        $dias = ['trabajo'=>12, 'descanso'=>12, 'interval'=>24];
        break;
      case '20x10':
        $dias = ['trabajo'=>20, 'descanso'=>10, 'interval'=>30];
        break;
    }

    return (object)$dias;
  }

  public function getEventos()
  {
    $eventos = [];
    foreach($this->eventos()->get() as $evento){
      $data = $evento->eventoData();

      $eventos[] = [
        'id' => $evento->id,
        'className' => 'clickableEvent',
        'title' => $data->titulo,
        'start' => $evento->fecha,
        'allday'=> true,
        'color' => $data->color
      ];
    }

    return $eventos;
  }
}
