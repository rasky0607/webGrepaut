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
                    <h1 class="m-0 text-dark"> Gestión de clientes</h1>
                </div><!-- /.col -->
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right myactions">
                    <form method="post" action="/Cliente">
                        <div class="inputsfiltro">
                            <input name="cadena" class="form-control input_user inputsearch" placeholder="Nombre" type="search" />
                            <button class="btn btn-success btn-sm search" type="submit"><img title="Buscar por nombre"
                                    src="/assets/template/img/lupa.png" width="30" height="30" /></button>
                        </div>
                    </form>
                        <a href="/cliente/createCliente" class="btn btn-success btn-sm newItem">Nuevo cliente</a>
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
                            <h5 class="card-title m-0">Lista de clientes</h5>
                        </div>
                        <div class="card-body table-responsive no-padding">
                            <table class="table table-hover">
                                <tbody>
                                    <tr class="thead-dark">
                                        <th>Nombre</th>
                                        <th>Apellidos</th>
                                        <th>Teléfono</th>
                                        <th>&nbsp;Actions</th>
                                    </tr>
                                    <?php
                  foreach ($clientes as $item) {
                  ?>
                                    <tr>
                                        <td title="Todos los vehiculos del cliente"><a
                                                href=" /detallesCochesEnPropiedad/<?=$item->id ?>/<?=$item->nombre ?>">
                                                <img title="Vehiculos de cliente <?=$item->id?> - <?=$item->nombre ?>"
                                                    src="/assets/template/img/carkey.png" width="30" height="30" />
                                            </a><?= $item->nombre ?></td>
                                        <td><?= $item->apellido ?> </td>
                                        <td><?= $item->tlf ?></td>
                                        <td>
                                            <a href=<?= site_url('/editCliente/'.$item->id) ?>><img
                                                    title="Editar elemento" src="/assets/template/img/pencil.png"
                                                    width="30" height="30" /></a>
                                            &nbsp;&nbsp;&nbsp;
                                            <a href="<?= site_url('deleteCliente/'.$item->id) ?>"
                                                onclick="return confirmDelete()"><img title="Eliminar elemento"
                                                    src="/assets/template/img/trash.png" width="30" height="30" />
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
                        <a href="/cliente/createCliente" class="btn btn-success btn-sm">Nuevo cliente</a>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div>

    </div><!-- /.content-wrapper -->

    <?= $this->endSection() ?>