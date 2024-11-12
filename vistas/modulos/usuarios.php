<script src="vistas/dist/js/modulos/usuarios.js"></script>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><?php   if(in_array($_GET['vista'],array('usuarios')))   echo "Usuarios";      ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
                <li class="breadcrumb-item active">
                  <?php   if(in_array($_GET['vista'],array('usuarios')))   echo "Usuarios";      ?>
                </li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- =========tabla========== -->
    <div class="container-fluid">
        <div class="card">

          <div class="card-header">
            <button type="button" class="btn btn-primary" id="btn-nuevo" data-toggle="modal" data-target="#modal_creacion" ><i class="fas fa-plus"></i></button>
            
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                <i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>

          <div class="card-body row">
            <div class="col-md-12">
              <table class="col-md-12 table table-hover " id="tabla_usu">
                <thead>
                  <tr>
                    <th>Rol</th>
                    <th>Nombre</th>
                    <th>Usuario</th>
                    <th>Foto</th>
                    <th>Ultimo login</th>
                    <th>Estado</th>
                    <th>Acción</th>
                  </tr>
                </thead>
                <tbody id="body_usu">
                </tbody>                    
              </table>
            </div>
              
          </div>

        </div>
    </div>
</div>

<!-- modal de creacion  -->
<div class="modal fade " id="modal_creacion"  aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Creación de usuarios</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form role="form" method="post" enctype="multipart/form-data" id="frm_usu" action="" >
        <div class="modal-body">
          <div class="card"> 
              <div class="card-body row">

                <input type="hidden" name="tipo" id="tipo" value="nuevo" >

                <div class="form-group col-md-6">
                  <label for="">Usuario:</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1"><i class="fas fa-user"></i></span>
                    </div>
                    <input type="text" class="form-control" id="usuario" name="usuario" onchange="unicoUsuario(this.value)" value="">
                  </div>              
                </div>
    
                <div class="form-group col-md-6">
                  <label for="">Contraseña:</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1"><i class="fas fa-key" aria-hidden="true"></i></span>
                    </div>
                    <input type="password" class="form-control" id="password" name="password" value="">
                  </div>              
                </div>
    
                <div class="form-group col-md-6">
                  <label for="">Nombre:</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1"><i class="fas fa-user"></i></span>
                    </div>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="">
                  </div>              
                </div>
    
                <div class="form-group col-md-6">
                  <label for="">Apellidos:</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1"><i class="fas fa-user"></i></span>
                    </div>
                    <input type="text" class="form-control" id="apellido" name="apellido" value="">
                  </div>              
                </div>
    
                <div class="form-group col-md-6">
                  <label for="">Rol:</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1"><i class="fas fa-user"></i></span>
                    </div>
                    <select class="form-control" name="rol" id="rol">
                      <option value="">-</option>
                      <?php
    
                        $tabla="roles";
                        $campos="rol_id,rol_nombre";
                        $where="1=1 AND rol_estado='1'";
                        $result= usuarioControlador::getInput($tabla,$campos,$where);
                        foreach ($result as $res) {
                          $rol_id = $res['rol_id'];
                          $rol_nombre = $res['rol_nombre'];
                          echo"<option value=\"$rol_id\">$rol_nombre</option>";
                        }
                      ?>
                      
                    </select>
                  </div>              
                </div>
    
                <div class="form-group col-md-6">
                  <label for="">Telefono:</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1"><i class="fas fa-phone"></i></span>
                    </div>
                    <input type="number" min="0" maxlength="10" class="form-control" id="telefono" name="telefono" value="">
                  </div>              
                </div>
    
                <div class="form-group col-md-6">
                  <label for="">Correo:</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1"><i class="fas fa-envelope"></i></span>
                    </div>
                    <input type="email" class="form-control" id="correo" name="correo" value="">
                  </div>              
                </div>

                <div class="form-group col-md-6">
                  <label for="">Foto:</label>              
                  <input type="file" class="form-control" name="usu_foto" id="usu_foto" onchange="validarImagen('usu_foto')">                    
                </div>

              </div>

            
          </div>
        </div>
        <div class="modal-footer">           
          <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="limpiarModal()">Cerrar</button>  
          <button type="submit" class="btn btn-primary" onclick="validarCampos(event)" >Guardar</button>              
          <?php
          
          $ctrUsuario= new usuarioControlador();
          $ctrUsuario->ctrCreacionUsuario();

          ?>
        </div>
      </form> 
    </div>     
  </div>
