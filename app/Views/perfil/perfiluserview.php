<!--We indicate where is the layout that will use-->
<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<!-- Content footer (Page footer User Management) -->
<div class="content-header">
    <div class="container">
        <h6>Vista Perfil</h6>
        <div class="row mb-2">
            <div class="col-sm-6">
                <!-- .col-sm-6 -->
                <!-- Si es de tipo admin puede añadir o cambiar foto de empresa,sino, no -->
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5 class="card-title m-0">Datos Empresa</h5>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <img src="/assets/pictures/<?= $empresa['logoEmpresa'] ?>" class="brand_logo" id="logoEmpresa" alt="Logo" style="max-width: 120px;margin-left: 30px;margin-right: 30px;">
                        </div>
                        <div class="col-sm-6">
                            <p>Nombre: <?= $empresa['nombreEmpresa'] ?>.</p>
                            <p>Dirección: <?= $empresa['direccionEmpresa'] ?>.</p>
                            <p>Teléfono: <?= $empresa['tlfEmpresa'] ?>.</p>

                            <!--- Test subir imagen-->

                            <!-- <form enctype="multipart/form-data" action="Perfil/upload" method="POST">
                                <input type="hidden" name="MAX_FILE_SIZE" value="512000" />
                                <p> Enviar mi archivo:
                                    <input name="archivo_csv" type="file" accept=".jpg" />
                                </p>
                                <p>
                                    <button class=\"btn btn-primary\">Enviar Archivo</button>
                                <div class="result">
                                </div>
                                </input>
                                </p>
                            </form>  -->
                            <!--- END Test subir imagen-->

                            <!--- Test subir imagen-->
                            <?php
                            //Determina si el usuario es admin o no, para mostrar el input para cambiar la imagen de empresa
                                if($_SESSION['tipo'] == "admin"){
                                    echo "                  
                                    <form id='myform' enctype=\"multipart/form-data\" action=\"/Perfil/upload\" method=\"POST\">                       
                                        <div style=\"width: max-content;\">
                                            <span class=\"btn btn-primary btn-file\">
                                                Cambiar logo <input name=\"archivo\" type=\"file\" onchange='submit()'>
                                            </span>
                                        </div>
                                    </form>  
                                
                                    ";
                                }?>
                            <!--- END Test subir imagen-->
                        </div>
                    </div>

                </div>
            </div><!-- /.col-sm-6 -->

            <div class="col-sm-6">
                <!-- Si es de tipo admin puede añadir o cambiar foto de empresa,sino, no -->
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5 class="card-title m-0">Datos usuario</h5>
                    </div>
                    <div class="card-body">
                        <p>Nombre: <?= $_SESSION['nombre'] ?>.</p>
                        <p>E-mail: <?= $_SESSION['email'] ?>.</p>
                        <p>Tipo de usuario: <?= $_SESSION['tipo'] ?>.</p>
                        <a href="/Perfil/changePassword" class="btn btn-primary">Cambiar contraseña</a>
                    </div>
                </div>
            </div><!-- /.col-sm-6 -->


        </div><!-- /.row  mb-2 -->

    </div><!-- /.container -->

</div><!-- /.content-header -->

<?= $this->endSection() ?>