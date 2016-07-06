<?php
	//get the value
	if (isset($_GET['ins_id'])){
		$ins_id=$_GET['ins_id'];		
	}

	include_once('src/models/Masterfile.php');
	$masterfile = new Masterfile();
	$ins_data = $masterfile->getCustomerNameFromInsId($ins_id);

	set_layout("dt-layout.php", array(
		'pageSubTitle' => 'All Customer Insurance Policies',
		'pageSubTitleText' => '',
		'pageBreadcrumbs' => array (
			array ( 'url'=>'index.php', 'text'=>'Home' ),
			array ( 'text'=>'CRM' ),
			array ( 'url'=>'?num=829', 'text'=>'Insurance Policy' ),
			array ( 'text'=>'Insurance Claim' )
		)
	));
?>
<div class="widget">
	<div class="widget-title"><h4><i class="icon-reorder"></i> <span style="color:green;"><?php echo strtoupper($ins_data['full_name']); ?></span></h4>
		<span class="actions">
			<a href="#add_policy" data-toggle="modal" class="btn btn-small btn-primary"><i class="icon-plus"></i> Claim</a>
			<a href="#edit_claim" class="btn btn-small btn-success" id="edit_type_btn"><i class="icon-edit"></i> Edit Claim</a>
			<a href="#delete_claim" class="btn btn-small btn-danger" id="delete_claim_btn"><i class="icon-remove icon-white"></i> Delete Claim</a>
		</span>
	</div>
	</br>
	<div class="widget-body form">
		<!-- progress bar -->
		<div class="progress progress-striped progress-success active" style="height: 10px; display: none;" id="progression">
			<div style="width: 100%;" class="bar"></div>
		</div>
		<!-- end progress bar -->
		<div class="alert alert-error error_message" style="display: none;">
			<button class="close" data-dismiss="alert">&times;</button>
			<strong>Error!</strong> <span id="error_message"></span>
		</div>
		<div class="alert alert-success success_mes" style="display: none;">
			<button class="close" data-dismiss="alert">&times;</button>
			<strong>Success!</strong> <span id="success_mes"></span>
		</div>
		 <?
			if(isset($_SESSION['done-deal'])){
			echo $_SESSION['done-deal'];
			unset($_SESSION['done-deal']);
		     }
		?>
		<table id="table1" class="table table-bordered">
			<thead>
				<tr>
					<th>Claim Id:</th>
					<th>Policy Id:</th>
					<th>Claim Type:</th>
					<th>Case Type:</th>
					<th>Claimed Date:</th>
					<th>Status:</th>
					<th>Description</th>
					<th>Process Claim</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$result = $masterfile->getAllInsuaranceClaim($ins_id);					
					while ($rows = get_row_data($result)) {
				?>
				<tr>
					<td><?=$rows['claim_id']; ?></td>
					<td><?=$rows['insurance_id']; ?></td>
					<td><?=$rows['claim_type']; ?></td>
					<td><?=$rows['case_type']; ?></td>
					<td><?=$rows['claim_date']; ?></td>
					<td>
						<?php
						  if($rows['status'] == 'f'){
					        echo 'Closed';
					      }else{
					        echo 'Open';
					      }
						?>
					</td>					
					<td><?=$rows['description']; ?></td>
					<td>
					<?php
					if($rows['status'] == 't'){
					?>
					<a href="#" class="btn btn-mini btn-success process_claim" ins_id="<?php echo $_GET['ins_id']; ?>" claim-id=<?php echo $rows['claim_id']; ?> case-type="<?php echo $rows['case_type']; ?>"><i class="icon-check"></i> Process Claim</a>
					<?php } ?>
					</td>
				</tr>
				<? } ?>
			</tbody>
		</table>
		<div class="clearfix"></div>
	</div>
</div>

