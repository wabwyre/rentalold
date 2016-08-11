<?php
include_once 'src/models/House.php';
$house = new House();

set_layout("dt-layout.php", array(
    'pageSubTitle' => 'Units Profile',
    'pageSubTitleText' => '',
    'pageBreadcrumbs' => array (
        array ( 'url'=>'#', 'text'=>'Home' ),
        array ( 'text'=>'PROPERTY MANAGER' ),
        array ( 'url'=>'?num=view_houses', 'text'=>'All units' ),
        array ( 'text'=>'Units Profile' )
    )
));

set_css(array(
    'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.css',
    'assets/css/pages/profile.css'
));

set_js(array(
    'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.js',
));


?>

<div class="widget">
    <div class="widget-title"><h4><i class="icon-reorder"></i> <span style="color: green;"><?php $result = $house->getHouseModelDetails($_GET['house_id']); echo $result[0]['house_number']; ?></span></h4></div>
    <div class="widget-body form">
        <!-- BEGIN INLINE TABS PORTLET-->
        <form enctype="multipart/form-data" class="form-horizontal" method="post" id= "" class="widget">
            <div class="row-fluid">
                <div class="span12">
                    <!--BEGIN TABS-->
                    <div class="tabbable tabbable-custom">
                        <ul class="nav nav-tabs">
                            <?php
                            $tab1 = '';
                            $tab2 = '';
                            if(isset($_SESSION['done-deal'])){
                                $tab2 = 'active';
                            }
                            else{
                                $tab1 = 'active';
                            }
                            ?>
                            <li class="<?=$tab1; ?>"><a href="#tab_1_1" data-toggle="tab"><i class="icon-user"></i> Profile Info</a></li>
                            <li class="<?=$tab2; ?>"><a href="#tab_1_2" data-toggle="tab"><i class="icon-map-marker"></i> Unit services</a></li>

                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane <?=$tab1; ?> profile-classic row-fluid"  id="tab_1_1">
                                <?php include_once "house_profile_info.php"; ?>
                            </div>

                            <div class="tab-pane <?=$tab2; ?> profile-classic row-fluid" id="tab_1_2">
                                <?php include "house_services_info.php"; ?>
                            </div>

                        </div>

                    </div>
                    <!--END TABS-->
                    <!-- END PAGE -->
                </div>
            </div>
        </form>
    </div>
</div>
