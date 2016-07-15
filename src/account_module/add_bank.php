<?php
/**
 * Created by PhpStorm.
 * User: JOEL
 * Date: 7/14/2016
 * Time: 2:31 PM
 */
include_once ('src/models/Accounts.php');
$acc = new Accounts();

set_layout("dt-layout.php", array(
    'pageSubTitle' => 'Manage Accounts',
    'pageSubTitleText' => '',
    'pageBreadcrumbs' => array (
        array ( 'url'=>'index.php', 'text'=>'Home' ),
        array ( 'text'=>'ACCOUNTS' ),
        array ( 'text'=>'Add Bank' )
    )

));
?>

<div class="widget">
    <div class="widget-title"><h4><i class="icon-money"></i> Account Details</h4>
	    <span class="actions">
			<!-- delete shd not have data toggle -->
            <a href="#add_bank" data-toggle="modal" class="btn btn-small btn-primary tooltips m-wrap" data-trigger="hover" data-original-title="Add New Bank"><i class="icon-plus"></i></a>&nbsp;
            <a href="#edit_bank" id="edit_btn" class="btn btn-small btn-warning tooltips m-wrap" data-trigger="hover" data-original-title="Edit Bank"><i class="icon-edit"></i></a>&nbsp;
            <a href="#delete_bank" id="del_btn" class="btn btn-small btn-danger tooltips m-wrap" data-trigger="hover" data-original-title="Delete Bank"><i class="icon-trash"></i></a>
		</span>
    </div>
    <div class="widget-body form">
        <?php
        $acc->splash('acc');
        // display all encountered errors
        (isset($_SESSION['mf_warnings'])) ? $mf->displayWarnings('mf_warnings') : '';
        ?>

        <div class="alert alert-error hide">
            <button class="close" data-dismiss="alert">&times;</button>
            You have some form errors. Please check below.
        </div>
        <div class="alert alert-success hide">
            <button class="close" data-dismiss="alert">&times;</button>
            Your form validation is successful!
        </div>
        <table id="table1" style="width: 100%" class="table table-bordered">
            <thead>
                <tr>
                    <th>ID#</th>
                    <th>Bank Name</th>
                    <th>Created At</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $rows = $acc->getAllBank();
                $rows = $rows['all'];

                if(count($rows)){
                    foreach ($rows as $row){;
                ?>
                    <tr>
                        <td><?php echo $row['bank_id']; ?></td>
                        <td><?php echo $row['bank_name']; ?></td>
                        <td><?php echo $row['created_at']; ?></td>
                        <td>
                            <?php
                            if($row['status'] == '1'){
                                echo 'Closed';
                            }else{
                                echo'Open';
                            }
                            ?>
                        </td>
                    </tr>
                <?php }} ?>
            </tbody>
        </table>
        <div class="clearfix"></div>
    </div>
</div>

<!-- begin add modal -->
<form action="" method="post">
    <div id="add_bank" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel1">Manage Account Details</h3>
        </div>
        <div class="modal-body">
            <div class="row-fluid">
                <label for="bank_name">Bank Name:</label>
                <input type="text" name="bank_name" value="" class="span12" required>
            </div>
            <div class="row-fluid">
                <label for="created_at">Date:</label>
                <input type="date" name="created_at" class="span12" required>
            </div>
            <div class="row-fluid">
                <label for="status">Status:</label>
                <select name="status" class="span12" required>
                    <option value="">--Select Status</option>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
        </div>
        <!-- the hidden fields -->
        <input type="hidden" name="action" value="add_bank"/>
        <div class="modal-footer">
            <button class="btn btn-default" data-dismiss="modal" aria-dismiss="true">Close</button>
            <button class="btn btn-primary">Save</button>
            <?php //createSectionButton($_SESSION['role_id'], $_GET['num'], 'Clo646'); ?>
            <?php //createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav647'); ?>
        </div>
    </div>
</form>
<!-- end add address modal -->

<!-- begin of edit modal -->
<form action="" method="post">
    <div id="edit_bank" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel1">Edit Bank Details</h3>
        </div>
        <div class="modal-body">
            <div class="row-fluid">
                <label for="bank_name">Bank Name:</label>
                <input type="text" name="bank_name" id="bank_name" value="" class="span12" required>
            </div>
            <div class="row-fluid">
                <label for="created_at">Date:</label>
                <input type="text" name="created_at" id="created_at" class="span12" required>
            </div>
            <div class="row-fluid">
                <label for="status">status:</label>
                <select name="status" class="span12" required>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
        </div>
        <!-- the hidden fields -->
        <input type="hidden" name="action" value="edit_bank"/>
        <input type="hidden" id="edit_id" name="edit_id"/>
        <div class="modal-footer">
            <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Can439'); ?>
            <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav440'); ?>
        </div>
    </div>
</form>
<!-- end of edit modal -->

<!-- delete modal -->
<form action=""  method="post">
    <div id="delete_bank" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel1">Delete Bank Details</h3>
        </div>
        <div class="modal-body">
            <p>Are you sure you want to delete the bank details (<span id="bank"></span>)</p>
        </div>

        <input type="hidden" name="action" value="delete_bank"/>
        <input type="hidden" id="delete_id" name="delete_id"/>
        <div class="modal-footer">
            <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'No441'); ?>
            <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Yes442'); ?>
        </div>
    </div>
</form>
<!-- end of delete modal -->

<!-- js script -->
<?php set_js(array('src/js/manage_account.js')); ?>

