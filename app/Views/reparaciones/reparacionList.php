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
                    <h1 class="m-0 text-dark"> Gestión de Reparaciones</h1>
                </div><!-- /.col -->
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right myactions">
                    <form method="post" action="/Reparacion">
                        <div class="inputsfiltro">
                            <input name="cadena" class="form-control input_user inputsearch" placeholder="Matricula" type="search" />
                            <button class="btn btn-success btn-sm search" type="submit"><img
                                    title="Buscar por matricula de vehiculo" src="/assets/template/img/lupa.png"
                                    width="30" height="30" /></button>
                        </div>
                    </form>
                        <a href="/Reparacion/createReparacion" class="btn btn-success btn-sm newItem">Nueva
                            reparación</a>
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
                            <h5 class="card-title m-0">Lista de Reparaciones</h5>
                        </div>
                        <div class="card-body table-responsive no-padding">
                            <table class="table table-hover">
                                <tbody>
                                    <tr class="thead-dark">
                                        <th>Estado de reparación</th>
                                        <th>Técnico</th>
                                        <th>Matricula vehículo</th>
                                        <th>&nbsp;Actions</th>
                                    </tr>
                                    <?php
                  foreach ($reparaciones as $item) {
                  ?>
                                    <?php
                      /*Si el estado no es facturado, se pone rojo, si es facturado, se pone verde*/
                        if($item->estadoReparacion != 'facturado') {
                        ?>
                                    <tr style="background-color: #ff867c;">
                                        <?php
                        }else {
                      ?>
                                    <tr style="background-color: #5efa81;">
                                        <?php
                      }
                      ?>
                                        <td><?= $item->estadoReparacion ?></td>
                                        <td title="id de tecnico <?=$item->idusuario?>"><?= $item->nombreTecnico ?></td>
                                        <td title="id de coche <?=$item->idcoche?>"><?= $item->matricula ?></td>
                                        <td>

                                            <a href=" /detallesReparacion/<?=$item->id ?>"> <img
                                                    title="Ver/Añadir servicios a reparacion con id <?=$item->id?>"
                                                    src="/assets/template/img/repair.png" width="30" height="30" />
                                                &nbsp;&nbsp;&nbsp;
                                                <a
                                                    href=<?= site_url('/editReparacion/'.$item->id.'/'.$item->idusuario.'/'.$item->idcoche) ?>><img
                                                        title="Editar elemento" src="/assets/template/img/pencil.png"
                                                        width="30" height="30" /></a>
                                                &nbsp;&nbsp;&nbsp;
                                                <a href="<?= site_url('deleteReparacion/'.$item->id) ?>"
                                                    onclick="return confirmDelete()"><img title="Eliminar elemento"
                                                        src="/assets/template/img/trash.png" width="30" height="30" />
                                                </a>

                                                <?php
                        if($item->estadoReparacion != 'facturado') {
                        ?>
                                                &nbsp;&nbsp;&nbsp;
                                                &nbsp;&nbsp;&nbsp;
                                                <a href=<?= site_url('/facturarReparacion/'.$item->id) ?>><img
                                                        title="Generar factura de esta reparción"
                                                        src="/assets/template/img/invoice.png" width="30"
                                                        height="30" /></a>

                                                <?php
                        }else {
                       ?>
                                                &nbsp;&nbsp;&nbsp;
                                                <a href=<?= site_url('/facturarReparacion/'.$item->id) ?>></a>
                                                <?php
                        }
                       ?>

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
                        <a href="/Reparacion/createReparacion" class="btn btn-success btn-sm">Nueva reparación</a>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div>

    </div><!-- /.content-wrapper -->

    <?= $this->endSection() ?>