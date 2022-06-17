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
                    <h1 class="m-0 text-dark"> Nuevo <small>usuario</small></h1>
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

                        <div class="card-body">
                            <form method="post" action="/Usuario/createUsuario">

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

                                <div class="d-flex justify-content-center form_container">
                                    <div class="col-12 col-md-3">

                                        <div class="input-group mb-3">
                                            <input autocomplete="off" type="text" name="nombre" class="form-control input_user"  placeholder="Nombre *"/>
                                        </div>
                                        <div class="input-group mb-3">
                                            <input autocomplete="new-email" type="email" name="email" class="form-control input_user"  placeholder="email *"/>
                                        </div>
                                        <div class="input-group mb-3">
                                            <input autocomplete="new-password" type="password" name="password1" class="form-control input_pass"  placeholder="Password *"/>
                                        </div>
                                        <div class="input-group mb-3">
                                            <input autocomplete="off" type="password" name="password2" class="form-control input_pass"  placeholder="Repetir password *"/>
                                        </div>                                       

                                    </div>
                                </div>

                                <!-- Content footer (Page footer User Management) -->
                                <div class="content-header">
                                    <div class="container">
                                        <div class="row mb-2">
                                            <div class="col-sm-6">

                                            </div><!-- /.col -->
                                            <div class="col-sm-6">
                                                <ol class="breadcrumb float-sm-right">
                                                    <input type="submit" name="button" class="btn  btn-primary" value="Crear">
                                                </ol>
                                            </div><!-- /.col -->
                                        </div><!-- /.row -->
                                    </div>
                                </div>
                            </form>

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


<?= $this->endSection() ?>