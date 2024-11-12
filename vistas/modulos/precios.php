<script src="vistas/dist/js/modulos/precios.js"></script>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <input type="hidden" id="rol_login" value="<?php echo $_SESSION['rol'];?>">
    
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Precios</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
              <li class="breadcrumb-item active">Precios</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <form role="form" method="post" enctype="multipart/form-data" id="forma_proy_upd" action="" >
       
        <input type="hidden" id="tipo" name="tipo" value="upd">
        <input type="hidden" id="id" name="id" value="">
        
        <div class="card">
          
          <div class="card-header">
            
            <h3>Valores de la cotización</h3>
  
            <div class="card-tools">
              
              <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
  
          <div class="card-body row">  
  
            <div class="form-group col-md-4">
              <label for="valor">Valor arquitectonico:</label>
              <input type="text" class="form-control" id="vlr_arquitectonico" name="vlr_arquitectonico" value="">
            </div>
  
            <div class="form-group col-md-4">
              <label for="valor">Valor proyecto 1 piso:</label>
              <input type="text" class="form-control" id="vlr_proyecto" name="vlr_proyecto" value="">
            </div>
  
            <div class="form-group col-md-4">
              <label for="valor">Valor propiedad Horizontal:</label>
              <input type="text" class="form-control" id="vlr_prohori" name="vlr_prohori" value="">
            </div>
  
            <div class="form-group col-md-4">
              <label for="valor">Valor levantamiento arquitectonico:</label>
              <input type="text" class="form-control" id="vlr_levanarqui" name="vlr_levanarqui" value="">
            </div>
  
            <div class="form-group col-md-4">
              <label for="valor">Valor estudio de suelos:</label>
              <input type="text" class="form-control" id="vlr_suelos" name="vlr_suelos" value="">
            </div>
  
            <div class="form-group col-md-4">
              <label for="valor">Valor de gastos:</label>
              <input type="text" class="form-control" id="vlr_gastos" name="vlr_gastos" value="">
            </div>
  
        
          </div>
  
        </div>
  
  
        <div class="card">
          
          <div class="card-header">
            
            <h3>Valores de la documentación</h3>
  
            <div class="card-tools">
              
              <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
  
          <div class="card-body row">  
  
            <div class="form-group col-md-4">
              <label for="valor">Certificado de tradicción:</label>
              <input type="text" class="form-control" id="vlr_tradicion" name="vlr_tradicion" value="">
            </div>
  
            <div class="form-group col-md-4">
              <label for="valor">Valor vecinos :</label>
              <input type="text" class="form-control" id="vlr_vecinos" name="vlr_vecinos" value="">
            </div>
  
            <div class="form-group col-md-4">
              <label for="valor">Valor confinado:</label>
              <input type="text" class="form-control" id="vlr_confinado" name="vlr_confinado" value="">
            </div>
  
            <div class="form-group col-md-4">
              <label for="valor">Valor aporticado:</label>
              <input type="text" class="form-control" id="vlr_aporticado" name="vlr_aporticado" value="">
            </div>
        
          </div>
  
          
        </div>
  

        <div class="card">
          
          <div class="card-header">
            
            <h3>Valores de linea de paramentos</h3>
  
            <div class="card-tools">
              
              <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
  
          <div class="card-body row">  
  
            <table class="table">
              <thead>
                <tr>
                  <th>rango inicio</th>
                  <th>rango fin</th>
                  <th>valor</th>
                  <th>valor de estampilla</th>
                </tr>
              </thead>
              <tbody id="body_precios">              
              </tbody>           
            </table>
        
          </div>
  
          <div class="card-footer row">
            <div class="col-md-5"></div>
            <div class="col-md-5">
              <button type="submit" class="btn btn-primary">Actualizar</button>
              <?php
              
              $precios=  new preciosControlador();
              $precios->ctrUpdaPrecios();
 
              ?>
            </div>
          </div>
          
        </div>
      </form>

    </section>
</div>



