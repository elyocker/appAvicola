<script src="vistas/dist/js/modulos/clientes.js"></script>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <input type="hidden" id="rol_login" value="<?php echo $_SESSION['rol'];?>">
    
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Clientes</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
              <li class="breadcrumb-item active">Clientes</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      
      <div class="card">
        
        <div class="card-header">
          
          <button type="button" class="btn btn-primary" id="btn-cotizacion" data-toggle="modal" data-target="#modal_clientes" ><i class="fas fa-users"></i></button>
          

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>

        <div class="card-body ">  

          <table class="col-md-12 table table-hover " id="tabla_cliente">
            <thead>
              <tr>
                <th>Cedula</th>
                <th>Nombre</th>
                <th>Telefono</th>
                <th>Email</th>
                <th>Ubicación</th>
                <th>Acción</th>
              </tr>
            </thead>
            <tbody id="body_cliente">               
            </tbody>            
          </table>
                    
        </div>
        
      </div>

    </section>
</div>


<!-- modal de creacion clientes -->
<div class="modal  fade " id="modal_clientes"  aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog   modal-lg ">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Creación de cliente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form role="form" method="post" enctype="multipart/form-data" id="forma_cliente" action="" >
        <div class="modal-body">

          <div class="card">

            <div class="card-header">
              <H3>Datos del cliente</H3>
            </div>
            
            <div class="card-body row">
                <input type="hidden" id="tipo" name="tipo" value='nuevo'>
                <div class="form-group col-md-6">
                  <label for="">Cedula:</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1"><i class="fas fa-address-card"></i></span>
                    </div>
                    <input type="text" class="form-control" id="cli_cedula" name="cli_cedula" require onkeypress="evento(event,'cliente')">
                  </div>              
                </div>

                <div class="form-group col-md-6">
                  <label for="">Nombre completo:</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1"><i class="fas fa-user" aria-hidden="true"></i></span>
                    </div>
                    <input type="text" class="form-control" id="cli_nombre" name="cli_nombre" require>
                  </div>              
                </div>
                <div class="form-group col-md-6">
                  <label for="">Telefono:</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1"><i class="fas fa-phone" aria-hidden="true"></i></span>
                    </div>
                    <input type="number" min='0' maxlength="10" class="form-control" id="cli_telefono" name="cli_telefono" >
                  </div>              
                </div>

                
                <div class="form-group col-md-6">
                  <label for="">Email:</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1"><i class="fas fa-envelope"></i></span>
                    </div>
                    <input type="email" class="form-control" id="cli_email" name="cli_email" require>
                  </div>              
                </div>
                
                <div class="form-group col-md-6">
                  <label for="">Dirección:</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1"><i class="fas fa-home" aria-hidden="true"></i></span>
                    </div>
                    <input type="text" class="form-control" id="cli_direccion" name="cli_direccion" require>
                  </div>              
                </div>

                <div class="form-group col-md-6">
                  <label for="">Barrio:</label>                  
                  <input type="text" class="form-control" id="cli_barrio" name="cli_barrio" require>                            
                </div>

                <div class="form-group col-md-6">
                  <label for="">Departamento:</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1"><i class="fas fa-map" aria-hidden="true"></i></span>
                    </div>
                    <select class="form-control" id="departamento" name="departamento" onchange="getMunicipio(this.value,'ciudad');">
                      <option value="">-</option>
                      <?php
                        $depart= cotizacionControlador::getDepartamento();
                        foreach ($depart as $dep) {
                          echo"<option value='".$dep['id_departamento']."'>".$dep['departamento']."</option>";
                        }
                      ?>                      
                    </select>
                  </div>              
                </div>

                <div class="form-group col-md-6">
                  <label for="">Municipios:</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1"><i class="fas fa-map"></i></span>
                    </div>
                    <select class="form-control" id="ciudad" name="ciudad" >                                     
                    </select>
                  </div>              
                </div>

            </div>

          </div>
          
        </div>
        <div class="modal-footer">           
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>  
          <button type="button" class="btn btn-primary" onclick="validaForma(event);" >Registrar</button>              
          <?php
          
            $ctrCliente= new clientesControlador();
            $ctrCliente->setclientes();

          ?>
        </div>
      </form>    

    </div>
  </div>
</div>


<div class="modal  fade " id="modal_clientes_upd"  aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog   modal-lg ">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Actualización del cliente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form role="form" method="post" enctype="multipart/form-data" id="forma_cliente_upd" action="" >
        <div class="modal-body">

          <div class="card">

            <div class="card-header">
              <H3>Datos del cliente</H3>
            </div>

            <div class="card-body row">

                <input type="hidden" id="tipo" name="tipo" value='upd'>

                <div class="form-group col-md-6">
                  <label for="">Cedula:</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1"><i class="fas fa-address-card"></i></span>
                    </div>
                    <input type="text" class="form-control" id="cli_cedula_upd" name="cli_cedula_upd" require onkeypress="evento(event,'cliente')">
                  </div>              
                </div>

                <div class="form-group col-md-6">
                  <label for="">Nombre completo:</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1"><i class="fas fa-user" aria-hidden="true"></i></span>
                    </div>
                    <input type="text" class="form-control" id="cli_nombre_upd" name="cli_nombre_upd" require>
                  </div>              
                </div>
                <div class="form-group col-md-6">
                  <label for="">Telefono:</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1"><i class="fas fa-phone" aria-hidden="true"></i></span>
                    </div>
                    <input type="number" min='0' maxlength="10" class="form-control" id="cli_telefono_upd" name="cli_telefono_upd" >
                  </div>              
                </div>

                
                <div class="form-group col-md-6">
                  <label for="">Email:</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1"><i class="fas fa-envelope"></i></span>
                    </div>
                    <input type="email" class="form-control" id="cli_email_upd" name="cli_email_upd" require>
                  </div>              
                </div>
                
                <div class="form-group col-md-6">
                  <label for="">Dirección:</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1"><i class="fas fa-home" aria-hidden="true"></i></span>
                    </div>
                    <input type="text" class="form-control" id="cli_direccion_upd" name="cli_direccion_upd" require>
                  </div>              
                </div>

                <div class="form-group col-md-6">
                  <label for="">Barrio:</label>                  
                  <input type="text" class="form-control" id="cli_barrio_upd" name="cli_barrio_upd" require>                            
                </div>

                <div class="form-group col-md-6">
                  <label for="">Departamento:</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1"><i class="fas fa-map" aria-hidden="true"></i></span>
                    </div>
                    <select class="form-control" id="departamento_upd" name="departamento_upd" onchange="getMunicipio(this.value,'ciudad_upd');">
                      <option value="">-</option>
                      <?php
                        $depart= cotizacionControlador::getDepartamento();
                        foreach ($depart as $dep) {
                          echo"<option value='".$dep['id_departamento']."'>".$dep['departamento']."</option>";
                        }
                      ?>                      
                    </select>
                  </div>              
                </div>

                <div class="form-group col-md-6">
                  <label for="">Municipios:</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1"><i class="fas fa-map"></i></span>
                    </div>
                    <select class="form-control" id="ciudad_upd" name="ciudad_upd" >                                     
                    </select>
                  </div>              
                </div>

            </div>

          </div>

        </div>

        <div class="modal-footer">           
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>  
          <button type="button" class="btn btn-primary" onclick="validaFormaUpd(event);" >Actualizar</button>              
          <?php
          
            $ctrCliente= new clientesControlador();
            $ctrCliente->updclientes();

          ?>
        </div>
      </form> 
    </div>   
  </div>
</div>
