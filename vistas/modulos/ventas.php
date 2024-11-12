<script src="vistas/dist/js/modulos/balance.js"></script>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Ventas</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
              <li class="breadcrumb-item active">Ventas</li>
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
          <h3 class="card-title">Filtros de busqueda</h3>

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

          <div class="form-group col-md-4">
            <label for="">Nombre:</label>                
            <input type="text"  class="form-control" id="bal_nombre" name="bal_nombre" >                        
          </div>            

          <div class="form-group col-md-4">
            <label for="">Fecha inicio:</label>              
              <input type="date" class="form-control" id="fecha_ini" name="fecha_ini" >  
          </div>

          <div class="form-group col-md-4">   
            <label for="">Fecha fin:</label>             
            <input type="date" class="form-control" id="fecha_fin" name="fecha_fin"  >                        
          </div>

          <div class="form-group col-md-2">
            <label for="">Limite:</label>                
            <input type="number" min='0' class="form-control" id="limite" name="limite" value="10" >                        
          </div> 
          
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          <div class="row">
            <div class="col-md-5"></div>
            <div class="col-md-4">
            <button type="button" class="btn btn-primary" onclick="buscar('buscar')">Buscar</button>
              <button type="button" class="btn btn-secundary" onclick="cleanBalance()">Limpiar</button>
            </div>
          </div>
        </div>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->


      
      <!-- Default box -->
      <div class="card">
        
        <div class="card-header">
          <h3 class="card-title">Resultados de busqueda</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>
 
          <div class="card-body table-responsive p-0">
            <table class="table table-striped table-valign-middle" id="table_balance">
              <thead>
              <tr>
              <th>Id</th>
                <th>Nombre</th>
                <th>Excedente</th>
                <th>Proveedor</th>
                <th>Ingresos</th>
                <th>Porcentaje</th>
                <th>Valor 60%</th>
                <th>Valor 40%</th>
                <th>Fecha</th>
                <th>Estado</th>
                <th>Valor total</th>
              </tr>
              </thead>
              <tbody id="body_balance">
              </tbody>

              <tfoot id="foot_balance">                
              </tfoot>

            </table>
          </div>
                           
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
</div>