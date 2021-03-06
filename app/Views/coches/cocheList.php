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
                    <h1 class="m-0 text-dark"> Gestión de vehículos</h1>
                </div><!-- /.col -->
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right myactions">
                    <form method="post" action="/Coche">
                        <div class="inputsfiltro">
                            <input name="cadena" class="form-control input_user inputsearch" placeholder="Matricula" type="search" />
                            <button class="btn btn-success btn-sm search" type="submit"><img title="Buscar por matricula"
                                    src="/assets/template/img/lupa.png" width="30" height="30" /></button>
                        </div>
                    </form>
                        <a href="/Coche/createCoche" class="btn btn-success btn-sm newItem">Nuevo vehículo</a>
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
                            <h5 class="card-title m-0">Lista de vehículos</h5>
                        </div>
                        <div class="card-body table-responsive no-padding">
                            <table class="table table-hover">
                                <tbody>
                                    <tr class="thead-dark">
                                        <th>Matricula</th>
                                        <th>Marca</th>
                                        <th>Modelo</th>
                                        <th>Cliente</th>
                                        <th>&nbsp;Actions</th>
                                    </tr>
                                    <?php
                  foreach ($coches as $item) {
                  ?>
                                    <tr>
                                        <td><?= $item->matricula ?></td>
                                        <td><?= $item->marca ?></td>
                                        <td><?= $item->modelo ?></td>
                                        <td> <?= $item->nombre ?> <?= $item->apellido ?>
                                            <a
                                                href=" /detallesCochesEnPropiedad/<?=$item->idcliente?>/<?=$item->nombre ?>">
                                                <img title="Vehiculos de cliente <?=$item->idcliente?> - <?=$item->nombre ?>"
                                                    src="/assets/template/img/carkey.png" width="30" height="30" />
                                            </a>
                                        </td>
                                        <td>
                                            <a href="<?= site_url('/editCoche/'.$item->id) ?>/<?= $item->id ?>"><img
                                                    title="Editar elemento <?=$item->id?>" src="/assets/template/img/pencil.png"
                                                    width="30" height="30" /></a>
                                            &nbsp;&nbsp;&nbsp;
                                            <a href="<?= site_url('deleteCoche/'.$item->id) ?>"
                                                onclick="return confirmDelete()"><img title="Eliminar elemento <?=$item->id?>"
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
                        <a href="/Coche/createCoche" class="btn btn-success btn-sm">Nuevo vehículo</a>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div>

    </div><!-- /.content-wrapper -->

    <?= $this->endSection() ?>