<script src="vistas/dist/js/modulos/cotizacion.js"></script>
<script src="vistas/dist/js/modulos/inicio.js"></script>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Bienvenido a la Avicola</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
              <li class="breadcrumb-item active">Pagina principal</li>
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
            <div class="row">
              <?php
              
                if ($_SESSION['rol']=='admin') {
                    echo'<div class="col-lg-6 col-6">
                          <div class="small-box bg-success">
                            
                            <div class="inner">
                              <h3 id="h3_ingresos">150.000</h3>
                              <p>Ganancias</p>
                            </div>
          
                            <div class="icon">
                              <i class="fas fa-dollar-sign"></i>
                            </div>
                            <a href="balance" class="small-box-footer">Mas informacion... <i class="fas fa-arrow-circle-right"></i></a>
                          </div>
                        </div>
          
                        <div class="col-lg-6 col-6">
                          <div class="small-box bg-warning">
                            
                            <div class="inner">
                              <h3 id="h3_gastos">1.500.000</h3>
                              <p>Gastos Mensuales</p>
                            </div>
          
                            <div class="icon">
                              <i class="fas fa-dollar-sign"></i>
                            </div>
                            <a href="balance" class="small-box-footer">Mas informacion... <i class="fas fa-arrow-circle-right"></i></a>
                          </div>
                        </div>';
                }

              ?>
              <div class="col-md-6">
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Inventario</h3>
  
                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                      </button>
                      <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                      </button>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="chart">
                      <canvas id="lineChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                  </div>
                  <!-- /.card-body -->
                </div>
              </div>
              <div class="col-md-6">
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Ventas</h3>
  
                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                      </button>
                      <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                      </button>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="chart">
                      <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                  </div>
                  <!-- /.card-body -->
                </div>
              </div>
           
            </div>
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

