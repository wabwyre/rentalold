<?php
include_once('src/models/Quotes.php');
$Quotes = new Quotes;

set_layout("dt-layout.php", array(
	'pageSubTitle' => 'Manage Quotations',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'Maintenance Tickets' ),
		array ( 'text'=>'Manage Quotations' )
	)
));

?>
<div class="widget">
	<div class="widget-title"><h4><i class="icon-comments-alt"></i> All Quaotations</h4>
	    <span class="actions">
			<a href="#add-quotation" data-toggle="modal" class="btn btn-small btn-primary"><i class="icon-plus"></i>Add a Quotation</a>
		</span>
	</div>
	<div class="widget-body form">
	
    <table id="table1" style="width: 100%" class="table table-bordered">
 		<thead>
			<tr>
			  	<th>ID#</th>
				<th>Bid Amount</th>
				<th>Contractor Id</th>
				<th>Bid Date</th>
				<th>Status</th>
				<th>Job Status</th>
				
				<!-- <th>View</th> -->
			</tr>
 		</thead>
 	<tbody>
	 		<?php
	 		$result = $Quotes->allQuotations();

	 		while ($rows = get_row_data($result)) {

	 		?>
		<tr>
				<td><?php echo $rows['qoute_id'] ;?></td>
				<td><?php echo $rows['bid_amount'] ; ?></td>
				<td><?php echo $rows['contractor_mf_id'] ;?></td>
				<td><?php echo $rows['expire_date'] ;?></td>
				<td><?php echo $rows['bid_status'] ;?></td>
				<td><?php echo $rows['job_status'] ;?></td>
			
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
	<div id="add-support" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel1">Add Quotation</h3>
		</div>
		<div class="modal-body">
			<div class="row-fluid">
	               
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
	<div id="add-quotation" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel1"><i class="icon-comments"></i> Add Quotation</h3>
		</div>
		<div class="modal-body">
	        <div class="row-fluid">
	        	Quation
		        
	        </div>
	        
	        <div class="row-fluid">
	        	<label for="bid_amount" class="control-label">Bid Amount</label>
	        	<input type="text" name="bid_amount" class="span12" required="true">
	        </div>

	        <div class="row-fluid">
	        <label for="maintainance" class="control-label">Maintainance</label>
	        	 <select name="maintainance" id="add-maintanance" class="span12" required="required">
	            	<option value="">--Select Maintainance--</option>
	            	<?php
	            		$result = $Quotes->getAllMaintainance();
	            		while($rows = get_row_data($result)){
	            	?>
	            	<option value="<?=$rows['voucher_id']; ?>"><?=$rows['maintainance_name']; ?></option>
	            	<?php } ?>
	            </select> 
	        </div>
		</div>
		<!-- the hidden fields -->
		<input type="hidden" name="action" value="add_support"/>
		<div class="modal-footer">
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Clo650'); ?>
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav649'); ?>
		</div>
	</div>
</form>
<?// set_js(array('src/js/assign_staff.js')); ?>