</div>

<!-- modal de update  -->
<div class="modal fade " id="modal_upd_usu"  aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Creación de usuarios</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form role="form" method="post" enctype="multipart/form-data" id="frm_upd_usu" action="" >
        <div class="modal-body">
          <div class="card"> 
              <div class="card-body row">

                <input type="hidden" name="usu_codigo" id="usu_codigo" value="nuevo" >
                <input type="hidden" name="upd_tipo" id="upd_tipo" value="nuevo" >

                <div class="form-group col-md-6">
                  <label for="">Usuario:</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1"><i class="fas fa-user"></i></span>
                    </div>
                    <input type="text" class="form-control" id="upd_usuario" name="upd_usuario" value="">
                  </div>              
                </div>
    
                <div class="form-group col-md-6">
                  <label for="">Contraseña:</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1"><i class="fas fa-key" aria-hidden="true"></i></span>
                    </div>
                    <input type="password" class="form-control" id="upd_password" name="upd_password" value="">
                  </div>              
                </div>
    
                <div class="form-group col-md-6">
                  <label for="">Nombre:</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1"><i class="fas fa-user"></i></span>
                    </div>
                    <input type="text" class="form-control" id="upd_nombre" name="upd_nombre" value="">
                  </div>              
                </div>
    
                <div class="form-group col-md-6">
                  <label for="">Apellidos:</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1"><i class="fas fa-user"></i></span>
                    </div>
                    <input type="text" class="form-control" id="upd_apellido" name="upd_apellido" value="">
                  </div>              
                </div>
    
                <div class="form-group col-md-6">
                  <label for="">Rol:</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1"><i class="fas fa-user"></i></span>
                    </div>
                    <select class="form-control" name="upd_rol" id="upd_rol">
                      <option value="">-</option>
                      <?php
    
                        $tabla="roles";
                        $campos="rol_id,rol_nombre";
                        $where="1=1 AND rol_estado='1'";
                        $result= usuarioControlador::getInput($tabla,$campos,$where);
                        foreach ($result as $res) {
                          $rol_id = $res['rol_id'];
                          $rol_nombre = $res['rol_nombre'];
                          echo"<option value=\"$rol_id\">$rol_nombre</option>";
                        }
                      ?>
                      
                    </select>
                  </div>              
                </div>
    
                <div class="form-group col-md-6">
                  <label for="">Telefono:</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1"><i class="fas fa-phone"></i></span>
                    </div>
                    <input type="number" min="0" maxlength="10" class="form-control" id="upd_telefono" name="upd_telefono" value="">
                  </div>              
                </div>
    
                <div class="form-group col-md-6">
                  <label for="">Correo:</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1"><i class="fas fa-envelope"></i></span>
                    </div>
                    <input type="email" class="form-control" id="upd_correo" name="upd_correo" value="">
                  </div>              
                </div>

                <div class="form-group col-md-6">
                  <label for="">Foto:</label>              
                  <input type="file" class="form-control" name="upd_usu_foto" id="upd_usu_foto" onchange="validarImagen('upd_usu_foto')">                    
                </div>

              </div>

            
          </div>
          <div class="modal-footer">           
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>  
            <button type="submit" class="btn btn-primary" onclick="" >Actualizar</button>              
            <?php
            
            $ctrUsuario= new usuarioControlador();
            $ctrUsuario->ctrUpdateUsuario();

            ?>
          </div>
        </div>
      </form>  
    </div>  
  </div>
</div>