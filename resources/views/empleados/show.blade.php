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
    <button class="btn btn-flat btn-danger" data-toggle="modal" data-target="#delModal"><i class="fa fa-times" aria-hidden="true"></i> Eliminar</button>
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
                <b>Nombres</b>
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
                <span class="pull-right">{{ number_format($empleado->contrato->sueldo, 0, ',', '.') }}</span>
              </li>
              <li class="list-group-item">
                <b>Inicio</b>
                <span class="pull-right">{{ $empleado->contrato->inicio }}</span>
              </li>
              <li class="list-group-item">
                <b>Fin</b>
                <span class="pull-right"> {!! $empleado->contrato->fin ? $empleado->contrato->fin : '<span class="text-muted">Indefinido</span>' !!} </span>
              </li>
            </ul>
          </div><!-- /.box-body -->
        </div>
      </div>

      <div class="col-md-6">
        <div class="col-md-12" style="margin-bottom: 5px">
          <h4>
            Documentos
            @if($empleado->documentos()->count() < 10)
            <span class="pull-right">
              <a class="btn btn-flat btn-success btn-sm" href="{{ route('documentos.create', ['empleado' => $empleado->id]) }}"><i class="fa fa-plus" aria-hidden="true"></i> Agregar</a>
            </span>
            @endif
          </h4>
        </div>
        @foreach($empleado->documentos()->get() as $documento)
          {!! $documento->generateThumb() !!}
        @endforeach
      </div>    
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="box box-solid">
          <div class="box-body">
           <div id="calendar"></div> 
          </div>
        </div>
      </div>
    </div>
  </section>

  <div id="delFileModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="delFileModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="delFileModalLabel">Eliminar archivo</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <form id="delete-file-form" class="col-md-8 col-md-offset-2" action="#" method="POST">
              {{ method_field('DELETE') }}
              {{ csrf_field() }}
              <h4 class="text-center">¿Esta seguro de eliminar este Documento?</h4><br>

              <center>
                <button class="btn btn-flat btn-danger" type="submit">Eliminar</button>
                <button type="button" class="btn btn-flat btn-default" data-dismiss="modal">Cerrar</button>
              </center>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="delModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="delModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="delModalLabel">Eliminar Empleado</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <form class="col-md-8 col-md-offset-2" action="{{ route('empleados.destroy', [$empleado->id]) }}" method="POST">
              {{ method_field('DELETE') }}
              {{ csrf_field() }}
              <h4 class="text-center">¿Esta seguro de eliminar este Empleado?</h4><br>

              <center>
                <button class="btn btn-flat btn-danger" type="submit">Eliminar</button>
                <button type="button" class="btn btn-flat btn-default" data-dismiss="modal">Cerrar</button>
              </center>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="delEventModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="delEventModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="delEventModalLabel">Eliminar Evento</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <form id="delEventForm" class="col-md-8 col-md-offset-2" action="#" method="POST">
              {{ method_field('DELETE') }}
              {{ csrf_field() }}
              <h4 class="text-center">¿Desea eliminar este evento?</h4><br>

              <center>
                <button class="btn btn-flat btn-danger" type="submit">Eliminar</button>
                <button type="button" class="btn btn-flat btn-default" data-dismiss="modal">Cerrar</button>
              </center>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="eventsModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="delModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="delModalLabel">Agregar evento</h4>
        </div>
        <div class="modal-body">
          <div class="row">
          <div class="col-md-8 col-md-offset-2">
            <div class="alert alert-danger">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong class="text-center">Ha ocurrido un error.</strong> 
            </div>
          </div>
            <form id="eventForm" class="col-md-8 col-md-offset-2" action="{{ route('eventos.store', ['empleado'=>$empleado->id]) }}" method="POST">
              <input type="hidden" name="empleado_id" value="{{ $empleado->id }}">
              <input id="eventDay" type="hidden" name="fecha" value="">
              {{ csrf_field() }}
              <h4 class="text-center" id="eventTitle"></span></h4>
              <div class="form-group">
                <label for="tipo">Evento:</label>
                <select id="tipo" class="form-control" name="tipo" required>
                  <option value="">Seleccione...</option>
                  <option value="1">Licencia médica</option>
                  <option value="2">Vacaciones</option>
                  <option value="3">Permiso</option>
                  <option value="4">Permiso no remunerable</option>
                  <option value="5">Despido</option>
                  <option value="6">Renuncia</option>
                </select>
              </div>

              <center>
                <button type="button" class="btn btn-flat btn-default" data-dismiss="modal">Cerrar</button>
                <button class="btn btn-flat btn-primary" type="submit">Gardar</button>
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
    var jornada = @json($empleado->proyectarJornada()),
        eventos = @json($empleado->getEventos()),
        year = new Date().getFullYear(),
        feriados = [{
          title: 'Feriado',
          start: year + '-01-01',
          fillday: true
        },
        {
          title: 'Feriado',
          start: year + '-04-19',
          fillday: true
        },
        {
          title: 'Feriado',
          start: year + '-04-20',
          fillday: true
        },
        {
          title: 'Feriado',
          start: year + '-05-21',
          fillday: true
        },
        {
          title: 'Feriado',
          start: year + '-06-29',
          fillday: true
        },
        {
          title: 'Feriado',
          start: year + '-07-16',
          fillday: true
        },
        {
          title: 'Feriado',
          start: year + '-08-15',
          fillday: true
        },
        {
          title: 'Feriado',
          start: year + '-09-18',
          fillday: true
        },
        {
          title: 'Feriado',
          start: year + '-09-19',
          fillday: true
        },
        {
          title: 'Feriado',
          start: year + '-09-20',
          fillday: true
        },
        {
          title: 'Feriado',
          start: year + '-10-12',
          fillday: true
        },
        {
          title: 'Feriado',
          start: year + '-10-31',
          fillday: true
        },
        {
          title: 'Feriado',
          start: year + '-11-01',
          fillday: true
        },
        {
          title: 'Feriado',
          start: year + '-12-08',
          fillday: true
        },
        {
          title: 'Feriado',
          start: year + '-12-25',
          fillday: true
        }];
   	
    $(document).ready(function(){
      $('#delFileModal').on('show.bs.modal', function(e){
        var button = $(e.relatedTarget),
            file   = button.data('file'),
            action = '{{ route("documentos.index") }}/' + file;

        $('#delete-file-form').attr('action', action);
      });

      $('#delete-file-form').submit(deleteFile);
      $('#eventForm').submit(storeEvent)
      $('#delEventForm').submit(delEvent)

      $('#calendar').fullCalendar({
        locale: 'es',
        eventSources: [{
          events: jornada.trabajo,
          color: '#3c8dbc',
          textcolor: 'white'
        },
        {
          events: jornada.descanso,
          color: '#00a65a',
          textcolor: 'white'
        },
        {
          events: feriados,
          color: '#f39c12',
          textcolor: 'white'
        },
        {
          events: eventos
        }
        ],
        dayClick: function(date){
          $('#eventTitle').text(date.format())
          $('#eventDay').val(date.format())
          $('#eventsModal').modal('show')
        },
        eventClick: function(event){
          console.log(event)
          if(event.id){
            $('#delEventModal').modal('show');
            $('#delEventForm').attr('action', '{{ route("eventos.index") }}/' + event.id);
          }else{
            $('#delEventForm').attr('action', '#');
          }
        }
      })
   	});

    function deleteFile(e){
      e.preventDefault();

      var form = $(this),
          action = form.attr('action');

      $.ajax({
        type: 'POST',
        url: action,
        data: form.serialize(),
        dataType: 'json',
      })
      .done(function(r){
        if(r.response){
          $('#file-' + r.id).remove();
          $('#delFileModal').modal('hide');
        }else{
          $('.alert').show().delay(7000).hide('slow');
        }
      })
      .fail(function(){
        $('.alert').show().delay(7000).hide('slow');
      })
    }

    function storeEvent(e){
      e.preventDefault();

      var form = $(this),
          action = form.attr('action'),
          alert  = form.find('.alert');
          button = form.find('button[type="submit"]');

      button.button('loading');
      alert.hide();

      $.ajax({
        type: 'POST',
        url: action,
        data: form.serialize(),
        dataType: 'json',
      })
      .done(function(r){
        if(r.response){
          $('#calendar').fullCalendar('renderEvent', {
            id: r.evento.id,
            className: 'clickableEvent',
            title: r.data.titulo,
            start: r.evento.fecha,
            allDay: true,
            color: r.data.color
          });
          form[0].reset()
          $('#eventsModal').modal('hide');
        }else{
          alert.show().delay(7000).hide('slow');
        }
      })
      .fail(function(){
        alert.show().delay(7000).hide('slow');
      })
      .always(function(){
        button.button('reset');
      })
    }

    function delEvent(e){
      e.preventDefault();

      var form = $(this),
          action = form.attr('action'),
          alert  = form.find('.alert');
          button = form.find('button[type="submit"]');

      button.button('loading');
      alert.hide();

      $.ajax({
        type: 'POST',
        url: action,
        data: form.serialize(),
        dataType: 'json',
      })
      .done(function(r){
        if(r.response){
          $('#calendar').fullCalendar('removeEvents', r.evento.id);
          $('#delEventModal').modal('hide');
        }else{
          alert.show().delay(7000).hide('slow');
        }
      })
      .fail(function(){
        alert.show().delay(7000).hide('slow');
      })
      .always(function(){
        button.button('reset');
      })
    }
 	</script>
@endsection
