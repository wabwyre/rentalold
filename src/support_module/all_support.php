<?php
include_once('src/models/SupportTickets.php');
$Support = new SupportTickets;

set_layout("dt-layout.php", array(
	'pageSubTitle' => 'All Maintenance Tickets',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'Maintenance Tickets' ),
		array ( 'text'=>'All Maintenance Tickets' )
	)
));

?>
<div class="widget">
	<div class="widget-title"><h4><i class="icon-comments-alt"></i> All Maintenance Tickets</h4>
	    <span class="actions">
			<a href="#add_support" data-toggle="modal" class="btn btn-small btn-primary"><i class="icon-plus"></i>Add Maintenance Ticket</a>
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
			<td></td>
			
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
	<div id="add_support" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel1"><i class="icon-comments"></i> Staff Add Maintenance Ticket</h3>
		</div>
		<div class="modal-body">
	        <div class="row-fluid">
	        	Customer Account
		        <select id="select2_sample2" name="customer" class="span12" >
		           <option>--Select Customer Account--</option>
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
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Can592'); ?>
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav591'); ?>
		</div>
	</div>
</form>
<? set_js(array('src/js/assign_staff.js')); ?>