<!-- The Modals -->
<form action="" method="post">
	<div id="add_policy" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3 id="myModalLabel1">Insurance Claim</h3>
		</div>		

		<div class="modal-body">
		   	<div class="row-fluid"/>
				<input type="hidden" name="mf_id" class="span12" value="<?php echo $ins_data['mf_id']; ?>" readonly required/>
				<input type="hidden" name="insurance_id" value="<?php echo $_GET['ins_id']; ?>" required/>
			</div>

		   	<div class="row-fluid" style="margin-bottom: 10px;">
		   		<label for="claim_type">Claim Type:</label>
		   		<select name="claim_type" class="span12" required="required" />
		   			<option value="">--choose claim type--</option>
		   			<option value="Repair">Repair</option>
		   			<option value="Replacement">Replacement</option>
		   		</select>
		   	</div>

		   	<div class="row-fluid" style="margin-bottom: 10px;">
		   		<label for="case_type">Case Type:</label>
		   		<select name="case_type" class="span12" required="required" />
		   			<option value="">--choose case type--</option>
		   			<option value="First fix">First fix</option>
		   			<option value="Second fix">Second fix</option>
		   			<option value="Third fix">Third fix</option>
		   		</select>
		   	</div>

			<div class="row-fluid">
	            <label for="claim_date">Claim Date:<span class="required">*</span></label>
	            <input type="date" name="claim_date" class="span12" required>
	        </div>

	        <div class="row-fluid">
	            <label for="description">Claim Description:<span class="required">*</span></label>
	            <input type="text" name="description" class="span12" placeholder="claim description" required/>
	        </div>
	        
	        <div class="row-fluid">
		   		<label for="status">Status:</label>
		   		<select name="status" required="required" class="span12" />
		   			<option value="1" <?php if(isset($_POST['status']) && $_POST['status'] == 'Active') echo 'selected'; ?>>Active</option>
					<option value="0" <?php if(isset($_POST['status']) && $_POST['status'] == 'Inactive') echo 'selected'; ?>>Inactive</option>
		   		</select>
		   	</div>
		</div>
		<!-- the hidden fields -->
		<input type="hidden" name="action" value="insurance_claim"/>
		<div class="modal-footer">
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Clo617'); ?>
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav618'); ?>
		</div>
	</div>
</form>

<!-- edit modal -->
<form action="" method="post">
	<div id="edit_claim" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3 id="myModalLabel1">Edit Insurance Claim</h3>
		</div>
		<div class="modal-body">
			<input type="hidden" name="mf_id" class="span12" value="<?php echo $ins_data['mf_id']; ?>" readonly required/>
			<input type="hidden" name="insurance_id" value="<?php echo $_GET['ins_id']; ?>" required/>
			
		   	<div class="row-fluid" style="margin-bottom: 10px;">
		   		<label for="claim_type">Claim Type:</label>
		   		<select name="claim_type" class="span12" id="claim_type" required="required" />
		   			<option value="">--choose claim type--</option>
		   			<option value="Repair">Repair</option>
		   			<option value="Replacement">Replacement</option>
		   		</select>
		   	</div>

		   	<div class="row-fluid" style="margin-bottom: 10px;">
		   		<label for="case_type">Case Type:</label>
		   		<select name="case_type" class="span12" id="case_type" required="required" />
		   			<option value="">--choose case type--</option>
		   			<option value="First fix">First fix</option>
		   			<option value="Second fix">Second fix</option>
		   			<option value="Third fix">Third fix</option>
		   		</select>
		   	</div>

			<div class="row-fluid">
	            <label for="claim_date">Claim Date:<span class="required">*</span></label>
	            <input type="date" name="claim_date" class="span12" id="claim_date" required>
	        </div>

	        <div class="row-fluid">
	            <label for="description">Claim Description:<span class="required">*</span></label>
	            <input type="text" name="description" class="span12" id="description" placeholder="claim description" required/>
	        </div>
	        
	        <div class="row-fluid" style="margin-bottom: 10px;">
		   		<label for="status" class="span12">Status:</label>
		   		<select name="status" id="status" required="required" class="span12">
		   			<option value="1" <?php if(isset($_POST['status']) && $_POST['status'] == 'Active') echo 'selected'; ?>>Active</option>
					<option value="0" <?php if(isset($_POST['status']) && $_POST['status'] == 'Inactive') echo 'selected'; ?>>Inactive</option>
		   		</select>
		   	</div>
		</div>
		<!-- the hidden fields -->
		<input type="hidden" name="action" value="edit_insurance_claim"/>
		<input type="hidden" id="edit_id" name="edit_id"/>
		<div class="modal-footer">
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Can619'); ?>
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav620'); ?>
		</div>
	</div>
</form>

<!-- delete modal -->
<form action=""  method="post">
	<div id="delete_claim" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3 id="myModalLabel1">Delete Insurance Claim</h3>
		</div>
		<div class="modal-body">
			<p>Are you sure you want to delete the Insurance Claim?</p>
		</div>
		<input type="hidden" name="status" id="status"/>
		<input type="hidden" name="action" value="delete_insurance_claim"/>
		<input type="hidden" id="delete_id" name="delete_id"/>
		<div class="modal-footer">
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'No621'); ?>
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Yes622'); ?>
		</div>
	</div>
</form>

<? set_js(array('src/js/manage_insurance_claim.js')); ?>
