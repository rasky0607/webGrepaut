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
                    <h1 class="m-0 text-dark"> Gestión de Facturas</h1>
                    <div class="col-sm-12">
                        <ol class="breadcrumb float-sm-right myactions">
                        <form method="post" action="/Factura">
                            <div class="inputsfiltro">
                                <input name="cadena" class="form-control input_user inputsearch" placeholder="Matricula" type="search" />
                                <button class="btn btn-success btn-sm search" type="submit"><img
                                        title="Buscar por nombre" src="/assets/template/img/lupa.png" width="30"
                                        height="30" /></button>
                            </div>
                        </form>                         
                        </ol>
                    </div><!-- /.col -->
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
                            <h5 class="card-title m-0">Lista de Facturas</h5>
                        </div>
                        <?php
            if (!empty($error)) {
              ?>
                        <div class="d-flex justify-content-center form_container">
                            <div class="col-12 col-md-3">
                                <div class="d-flex mb-3 errormsg">
                                    <span><?= $error ?></span>
                                </div>
                            </div>
                        </div>
                        <?php
            }
            ?>

                        <div class="card-body table-responsive no-padding">
                            <table class="table table-hover">
                                <tbody>
                                    <tr class="thead-dark">
                                        <th>Nº de factura</th>
                                        <th>ID de reparación</th>
                                        <th>Matricula vehiculo</th>
                                        <th>ID de técnico</th>
                                        <th>Fecha</th>
                                        <th>Estado de factura</th>
                                        <th>Nº de factura anulada</th>
                                        <th>&nbsp;Actions</th>
                                    </tr>
                                    <?php
                  foreach ($facturas as $item) {
                    ?>
                                    <?php
                      /*Si el estado no es facturado, se pone rojo, si es facturado, se pone verde*/
                        if($item->estado != 'vigente') {
                        ?>
                                    <tr style="background-color: #ff867c;">
                                        <?php
                        }else {
                      ?>
                                    <tr style="background-color: #5efa81;">
                                        <?php
                      }
                      ?>
                                        <td><a
                                                href=" /detallesFactura/<?=$item->numerofactura ?>/<?=$item->idreparacion ?>"><?= $item->numerofactura ?>
                                        </td>
                                        <td><?= $item->idreparacion ?></td>
                                        <td><?= $item->matricula ?></td>
                                        <td title="id de tecnico <?=$item->idusuario?>"><?= $item->nombreTecnico ?></td>
                                        <td><?= $item->fecha ?></td>
                                        <td><?= $item->estado ?></td>
                                        <td><?= $item->numerofacturanulada ?></td>
                                        <td>
                                            <?php
                          if($item->estado == 'vigente') {
                          ?>
                                            <a href="<?= '/anularFactura/'.$item->idreparacion ?>"
                                                onclick="return confirmAnulacion()"> <img
                                                    title="Anular factura y crear otra factura negativa"
                                                    src="/assets/template/img/cancelar.png" width="30" height="30" />
                                            </a>
                                            &nbsp;&nbsp;&nbsp;

                                            <?php
                            }
                            else{
                              ?>
                                            <a href="<?= '/anularFactura/'.$item->idreparacion ?>">
                                            </a>
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

            </div><!-- /.row -->
        </div>

    </div><!-- /.content-wrapper -->

    <?= $this->endSection() ?>