<?php
require_once 'src/models/Plots.php';
//include_once('src/models/House.php');
//$House = new House;
$plots = new Plots();

set_layout("dt-layout.php", array(
    'pageSubTitle' => 'Property attributes',
    'pageSubTitleText' => '',
    'pageBreadcrumbs' => array (
        array ( 'url'=>'index.php', 'text'=>'Home' ),
        array ( 'text'=>'Property Management' ),
        array ( 'text'=>'Manage Property Attributes' )
    )

));
?>
    <div class="widget">
        <div class="widget-title"><h4><i class="icon-reorder"></i> Manage Property Attributes</h4>
            <span class="actions">
            <a href="#add_attribute" data-toggle="modal" class="btn btn-small btn-primary"><i class="icon-plus"></i> Add</a>
            <a href="#edit_attribute" class="btn btn-small btn-success" id="edit_attribute_btn"><i class="icon-edit"></i> Edit</a>
            <a href="#delete_attribute" class="btn btn-small btn-danger" id="del_attribute_btn"><i class="icon-remove icon-white"></i> Delete</a>
        </span>
        </div>

        <div class="widget-body form">
            <?php
            $plots->splash('plots');
            (isset($_SESSION['warnings'])) ? $plots->displayWarnings('warnings') : '';

            if(isset($_SESSION['attributes'])){
                echo $_SESSION['attributes'];
                unset($_SESSION['attributes']);
            }
            ?>
            <table id="table1" class="table table-bordered">
                <thead>
                <tr>
                    <th>ID#</th>
                    <th>Attribute Name</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $rows = $plots->getAllAttributes();
                if ($rows){
                    foreach($rows as $row) {
                        ?>
                        <tr>
                            <td><?=$row['prop_attr_id']; ?></td>
                            <td><?=$row['prop_attr_name']; ?></td>
                        </tr>
                    <? }} ?>
                </tbody>
            </table>
            <div class="clearfix"></div>
        </div>
    </div>

    <!-- The Modals -->
    <form action="" method="post">
        <div id="add_attribute" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel1">Add Attribute</h3>
            </div>
            <div class="modal-body">
                <div class="row-fluid">
                    <label for="group_name">Attribute Name:</label>
                    <input type="text" name="name" value="" class="span12" required>
                </div>
            </div>
            <!-- the hidden fields -->
            <input type="hidden" name="action" value="add_attribute"/>
            <div class="modal-footer">
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Clo716'); ?>
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav715'); ?>
            </div>
        </div>
    </form>
    <!-- edit modal -->
    <form action="" method="post">
        <div id="edit_attribute" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel1">Edit Attribute</h3>
            </div>
            <div class="modal-body">
                <div class="row-fluid">
                    <label for="name">Attribute Name:</label>
                    <input type="text" name="name" id="name" value="" class="span12" required>
                </div>
            </div>
            <!-- the hidden fields -->
            <input type="hidden" name="action" value="edit_attribute"/>
            <input type="hidden" id="edit_id" name="edit_id"/>
            <div class="modal-footer">
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Clo718'); ?>
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav717'); ?>
            </div>
        </div>
    </form>
    <!-- delete modal -->
    <form action=""  method="post">
        <div id="delete_attribute" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel1">Delete Attribute</h3>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the Attribute?</p>
            </div>
            <!-- hidden fields -->
            <input type="hidden" name="action" value="delete_attribute"/>
            <input type="hidden" id="delete_id" name="delete_id"/>
            <div class="modal-footer">
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'No720'); ?>
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Yes719'); ?>
            </div>
        </div>
    </form>

<? set_js(array('src/js/manage_groups.js')); ?><?php
