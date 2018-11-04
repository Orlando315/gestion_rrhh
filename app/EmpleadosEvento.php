<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmpleadosEvento extends Model
{
  protected $fillable = [
    'empleado_id',
    'fecha',
    'tipo'
  ];

  public function getEventos()
  {
    foreach ($this->all() as $key => $value) {
    }
  }

  public function eventoData()
  {
    switch($this->tipo){
      case '1':
        $data = ['titulo'=>'Licencia médica','color'=>'#aa6708'];
        break;
      case '2':
        $data = ['titulo'=>'Vacaciones',' color'=> '#6f5499'];
        break;
      case '3':
        $data = ['titulo'=>'Permiso',' color'=> '#ecf0f5'];
        break;
      case '4':
        $data = ['titulo'=>'Permiso no remunerable', 'color'=> '#222d32'];
        break;
      case '5':
        $data = ['titulo'=>'Despido', 'color'=> '#ce4844'];
        break;
      case '6':
        $data = ['titulo'=>'Renuncia', 'color'=> '#ce4844'];
        break;
    }
    return (object) $data;
  }
}
