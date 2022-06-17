<!--Head and header-->
<!--Head-->
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Grepaut</title>
  <link rel="icon" type="image/png" href="/assets/pictures/favicon.png" />

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="/assets/template/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/assets/template/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link rel="stylesheet" href="/assets/styles.css">
  <script>
        
        function confirmDelete(){
            var reply=confirm("Este elemento va ser elimnado, ¿Estas seguro de continuar con el proceso?");
            if(reply){
                //aler("Elemento eliminado");
                return true;
            }else{
                return false;
            }
        }

        function confirmAnulacion(){
            var reply=confirm("Esta factura va ser anulada y va generarse una negativa en su lugar. ¿Estas seguro de continuar con el proceso?");
            if(reply){
                //aler("Elemento eliminado");
                return true;
            }else{
                return false;
            }
        }
        function copiarAlPortapapeles(id_elemento) {
            var aux = document.createElement("input");
            aux.setAttribute("value", document.getElementById(id_elemento).innerHTML);
            document.body.appendChild(aux);
            aux.select();
            document.execCommand("copy");
            document.body.removeChild(aux);

        }

        function Check(obj){
            console.log(obj+"hola");
        }
                
</script>
</head>
<body class="hold-transition sidebar-collapse layout-top-nav">
    <div class="wrapper">
<!--Header-->
    <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">
        <a href="/" class="navbar-brand">
        <span class="brand-text font-weight-light">Grepaut</span>
        </a>
        
        <div class="collapse navbar-collapse order-3" id="navbarCollapse">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            
        </ul>
        </div>

        <!-- Right navbar links -->
        <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
        <li class="nav-item">
            <a title="Muestra todas las opciones disponibles." href="/home/" class="nav-link">Home</a>
        </li>
        <li class="nav-item">
            <a title="Listado de todos los clientes." href="/Cliente/" class="nav-link">Clientes</a>
        </li>
        <li class="nav-item">
            <a title="Listado de todos los vehículos." href="/Coche/" class="nav-link">Vehículos</a>
        </li>
        <li class="nav-item">
            <a title="Listado de todos los servicios." href="/Servicio/" class="nav-link">Servicios</a>
        </li>
        <li class="nav-item">
            <a title="Listado de todas las reparaciones." href="/Reparacion/" class="nav-link">Reparaciones</a>
        </li>
        <li class="nav-item">
            <a title="Listado de todas las facturas." href="/Factura/" class="nav-link">Facturas</a>
        </li>
        <?php
            //Determina si el usuario es admin o no, para mostrar el acceso a la gestion de usuarios
                if($_SESSION['tipo'] == "admin"){
                    echo "
                    <li class=\"nav-item\">
                        <a title=\"Dar de alta o deshabilitar/habilitar usuarios.\" href=\"/Usuario/\" class=\"nav-link\">Gestion</a>
                    </li>
                    ";
                }

        ?>
        <li class="nav-item">
            <a title="Dar de alta y elimninar usuarios." href="/Perfil/" class="nav-link">Perfil de <?= $_SESSION['nombre'] ?></a>
        </li>

        <li class="nav-item">
            <a title="Cierra la sesión del usuario." href="/logout" class="nav-link">Logout</a>
        </li>

        </ul>
    </div>
    </nav>
    <!--Contenido-->
    <div class="container-fluid">
        <?= $this->renderSection('content') ?>
    <!--Footer-->
    </div>
        <footer class="main-footer">
            <!-- To the right -->
            <div class="float-right d-none d-sm-inline">
            
            </div>
            <!-- Default to the left -->
            <strong>Copyright &copy; 2021 <a href="https://github.com/rasky0607/webGrepaut">Proyecto Grepaut</a>.</strong> Todos los derechos reservados.
        </footer>
        </div>
        <!-- ./wrapper -->

        <!-- REQUIRED SCRIPTS -->
        <!-- jQuery -->
        <script src="/assets/template/plugins/jquery/jquery.min.js"></script>
        <!-- Bootstrap 4 -->
        <script src="/assets/template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- AdminLTE App -->
        <script src="/assets/template/js/adminlte.min.js"></script>
    </body>
</html>
