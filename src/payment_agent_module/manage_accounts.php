<?php
/**
 * Created by PhpStorm.
 * User: JOEL
 * Date: 7/14/2016
 * Time: 2:31 PM
 */
    include_once ('');
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
			<a href="#add_account" data-toggle="modal" class="btn btn-small btn-primary"><i class="icon-plus"></i>Add Account</a>
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
                    <th>Account Name</th>
                    <th>Bank Name</th>
                    <th>Branch Name</th>
                    <th>Account No.</th>
                    <th>status</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $rows = $mf->getAllAccDetails();
                $rows = $rows['all'];

                if(count($rows)){
                foreach ($rows as $row){
            ?>
                <tr>
                    <td><?=$rows['bank_acc_id']; ?></td>
                    <td><?=$rows['account_name']; ?></td>
                    <td><?=$rows['bank_name']; ?></td>
                    <td><?=$rows['branch_name']; ?></td>
                    <td><?=$rows['account_no']; ?></td>
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

<!-- The Modals -->
<form action="" method="post">
    <div id="add_account" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel1">Add Account</h3>
        </div>
        <div class="modal-body">
            <div class="row-fluid">

            </div>
        </div>
        <!-- the hidden fields -->
        <input type="hidden" name="support_ticket_id" id="support_ticket_id"/>
        <input type="hidden" name="action" value="add_account">
        <div class="modal-footer">
            <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Can584'); ?>
            <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav583'); ?>
        </div>
    </div>
</form>
