@extends( 'layouts.app' )
@section( 'title', 'Perfil - '.config( 'app.name' ) )
@section( 'header','Perfil' )
@section( 'breadcrumb' )
  <ol class="breadcrumb">
    <li><a href="{{ route( 'dashboard' ) }}"><i class="fa fa-home" aria-hidden="true"></i> Inicio</a></li>
    <li><a href="{{ route( 'empresas.perfil' ) }}" title="Perfil"> Perfil </a></li>
    <li class="active">Editar</li>
  </ol>
@endsection
@section('content')
  <!-- Formulario -->
  <div class="row">
    <div class="col-md-6 col-md-offset-3">
      <form class="" action="{{ route('empresas.update') }}" method="POST">

        {{ method_field('PATCH') }}
        {{ csrf_field() }}

        <h4>Editar Perfil</h4>

        <div class="form-group {{ $errors->has('usuario') ? 'has-error' : '' }}">
          <label class="control-label" for="usuario">Usuario: *</label>
          <input id="usuario" class="form-control" type="text" name="usuario" value="{{ old( 'usuario' ) ? old( 'usuario' ) : Auth::user()->usuario }}" placeholder="Usuario" required>
        </div>

        <div class="form-group {{ $errors->has('nombre') ? 'has-error' : '' }}">
          <label class="control-label" for="nombre">Nombre: *</label>
          <input id="nombre" class="form-control" type="text" name="nombre" value="{{ old( 'nombre' ) ? old( 'nombre' ) : Auth::user()->nombre }}" placeholder="Nombre" required>
        </div>

        <div class="form-group {{ $errors->has('rut') ? 'has-error' : '' }}">
          <label class="control-label" for="rut">RUT: *</label>
          <input id="rut" class="form-control" type="text" name="rut" value="{{ old( 'rut' ) ? old( 'rut' ) : Auth::user()->rut }}" placeholder="RUT" required>
        </div>

        <div class="form-group {{ $errors->has('representante') ? 'has-error' : '' }}">
          <label class="control-label" for="representante">Representante: *</label>
          <input id="representante" class="form-control" type="text" name="representante" value="{{ old('representante') ? old('representante') : Auth::user()->representante }}" placeholder="Representante" required>
        </div>

        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
          <label class="control-label" for="email">Email: *</label>
          <input id="email" class="form-control" type="email" name="email" value="{{ old('email') ? old('email') : Auth::user()->email }}" placeholder="Email" required>
        </div>

        <div class="form-group {{ $errors->has('telefono') ? 'has-error' : '' }}">
          <label class="control-label" for="telefono">Teléfono: *</label>
          <input id="telefono" class="form-control" type="text" name="telefono" value="{{ old('telefono') ? old('telefono') : Auth::user()->telefono }}" placeholder="Teléfono" required>
        </div>

        <div class="form-group {{ $errors->has('jornada') ? 'has-error' : '' }}">
          <label class="control-label" class="form-control" for="jornada">Jornada: *</label>
          <select id="jornada" class="form-control" name="jornada" required>
            <option value="">Seleccione...</option>
            <option value="5x2" {{ old('jornada') == '5x2' ? 'selected' : Auth::user()->configuracion->jornada == '5x2' ? 'selected' : '' }}>5x2</option>
            <option value="4x3" {{ old('jornada') == '4x3' ? 'selected' : Auth::user()->configuracion->jornada == '4x3' ? 'selected' : '' }}>4x3</option>
            <option value="7x7" {{ old('jornada') == '7x7' ? 'selected' : Auth::user()->configuracion->jornada == '7x7' ? 'selected' : '' }}>7x7</option>
            <option value="10x10" {{ old('jornada') == '10x10' ? 'selected' : Auth::user()->configuracion->jornada == '10x10' ? 'selected' : '' }}>10x10</option>
            <option value="12x12" {{ old('jornada') == '12x12' ? 'selected' : Auth::user()->configuracion->jornada == '12x12' ? 'selected' : '' }}>12x12</option>
            <option value="20x10" {{ old('jornada') == '20x10' ? 'selected' : Auth::user()->configuracion->jornada == '20x10' ? 'selected' : '' }}>20x10</option>
          </select>
        </div>

        @if (count($errors) > 0)
        <div class="alert alert-danger alert-important">
          <ul>
            @foreach($errors->all() as $error)
               <li>{{ $error }}</li>
             @endforeach
          </ul>  
        </div>
        @endif

        <div class="form-group text-right">
          <a class="btn btn-flat btn-default" href="{{ route( 'empresas.perfil' ) }}"><i class="fa fa-reply"></i> Atras</a>
          <button class="btn btn-flat btn-primary" type="submit"><i class="fa fa-send"></i> Guardar</button>
        </div>
      </form>
    </div>
  </div>
@endsection

@section( 'scripts' )
<script type="text/javascript">
  $(document).ready( function(){

  });
</script>
@endsection