<?
set_title('Manage System Action');
set_layout("dt-layout.php", array(
    'pageSubTitle' => 'Manage System Action',
    'pageSubTitleText' => '',
    'pageBreadcrumbs' => array (
        array ( 'url'=>'index.php', 'text'=>'Home' ),
        array ( 'text'=>'System Manager' ),
        array ( 'text'=>'Manage System Action' )
    )
));


?>

         <!-- BEGIN INLINE TABS PORTLET-->
       <form action="" method="post" class="widget">
          <div class="widget-title">
             <h4><i class="icon-reorder"></i>MANAGE SYSTEM ACTIONS</h4>                 
          </div>
          <div class="widget-body form">
            <?php
              if(isset($_SESSION['RMC'])){
                  echo "<p style='color:#f00; font-size:16px;'>".$_SESSION['RMC']."</p>";
                  unset($_SESSION['RMC']);
              }
            ?>
             <div class="row-fluid">
                <div class="span12">
                   <!--BEGIN TABS-->
                   <div class="tabbable tabbable-custom">
                      <ul class="nav nav-tabs">
                         <li class="active" ><a href="#tab_2_1" data-toggle="tab">ADD SYSTEM ACTIONS</a></li>
                         <li><a href="#tab_2_2" data-toggle="tab">ALL SYSTEM ACTIONS</a></li>
                      </ul>
                      <div class="tab-content">
                         <div class="tab-pane active" id="tab_2_1">
                              <? include "add_sys_actions.php"; ?>
                         </div>

                        <div class="tab-pane" id="tab_2_2">
                             <? include "manage_sys_actions.php"; ?>
                        </div>

                      </div>
                    </div>
                    <!-- END PAGE --> 
                  </div>
                </div>
          </div>
     <!--END TABS-->


