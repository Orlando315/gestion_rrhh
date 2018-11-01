<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield( 'title' , config( 'app.name' ) )</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Icon 16x16 -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset( 'images/icon.png' ) }}">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" type="text/css" href="{{ asset( 'css/bootstrap.min.css' ) }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" type="text/css" href="{{ asset( 'css/font-awesome.min.css' ) }}">
    <!-- Theme style -->
    <link rel="stylesheet" type="text/css" href="{{ asset( 'css/AdminLTE.min.css' ) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset( 'css/glyphicons.css' ) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset( 'plugins/datatables/dataTables.min.css' ) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset( 'plugins/datatables/RowGroup/css/rowGroup.bootstrap.min.css' ) }}">

    <link rel="stylesheet" type="text/css" href="{{ asset( 'plugins/datepicker/css/bootstrap-datepicker3.min.css' ) }}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset( 'css/_all-skins.min.css' ) }}">
    <link rel="stylesheet" href="{{ asset( 'css/style.css' ) }}">
  </head>
  <body class="hold-transition skin-red sidebar-mini">
    <div class="wrapper">
      <header class="main-header">
        <!-- Logo -->
        <a href="{{ route( 'dashboard' ) }}" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini">
            <img src="{{ asset('images/icon.png') }}" alt="Dr.">
          </span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg">
            <img src="{{ asset('images/logo_white.png') }}" alt="Dr. Care">
          </span>
        </a>

        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Navegación</span>
          </a>
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- Messages: style can be found in dropdown.less-->
              <!-- User Account: style can be found in dropdown.less -->
              
              @if( Auth::user()->role === 'Admin' )
              <li class="dropdown tasks-menu">
                <a href="{{ route('users.index') }}#solicitudes" title="Solicitudes de ingreso">
                  <i class="fa fa-user-plus"></i>
                  @if( count($notUsers) > 0 )
                  <span class="label label-warning">{{ count($notUsers) }}</span>
                  @endif
                </a>
              </li>
              @endif

              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <span class="hidden-xs">{{ Auth::user()->cedula() }}</span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <p>{{ Auth::user()->nombre }}</p>
                    <p>
                      {{ Auth::user()->departamento->departamento }}
                      <small>{{ Auth::user()->cargo->cargo }}</small>
                    </p>
                  </li>
                  
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="{{ route( 'perfil' ) }}" class="btn btn-flat btn-default"><i class="fa fa-user-circle" aria-hidden="true"></i> Perfil</a>
                    </div>
                    
                    <div class="pull-right">
                      <form id="logout-form" action="{{ route( 'logout' ) }}" method="POST">
                        {{ csrf_field() }}
                        <button class="btn btn-flat btn-default" type="submit"><i class="fa fa-sign-out" aria-hidden="true"></i> Salir</button>
                      </form>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">MENÚ</li>

            <li>
              <a href="{{ route('dashboard') }}">
                <i class="fa fa-home"></i> Inicio
              </a>
            </li>
            
            @if( Auth::user()->role === 'Admin' )

            <li class="treeview">
              <a href="#">
                <i class="fa fa-building"></i>
                <span>Departamentos</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{ route( 'departamentos.index' ) }}"><i class="fa fa-circle-o"></i>Ver departamentos</a></li>
                <li><a href="{{ route( 'departamentos.create' ) }}"><i class="fa fa-circle-o"></i>Agregar departamento</a></li>
              </ul>
            </li>

            <li class="treeview">
              <a href="#">
                <i class="fa fa-address-card"></i>
                <span>Cargo</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{ route( 'cargos.index' ) }}"><i class="fa fa-circle-o"></i>Ver cargos</a></li>
                <li><a href="{{ route( 'cargos.create' ) }}"><i class="fa fa-circle-o"></i>Agregar cargo</a></li>
              </ul>
            </li>

            <li class="treeview">
              <a href="#">
                <i class="fa fa-users"></i>
                <span>Usuarios</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{ route( 'users.index' ) }}"><i class="fa fa-circle-o"></i>Ver usuarios</a></li>
                <li><a href="{{ route( 'users.create' ) }}"><i class="fa fa-circle-o"></i>Agregar usuario</a></li>
              </ul>
            </li>            
            @endif

            <li class="treeview">
              <a href="#">
                <i class="fa fa-cubes"></i>
                <span>Productos</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{ route( 'productos.index' ) }}"><i class="fa fa-circle-o"></i>Ver productos</a></li>
                @if( Auth::user()->role == 'Admin' || Auth::user()->role == 'Operativo' )
                <li><a href="{{ route( 'productos.create' ) }}"><i class="fa fa-circle-o"></i>Agregar producto</a></li>
                @endif
              </ul>
            </li>

            <li>
              <a href="{{ route('about.index') }}">
                <i class="fa fa-exclamation-circle"></i> Sobre Dr. Care
              </a>
            </li>
  
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>

      <!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Main content -->
        <section class="content-header">
          <h1>
            @yield( 'header' )
          </h1>
          @yield( 'breadcrumb' )
        </section>
        <!-- Main content -->
        <section class="content">
          @yield( 'content' )
        </section>
      </div><!-- /.content-wrapper -->
      <!--Fin-Contenido-->
      <footer class="main-footer">
      </footer>
    </div><!-- .wrapper -->
    <!-- jQuery 2.1.4 -->
    <script type="text/javascript" src="{{ asset( 'js/jQuery-2.1.4.min.js' ) }}"></script>
    <!-- Bootstrap 3.3.5 -->
    <script type="text/javascript" src="{{ asset( 'js/bootstrap.min.js' ) }}"></script>
    <!-- AdminLTE App -->
    <script type="text/javascript" src="{{ asset( 'js/app.min.js' ) }}"></script>
    <!-- Data table -->
    <script type="text/javascript" src="{{ asset( 'plugins/datatables/datatables.min.js' ) }}"></script>
    <script type="text/javascript" src="{{ asset( 'plugins/datatables/RowGroup/js/rowGroup.bootstrap.min.js' ) }}"></script>
    <!-- Datepicker -->
    <script type="text/javascript" src="{{ asset( 'plugins/datepicker/js/bootstrap-datepicker.min.js' ) }}"></script>
    <script type="text/javascript" src="{{ asset( 'plugins/datepicker/locales/bootstrap-datepicker.es.min.js' ) }}"></script>
    <script type="text/javascript">
      $(document).ready(function(){
        $('div.alert').not('.alert-important').delay(7000).slideUp(300);

        $('.data-table').DataTable({
          responsive: true,
          language: {
            url:'{{ asset( "plugins/datatables/spanish.json" ) }}'
          }
        });

        $('.table-products').DataTable({
          responsive: true,
          pageLength: 100,
          language: {
            url:'{{ asset( "plugins/datatables/spanish.json" ) }}'
          },
          rowGroup: {
            dataSrc: 1
          },
          columnDefs: [
            {
              "targets": [ 1 ],
              "visible": false
            }
        ]
        });
      })
    </script>

    @yield( 'scripts' )
  </body>
</html>