<div class="box box-success">
  <div class="box-body box-profile">
    <h3 class="profile-username text-center">{{ $producto->nombre }}</h3>
    <p class="text-muted text-center">Imagen</p>

    <a title="Descargar documento" href="{{ route( 'get_file', ['producto' => $producto->id, 'file' => 'imagen']  ) }}">
      <img class="img-responsive pad" src="{{ asset( 'laravel/public/uploads/' . $producto->imagen ) }}" alt="{{ $producto->nombre }}" style="margin:0 auto; max-height:150px;">
    </a>
    

    <p class="text-muted text-center">Etiqueta</p>
    <a title="Descargar documento" href="{{ route( 'get_file', ['producto' => $producto->id, 'file' => 'etiqueta']  ) }}">
      <img class="img-responsive pad" src="{{ asset( 'laravel/public/uploads/' . $producto->etiqueta ) }}" alt="{{ $producto->nombre }}" style="margin:0 auto; max-height:150px;">
    </a>

    <ul class="list-group list-group-unbordered">
      <li class="list-group-item">
        <b>Registrado </b> <span class="pull-right">{{ $producto->created_at }}</span>
      </li>
      @if( Auth::user()->role == 'Admin' || Auth::user()->role == 'Operativo' )
      <li class="list-group-item">
        <b>Por</b>
        <span class="pull-right">
          <a href="{{ route('users.show', ['id' => $producto->user->id]) }}">
            {{ $producto->user->nombre }}
          </a>
        </span>
      </li>
      @endif
      <li class="list-group-item">
        <b>Categoria </b> <span class="pull-right">{{ $producto->categoria->categoria }}</span>
      </li>
      <li class="list-group-item">
        <b>Código de producto</b>
        <span class="pull-right"> {{ $producto->codigo_producto }} </span>
      </li>
      <li class="list-group-item">
        <b>Código de barra</b>
        <span class="pull-right"> {!! $producto->codigo_barra() !!} </span>
      </li>
      <li class="list-group-item">
        <b>Peso</b>
        <span class="pull-right"> {{ $producto->peso }} </span>
      </li>
      <li class="list-group-item">
        <b>Volumen</b>
        <span class="pull-right"> {{ $producto->volumen }} </span>
      </li>
      <li class="list-group-item">
        <b>Subempaque</b>
        <span class="pull-right"> {{ $producto->subempaque }} </span>
      </li>
      <li class="list-group-item">
        <b>Empaque Master</b>
        <span class="pull-right"> {{ $producto->empaque_master }} </span>
      </li>
      <li class="list-group-item">
        <b>Cantidad por paleta</b>
        <span class="pull-right"> {{ $producto->cantidad_paleta }} </span>
      </li>
    </ul>
  </div><!-- /.box-body -->
</div>
