@extends( 'layouts.app' )

@section( 'title', 'Perfil - '.config( 'app.name' ) )
@section( 'header', 'Perfil' )
@section( 'breadcrumb' )
	<ol class="breadcrumb">
	  <li><a href="{{ route( 'dashboard' ) }}"><i class="fa fa-home" aria-hidden="true"></i> Inicio</a></li>
	  <li class="active"> Perfil </li>
	</ol>
@endsection
@section( 'content' )
  <section>
    <a class="btn btn-flat btn-default" href="{{ route( 'dashboard' ) }}"><i class="fa fa-reply" aria-hidden="true"></i> Volver</a>
    <a class="btn btn-flat btn-success" href="{{ route( 'empresas.edit' ) }}"><i class="fa fa-pencil" aria-hidden="true"></i> Editar</a>
  </section>

  <section style="margin-top: 20px">

    @include('partials.flash')

    <div class="row">
      <div class="col-md-3">
        <div class="box box-danger">
          <div class="box-body box-profile">
            <h3 class="profile-username text-center">{{ Auth::user()->usuario }}</h3>
            <p class="text-muted text-center">{{ Auth::user()->created_at }}</p>

            <ul class="list-group list-group-unbordered">
              <li class="list-group-item">
                <b>Nombre</b>
                <span class="pull-right">{{ Auth::user()->nombre }}</span>
              </li>
              <li class="list-group-item">
                <b>RUT</b>
                <span class="pull-right">{{ Auth::user()->rut }}</span>
              </li>
              <li class="list-group-item">
                <b>Email</b>
                <span class="pull-right">{{ Auth::user()->email }}</span>
              </li>
              <li class="list-group-item">
                <b>Representante</b>
                <span class="pull-right"> {{ Auth::user()->representante }} </span>
              </li>
              <li class="list-group-item">
                <b>Teléfono</b>
                <span class="pull-right"> {{ Auth::user()->telefono }} </span>
              </li>
            </ul>
          </div><!-- /.box-body -->
        </div>
      </div>
    
    </div>
  </section>
@endsection

@section( 'script' )
 	<script type="text/javascript">
 	$(document).ready(function(){
 			$('#pp').click(function(event) {
	 		var bool = this.checked;
	 		if( bool ){
	 			$('#password_fields').show();
	 			$('#password, #password_confirmation').prop('required', true);
	 		}else{
	 			$('#password_fields').hide();
	 			$('#password, #password_confirmation').prop('required', false).val('');
	 		}
	 	});
 	});
 	</script>
@endsection
