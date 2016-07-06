<?php

/**
 * Set the page layout that will be used
 */
set_layout("form-layout.php", array(
	'pageSubTitle' => 'Add A Customer',
	'pageSubTitleText' => 'allow one to add a new customer',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
                array ( 'url'=>'index.php?num=801', 'text'=>'CRM' ),
		array ( 'text'=>'Add Customer' )
	),
	'pageWidgetTitle' => 'Customer Details'
));

set_css(array(
	'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.css',
	'assets/plugins/bootstrap-datepicker/css/datepicker.css'
));
set_js(array(
	'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.js',
	'assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js'
)); 
if(isset($_SESSION['add_crm'])){
    echo "<p style='color:#f00; font-size:16px;'>".$_SESSION['add_crm']."</p>";
    unset($_SESSION['add_crm']);
}
?>    
<!-- BEGIN FORM -->
<form action="" method="post" id="add_customer" enctype="multipart/form-data" class="form-horizontal">
	<div class="alert alert-error hide">
        <button class="close" data-dismiss="alert">×</button>
        You have some form errors. Please check below.
    </div>
    <div class="alert alert-success hide">
        <button class="close" data-dismiss="alert">×</button>
        Your form validation is successful!
    </div>                              <div class="row-fluid">
		<div class="span6">
			<div class="control-group">
				<label for="afyapoa_role" class="control-label">AfyaPoa Role<span class="required">*</span></label>
				<div class="controls">
					<select class="span12" name="afyapoa_role" required>
						<option value="1">Agent</option>
                        <option value="6">Medical Service Provider</option>
                        <option value="4">Associations</option>
                        <option value="staff">Staff</option>
					</select>
				</div>
			</div>
		</div>
		
	</div>
	<div class="row-fluid">
		<div class="span6">
			<div class="control-group">
				<label for="surname" class="control-label">Surname<span class="required">*</span></label>
				<div class="controls">
					<input class="span12" type="text" name="surname" required/>
				</div>
			</div>
		</div>
		<div class="span6">
			<div class="control-group">
				<label for="start_date" class="control-label">Start Date<span class="required">*</span></label>
				<div class="controls">
					<input type="text" class="date-picker span12" name="start_date" required />
				</div>
			</div>
		</div>
	</div>

	<div class="row-fluid">
		<div class="span6">
			<div class="control-group">
				<label for="firstname" class="control-label">First Name<span class="required">*</span></label>
				<div class="controls">
					<input class="span12" type="text" name="firstname" required/>
				</div>
			</div>
		</div>
		<div class="span6">
			<div class="control-group">
				<label for="attached_ro" class="control-label">Link RO:<span class="required">*</span></label>
				<div class="controls">
					<select class="span12" name="attached_ro" id="select2_sample5" class="span12" required>
						<option value="0">N/A</option>
							<?php
                                $query = run_query("SELECT * FROM afyapoa_agent aa left join customers c
                                                                    ON aa.customer_id = c.customer_id
                                                                    ORDER BY c.surname ASC");

                                if ( $query !== false )
                                {
                                    while ( $fetch = get_row_data($query) )
                                    {
                                            echo "<option value='".$fetch['customer_id']."'>".
                                                    $fetch['surname']." ".$fetch['firstname']."</option>";
                                    }
                                }
                            ?>
					</select>
				</div>
			</div>
		</div>
	</div>
    
	<div class="row-fluid">
		
		<div class="span6">
			<div class="control-group">
				<label for="middlename" class="control-label">Middle Name<span class="required">*</span></label>
				<div class="controls">
					<input class="span12" type="text" name="middlename" required />
				</div>
			</div>
		</div>
		<div class="span6">
			<div class="control-group">
				<label for="attached_champion" class="control-label">Link Champion:<span class="required">*</span></label>
				<div class="controls">
					<select class="span12" id="select2_sample2" name="attached_champion" required>
						<option value="0">N/A</option>
						<?php

                        $query = run_query("SELECT * FROM afyapoa_agent aa left join customers c
                                                                    ON aa.customer_id = c.customer_id
                                                                    ORDER BY c.surname ASC");

                        if ( $query !== false )
                        {
                                while ( $fetch = get_row_data($query) )
                                {
                                        echo "<option value='".$fetch['customer_id']."'>".
                                                $fetch['surname']." ".$fetch['firstname']."</option>";
                                }
                        }
                        ?>
					</select>
				</div>
			</div>
		</div>
        
	</div>
	<div class="row-fluid">
		<div class="span6">
			<div class="control-group">
				<label for="status" class="control-label">Status<span class="required">*</span></label>
				<div class="controls">
					<select class="span12" name="status" required>
						<option value="1">Active</option>
						<option value="0">Inactive</option>
					</select>
				</div>
			</div>
		</div>
		<div class="span6">
			<div class="control-group">
				<label for="attached_superchampion" class="control-label">Link Super-Champion:<span class="required">*</span></label>
				<div class="controls">
					<select class="span12" id="select2_sample1" name="attached_superchampion" required>
						<option value="0">N/A</option>
						<?php

                        $query = run_query("SELECT * FROM afyapoa_agent aa left join customers c
                                                                    ON aa.customer_id = c.customer_id
                                                                    ORDER BY c.surname ASC");

                        if ( $query !== false )
                        {
                                while ( $fetch = get_row_data($query) )
                                {
                                        echo "<option value='".$fetch['customer_id']."'>".
                                                $fetch['surname']." ".$fetch['firstname']."</option>";
                                }
                        }
                        ?>
					</select>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row-fluid">
		
		<div class="span6">
			<div class="control-group">
				<label for="email" class="control-label">Email<span class="required">*</span></label>
				<div class="controls">
					<input class="span12" type="email" name="email" required />
				</div>
			</div>
		</div>
		<div class="span6">
			<div class="control-group">
				<label for="phone" class="control-label">Phone<span class="required">*</span></label>
				<div class="controls">
					<input class="span12" type="number" name="phone" minlength="10" maxlength="10" required />
				</div>
			</div>
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span6">
			<div class="control-group">
				<label for="national_id_number" class="control-label">ID Number<span class="required">*</span></label>
				<div class="controls">
					<input class="span12" type="number" name="national_id_number" minlength="8" maxlength="10" required />
				</div>
			</div>
		</div>
		<div class="span6">
			<div class="control-group">
				<label for="customer_type_id" class="control-label">Customer Type<span class="required">*</span></label>
				<div class="controls">
					<select class="span12" name="customer_type_id" required>
						<?php
                            $query = run_query("SELECT * FROM customer_types ORDER BY customer_type_name");

                            if ( $query !== false )
                            {
                                    while ( $fetch = get_row_data($query) )
                                    {
                                            echo "<option value='".$fetch['customer_type_id']."'>".$fetch['customer_type_name']."</option>";
                                    }
                            }
                        ?>
                    </select>
				</div>
			</div>
		</div>
		
	</div>

	<div class="row-fluid">
	    <div class="span6">
			<label class="control-label">IMAGE UPLOAD:</label>
            <div class="controls">
            <div class="fileupload fileupload-new" data-provides="fileupload">
                <div class="fileupload-new thumbnail" style="width: 100px; height: 100px;"><img src="assets/img/profile/photo.jpg" /></div>
                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 100px; max-height: 100px; line-height: 20px;"></div>
                <div>
                    <span class="btn btn-file"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span><input class="span12" type="file" name="profile-pic"/></span>
                    <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                </div>
            </div> 
            </div>
        </div>
        <div class="span6">
            <label for="msp_type" class="control-label">MSP Type<span class="required">*</span></label>
            <div class="controls">
                <select class="span12" name="msp_type" required>
                    <option value="0">Not Applicable</option>
                    <option value="1">Pharmacy</option>
                    <option value="2">Clinic</option>
                    <option value="2">Dentist</option>
                </select>
            </div>
        </div>                                                                        
    </div>   
    <div class="row-fluid">
	    <div class="span6">
			<label class="control-label">User Role:</label>
            <div class="controls">
            	<select name="user_role" class="span12" required readonly>
            		<?php
            			$query = "SELECT * FROM user_roles where role_name = 'Default'";
            			$result = run_query($query);
            			while ($rows = get_row_data($result)) {
            		?>
            		<option value="<?=$rows['role_id']; ?>"><?=$rows['role_name']; ?></option>
            		<?php } ?>
            	</select> 
            </div>
        </div>
    </div>
	
	<input class="span12" type="hidden" name="balance" value="0"/>
	<input class="span12" type="hidden" name="action" value="add_crm"/>
	<input class="span12" type="hidden" name="regdate_stamp" value="<?php echo date('d-m-Y') ?>"/>
	
	<div class="form-actions">
		<button class="btn btn-primary" type="submit">Save</button>
		<button class="btn" type="reset">Reset</button>
	</div>
</form>
<!-- END FORM -->

 <div id="add_crm_errorloc" class="error_strings">
            </div>

<!---->
	<script language="JavaScript" type="text/javascript"
	    xml:space="preserve">//<![CDATA[
	//You should create the validator only after the definition of the HTML form
	  var frmvalidator  = new Validator("add_crm");
	 frmvalidator.EnableOnPageErrorDisplaySingleBox();
	 frmvalidator.EnableMsgsTogether();

	frmvalidator.addValidation("surname","req","Please enter your surname");
	  frmvalidator.addValidation("surname","maxlen=20","Max length for surname is 20");
	  frmvalidator.addValidation("surname","alpha_s","surname can contain alphabetic chars only");

	frmvalidator.addValidation("start_date","req");

	  frmvalidator.addValidation("time_date","req");
 	
	frmvalidator.addValidation("balance","req");

	frmvalidator.addValidation("status","req");

	 frmvalidator.addValidation("customer_type_id","maxlen=10");
	  frmvalidator.addValidation("customer_type_id","req");

	frmvalidator.addValidation("firstname","req","Please enter your First Name");
	  frmvalidator.addValidation("firstname","maxlen=20",	"Max length for FirstName is 20");
	  frmvalidator.addValidation("firstname","alpha_s","Name can contain alphabetic chars only");


	frmvalidator.addValidation("username","req","Please enter your userame");
	  frmvalidator.addValidation("username","maxlen=20",	"Max length for username is 20");

	frmvalidator.addValidation("password","req","Please enter your password");
	  frmvalidator.addValidation("password","maxlen=20",	"Max length for password is 20");

	frmvalidator.addValidation("middlename","req","Please enter your Middle Name");
	  frmvalidator.addValidation("middlename","maxlen=20",	"Max length for Middle Name is 20");
	  frmvalidator.addValidation("middlename","alpha_s","Name can contain alphabetic chars only");

	frmvalidator.addValidation("regdate_stamp","req");

	frmvalidator.addValidation("national_id_number","maxlen=10");
	  frmvalidator.addValidation("national_id_number","req");

	 
	  frmvalidator.addValidation("phone","maxlen=14");
	  frmvalidator.addValidation("phone","req");

           frmvalidator.addValidation("email","maxlen=50");
            frmvalidator.addValidation("email","req");
             frmvalidator.addValidation("email","email");

	
	 frmvalidator.addValidation("passport","req","Please enter the passport");
	  frmvalidator.addValidation("passport","maxlen=10");
	
	  frmvalidator.addValidation("Address","maxlen=50");
	  frmvalidator.addValidation("Country","dontselect=0");

	  
	    function DoCustomValidation()
	    {
		var frm = document.forms["edit_crm"];
		if(frm.firstname.value == 'Null')
		{
		    sfm_show_error_msg("You can't submit this form. Go away! ");
		    return false;
		}
		else
		{
		    return true;
		}
	    }
	
	  frmvalidator.setAddnlValidationFunction(DoCustomValidation);
	//]]></script>
	<!---->
<?php
/**
 * Using jQuery Validator Plugin
 */
set_css(array("assets/plugins/bootstrap-datepicker/css/datepicker.css"));
set_js(array(
	"assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js",
	"assets/scripts/form-validator.js",
	"src/js/add.crm.customer.js"
));
?>
