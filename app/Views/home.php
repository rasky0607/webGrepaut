<!--We indicate where is the layout that will use-->
<?= $this->extend('layouts/main')?>


<?= $this->section('content')?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"> Welcome to <small>Grepaut</small></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h5 class="card-title m-0">Clientes</h5>
              </div>
              <div class="card-body">
                <h6 class="card-title">Listado de clientes</h6>

                <p class="card-text">Aquí podrás ver y gestionar los clientes que tiene registrados tu empresa.</p>
                <a href="cliente/" class="btn btn-primary">Gestión de clientes</a>
              </div>
            </div>

            <div class="card card-primary card-outline">
              <div class="card-header">
                <h5 class="card-title m-0">Coches</h5>
              </div>
              <div class="card-body">
                <h6 class="card-title">Listado de coches</h6>

                <p class="card-text">Aquí podrás ver y gestionar los coches que tiene registrados tu empresa.</p>
                <a href="/users" class="btn btn-primary">Gestión de coches</a>
              </div>
            </div>

            <div class="card card-primary card-outline">
              <div class="card-header">
                <h5 class="card-title m-0">Servicios</h5>
              </div>
              <div class="card-body">
                <h6 class="card-title">Listado de servicios</h6>

                <p class="card-text">Aquí podrás ver y gestionar los servicios que tiene registrados tu empresa.</p>
                <a href="/users" class="btn btn-primary">Gestión de servicios</a>
              </div>
            </div>

            <!--Cuando haga click un elemento de este listado, llevara a los detalles de es rapración, es decir los servicios ofrecisos o la tabla ServiciosReparaciones-->
             <div class="card card-primary card-outline">
              <div class="card-header">
                <h5 class="card-title m-0">Reparaciones</h5>
              </div>
              <div class="card-body">
                <h6 class="card-title">Listado de reparaciones</h6>

                <p class="card-text">Aquí podrás ver y gestionar las reparaciones que tiene registradas tu empresa.</p>
                <a href="/users" class="btn btn-primary">Gestión de reparaciones</a>
              </div>
            </div>


            <div class="card card-primary card-outline">
              <div class="card-header">
                <h5 class="card-title m-0">Logout</h5>
              </div>
              <div class="card-body">
                <h6 class="card-title">¡Hasta pronto!.</h6>

                <p class="card-text">Aquí puedes hacer logout de tu sesión en Grepaut.</p>
                <a href="/logout" class="btn btn-primary">Logout</a>
              </div>
            </div>

          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!--Here finaly the content of section-->
<?= $this->endSection()?>   