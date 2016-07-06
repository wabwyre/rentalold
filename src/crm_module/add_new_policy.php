<?php
set_layout("form-layout.php", array(
	'pageSubTitle' => 'Add Member/Policy',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'#', 'text'=>'Home' ),
		array ( 'text'=>'CRM' ),
		array ( 'text'=>'Add New Member/Policy' )
	),
	'pageWidgetTitle'=>'Add New Member/Policy'
));

set_css(array(
	'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.css',
	'assets/plugins/bootstrap-datepicker/css/datepicker.css'
));
set_js(array(
	'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.js',
	'assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js'
)); 

if(isset($_SESSION['add_policy'])){
    echo "<p style='color:#f00; font-size:16px;'>".$_SESSION['add_policy']."</p>";
    unset($_SESSION['add_policy']);
}
?>
    <!-- BEGIN FORM -->
<form action=""  id="edit_crm" method="post" enctype="multipart/form-data" class="form-horizontal">
	<!-- Attach to an Association -->
	<h3 class="form-section">Attach Association</h3>
   	<div class="row-fluid">
		<div class="span6">
			<div class="control-group">
				<label for="customer_id" class="control-label">Association:</label>
				<div class="controls">
					<select name="association" class="span12" id="select2_sample2">
						<option value="">--Attach Association--</option>
						<?php
							//get all associations
							$query = "SELECT aa.*, c.* FROM afyapoa_association aa
							LEFT JOIN customers c ON c.customer_id = aa.customer_id
							";
							$result = run_query($query);
							while($rows = get_row_data($result)){
						?>
						<option value="<?=$rows['customer_id']; ?>"><?=$rows['surname'].' '.$rows['firstname'].' '.$rows['middlename']; ?></option>	
						<? } ?>
					</select>
				</div>
			</div>
		</div>
	</div>

	<!-- Add Customer Data -->
	<h3 class="form-section">Customer Details</h3>
   	<div class="row-fluid">
		<div class="span6">
			<div class="control-group">
				<label for="middlename" class="control-label">Surname Name:</label>
				<div class="controls">
					<input required type="text" name="surname" class="span12"/>
				</div>
			</div>
		</div>
		<div class="span6">
			<div class="control-group">
				<label for="middlename" class="control-label">Middle Name:</label>
				<div class="controls">
					<input type="text" name="middlename" class="span12"/>
				</div>
			</div>
		</div>
	</div>

	<div class="row-fluid">
		<div class="span6">
			<div class="control-group">
				<label for="firstname" class="control-label">First Name:</label>
				<div class="controls">
					<input required type="text" name="firstname" class="span12"/>
				</div>
			</div>
		</div>
		<div class="span6">
			<div class="control-group">
				<label for="start_date" class="control-label">Start Date:</label>
				<div class="controls">
					<input required type="text" name="start_date" value=""  class="span12 date-picker"/>
				</div>
			</div>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span6">
			<div class="control-group">
				<label for="status" class="control-label">Status:</label>
				<div class="controls">
					<select name="status" required class="span12">
						<option value="">--Choose Status--</option>
						<option value="1">Active</option>
						<option value="0">Inactive</option>
					</select>
				</div>
			</div>
		</div>
		<div class="span6">
			<div class="control-group">
				<label for="user_association" class="control-label">Balance:</label>
				<div class="controls">
					<input required type="number" value="0" name="balance" class="span12"/>
				</div>
			</div>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span6">
			<div class="control-group">
				<label for="user_association" class="control-label">Customer Type:</label>
				<div class="controls">
					<select class="span12" name="customer_type_id" required>
						<option value="">--Choose Customer Type--</option>
						<?php
                            $query = run_query("SELECT * FROM customer_types ORDER BY customer_type_name");

                            if ( $query !== false ){
                                while ( $fetch = get_row_data($query) ){
                                        echo "<option value='".$fetch['customer_type_id']."'>".$fetch['customer_type_name']."</option>";
                                }
                            }
                        ?>
                    </select>
				</div>
			</div>
		</div>
		<div class="span6">
			<div class="control-group">
				<label for="email" class="control-label">Email:</label>
				<div class="controls">
					<input required type="email" name="email" class="span12"/>
				</div>
			</div>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span6">
			<div class="control-group">
				<label for="national_id_number" class="control-label">National ID No:</label>
				<div class="controls">
					<input required type="number" min="0" name="national_id_number" class="span12"/>
				</div>
			</div>
		</div>
		<div class="span6">
			<div class="control-group">
				<label for="phone" class="control-label">Phone:</label>
				<div class="controls">
					<input required type="number" name="phone" class="span12"/>
				</div>
			</div>
		</div>
	</div>

	<!-- Add policy data -->
	<h3>Policy Details</h3>
	<div class="row-fluid">
		<div class="span6">
			<div class="control-group">
				<label for="payment_mode" class="control-label">Payment Mode:</label>
				<div class="controls">
					<select name="payment_mode" class="span12">
						<option value="1">Daily</option>
						<option value="2">Weekly</option>
						<option value="3">Monthly</option>
					</select>
				</div>
			</div>
		</div>
		<div class="span6">
			<div class="control-group">
				<label for="total_premium" class="control-label">Total Premium:</label>
				<div class="controls">
					<input required type="number" value="0" name="total_premium" class="span12" value=""/>
				</div>
			</div>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span6">
			<div class="control-group">
				<label for="paid_premium" class="control-label">Paid Premium:</label>
				<div class="controls">
					<input required type="number" value="0" name="paid_premium" class="span12" />
				</div>
			</div>
		</div>
		<div class="span6">
			<div class="control-group">
				<label for="loan_amount" class="control-label">Loan Amount</label>
				<div class="controls">
					<input required type="number" value="0" name="loan_amount" class="span12"/>
				</div>
			</div>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span6">
			<div class="control-group">
				<label for="mcare_id" class="control-label">MCare ID:</label>
				<div class="controls">
					<input type="text" name="mcare_id" class="span12"/>
				</div>
			</div>
		</div>
		<div class="span6">
			<div class="control-group">
				<label for="loan_id" class="control-label">Loan ID</label>
				<div class="controls">
					<input required type="text"  name="loan_id" class="span12"/>
				</div>
			</div>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span6">
			<div class="control-group">
				<label for="expiry_date" class="control-label">Expiry Date:</label>
				<div class="controls">
					<input required type="text" name="expiry_date" class="span12 date-picker"/>
				</div>
			</div>
		</div>
		<div class="span6">
			<div class="control-group">
				<label for="preffered_msp" class="control-label">Preffered MSP:</label>
				<div class="controls">
					<select name="preffered_msp" id="select2_sample1" class="span12">
						<option value="">--Choose MSP--</option>
						<?php
							$query = "SELECT * FROM afyapoa_msps";
							$result = run_query($query);
							while($rows = get_row_data($result)){
								$afyapoa_msp_id = $rows['afyapoa_msp_id'];
								$msp_name = $rows['msp_name'];
						?>
						<option value="<?=$afyapoa_msp_id; ?>"><?=$rows['msp_name']; ?></option>
						<? } ?>
					</select>
				</div>
			</div>
		</div>
	</div>

	<div class="row-fluid">
		<div class="span6">
			<div class="control-group">
				<label for="marital_status" class="control-label">Marital Status:</label>
				<div class="controls">
					<input required type="text" name="marital_status" class="span12"/>
				</div>
			</div>
		</div>
		<div class="span6">
			<div class="control-group">
				<label for="next_of_kin" class="control-label">Next of Kin:</label>
				<div class="controls">
					<input required type="text" name="next_of_kin" class="span12"/>
				</div>
			</div>
		</div>
	</div>

	<div class="row-fluid">
		<div class="span6">
			<div class="control-group">
				<label for="next_of_kin_phone" class="control-label">Next of Kin Phone:</label>
				<div class="controls">
					<input required type="number" name="next_of_kin_phone" class="span12"/>
				</div>
			</div>
		</div>
		<div class="span6">
			<div class="control-group">
				<label for="next_of_kin_physical_address" class="control-label">Next of Kin Physical Address:</label>
				<div class="controls">
					<input required type="text" name="next_of_kin_physical_address" class="span12"/>
				</div>
			</div>
		</div>
	</div>

	<div class="row-fluid">
		<div class="span6">
			<div class="control-group">
				<label for="relationship" class="control-label">Relationship:</label>
				<div class="controls">
					<input required type="text" name="relationship" class="span12"/>
				</div>
			</div>
		</div>
		<div class="span6">
			<div class="control-group">
				<label for="postal_address" class="control-label">Postal Address:</label>
				<div class="controls">
					<input required type="text" name="postal_address" class="span12"/>
				</div>
			</div>
		</div>
	</div>

	<div class="row-fluid">
		<div class="span6">
			<div class="control-group">
				<label for="user_city" class="control-label">User City:</label>
				<div class="controls">
					<input required type="text" name="user_city" class="span12"/>
				</div>
			</div>
		</div>
		<div class="span6">
			<div class="control-group">
				<label for="physical_address" class="control-label">Physical Address:</label>
				<div class="controls">
					<input required type="text" name="physical_address" class="span12"/>
				</div>
			</div>
		</div>
	</div>

	<div class="row-fluid">
		<div class="span6">
			<div class="control-group">
				<label for="agent_customer_id" class="control-label">Agent:</label>
				<div class="controls">
					<select name="agent_customer_id" class="span12" id="select2_sample5" required>
						<option value="">--Choose Agent--</option>
						<?php
							$query = "SELECT aa.*, c.* FROM afyapoa_agent aa
							LEFT JOIN customers c ON c.customer_id = aa.customer_id";
							$result = run_query($query);
							while ($rows = get_row_data($result)) {
						?>
						<option value="<?=$rows['customer_id']; ?>"><?=$rows['surname'].' '.$rows['firstname'].' '.$rows['middlename']; ?>
						<? } ?>
					</select>
				</div>
			</div>
		</div>
		<div class="span6">
			<div class="control-group">
				<label for="user_association" class="control-label">User Associtation:</label>
				<div class="controls">
					<input required type="text" name="user_association" class="span12"/>
				</div>
			</div>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span6">
			<div class="control-group">
				<label for="afyapoafile_status" class="control-label">Status:</label>
				<div class="controls">
					<select name="afyapoafile_status" required class="span12">
						<option value="">--Choose Status--</option>
						<option value="1">Active</option>
						<option value="0">Inactive</option>
					</select>
				</div>
			</div>
		</div>
	</div>

	<!-- Upload the profile and the ID image respectively -->
	<h3 class="form-section">Upload Images</h3>
	<div class="row-fluid">
	    <div class="span6">
			<label class="control-label">Upload Profile Photo:</label>
            <div class="controls">
            <div class="fileupload fileupload-new" data-provides="fileupload">
                <div class="fileupload-new thumbnail" style="width: 100px; height: 100px;"><img src="assets/img/profile/photo.jpg" /></div>
                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 100px; max-height: 100px; line-height: 20px;"></div>
                <div>
                    <span class="btn btn-file"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span><input required class="span12" type="file" name="profile-pic"/></span>
                    <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                </div>
            </div> 
            </div>
        </div>
        <div class="span6">
			<label class="control-label">Upload ID Photo:</label>
            <div class="controls">
            <div class="fileupload fileupload-new" data-provides="fileupload">
                <div class="fileupload-new thumbnail" style="width: 100px; height: 100px;"><img src="assets/img/profile/photo.jpg" /></div>
                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 100px; max-height: 100px; line-height: 20px;"></div>
                <div>
                    <span class="btn btn-file"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span><input required class="span12" type="file" name="id-pic"/></span>
                    <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                </div>
            </div> 
            </div>
        </div>
    </div>
	<div class="form-actions">
		<input required type="hidden" name="action" value="add_policy"/>
        <?php viewActions($_GET['num'], $_SESSION['role_id']); ?>
	</div>
								
</form>
<!-- END FORM -->  