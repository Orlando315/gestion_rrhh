@extends( 'layouts.app' )
@section( 'title','Inicio - '.config( 'app.name' ) )
@section( 'header','Inicio' )
@section( 'breadcrumb' )
  <ol class="breadcrumb">
    <li class="active"><i class="fa fa-home" aria-hidden="true"></i> Inicio</li>
  </ol>
@endsection

@section( 'content' )
  @include('partials.flash')
  <div class="row">
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-red"><i class="fa fa-users"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Empleados</span>
          <span class="info-box-number">{{ count($empleados) }}</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="box box-danger">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-users"></i> Empleados</h3>
          <span class="pull-right">
            <button class="btn btn-flat btn-warning" data-toggle="modal" data-target="#exportModal"><i class="fa fa-file-excel-o"></i> Exportar a excel</button>
            <a class="btn btn-success btn-flat" href="{{ route('empleados.create') }}"><i class="fa fa-plus" aria-hidden="true"></i> Nuevo empleado</a>
          </span>
        </div>
        <div class="box-body">
          <table class="table data-table table-bordered table-hover" style="width: 100%">
            <thead>
              <tr>
                <th class="text-center">#</th>
                <th class="text-center">Nombres</th>
                <th class="text-center">Apellidos</th>
                <th class="text-center">RUT</th>
                <th class="text-center">Teléfono</th>
                <th class="text-center">Acción</th>
              </tr>
            </thead>
            <tbody class="text-center">
              @foreach($empleados as $d)
                <tr>
                  <td>{{ $loop->index + 1 }}</td>
                  <td>{{ $d->nombres }}</td>
                  <td>{{ $d->apellidos }}</td>
                  <td>{{ $d->rut }}</td>
                  <td>{{ $d->telefono }}</td>
                  <td>
                    <a class="btn btn-primary btn-flat btn-sm" href="{{ route( 'empleados.show', ['id' => $d->id] )}}"><i class="fa fa-search"></i></a>
                    <a class="btn btn-success btn-flat btn-sm" href="{{ route( 'empleados.edit', ['id' => $d->id] )}}"><i class="fa fa-pencil"></i></a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>


  <div id="exportModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exportModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="exportModalLabel">Exportar a excel</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <form class="col-md-8 col-md-offset-2" action="{{ route('empleados.exportAll') }}" method="POST">
              {{ csrf_field() }}

              <div class="form-group">
                <label class="control-label" for="inicioExport">Inicio: *</label>
                <input id="inicioExport" class="form-control" type="text" name="inicio" placeholder="yyyy-mm-dd" required>
              </div>

              <div class="form-group">
                <label class="control-label" for="finExport">Fin: *</label>
                <input id="finExport" class="form-control" type="text" name="fin" placeholder="yyyy-mm-dd" rqeuired>
              </div>

              <center>
                <button type="button" class="btn btn-flat btn-default" data-dismiss="modal">Cerrar</button>
                <button class="btn btn-flat btn-success" type="submit">Enviar</button>
              </center>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
<script type="text/javascript">
  $(document).ready(function(){
    $('#inicioExport, #finExport').datepicker({
      format: 'yyyy-mm-dd',
      language: 'es',
      keyboardNavigation: false,
      autoclose: true
    }).on('changeDate', function(e){
      var inicio = new Date($('#inicioExport').val()),
          fin = new Date($('#finExport').val());

      if(inicio > fin){
        inicio.setDate(inicio.getDate() + 1)
        var newDate = inicio.getFullYear()+'-'+(inicio.getMonth()+1)+'-'+inicio.getDate()
        $('#finExport').datepicker('setDate', newDate)
      }
    });
  })
</script>
@endsection