<!--We indicate where is the layout that will use-->
<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark"> Gestión de Servicios</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <a href="/cliente/createCliente" class="btn btn-success btn-sm">Nuevo Servicio</a>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container -->
  </div><!-- /.content-header -->

  <!-- Main content -->
  <div class="content">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="card card-primary card-outline">
            <div class="card-header">
              <h5 class="card-title m-0">Lista de Servicios</h5>
            </div>
            <div class="card-body table-responsive no-padding">
              <table class="table table-hover">
                <tbody>
                  <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>&nbsp;Actions</th>
                  </tr>
                  <?php
                  foreach ($servicios as $item) {
                  ?>
                    <tr>
                      <td><?= $item['id'] ?></td>
                      <td><?= $item['nombre'] ?></td>
                      <td><?= $item['precio'] ?>€</td>
                      <td> 
                        <a href=<?= site_url('/editServicio/'.$item['id']) ?> ><img title="Editar elemento"src="/assets/template/img/pencil.png" width="30" height="30"/></a> 
                          &nbsp;&nbsp;&nbsp; 
                        <a href="<?= site_url('deleteServicio/'.$item['id']) ?>" onclick="return confirmDelete()"><img title="Eliminar elemento" src="/assets/template/img/trash.png" width="30" height="30"/>  
                        </a>
                      </td> 
                    </tr>
                  <?php
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>

        </div>
        <!-- /.col-md-6 -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content -->


  <!-- Content footer (Page footer User Management) -->
  <div class="content-header">
    <div class="container">
      <div class="row mb-2">
        <div class="col-sm-6">

        </div><!-- /.col -->
      <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <a href="/cliente/createCliente" class="btn btn-success btn-sm">Nuevo Servicio</a>
          </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div>

</div><!-- /.content-wrapper -->

    <?= $this->endSection() ?>