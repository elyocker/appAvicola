<script src="vistas/dist/js/modulos/roles.js"></script>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Maestro de Productos</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
              <li class="breadcrumb-item active">Productos</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <button type="button" class="btn btn-primary" id="btn-nuevo" data-toggle="modal" data-target="#modal_cr_roles" >
            <i class="fas fa-plus"></i>
          </button>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>
        <div class="card-body">
            
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          
        </div>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
</div>

<!-- modal de creacion  -->
<div class="modal fade " id="modal_cr_roles"  aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Creación de Roles</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form role="form" method="post" enctype="multipart/form-data" id="frm_usu" action="" >
        <div class="modal-body">
          <div class="card"> 
              <div class="card-body row">

                <input type="hidden" name="tipo" id="tipo" value="nuevo" >
                  <div class="col-md-3"></div>
                <div class="form-group col-md-6">
                  <label for="">Rol:</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1"><i class="fas fa-user"></i></span>
                    </div>
                    <input type="text" class="form-control" id="rol_nombre" name="rol_nombre" value="" onchange="validaRol(this.value)">
                  </div>              
                </div>
    
              </div>

            </div>
          </div>
          <div class="modal-footer">           
            <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="limpiarModal()">Cerrar</button>  
            <button type="submit" class="btn btn-primary" onclick="validarCampos(event)" >Guardar</button>              
            <?php
            
              $ctrRol= new rolesControlador();
              $ctrRol->ctrCreacionRoles();

            ?>
          </div>
        </div>
      </form>    
  </div>
</div>
