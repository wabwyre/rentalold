<?php
include_once('src/models/House.php');
$house = new House;
if(app::isAjaxRequest()){
    $ajax = $house->getDetails($_POST['edit_id']);
}else{

set_layout("dt-layout.php", array(
    'pageSubTitle' => 'Manage House Specifications',
    'pageSubTitleText' => '',
    'pageBreadcrumbs' => array (
        array ( 'url'=>'index.php', 'text'=>'Home' ),
        array ( 'text'=>'Houses/Units' ),
        array ( 'url'=>'?num=view_houses', 'text'=>'All Houses' ),
        array ( 'text'=>'Manage House Specifications' )
    )

));


//print_r($data);exit;
?>
    <div class="widget">
        <div class="widget-title"><h4><i class="icon-reorder"></i> House: <span style="color: green;"><?php if (isset($_GET['house_id'])) {
                    $house_id = $_GET['house_id'];
                    $data = $house->getAllHouses(" house_id = '".$house_id."' ");
                   // var_dump($data);
                    echo $data['specific'][house_number];
                } ?></h4>
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
                    <th>Specs</th>
                    <th>Value</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($_GET['house_id'])) {
                        $id = $_GET['house_id'];
                        $data = $house->getAllocDetails($id);
                    }
                    if (count($data)) {
                        foreach ($data as $row) {
                            ?>
                            <tr>
                                <td><?php echo $row['house_attr_id']; ?></td>
                                <td><?php echo $row['attribute_name']; ?></td>
                                <td><?php echo $row['attr_value']; ?></td>
                                <td><a href="#edit_house_spec" class="btn btn-mini btn-success edit_spec_btn" data-toggle="modal" edit-id="<?php echo $row['house_attr_id']; ?>" id=""><i class="icon-edit"></i> Edit</a></td>
                                <td><a href="#delete_house_spec" class="btn btn-mini btn-danger del_spec_btn" data-toggle="modal" delete-id="<?php echo $row['house_attr_id']; ?>" id=""><i class="icon-remove icon-white"></i> Detach</a></td>
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
            <h3 id="myModalLabel1">Attach House Specifications</h3>
        </div>
        <div class="modal-body">
            <div class="row-fluid">
                <select class="span12 live_search" name="attribute_id" required="required">
                    <option value="">--Select Specifications--</option>
                    <?php
                    $data = $house->listAllAttributes();

                        if(count($data)){
                        foreach($data as $row){
                            if(!$data = $house->checkIfHouseAttributeisAttached($_GET['house_id'],$row['attribute_id'])){
                                ?>
                                <option value="<?=$row['attribute_id']; ?>"><?=$row['attribute_name']; ?></option>
                            <?php }}}?>

                    </select>
                </div>
                <div class="row-fluid">
                    <label for="attribute_value">Spec Value:</label>
                    <input type="text" name="attribute_value"  class="span12" required>
                </div>
                <input type="hidden" name="house_id" value="<?php if (isset($_GET['house_id'])) {
               echo $id = $_GET['house_id'];}?>"/>
            </div>
            <!-- the hidden fields -->
            <input type="hidden" name="action" value="add_house_specs"/>
            <div class="modal-footer">
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Clo707'); ?>
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav706'); ?>
            </div>
        </div>
    </form>

    <!-- edit modal -->
    <form action="" method="post" class="form-horizontal">
        <div id="edit_house_spec" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel1">Edit House Specifications</h3>
            </div>
            <div class="modal-body">
                <div class="row-fluid">
                    <label for="attribute_value">Spec Value:</label>
                    <input type="text" name="attribute_value" id="attribute_value1" value="<?php if(isset($val)){
                        echo $val;
                    } ?>" class="span12" required>
                </div>
            </div>
            <!-- the hidden fields -->
            <input type="hidden" name="action" value="edit_house_spec"/>
            <input type="hidden" id="edit_id" name="edit_id"/>
            <div class="modal-footer">
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Clo709'); ?>
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav708'); ?>
            </div>
        </div>
    </form>

    <!-- detech modal -->
    <form action=""  method="post">
        <div id="delete_house_spec" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel1">Detach house Specifications</h3>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to Detach the Selected Specifications?</p>
            </div>
            <input type="hidden" name="action" value="delete_house_spec"/>
            <input type="hidden" id="delete_id" name="delete_id"/>
            <div class="modal-footer">
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'No711'); ?>
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Yes710'); ?>
            </div>
        </div>
    </form>
<? set_js(array('src/js/house_specifications.js')); }?>
