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
            <a class="btn btn-warning btn-flat" href="{{ route('empleados.exportAll') }}"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Exportar jornadas</a>
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
@endsection
