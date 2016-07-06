<?php
include_once('src/models/Device_management.php');
$device = new DeviceManagement();

set_title('Deleted Accounts');

set_layout("dt-layout.php", array(
    'pageSubTitle' => 'CRM',
    'pageSubTitleText' => 'A list of all deleted Customer Accounts',
    'pageBreadcrumbs' => array (
        array ( 'url'=>'index.php', 'text'=>'Home' ),
        array ( 'text'=>'CRM' ),
        array ( 'text'=>'All Deleted Customer Accounts' )
    )
));
?>
<div class="widget">
    <div class="widget-title"><h4><i class="icon-trash"></i> Deleted Customer Accounts</h4></div>
    <div class="widget-body form">
        <?php $device->splash('done-deal'); ?>
        <div class="alert alert-success" style="display: none" id="flash">
            <button class="close" data-dismiss="alert"></button>
            <strong>Success!</strong> The Customer Account has been restored.
        </div>
    <table id="table1" class="table table-bordered">
    <thead>
    <tr>
        <th>ID#</th>
        <th>Model</th>
        <th>IMEI No:</th>
        <th>Customer</th>
        <th>Acc. Code</th>
        <th>Referee</th>
        <th>Restore</th>
        <th>Delete</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $result = $device->getAllInactiveAccounts();
    while ($rows = get_row_data($result)) {
        ?>
        <tr>
            <td><?=$rows['customer_account_id']; ?></td>
            <td><?=$rows['model']; ?></td>
            <td><?=$rows['imei']; ?></td>
            <td><?=$rows['customer_name']; ?></td>
            <td><?=$rows['customer_code']; ?></td>
            <td><?=$device->getReferee($rows['referee_mf_id']); ?></td>
            <td><a href="javascript::void();" class="btn btn-mini restore_account" device_id="<?=$rows['device_id']; ?>"><i class="icon-refresh"></i> Restore</a></td>
            <td><a href="#delete_acc" class="btn btn-mini btn-danger delete_account" data-toggle="modal" device_id="<?=$rows['device_id']; ?>"><i class="icon-remove"></i> Delete Forever</a></td>
        </tr>
    <? } ?>
    </tbody>
</table>
        <div class="clearfix"></div>
    </div>
</div>

<form action=""  method="post">
    <div id="delete_acc" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel1">Delete Customer Account</h3>
        </div>
        <div class="modal-body">
            <p>Are you sure you want to permanently delete the Customer Account?</p>
        </div>
        <input type="hidden" name="status" id="status"/>
        <input type="hidden" name="action" value="delete_customer_account"/>
        <input type="hidden" id="delete_id" name="delete_id" required/>
        <div class="modal-footer">
            <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'No626'); ?>
            <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav627'); ?>
        </div>
    </div>
</form>
<?php
    set_js(array('src/js/delete_customer_account.js'));
?>