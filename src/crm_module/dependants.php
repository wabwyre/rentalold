<? 
	if(isset($_SESSION['dependant'])){
		echo $_SESSION['dependant'];
		unset($_SESSION['dependant']);
	}
?>
<a href="#myModal1" role="button" class="btn btn-small btn-primary" data-toggle="modal"><i class="icon-plus"></i> Add Dependants</a>
<form action="" method="post">	
	<div id="myModal1" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel1">Add Dependant</h3>
		</div>
		<div class="modal-body">
			<div class="row-fluid">
				<label for="afyapoa_id">Afyapoa ID:<span class="required">*</span></label>
				<select name="afyapoa_id" class="span12" required>
					<option value="">--Choose Policy No</option>
					<?php
						$query = "SELECT * FROM afyapoa_file";
						$result = run_query($query);
						while ($rows = get_row_data($result)) {
							$afyapoa_id = $rows['afyapoa_id'];
					?>
					<option value="<?=$afyapoa_id; ?>" <?=($afyapoa_id == $policy_no) ? 'selected' : ''; ?>><?=$afyapoa_id; ?></option>
					<?php
						}
					?>
				</select>
			</div>
			<div class="row-fluid">
				<label for="dependant_name">Name:<span class="required">*</span></label>
				<input type="text" name="dependant_name" required class="span12"/>
			</div>
			<div class="row-fluid">
				<label for="dob">D.O.B: <span class="required">*</span></label>
				<input type="date" name="dob" required class="span12"/>
			</div>
			<div class="row-fluid">
				<label for="gender">Gender: <span class="required">*</span></label>
				<select name="gender" required class="span12">
					<option value="">--Choose Gender--</option>
					<option value="Male">Male</option>
					<option value="Female">Female</option>
				</select>
			</div>
			<div class="row-fluid">
				<label for="status">Status:</label>
				<select name="status" required class="span12">
					<option value="1">Active</option>
					<option value="0">Inactive</option>
				</select>
			</div>
			<div class="row-fluid">
				<label for="mcare_id">MCare No: <span class="required">*</span></label>
				<input type="text" name="mcare_id" required class="span12"/>
			</div>
		</div>
		<div class="modal-footer">
			<? createSectionButton($_SESSION['role_id'], $_GET['num'], 'Clo437'); ?>
			<? createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav438'); ?>
		</div>
	</div>
		<input type="hidden" name="action" value="add_dependant"/>
		<input type="hidden" name="dependant" value="0"/>
</form>
<form action="" method="post">	
	<div id="myModal2" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel1">Add Dependant</h3>
		</div>
		<div class="modal-body">
			<div class="row-fluid">
				<label for="afyapoa_id">Department ID:<span class="required">*</span></label>
				<input type="text" name="dept_id" class="span12" id="dept_id"/>
			</div>
			<div class="row-fluid">
				<label for="afyapoa_id">Afyapoa ID:<span class="required">*</span></label>
				<select name="afyapoa_id" id="afyapoa_id" class="span12" required>
					<option value="">--Choose Policy No</option>
					<?php
						$query = "SELECT * FROM afyapoa_file";
						$result = run_query($query);
						while ($rows = get_row_data($result)) {
							$afyapoa_id = $rows['afyapoa_id'];
					?>
					<option value="<?=$afyapoa_id; ?>" <?=($afyapoa_id == $policy_no) ? 'selected' : ''; ?>><?=$afyapoa_id; ?></option>
					<?php
						}
					?>
				</select>
			</div>
			<div class="row-fluid">
				<label for="dependant_name">Name:<span class="required">*</span></label>
				<input type="text" name="dependant_name" id="dependant_name" required class="span12"/>
			</div>
			<div class="row-fluid">
				<label for="dob">D.O.B</label>
				<input type="date" name="dob" id="dob" class="span12"/>
			</div>
			<div class="row-fluid">
				<label for="gender">Gender</label>
				<select name="gender" id="gender" class="span12">
					<option value="">--Choose Gender--</option>
					<option value="Male">Male</option>
					<option value="Female">Female</option>
				</select>
			</div>
			<div class="row-fluid">
				<label for="status">Status:</label>
				<select name="status" id="status" class="span12">
					<option value="1">Active</option>
					<option value="0">Inactive</option>
				</select>
			</div>
			<div class="row-fluid">
				<label for="mcare_id">MCare No:</label>
				<input type="text" name="mcare_id" id="mcare_id" class="span12"/>
			</div>
		</div>
		<div class="modal-footer">
			<? createSectionButton($_SESSION['role_id'], $_GET['num'], 'Can439'); ?>
			<? createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav440'); ?>
		</div>
	</div>
		<input type="hidden" name="action" value="edit_dependant"/>
		<input type="hidden" name="dependant"/>
</form>
<form action="" method="post">	
	<div id="myModal3" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel1">Add Dependant</h3>
		</div>
		<div class="modal-body">
			<p>Are you sure you want to delete the record?</p>
			<input type="hidden" name="dependant_id" id="dependant_id"/>
		</div>
		<div class="modal-footer">
			<? createSectionButton($_SESSION['role_id'], $_GET['num'], 'No441'); ?>
			<? createSectionButton($_SESSION['role_id'], $_GET['num'], 'Yes442'); ?>
		</div>
	</div>
		<input type="hidden" name="action" value="delete_dependant"/>
		<input type="hidden" name="dependant"/>
</form>
<table id="table1" style="width: 100%" class="table table-bordered">
	<thead>
	  <tr>
		  <th>DEP_ID#</th>
		  <th>Policy_ID#</th>
		  <th>Names</th>
		  <th>DoB</th>
		  <th>Mcare#</th>
		  <th>Gender</th>
		  <th>Status</th>
		  <th>Edit</th>
		  <th>Delete</th>
	  </tr>
	</thead>
	<tbody>	
 <?php
    	$distinctQuery = "SELECT * "
           . "FROM afyapoa_dependants "
           . "WHERE afyapoa_id = $policy_no "
           . "Order by dependant_id DESC ";
           // var_dump($distinctQuery);exit;
   	$resultId = run_query($distinctQuery);
	while($row = get_row_data($resultId)){
		$dependant_id=$row['dependant_id'];
        $afyapoa_id = $row['afyapoa_id'];
		$names=$row['dependant_names'];
		$mcare_id = $row['mcare_id'];
		$gender = $row['dependant_gender'];
		$status = $row['status'];
		if($status == 1){
			$choice = 'Active';
		}else{
			$choice = 'Inactive';
		}
		$dob = $row['dependant_dob'];
 ?>
		<tr>
			<td><?=$dependant_id; ?></td>
			<td><?=$afyapoa_id; ?></td>
			<td><?=$names; ?></td>
			<td><?=$dob; ?></td>
			<td><?=$mcare_id; ?> </td>
			<td><?=$gender; ?></td>	
			<td><?=$choice; ?></td>
			<td><a href="#myModal2" role="button" class="btn btn-mini edit_modal" data-toggle="modal"><i class="icon-edit"></i> Edit</a></td>
			<td><a href="#myModal3" role="button" class="btn btn-mini delete_modal" data-toggle="modal"><i class="icon-edit"></i> Delete</a></td>
		</tr>
	<?php } ?>
  </tbody>
</table>
<? set_js(array("src/js/dependant_modals.js")); ?>
