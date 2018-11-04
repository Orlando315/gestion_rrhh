<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmpleadosDocumento extends Model
{
  protected $fillable = [
    'nombre',
    'path',
    'mime',
    'vencimiento'
  ];

  public function generateThumb()
  {

    $icon = $this->getIconByMime();
    $download = $this->getDownloadLink();

    $vencimiento = $this->vencimiento ? '<b>Vencimiento:</b> ' . $this->vencimiento : '';

    return "<div id='file-{$this->id}' class='col-md-6 col-sm-6 col-xs-12'>
              <div class='info-box'>
                <span class='info-box-icon bg-red'><i class='fa {$icon}'></i></span>
                <div class='info-box-content'>
                  <span class='info-box-text'>{$this->nombre}</span>
                  <div class='btn-group'>
                    <button type='button' class='btn btn-default dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                      <i class='fa fa-cog'></i> <span class='caret'></span>
                    </button>
                    <ul class='dropdown-menu dropdown-menu-right'>
                      <li>
                        <a title='Descargar documento' href='{$download}'>
                          Descargar <i class='fa fa-download' aria-hidden='true'></i>
                        </a>
                      </li>
                      <li>
                        <a type='button' title='Eliminar archivo' data-file='{$this->id}' class='btn-delete-file' data-toggle='modal' data-target='#delFileModal'>
                          Eliminar
                        </a>
                      </li>
                    </ul>
                  </div>
                  <p>{$vencimiento}</p>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>";
  }

  public function getDownloadLink()
  {
    return route('documentos.download', ['id' => $this->id]);
  }

  protected function getIconByMime()
  {
    switch ($this->mime) {
      case 'image/jpeg':
      case 'image/png':
        $url = 'fa-picture-o';
        break;

      case 'application/pdf':
        $url = 'fa-pdf-o';
        break;
      
      default:
        $url = 'fa-file';
        break;
    }

    return $url;
  }

  public function setVencimientoAttribute($date)
  {
    $this->attributes['vencimiento'] = $date ? date('Y-m-d', strtotime($date)) : null;
  }

  public function getVencimientoAttribute($date)
  {
    return $date ? date('d-m-Y', strtotime($date)) : null;
  }
}
