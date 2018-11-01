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
            <img src="#" alt="Logo">
          </span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg">
            <img src="#" alt="Logo">
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

              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <span class="hidden-xs">{{ Auth::user()->usuario }}</span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <p>{{ Auth::user()->nombre }}<br>
                      <small>{{ Auth::user()->rut }}</small><br>
                      <small>{{ Auth::user()->email }}</small>
                    </p>
                    <p>
                      {{ Auth::user()->representante }}
                      <small>{{ Auth::user()->telefono }}</small>
                    </p>
                  </li>
                  
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="{{ route('empresas.perfil') }}" class="btn btn-flat btn-default"><i class="fa fa-user-circle" aria-hidden="true"></i> Perfil</a>
                    </div>
                    
                    <div class="pull-right">
                      <form action="{{ route('login.logout') }}" method="POST">
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
      })
    </script>

    @yield( 'scripts' )
  </body>
</html>