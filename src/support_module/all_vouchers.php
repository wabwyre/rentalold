<?php
include_once('src/models/SupportTickets.php');
$Support = new SupportTickets;

set_layout("dt-layout.php", array(
    'pageSubTitle' => 'All Maintenance Vouchers',
    'pageSubTitleText' => '',
    'pageBreadcrumbs' => array (
        array ( 'url'=>'index.php', 'text'=>'Home' ),
        array ( 'text'=>'Maintenance Vouchers' ),
        array ( 'text'=>'All Maintenance Vouchers' )
    )
));

?>
<div class="widget">
    <div class="widget-title"><h4><i class="icon-comments-alt"></i> All Maintenance Vouchers</h4>
	    <span class="actions">
			<a href="#add_voucher" data-toggle="modal" class="btn btn-small btn-primary"><i class="icon-plus"></i>Add Maintenance Vouchers</a>
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
                <th>Customer Complaint</th>
                <th>Maintenance Name</th>
                <th>Category</th>
                <th>Create User</th>
                <th>Edit</th>
                <th>Delete</th>
                <th>Approve</th>
            </tr>
            </thead>
            <tbody>

                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><a href="#edit_voucher" class="btn btn-mini btn-inverse attach_detach"
                           data-toggle="modal" support_ticket_id="<?=$rows['support_ticket_id']; ?>"><i class="icon-paper-clip"></i> Assign</a></td>
                    <td></td>
                    <td></td>
                </tr>

            </tbody>
        </table>
        <div class="clearfix"></div>
    </div>
</div>

<!-- The Modals -->
<form action="" method="post">
    <div id="add_voucher" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel1"><i class="icon-comments"></i>Add Maintenance Vouchers</h3>
        </div>
        <div class="modal-body">
            <div class="row-fluid">
                Customer Complaint
                <select id="select2_sample2" name="complaint_id" class="span12" >
                    <option value="">--Select Complaint--</option>
                    <?php
                    $data = $Support->allMaintenanceTickets();
                    while($rows = get_row_data($data)){
                        ?>
                        <option value="<?=$rows['maintenance_ticket_id']; ?>"><?=$rows['body']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <label for="">Categories</label>
            <div class="row-fluid">
                <select id="select2_sample3" name="category_id" class="span12" required>
                    <option value="">--Select Category--</option>
                    <?php
                    $data = $Support->getVoucherCategories();
                    while($rows = get_row_data($data)){
                        ?>
                        <option value="<?=$rows['category_id']; ?>"><?=$rows['category_name']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="row-fluid">
                <label for="maintaince_name" class="control-label">Maintenance Description</label>
                <textarea name="maintaince_name" class="span12" required></textarea>
            </div>
        </div>
        <!-- the hidden fields -->
        <input type="hidden" name="action" value="add_voucher"/>
        <div class="modal-footer">
            <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Clo650'); ?>
            <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav649'); ?>
        </div>
    </div>
</form>
