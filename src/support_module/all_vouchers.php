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
                <th>Category</th>
                <th>Create User</th>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                    <td></td>
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
                Customer Account
                <select id="select2_sample2" name="customer" class="span12" >

                </select>
            </div>
            <div class="row-fluid">
                <label for="subject">Categories</label>
                <select name="subject" class="span12" required>
                    <option value=" ">--Select Voucher Category--</option>
                    <option value="Plumbing"> Plumbing</option>
                    <option value="Electrical"> Electrical</option>
                    <option value="Carpentry"> Carpentry</option>
                    <option value="Painting"> Painting</option>
                    <option value="Other"> Others</option>
                </select>
            </div>
            <div class="row-fluid">
                <label for="body" class="control-label">Message</label>
                <textarea name="body" class="span12" required></textarea>
            </div>
        </div>
        <!-- the hidden fields -->
        <input type="hidden" name="action" value="add_support"/>
        <div class="modal-footer">

        </div>
    </div>
</form>
