<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="<?php   echo $_SESSION['logo']  ?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">App Avicola</span>
    </a>
    <?php
    
      $datos=new usuarioControlador();
      $datos->getUsuario();
    
    ?>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?php   echo $_SESSION['urlFoto']  ?>" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php   echo $_SESSION['nombreUsuario']  ?></a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <?php
            $result = menuControlador::getMenu();
            
            foreach ($result as $res) {
              $men_menu   = $res['men_menu'];
              $men_submen = $res['men_submen'];
              $men_menurl = $res['men_menurl'];
              $men_suburl = $res['men_suburl'];

              if ( $men_menu !='' && $men_submen=='' && $men_menurl !='' && $men_suburl==''  ) {
                  echo' <li class="nav-item">
                        <a href="'.$men_menurl.'" class="nav-link">
                          <i class="nav-icon fas fa-toolbox nav-icon"></i>
                          <p>'.$men_menu.'</p>
                        </a>
                      </li>';
              }

              if ($men_menu !='' && $men_submen!='' && $men_menurl =='' && $men_suburl!='' ) {
                if($_SESSION['rol']!='admin' &&  in_array($men_menu,array('Finanzas') ) ) continue;
                
                    echo' <li class="nav-item">
                            <a href="#" class="nav-link">              
                              <i class="nav-icon fas fa-toolbox "></i>
                              <p>
                                '.$men_menu.'
                                <i class="right fas fa-angle-left"></i>
                              </p>
                            </a>
                            <ul class="nav nav-treeview">';
                          
                              if (strpos($men_submen,',') || $men_submen!='')  {
                                $sub_menu = explode(',',$men_submen);
                                $sub_url = explode(',',$men_suburl);                             

                                for ($i=0; $i < sizeof($sub_menu); $i++) { 
                                  if($_SESSION['rol']!='admin' &&  in_array($sub_menu[$i],array('usuarios','roles','precios') ) ) continue;
                                    echo'<li class="nav-item">
                                      <a href="'.$sub_url[$i].'" class="nav-link">
                                        <i class="fas fa-hammer  nav-icon"></i>
                                        <p>'.$sub_menu[$i].'</p>
                                      </a>
                                    </li>'; 
                                  
                                }
                              }
                        echo'</ul>
                          </li>';
                  
                
              }
              
            }
        
          ?>
 
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>