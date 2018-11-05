@extends( 'layouts.app' )
@section( 'title', 'Empleado - '.config( 'app.name' ) )
@section( 'header','Empleado' )
@section( 'breadcrumb' )
  <ol class="breadcrumb">
    <li><a href="{{ route( 'dashboard' ) }}"><i class="fa fa-home" aria-hidden="true"></i> Inicio</a></li>
    <li class="active">Editar</li>
  </ol>
@endsection
@section('content')
  <!-- Formulario -->
  <div class="row">
    <div class="col-md-6 col-md-offset-3">
      <form class="" action="{{ route('empleados.update', [$empleado->id]) }}" method="POST">

        {{ method_field('PATCH') }}
        {{ csrf_field() }}

        <h4>Editar Empleado</h4>

        <fieldset>
          <legend>Datos del empleado</legend>

          <div class="form-group {{ $errors->has('nombres') ? 'has-error' : '' }}">
            <label class="control-label" for="nombres">Nombres: *</label>
            <input id="nombres" class="form-control" type="text" name="nombres" maxlength="50" value="{{ old('nombres') ? old('nombres') : $empleado->nombres }}" placeholder="Nombres" required>
          </div>

          <div class="form-group {{ $errors->has('apellidos') ? 'has-error' : '' }}">
            <label class="control-label" for="apellidos">Apellidos: *</label>
            <input id="apellidos" class="form-control" type="text" name="apellidos" maxlength="50" value="{{ old('apellidos') ? old('apellidos') : $empleado->apellidos }}" placeholder="Apellidos" required>
          </div>

          <div class="form-group {{ $errors->has('rut') ? 'has-error' : '' }}">
            <label class="control-label" for="rut">RUT: *</label>
            <input id="rut" class="form-control" type="text" name="rut" maxlength="20" value="{{ old( 'rut' ) ? old( 'rut' ) : $empleado->rut }}" placeholder="RUT" required>
          </div>

          <div class="form-group {{ $errors->has('direccion') ? 'has-error' : '' }}">
            <label class="control-label" for="direccion">Dirección: *</label>
            <input id="direccion" class="form-control" type="text" name="direccion" maxlength="100" value="{{ old('direccion') ? old('direccion') : $empleado->direccion }}" placeholder="Dirección" required>
          </div>

          <div class="form-group {{ $errors->has('telefono') ? 'has-error' : '' }}">
            <label class="control-label" for="telefono">Teléfono: *</label>
            <input id="telefono" class="form-control" type="telefono" name="telefono" maxlength="20" value="{{ old('telefono') ? old('telefono') : $empleado->telefono }}" placeholder="Teléfono" required>
          </div>

          <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
            <label class="control-label" for="email">Email: *</label>
            <input id="email" class="form-control" type="text" name="email" maxlength="50" value="{{ old('email') ? old('email') : $empleado->email }}" placeholder="Email" required>
          </div>

          <div class="form-group {{ $errors->has('talla_zapato') ? 'has-error' : '' }}">
            <label class="control-label" for="talla_zapato">Talla de zapato: *</label>
            <input id="talla_zapato" class="form-control" type="number" step="0.5" max="99" min="1" name="talla_zapato" value="{{ old('talla_zapato') ? old('talla_zapato') : $empleado->talla_zapato }}" required style="width: 80px">
          </div>

          <div class="form-group {{ $errors->has('talla_pantalon') ? 'has-error' : '' }}">
            <label class="control-label" for="talla_pantalon">Talla de pantalon: *</label>
            <input id="talla_pantalon" class="form-control" type="number" step="1" max="99" min="1" name="talla_pantalon" value="{{ old('talla_pantalon') ? old('talla_pantalon') : $empleado->talla_pantalon }}" required style="width: 80px">
          </div>
        </fieldset>

        <fieldset>
          <legend>Datos bancarios:</legend>

          <div class="form-group {{ $errors->has('nombre') ? 'has-error' : '' }}">
            <label class="control-label" for="nombre">Nombre del banco: *</label>
            <input id="nombre" class="form-control" type="text" maxlength="50" name="nombre" value="{{ old('nombre') ? old('nombre') : $empleado->banco->nombre }}" placeholder="Nombre del banco" required>
          </div>

          <div class="form-group {{ $errors->has('tipo_cuenta') ? 'has-error' : '' }}">
            <label class="control-label" for="tipo_cuenta">Tipo de cuenta: *</label>
            <input id="tipo_cuenta" class="form-control" type="text" maxlength="10" name="tipo_cuenta" value="{{ old('tipo_cuenta') ? old('tipo_cuenta') : $empleado->banco->tipo_cuenta }}" placeholder="Tipo de cuenta" required>
          </div>

          <div class="form-group {{ $errors->has('cuenta') ? 'has-error' : '' }}">
            <label class="control-label" for="cuenta">N° de Cuenta: *</label>
            <input id="cuenta" class="form-control" type="numeric" step="1" min="1" max="9999999999999999999999999" name="cuenta" value="{{ old('cuenta') ? old('cuenta') : $empleado->banco->cuenta }}" placeholder="N° de cuenta" required>
          </div>
        </fieldset>

        <fieldset>
          <legend>Contrato</legend>

          <div class="form-group {{ $errors->has('sueldo') ? 'has-error' : '' }}">
            <label class="control-label" for="sueldo">Sueldo: *</label>
            <input id="sueldo" class="form-control" type="number" step="1" min="1" maxlength="999999999999999" name="sueldo" value="{{ old('sueldo') ? old('sueldo') : $empleado->contratos->last()->sueldo }}" placeholder="Sueldo" required>
          </div>

          <div class="form-group {{ $errors->has('inicio') ? 'has-error' : '' }}">
            <label class="control-label" for="inicio">Inicio: *</label>
            <input id="inicio" class="form-control" type="text" name="inicio" value="{{ old('inicio') ? old('inicio') : $empleado->contratos->last()->inicio }}" placeholder="dd-mm-yyyy" required>
          </div>

          <div class="form-group {{ $errors->has('fin') ? 'has-error' : '' }}">
            <label class="control-label" for="fin">Fin:</label>
            <input id="fin" class="form-control" type="text" name="fin" value="{{ old('fin') ? old('fin') : $empleado->contratos->last()->fin }}" placeholder="dd-mm-yyyy">
          </div>

          <div class="form-group {{ $errors->has('jornada') ? 'has-error' : '' }}">
            <label class="control-label" class="form-control" for="jornada">Jornada: *</label>
            <select id="jornada" class="form-control" name="jornada">
              <option value="">Seleccione...</option>
              <option value="5x2" {{ old('jornada') == '5x2' ? 'selected' : $empleado->contratos->last()->jornada == '5x2' ? 'selected' : '' }}>5x2</option>
              <option value="4x3" {{ old('jornada') == '4x3' ? 'selected' : $empleado->contratos->last()->jornada == '4x3' ? 'selected' : '' }}>4x3</option>
              <option value="7x7" {{ old('jornada') == '7x7' ? 'selected' : $empleado->contratos->last()->jornada == '7x7' ? 'selected' : '' }}>7x7</option>
              <option value="10x10" {{ old('jornada') == '10x10' ? 'selected' : $empleado->contratos->last()->jornada == '10x10' ? 'selected' : '' }}>10x10</option>
              <option value="12x12" {{ old('jornada') == '12x12' ? 'selected' : $empleado->contratos->last()->jornada == '12x12' ? 'selected' : '' }}>12x12</option>
              <option value="20x10" {{ old('jornada') == '20x10' ? 'selected' : $empleado->contratos->last()->jornada == '20x10' ? 'selected' : '' }}>20x10</option>
            </select>
            <span class="help-block">Si no se selecciona, se colocara la jornada de la empresa</span>
          </div>
        </fieldset>

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
          <a class="btn btn-flat btn-default" href="{{ route('empleados.show', [$empleado->id] ) }}"><i class="fa fa-reply"></i> Atras</a>
          <button class="btn btn-flat btn-primary" type="submit"><i class="fa fa-send"></i> Guardar</button>
        </div>
      </form>
    </div>
  </div>
@endsection

@section( 'scripts' )
<script type="text/javascript">
  $(document).ready( function(){
    $('#inicio, #fin').datepicker({
      format: 'dd-mm-yyyy',
      startDate: 'today',
      language: 'es',
      keyboardNavigation: false,
      autoclose: true
    });
  });
</script>
@endsection