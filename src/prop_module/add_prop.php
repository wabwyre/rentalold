<?php
include_once 'src/models/Plots.php';
$prop = new Plots();

if(App::isAjaxRequest()) {
    if (!empty($_POST['edit_id'])){
        $prop->getPlotByPlotId($_POST['edit_id']);
    }
    if (!empty($_POST['id'])) {
        $prop->getOptionDataById($_POST['id']);
    }
}else{
set_title('Add a Property');
/**
 * Set the page layout that will be used
 */
set_layout("wizard-layout.php", array(
    'pageSubTitle' => 'Add property',
    'pageSubTitleText' => 'Allows one to add a property',
    'pageBreadcrumbs' => array(
        array('url' => 'index.php', 'text' => 'Home'),
        array('text' => 'PROPERTY MANAGEMENT'),
        array('text' => 'Add property')
    ),
    'pageWidgetTitle' => 'Property Details'
));

?>
<div class="widget box blue" id="property_wizard">
    <div class="widget-title">
        <h4>
            <i class="icon-reorder"></i> Add Property Details<span class="step-title"></span>
        </h4>
    </div>
    <div class="widget-body form">
        <?php

        $prop->splash('plots');
        (isset($_SESSION['warnings'])) ? $prop->displayWarnings('warnings') : '';
        ?>
        <form action="" method="post" class="form-horizontal" enctype="multipart/form-data">

            <div class="form-wizard">
                <h3 class="form-section">Provide Property Details</h3>
                <? include "add_prop_details.php"; ?>

                <div class="form-actions clearfix">
                    <!--hidden fields-->
                    <input type="hidden" name="created_by" value="<?php echo $_SESSION['mf_id'];?>"/>
                    <input type="hidden" name="action" value="add_property"/>
                    <button id="submit_wizard_contents" class="btn btn-primary button-submit">
                        Submit <i class="icon-ok"></i>
                    </button>
                </div>
            </div>
        </form>
    </div><?php ?>
</div>
<?php set_js(array('src/js/plots.js')); }?>
