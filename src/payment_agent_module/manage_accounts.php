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
            array ( 'text'=>'PAYMENTS & BILLS' ),
            array ( 'text'=>'Manage Accounts' )
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
        <?
        if(isset($_SESSION['support'])){
            echo $_SESSION['support'];
            unset($_SESSION['support']);
        }
        ?>
        <table id="table1" style="width: 100%" class="table table-bordered">
            <thead>
                <tr>
                    <th>ID#</th>
                    <th>Bank Name</th>
                    <th>Bank Code</th>
                    <th>Created At</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $rows = $acc->getAllBankDetails();
                $rows = $rows['all'];

                if(count($rows)){
                foreach ($rows as $row){
            ?>
                <tr>
                    <td><?=$rows['bank_id']; ?></td>
                    <td><?=$rows['bank_name']; ?></td>
                    <td><?=$rows['bank_code']; ?></td>
                    <td><?=$rows['created_at']; ?></td>
                    <td><?=$rows['status']; ?></td>
                    <td>
                        <?php
                        if($rows['status'] == '1'){
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
                <label for="bank_code">Branch Code:</label>
                <input type="text" name="bank_code" class="span12" required>
            </div>
            <div class="row-fluid">
                <label for="created_at">Created At:</label>
                <input type="date" name="created_at" class="span12" required>
            </div>
            <div class="row-fluid">
                <label for="status">Status:</label>
                <input type="text" name="status" class="span12" required>
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
    <div id="edit_account" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel1">Edit Address</h3>
        </div>
        <div class="modal-body">
            <div class="row-fluid">
                <label for="bank_name">Bank Name:</label>
                <input type="text" name="bank_name" id="bank_name" value="" class="span12" required>
            </div>
            <div class="row-fluid">
                <label for="branch_name">Branch Name:</label>
                <input type="text" name="branch_name" id="branch_name" class="span12" required>
            </div>
            <div class="row-fluid">
                <label for="branch_code">Branch Code:</label>
                <input type="text" name="branch_code" id="branch_code" class="span12" required>
            </div>
        </div>
        <!-- the hidden fields -->
        <input type="hidden" name="action" value="edit_account"/>
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
    <div id="delete_account" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel1">Delete Bank Details</h3>
        </div>
        <div class="modal-body">
            <p>Are you sure you want to delete the bank details (<span id="bank"></span>) (<span id="branch"></span>)?</p>
        </div>

        <input type="hidden" name="action" value="delete_account"/>
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

