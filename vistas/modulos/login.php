<script src="vistas/dist/js/modulos/login.js"></script>


<section class="login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="#" class="h1"><b>App Avicola</b></a>
            </div>
            <div class="card-body">
                 <p class="login-box-msg">Inicia sesión</p>
        
                <form action="" method="post">

                    <input type="hidden" name="tipo" id="tipo" value="login">
                    
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Usuario" name="log_usuario" id="log_usuario" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="Contraseña" name="log_password" id="log_password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">              
                        <idv class="col-md-4"></idv>
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block" >Ingresar</button>
                        </div>

                        <?php
                            $login = new usuarioControlador();
                            $login->ctrLogin();
                        ?>
                    
                    </div>
                </form>
                            
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</section>

