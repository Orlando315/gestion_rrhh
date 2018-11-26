<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Scopes\IdScope;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

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

    foreach ($this->contratos()->get() as $contrato){
      
      $contratoStart = new Carbon($contrato->inicio);
      // Si el contrato no tiene fecha de fin, se proyectan 6 meses desde la fecha de inicio
      $contratoEnd = $contrato->fin ?? $contratoStart->copy()->addMonths(6);
      
      //Diferencia en dias desde el inicio hasta el fin del contrato      
      $diffInDays = $contratoStart->diffInDays($contratoEnd);
      $jornada = $contrato->jornada();
      // Intervalos a iterar para generar los bloquees de trabajo + descanso
      $interval = (int) ceil($diffInDays / $jornada->interval);
      $endDifInDays = 1;

      for ($i=0; $i < $interval; $i++){
        $endJornada = $contratoStart->copy()->addDays($jornada->trabajo);

        if($i == ($interval - 1)){
          $endDifInDays = $endJornada->diffInDays($contratoEnd, false);

          // Si fecha final de la jornada es menor a la fecha final de contrato
          // se le restan la diferencia en dias a sa jornada
          if($endDifInDays < 0){
            $endJornada = $endJornada->subDays(($endDifInDays * -1));
          }
        }

        $trabajo = [
          'title' => 'Trabajo ' . $contrato->jornada,
          'start' => $contratoStart->toDateString(),
          'end' => $endJornada->toDateString(),
          'allday' => true
        ];
        // Se aumenta la fecha de inicio con la cantidad de dias en la jornada
        $contratoStart->addDays($jornada->trabajo);

        $events['trabajo'][] = $trabajo;
        
        if($endDifInDays < 0){
          continue;
        }

        $endJornada = $contratoStart->copy()->addDays($jornada->descanso);

        if($i == ($interval - 1)){
          $endDifInDays = $endJornada->diffInDays($contratoEnd, false);

          // Si fecha final de la jornada es menor a la fecha final de contrato
          // se le restan la diferencia en dias a sa jornada
          if($endDifInDays < 0){
            $endJornada = $endJornada->subDays(($endDifInDays * -1));
          }
        }

        $descanso = [
          'title' => 'Descanso ' . $contrato->jornada,
          'start' => $contratoStart->toDateString(),
          'end' => $endJornada->toDateString(),
          'allday' => true,
        ];
        // Se aumenta la fecha de inicio con la cantidad de dias en la jornada
        $contratoStart->addDays($jornada->descanso);
        $events['descanso'][] = $descanso;
      }// For invertal

    }//Foreach contratos

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

  public function getFeriados()
  {
    $feriados = [];

    foreach (EmpleadosEvento::feriados() as $feriado) {
      $feriados[] = [
                      'title' => 'Feriado',
                      'start' => $feriado,
                      'fillday' => true
                    ];
    }

    return $feriados;
  }

  public function getDataAsArray($inicio = null, $fin = null)
  {
    // Contratos
    $lastContrato  = $this->contratos->last();
    $firstContrato = $this->contratos->first();
    
    $carbonInicioLastContrato = new Carbon($lastContrato->inicio);
    // Si el lastContrato no tiene fecha de fin, se proyectan 6 meses desde la fecha de inicio
    $finLastContrato = $lastContrato->fin ?? $carbonInicioLastContrato->addMonths(6);
    // Periodo desde el inicio del 1er contrato, hasta el fin del ultimo

    $inicio = $inicio ?? $firstContrato->inicio;
    $fin    = $fin ?? $finLastContrato;

    $periodo = new CarbonPeriod($inicio, $fin);

    // Headers para el excel
    $dataHeaders = ["{$this->rut} | {$this->nombres} {$this->apellidos}"];
    $dataRow = array_fill(0, count($periodo) + 1, null);

    foreach($periodo as $date){
      // Headers para el excel
      $dataHeaders[] = $date->format('Y-m-d');
    }

    $jornadas = $this->proyectarJornadaAsArray($dataRow, $dataHeaders);
    $eventos  = $this->getEventosAsArray($dataRow, $dataHeaders);
    $feriados = $this->getFeriadosAsArray($dataRow, $dataHeaders);

    return [$dataHeaders, $jornadas, $eventos, $feriados];
  }

  protected function proyectarJornadaAsArray($dataRow, $dataHeaders)
  {
    foreach ($this->contratos()->get() as $contrato){
      
      $contratoStart = new Carbon($contrato->inicio);
      // Si el contrato no tiene fecha de fin, se proyectan 6 meses desde la fecha de inicio
      $contratoEnd = $contrato->fin ?? $contratoStart->copy()->addMonths(6);

      // Diferencia en dias desde el inicio hasta el fin del contrato      
      $diffInDays = $contratoStart->diffInDays($contratoEnd);
      $jornada = $contrato->jornada();
      // Intervalos a iterar para generar los bloquees de trabajo + descanso
      $interval = (int) ceil($diffInDays / $jornada->interval);
      $endDifInDays = 1;

      for ($i=0; $i < $interval; $i++){
        $endJornada = $contratoStart->copy()->addDays($jornada->trabajo);

        if($i == ($interval - 1)){
          $endDifInDays = $endJornada->diffInDays($contratoEnd, false);

          // Si fecha final de la jornada es menor a la fecha final de contrato
          // se le restan la diferencia en dias a sa jornada
          if($endDifInDays < 0){
            $endJornada = $endJornada->subDays(($endDifInDays * -1));
          }
        }

        // Encuentro el index de la fecha de inicio de la jornada
        $dataStart = array_search($contratoStart->toDateString(), $dataHeaders);
        // Crea un array temporal desde el index encontrado y la cantidad de dias de trabajo
        $arrayTempData = array_fill($dataStart, $jornada->trabajo, 'Trabajo ' . $contrato->jornada);
        // Reemplaza los valores del array vacio con los valores de la jornada
        $dataRow = array_replace($dataRow, $arrayTempData);
        // Se aumenta la fecha de inicio con la cantidad de dias en la jornada
        $contratoStart->addDays($jornada->trabajo);
        
        if($endDifInDays < 0){
          continue;
        }

        $endJornada = $contratoStart->copy()->addDays($jornada->descanso);

        if($i == ($interval - 1)){
          $endDifInDays = $endJornada->diffInDays($contratoEnd, false);

          // Si fecha final de la jornada es menor a la fecha final de contrato
          // se le restan la diferencia en dias a sa jornada
          if($endDifInDays < 0){
            $endJornada = $endJornada->subDays(($endDifInDays * -1));
          }
        }

        // Encuentro el index de la fecha de inicio de la jornada
        $dataStart = array_search($contratoStart->toDateString(), $dataHeaders);
        // Crea un array temporal desde el index encontrado y la cantidad de dias de descanso
        $arrayTempData = array_fill($dataStart, $jornada->descanso, 'Descanso ' . $contrato->jornada);
        // Reemplaza los valores del array vacio con los valores de la jornada
        $dataRow = array_replace($dataRow, $arrayTempData);
        // Se aumenta la fecha de inicio con la cantidad de dias en la jornada
        $contratoStart->addDays($jornada->descanso);
      }// For invertal

    }// Foreach contratos

    //Eliminar datos sobrantes
    $dataRow = array_slice($dataRow, 0, count($dataHeaders));

    return $dataRow;
  }

  protected function getEventosAsArray($dataRow, $dataHeaders)
  {
    foreach($this->eventos()->get() as $evento){
      $data = $evento->eventoData();
      $inicio = new Carbon($evento->inicio);
      $diffInDays = 1;

      // Encuentra el index de la fecha de inicio
      $dataStart = array_search($inicio->toDateString(), $dataHeaders);
      
      if($dataStart === false){
        continue;
      }

      if($evento->fin){
        $fin = new Carbon($evento->fin);

        if($inicio->equalTo($fin)){
          // Encuentra el index de la fecha de inicio
          $dataEnd = array_search($fin->toDateString(), $dataHeaders);

          if($dataEnd === false){
            continue;
          }

          $diffInDays = $dataEnd - $dataStart;
        }
      }

      // Crea un array temporal usando los index encontrados
      $arrayTempData = array_fill($dataStart, $diffInDays, $data->titulo);
      // Reemplaza los valores del array vacio con los valores del evento
      foreach ($arrayTempData as $key => $data) {
        $dataRow[$key] = $dataRow[$key] == null ? $data : "{$dataRow[$key]}, {$data}";
      }
    }

    return $dataRow;
  }
  
  protected function getFeriadosAsArray($dataRow, $dataHeaders)
  {
    foreach (EmpleadosEvento::feriados() as $feriado){
      // Encuentro el index de la fecha del feriado
      $key = array_search($feriado, $dataHeaders);
      if($key === false){
        continue;
      }
      $dataRow[$key] = 'Feriado';
    }

    return $dataRow;
  }

  public static function exportAll($inicio = null, $fin = null)
  {
    // Tomar la fecha inicial mas baja
    $lowerDateContrato = EmpleadosContrato::orderBy('inicio', 'asc')->first();
    $inicio = $inicio ?? $lowerDateContrato->inicio;

    $lowerStartDate = new Carbon($inicio);

    // Contrato con fecha final mas alta
    $higherDateContrato = EmpleadosContrato::orderBy('fin', 'desc')->first();
    if($fin){
      $higherEndDate = new Carbon($fin);
    }else{
      $higherEndDate = new Carbon($higherDateContrato->fin);
      $higherEndDate->addMonths(6);  
    }

    // Periodo desde el inicio del contrato con fecha inicial mas baja, hasta la fecha final calculada
    $periodo = new CarbonPeriod($lowerStartDate, $higherEndDate);

    // Headers para el excel
    $dataHeaders = ['Empleado'];
    $dataRow = array_fill(0, count($periodo) + 1, null);

    foreach($periodo as $date){
      // Headers para el excel
      $dataHeaders[] = $date->format('Y-m-d');
    }

    $allData = [$dataHeaders];

    foreach (Empleado::all() as $empleado) {
      $nombre = "{$empleado->rut} | {$empleado->nombres} {$empleado->apellidos}";

      $jornadas    = $empleado->proyectarJornadaAsArray($dataRow, $dataHeaders);
      $jornadas[0] = $nombre;
      $eventos     = $empleado->getEventosAsArray($dataRow, $dataHeaders);
      $eventos[0 ] = $nombre;

      $allData = array_merge($allData, [$jornadas, $eventos]);
    }
    return $allData;
  }

  public function despidoORenuncia()
  {
    return $this->eventos()->where('tipo', 5)->orWhere('tipo', 6)->count();
  }

}
