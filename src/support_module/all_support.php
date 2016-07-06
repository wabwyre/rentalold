<?php
include_once('src/models/SupportTickets.php');
$Support = new SupportTickets;

set_layout("dt-layout.php", array(
	'pageSubTitle' => 'All Support Tickets',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'Support Tickets' ),
		array ( 'text'=>'All Support Tickets' )
	)
));

?>
<div class="widget">
	<div class="widget-title"><h4><i class="icon-comments-alt"></i> All Support Tickets</h4>
	    <span class="actions">
			<a href="#add_support" data-toggle="modal" class="btn btn-small btn-primary"><i class="icon-plus"></i>Add Support Ticket</a>
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
				<th>Customer Account</th>
				<th>Subject</th>
				<th>Reported By</th>
				<th>Status</th>
				<th>reported time</th>
				<th>Assigned To</th>
				<th>Action</th> 
				<!-- <th>View</th> -->
			</tr>
 		</thead>
 	<tbody>
	 	<?php
			$result = $Support->allSuportTickets();
			while ($rows = get_row_data($result)) {
				$time = $rows['reported_time'];
				$aDate = explode(" ", $time);
                    $date = $aDate[0];
               $cust = $rows['customer_account_id'];
            $data =$Support->getSupportCustomerName($cust);
		?>
		<tr>
			<td><?=$rows['support_ticket_id']; ?></td>
			<td><?=$data; ?></td>
			<td><?=$rows['subject']; ?></td>
			<td><?=$rows['customer_name']; ?></td>
			<td>
			<?php
			  if($rows['status'] == '1'){
		        echo 'Closed';
		      }else{
		        echo'Open';
		      }
			 ?>
			 </td>
			<td><?=$date; ?></td>	
			<td><?=$Support->getAssignedTo($rows['assigned_to']); ?></td>	
			<td>
			<?php
				if(empty($rows['assigned_to'])){
			?>
			  	<a href="#assign_staff" class="btn btn-mini btn-success attach_detach" 
			  data-toggle="modal" support_ticket_id="<?=$rows['support_ticket_id']; ?>"><i class="icon-paper-clip"></i> Assign</a>
			<?php }
				if($rows['status'] == '0'){ 
			?>
				<a href="#reassing_staff" class="btn btn-mini btn-warning reassign" 
			  	data-toggle="modal" support_ticket_id="<?=$rows['support_ticket_id']; ?>" assigned_to="<?=$rows['assigned_to']; ?>"><i class="icon-paper-clip"></i> Reassign</a>
			<?php } ?>
			</td>
			
		</tr>
<?php
 
	}
	   
	?>
  
  </tbody>
</table>
<div class="clearfix"></div>
</div>
</div>

<!-- The Modals -->
<form action="" method="post">
	<div id="assign_staff" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel1">Assign Staff</h3>
		</div>
		<div class="modal-body">
			<div class="row-fluid">
	            <select name="staff" class="span12 live_search" required="required">
	            	<option value="">--Select Staff--</option>
	            	<?php
	            		$result = $Support->getAllStaffAassignment();
	            		while($rows = get_row_data($result)){
	            	?>
	            	<option value="<?=$rows['mf_id']; ?>"><?=$rows['customer_name']; ?></option>
	            	<?php } ?>
	            </select>     
	        </div>
	    </div>
		<!-- the hidden fields -->
		<input type="hidden" name="support_ticket_id" id="support_ticket_id"/>
		<input type="hidden" name="action" value="assign_staff">
		<div class="modal-footer">
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Can584'); ?>
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav583'); ?>
		</div>
	</div>
</form>

<form action="" method="post">
	<div id="reassing_staff" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel1">Reassign Staff</h3>
		</div>
		<div class="modal-body">
			<div class="row-fluid">
	            <select name="staff" id="reass_staff" class="span12" required="required">
	            	<option value="">--Select Staff--</option>
	            	<?php
	            		$result = $Support->getAllStaffAassignment();
	            		while($rows = get_row_data($result)){
	            	?>
	            	<option value="<?=$rows['mf_id']; ?>"><?=$rows['customer_name']; ?></option>
	            	<?php } ?>
	            </select>     
	        </div>
	    </div>
		<!-- the hidden fields -->
		<input type="hidden" name="origin_staff" id="origin_staff"/>
		<input type="hidden" name="support_ticket_id" id="supp_ticket_id" />
		<input type="hidden" name="action" value="reassign_staff">
		<div class="modal-footer">
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Can584'); ?>
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav583'); ?>
		</div>
	</div>
</form>

<form action="" method="post">
	<div id="add_support" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel1"><i class="icon-comments"></i> Staff Add Support Ticket</h3>
		</div>
		<div class="modal-body">
	        <div class="row-fluid">
	        	Customer Account
		        <select id="select2_sample2" name="customer" class="span12" >
		           <option>--Select Customer Account--</option>
		            <?php 
		            	$result = $Support->getAllSupportCustomerAccounts();
		            	//var_dump(get_row_data($result));exit;
		            	while($rows = get_row_data($result)){
		            ?>
		                <option value="<?=$rows['customer_account_id']; ?>"><?=$rows['customer_name']; ?> - Issued <?=$rows['issued_phone_number']; ?></option>
		            <?php } ?>
		        </select>
	        </div>
	        <div class="row-fluid">
	        	<label for="subject">Subject</label>
	        	<select name="subject" class="span12" required>
	        	<option value=" ">--Select Subject--</option>
	              <option value="Airtime&data"> Airtime and Data</option>
	              <option value="Billing"> Billing</option>
	              <option value="Insurance"> Insurance</option>
	              <option value="Damage"> Physical damage</option>
	              <option value="Technical"> Technical Issues</option>
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
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Can592'); ?>
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav591'); ?>
		</div>
	</div>
</form>
<? set_js(array('src/js/assign_staff.js')); ?>