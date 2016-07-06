	   <span class="actions">
			<a href="#add_policy" data-toggle="modal" class="btn btn-small btn-primary"><i class="icon-plus"></i> Add Policy</a>
		</span>
		</br>
		 <?php
			if(isset($_SESSION['done-deal'])){
			echo $_SESSION['done-deal'];
			unset($_SESSION['done-deal']);
		     }
		?>
		<table id="table1" class="table table-bordered">
			<thead>
				<tr>
					<th>Policy No</th>
					<th>Id No</th>
					<th>Customer</th>
					<th>Policy:</th>
					<th>Term:</th>
					<th>Phone No:</th>
					<th>Start Date:</th>
					<th>End Date:</th>
					<th>Status:</th>
					<th>Insurance Claim</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$result = $masterfile->getAllInsuarancePolicy();					
					while ($rows = get_row_data($result)) {
						$data = $masterfile->getAllMasterfileByName($rows['transacted_by']);
						$start_year = $rows['year'];
						$start_month = $rows['month'];
						$start_day = $rows['day'];
						$acc_id = $rows['customer_account_id'];
						// var_dump($query); exit;

						$expiry_year = $start_year + $rows['insurance_term_in_years'];
						$expiry_date = date($expiry_year.'-'.$start_month.'-'.$start_day);
				?>
				<tr>
					<td><?=$rows['insurance_id']; ?></td>
					<td><?=$rows['id_passport']; ?></td>
					<td><?=$data;?></td>
					<td><?=$rows['insurance_policy']; ?></td>
					<td><?=$rows['insurance_term_in_years']; ?></td>
					<td><?=$rows['phone']; ?></td>
					<td><?=$rows['start_date']; ?></td>
					<td><?=$expiry_date; ?></td>
					<td>
					<?php
					  if($rows['status'] == 't'){
				        echo 'Active';
				      }else{
				        echo 'Inactive';
				      }
					 ?>
					</td>
					<td><a id="edit_link" href="index.php?num=830&ins_id=<?php echo $rows['insurance_id']; ?>" class="btn btn-mini"><i class="icon-external-link"></i> Insurance Claim</a></td>
				</tr>
				<? } ?>
			</tbody>
		</table>
		<div class="clearfix"></div>

<!-- The Modals -->
<form action="" method="post">
	<div id="add_policy" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3 id="myModalLabel1">Add Policy </h3>
		</div>
		<div class="modal-body">
		   	<div class="row-fluid" style="margin-bottom: 10px;">
		   		<!-- <label for="customer">Select Customer:</label> -->
		   		<select name="customer" required="required" id="select_customer" class="span12 live_search">
		   			<option value="">--Choose Customer--</option>
		   			<?php
		   				$result = $masterfile->getAllMasterfileByBrole('client');
		   				while ($rows = get_row_data($result)){
		   			?>
		   			<option value="<?=$rows['mf_id']; ?>"><?=$rows['full_name']; ?></option>
		   			<?php } ?>
		   		</select>
		   	</div>

		   	<div class="row-fluid" style="margin-bottom: 10px;">
		   		<label for="customer_account_id">Select Phone:</label>
		   		<select name="customer_account_id" required="required" id="select_phone" class="span12">
		   			<option value="">--Choose Phone--</option>
		   		</select>
		   	</div>

			<div class="row-fluid">
	            <label for="insurance_policy">Policy:<span class="required">*</span></label>
	            <select class="span12 insurance_policy" name="insurance_policyjsdlkjflskd" disabled="disabled" required>
	            	<option value="">--Choose Policy Type--</option>
	            	<?php
	            		$result = $masterfile->getPolicyType();
	            		while($rows = get_row_data($result)){
	            	?>
	            	<option value="<?=$rows['service_channel_id']; ?>"><?=$rows['service_option']; ?></option>
	            	<?php } ?>
	            </select>
	            <input type="hidden" name="insurance_policy" id="policy" class="span12" required/>
	        </div>

	        <div class="row-fluid">
	            <label for="insurance_term_in_years">Insurance Term:<span class="required">*</span></label>
	            <input type="number" name="insurance_term_in_years" class="span12" placeholder="term in years" required/>
	        </div>
	        
	        <div class="row-fluid">
	        	<label for="start_date">Start Date:<span class="required">*</span></label>
				<input type="text" class="date-picker span12" name="start_date" value="<?php
					if(isset($_POST['start_date'])){
						echo $_POST['start_date'];
					}else{
						echo date('m/d/Y');
					}
					?>" />
	        </div>

	        <div>
	        	<label for="status" class="control-label">Status:<span class="required">*</span></label>
                <div class="controls">
                    <select name="status" class="span12" required>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
	        </div>

		</div>
		<!-- the hidden fields -->
		<input type="hidden" name="action" value="add_insurance_policy"/>
		<div class="modal-footer">
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Clo606'); ?>
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav607'); ?>
		</div>
	</div>
</form>

<? set_js(array('src/js/manage_insurance.js')); ?>