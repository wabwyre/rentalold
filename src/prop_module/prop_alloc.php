<?php
include_once('src/models/House.php');
include_once 'src/models/Plots.php';
$prop = new Plots;
$house = new House;
if(app::isAjaxRequest()){
    $House->getAllocDetails($_POST['edit_id']);
}else{

    set_layout("dt-layout.php", array(
        'pageSubTitle' => 'Manage property attributes',
        'pageSubTitleText' => '',
        'pageBreadcrumbs' => array (
            array ( 'url'=>'index.php', 'text'=>'Home' ),
            array ( 'text'=>'Property' ),
            array ( 'url'=>'?num=pro_attr_alloc', 'text'=>'All Attributes' ),
            array ( 'text'=>'Manage property attributes' )
        )

    ));


//print_r($data);exit;
    ?>
    <div class="widget">
        <div class="widget-title"><h4><i class="icon-reorder"></i> Attributes for: <?php if(isset($_GET['p_name'])){ echo $_GET['p_name']; } ?>  <span style="color: green;"><?php //echo $data['house_number']; ?></h4>
            <span class="actions">
			<a href="#add_house_spec" data-toggle="modal" class="btn btn-small btn-primary"><i class="icon-plus"></i> Attach</a>


		</span>
        </div>
        </br>
        <div class="widget-body form">
            <?php
            $house->splash('house_attr');
            (isset($_SESSION['warnings'])) ? $house->displayWarnings('warnings') : '';

            if(isset($_SESSION['house'])){
                echo $_SESSION['house'];
                unset($_SESSION['house']);
            }
            ?>

            <table id="table1" class="table table-bordered">
                <thead>
                <tr>
                    <th>#Id</th>
                    <th>Attribute</th>
                    <th>Value</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if (isset($_GET['plot_id'])) {
                    $id = $_GET['plot_id'];
                    //echo '<strong><h3>Plot: '.if(isset($_GET['p_name'])){ echo $_GET['p_name']; }.'</h3></strong>';
                    $data = $prop->getAllocDetails($id);
                    //var_dump($data);die;
                    $count = 0;
                }
                if (count($data)) {
                    foreach ($data as $row) {
                        $count++;
                        ?>
                        <tr>
                            <td><?php echo $count; ?></td>
                            <td><?php echo $prop->getAttrNameByID($row['prop_attr_id']); ?></td>
                            <td><?php echo $row['value']; ?></td>
                            <td><a href="#edit_house_spec" class="btn btn-mini btn-success edit_spec_btn" data-toggle="modal" edit-id="<?php echo $row['unit_alloc_id']; ?>" id=""><i class="icon-edit"></i> Edit</a></td>
                            <td><a href="#delete_house_spec" class="btn btn-mini btn-danger del_spec_btn" data-toggle="modal" delete-id="<?php echo $row['unit_alloc_id']; ?>" id=""><i class="icon-remove icon-white"></i> Detach</a></td>
                        </tr>
                    <?php }
                } ?>
                </tbody>
            </table>
            <div class="clearfix"></div>
        </div>
    </div>

    <!--  add allocation modals -->
    <form action="" method="post" class="form-horizontal">
        <div id="add_house_spec" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
             aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel1">Attach  a property attribute</h3>
            </div>
            <div class="modal-body">
                <div class="row-fluid">
                    <select class="span12 live_search" name="attribute_id" required="required">
                        <option value="">--Select Specifications--</option>
                        <?php
                        $data = $prop->listAllAttributes();

                        if(count($data)){
                            foreach($data as $row){
                                //if(!$data = $house->checkIfHouseAttributeisAttached($_GET['hos_id'],$row['attribute_id'])){
                                    ?>
                                    <option value="<?=$row['prop_attr_id']; ?>"><?=$row['prop_attr_name']; ?></option>
                                <?php }}?>

                    </select>
                </div>
                <div class="row-fluid">
                    <label for="attribute_value">Spec Value:</label>
                    <input type="text" name="attribute_value"  class="span12" required>
                </div>
                <input type="hidden" name="prop_id" value="<?php if (isset($_GET['plot_id'])) {
                    echo $id = $_GET['plot_id'];}?>"/>
            </div>
            <!-- the hidden fields -->
            <input type="hidden" name="action" value="attch_prop_attr"/>
            <div class="modal-footer">
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Clo728'); ?>
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav727'); ?>
            </div>
        </div>
    </form>

    <!-- edit modal -->
    <form action="" method="post" class="form-horizontal">
        <div id="edit_house_spec" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel1">Edit Property Attribute</h3>
            </div>
            <div class="modal-body">
                <div class="row-fluid">
                    <label for="attribute_value">Spec Value:</label>
                    <input type="text" name="attribute_value" id="attribute_value" value="" class="span12" required>
                </div>
            </div>
            <!-- the hidden fields -->
            <input type="hidden" name="action" value="edit_house_prop_attr"/>
            <input type="hidden" id="edit_id" name="edit_id"/>
            <div class="modal-footer">
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Clo724'); ?>
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav723'); ?>
            </div>
        </div>
    </form>

    <!-- detech modal -->
    <form action=""  method="post">
        <div id="delete_house_spec" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel1">Detach property attribute</h3>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to Detach the Selected Attribute?</p>
            </div>
            <input type="hidden" name="action" value="delete_prop_attr"/>
            <input type="hidden" id="delete_id" name="delete_id"/>
            <div class="modal-footer">
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'No726'); ?>
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Yes725'); ?>
            </div>
        </div>
    </form>
    <? set_js(array('src/js/house_specifications.js')); }?>
