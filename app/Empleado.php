<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Scopes\IdScope;
use Carbon\Carbon;

class Empleado extends Model
{
  use SoftDeletes;

  protected static function boot()
  {
    parent::boot();

    static::addGlobalScope(new IdScope);
  }

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

  public function contratos()
  {
    return $this->hasMany('App\EmpleadosContrato');
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
    $events = ['trabajo' => [], 'descanso'=>[]];

    foreach ($this->contratos()->get() as $lastContrato){

      $contratoStart = new Carbon(date('Y-m-d', strtotime($lastContrato->inicio)));
      $contratoEnd = $lastContrato->fin ? new Carbon(date('Y-m-d', strtotime($lastContrato->fin))) : $contratoStart->copy()->addMonths(6);
      
      $diffInDays = $contratoStart->diffInDays($contratoEnd);
      $jornada = $lastContrato->jornada();
      $interval = (int) ceil($diffInDays / $jornada->interval);
      $endDifInDays = 1;

      for ($i=0; $i < $interval; $i++){
        $endJornada = $contratoStart->copy()->addDays($jornada->trabajo);

        if($i == ($interval - 1)){
          $endDifInDays = $endJornada->diffInDays($contratoEnd, false);

          if($endDifInDays < 0){
            $endJornada = $endJornada->subDays(($endDifInDays * -1));
          }
        }

        $trabajo = [
          'title' => 'Trabajo ' . $lastContrato->jornada,
          'start' => $contratoStart->toDateString(),
          'end' => $endJornada->toDateString(),
          'allday' => true
        ];

        $contratoStart->addDays($jornada->trabajo);

        $events['trabajo'][] = $trabajo;
        
        if($endDifInDays < 0){
          break;
        }

        $endJornada = $contratoStart->copy()->addDays($jornada->descanso);

        if($i == ($interval - 1)){
          $endDifInDays = $endJornada->diffInDays($contratoEnd, false);

          if($endDifInDays < 0){
            $endJornada = $endJornada->subDays(($endDifInDays * -1));
          }
        }

        $descanso = [
          'title' => 'Descanso ' . $lastContrato->jornada,
          'start' => $contratoStart->toDateString(),
          'end' => $endJornada->toDateString(),
          'allday' => true,
        ];

        $contratoStart->addDays($jornada->descanso);
        $events['descanso'][] = $descanso;
      }

    }

    return $events;
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
        'start' => $evento->inicio,
        'end' => $evento->fin,
        'color' => $data->color
      ];
    }

    return $eventos;
  }
}
