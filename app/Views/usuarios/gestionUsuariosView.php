<!--We indicate where is the layout that will use-->
<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<script>
function confirmDeshabilitar() {
    var reply = confirm("Este usuario va ser deshabilitado, ¿Estas seguro de continuar con el proceso?");
    if (reply) {
        //aler("Elemento eliminado");
        return true;
    } else {
        return false;
    }
}

function confirmHabilitar() {
    var reply = confirm("Este usuario va ser habilitdo, ¿Estas seguro de continuar con el proceso?");
    if (reply) {
        //aler("Elemento eliminado");
        return true;
    } else {
        return false;
    }
}
</script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"> Gestión de Usuarios <?= $empresa['nombreEmpresa'] ?></h1>
                </div><!-- /.col -->
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right myactions">
                    <form method="post" action="/Usuario">
                      <div class="inputsfiltro">
                        <input name="cadena"  class="form-control input_user inputsearch" placeholder="Email" type="search" />
                        <button class="btn btn-success btn-sm search" type="submit"><img title="Buscar por email" src="/assets/template/img/lupa.png" width="30" height="30"/></button>
                      </div>
                    </form>
                        <a href="/Usuario/createUsuario" class="btn btn-success btn-sm newItem">Nuevo usuario</a>
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
                            <h5 class="card-title m-0">Lista de usuarios</h5>
                        </div>
                        <div class="card-body table-responsive no-padding">
                            <table class="table table-hover">
                                <tbody>
                                    <tr class="thead-dark">
                                        <th>Email</th>
                                        <th>Nombre</th>
                                        <th>Habilitado</th>
                                    </tr>
                                    <?php
                                    
                  foreach ($usuarios as $item) {
                    
                  ?>
                                    <tr>
                                        <td><?= $item->email ?></td>
                                        <td><?= $item->nombre ?></td>
                                        <td> <?php
                          if($item->estado == 'enable') {
                          ?>
                                            <!--<input type="checkbox" name="estadoUser"checked="true" onchange="return Check(this)" disabled = "disabled"/>-->
                                            <a href="<?= '/deshabilitarUser/'.$item->id ?>"
                                                class="btn btn-success btn-sm" onclick="return confirmDeshabilitar()"
                                                title="Deshabilitara el usuario"></a>
                                            <?php
                            }
                            else{
                              ?>
                                            <!--<input type="checkbox" name="estadoUser" onchange="return Check(this)" disabled = "disabled"/>-->
                                            <a href="<?= '/habilitarUser/'.$item->id ?>" class="btn btn-danger btn-sm"
                                                onclick="return confirmHabilitar()" title="Habilitara el usuario"></a>
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
                        <a href="/Usuario/createUsuario" class="btn btn-success btn-sm">Nuevo usuario</a>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div>

    </div><!-- /.content-wrapper -->

    <?= $this->endSection() ?>