@extends( 'layouts.app' )

@section( 'title', 'Empleado - '.config( 'app.name' ) )
@section( 'header', 'Empleado' )
@section( 'breadcrumb' )
	<ol class="breadcrumb">
	  <li><a href="{{ route( 'dashboard' ) }}"><i class="fa fa-home" aria-hidden="true"></i> Inicio</a></li>
	  <li class="active"> Empleado </li>
	</ol>
@endsection
@section( 'content' )
  <section>
    <a class="btn btn-flat btn-default" href="{{ route('dashboard') }}"><i class="fa fa-reply" aria-hidden="true"></i> Volver</a>
    <a class="btn btn-flat btn-success" href="{{ route('empleados.edit', [$empleado->id]) }}"><i class="fa fa-pencil" aria-hidden="true"></i> Editar</a>
  </section>

  <section style="margin-top: 20px">

    @include('partials.flash')

    <div class="row">
      <div class="col-md-3">
        <div class="box box-danger">
          <div class="box-body box-profile">
            <h4 class="profile-username text-center">
              Datos del Empleado
            </h4>
            <p class="text-muted text-center"></p>

            <ul class="list-group list-group-unbordered">
              <li class="list-group-item">
                <b>Nombre</b>
                <span class="pull-right">{{ $empleado->nombres }}</span>
              </li>
              <li class="list-group-item">
                <b>Apellidos</b>
                <span class="pull-right">{{ $empleado->apellidos }}</span>
              </li>
              <li class="list-group-item">
                <b>RUT</b>
                <span class="pull-right"> {{ $empleado->rut }} </span>
              </li>
              <li class="list-group-item">
                <b>Dirección</b>
                <span class="pull-right"> {{ $empleado->direccion }} </span>
              </li>
              <li class="list-group-item">
                <b>Teléfono</b>
                <span class="pull-right"> {{ $empleado->telefono }} </span>
              </li>
              <li class="list-group-item">
                <b>Email</b>
                <span class="pull-right">{{ $empleado->email }}</span>
              </li>
              <li class="list-group-item">
                <b>Talla de zapato</b>
                <span class="pull-right">{{ $empleado->talla_zapato }}</span>
              </li>
              <li class="list-group-item">
                <b>Talla de pantalon</b>
                <span class="pull-right">{{ $empleado->talla_pantalon }}</span>
              </li>
              <li class="list-group-item">
                <b>Registrado</b>
                <span class="pull-right">{{ $empleado->created_at }}</span>
              </li>
            </ul>
          </div><!-- /.box-body -->
        </div>
      </div>
      <div class="col-md-3">
        <div class="box box-primary">
          <div class="box-body box-profile">
            <h4 class="profile-username text-center">
              Datos Bancarios
            </h4>
            <p class="text-muted text-center"></p>

            <ul class="list-group list-group-unbordered">
              <li class="list-group-item">
                <b>Banco</b>
                <span class="pull-right">{{ $empleado->banco->nombre }}</span>
              </li>
              <li class="list-group-item">
                <b>Tipo de cuenta</b>
                <span class="pull-right">{{ $empleado->banco->tipo_cuenta }}</span>
              </li>
              <li class="list-group-item">
                <b>Cuenta</b>
                <span class="pull-right"> {{ $empleado->banco->cuenta }} </span>
              </li>
            </ul>
          </div><!-- /.box-body -->
        </div>
        <div class="box box-primary">
          <div class="box-body box-profile">
            <h4 class="profile-username text-center">
              Contrato
            </h4>
            <p class="text-muted text-center"></p>

            <ul class="list-group list-group-unbordered">
              <li class="list-group-item">
                <b>Sueldo</b>
                <span class="pull-right">{{ $empleado->contrato->sueldo }}</span>
              </li>
              <li class="list-group-item">
                <b>Inicio</b>
                <span class="pull-right">{{ $empleado->contrato->inicio }}</span>
              </li>
              <li class="list-group-item">
                <b>Fin</b>
                <span class="pull-right"> {{ $empleado->contrato->fin ? $empleado->contrato->fin : 'Indefinido.' }} </span>
              </li>
            </ul>
          </div><!-- /.box-body -->
        </div>
      </div>

      <div class="col-md-6">
        <div class="col-md-12">
          <h4>
            Documentos
            <span class="pull-right">
              <a class="btn btn-flat btn-success btn-sm" href="{{ route('documentos.create', [$empleado->id]) }}"><i class="fa fa-plus" aria-hidden="true"></i> Agregar</a>
            </span>
          </h4>
          
        </div>
        @foreach($empleado->documentos()->get() as $documento)
          {!! $documento->createThumb() !!}
        @endforeach
      </div>    
    </div>
  </section>
@endsection

@section( 'script' )
 	<script type="text/javascript">
 	$(document).ready(function(){
 	});
 	</script>
@endsection
