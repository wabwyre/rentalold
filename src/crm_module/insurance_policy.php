<?php
include_once('src/models/Masterfile.php');
$masterfile = new Masterfile();


set_layout("dt-layout.php", array(
	'pageSubTitle' => 'Manage Insurance Policies',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'CRM' ),
		array ( 'text'=>'Manage Insurance Policy' )
	)
	
));

set_css(array(
  'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.css'
));

?>
 <!-- BEGIN INLINE TABS PORTLET-->
       <form action="" method="post" class="widget">
          <div class="widget-title">
             <h4><i class="icon-reorder"></i>Manage Insurance Policy </h4>                 
          </div>
          <div class="widget-body">
            <?php
              if(isset($_SESSION['done-deal'])){
                  echo "<p style='color:#f00; font-size:16px;'>".$_SESSION['done-deal']."</p>";
                  unset($_SESSION['done-deal']);
              }
            ?>
             <div class="row-fluid">
                <div class="span12">
                   <!--BEGIN TABS-->
                   <div class="tabbable tabbable-custom">
                      <ul class="nav nav-tabs">
                         <li class="active" ><a href="#tab_2_1" data-toggle="tab">Add Insurance Policy</a></li>
                         <li><a href="#tab_2_2" data-toggle="tab">Upload Insurance Policy</a></li>
                      </ul>
                      <div class="tab-content">
                         <div class="tab-pane active" id="tab_2_1">
                              <? include "add_insurance_policy.php"; ?>
                         </div>

                        <div class="tab-pane" id="tab_2_2">
                             <? include "upload_policy.php"; ?>
                        </div>

                      </div>
                    </div>
                    <!-- END PAGE --> 
                  </div>
                </div>
          </div>
     <!--END TABS-->