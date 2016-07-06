<?php
set_layout("form-layout.php", array(
	'pageSubTitle' => 'Add Revenue channels',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'Revenue Management' ),
		array ( 'url'=>'index.php?num=620','text'=>'All Revenue Channel Record' ),
		array ( 'text'=>'Add Revenue Channel' )
	),
	'pageWidgetTitle' => 'Add REVENUE CHANNEL'
));


set_css(array(
	'assets/plugins/bootstrap-datepicker/css/datepicker.css'
));
set_js(array(
	'assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js',
    'assets/scripts/form-validator.js'	
)); 
if(isset($_SESSION['RMC'])){
    echo "<p style='color:#33FF33; font-size:16px;'>".$_SESSION['RMC']."</p>";
    unset($_SESSION['RMC']);
}

?>    
<!-- BEGIN FORM -->
	<form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
		<div class="row-fluid">
			<div class="span6">
				<div class="control-group">
					<label for="revenue_channel_name" class="control-label">Revenue channel name:<span class="required"></span></label>
					<div class="controls">
						<input type="text" name="revenue_channel_name" class="span12" required/>
					</div>
				</div>
			</div>
		</div>
		<div class="row-fluid">
	        <div class="span6">
	          <div class="control-group">
	            <label for="revenue_channel_code" class="control-label">Revenue Channel Code:</label>
	            <div class="controls">
	             <input type="text"  id="revenue_channel_code" name="revenue_channel_code" class="span12" title="e.g. pk_ser for Parking Service" required/>
	            </div>
	          </div>
	        </div>
        </div>
	
	<div class="form-actions">
        <input type="hidden" name="action" value="add_revenue_channels"/>
		<?php viewActions($_GET['num'], $_SESSION['role_id']); ?>
	</div>
	</form>
	<!-- END FORM -->

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