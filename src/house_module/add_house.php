<?php
error_reporting(0);
set_title('Add House');
/**
 * Set the page layout that will be used
 */
set_layout("form-layout.php", array(
	'pageSubTitle' => 'Add A House',
	'pageSubTitleText' => 'allow one to add a new house',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'Houses/Units' ),
		array ( 'text'=>'Add House' )
	),
	'pageWidgetTitle' => 'House Details'
));

set_css(array(
	'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.css',
	'assets/plugins/bootstrap-datepicker/css/datepicker.css'
));
set_js(array(
	'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.js',
	'assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js'
)); 
if(isset($_SESSION['done-add'])){
    echo "<p style='color:#f00; font-size:16px;'>".$_SESSION['done-add']."</p>";
    unset($_SESSION['done-add']);
}
?>    
<!-- BEGIN FORM -->
	<form action="" method="post" id="add_house" enctype="multipart/form-data" class="form-horizontal">
		<div class="alert alert-error hide">
            <button class="close" data-dismiss="alert">×</button>
            You have some form errors. Please check below.
        </div>
        <div class="alert alert-success hide">
            <button class="close" data-dismiss="alert">×</button>
            Your form validation is successful!
        </div>
        <?php if(isset($_SESSION['mes2'])){ echo $_SESSION['mes2']; unset($_SESSION['mes2']); } ?>                              
        <div class="row-fluid">
			<div class="span6">
				<div class="control-group">
					<label for="house_no" class="control-label">House No.:<span class="required">*</span></label>
					<div class="controls">
						<input type="text" name="house_no" autocomplete="off" required/>
					</div>
				</div>
			</div>
		</div>
		
		<div class="row-fluid">
			<div class="span6">
				<div class="control-group">
					<label for="plot_id" class="control-label">Plot:<span class="required">*</span></label>
					<div class="controls">
						<select name="plot_id"required>
							<option value="0">N/A</option>
								<?php

                                $query = run_query("SELECT * FROM plots ORDER BY plot_name ASC");

                                if ( $query !== false )
                                {
                                        while ( $fetch = get_row_data($query) )
                                        {
                                                echo "<option value='".$fetch['plot_id']."'>".$fetch['plot_name']."</option>";
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
					<label for="rent_amount" class="control-label">Rent Amount:<span class="required">*</span></label>
					<div class="controls">
						<input type="number" name="rent_amount" required/>
					</div>
				</div>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span6">
				<div class="control-group">
					<label for="tenant" class="control-label">Tenant:<span class="required">*</span></label>
					<div class="controls">
						<select name="tenant" required>
							<option value="">--Choose Tenant--</option>
							<?php

								$query = "SELECT * FROM tenants";
								$result = run_query($query);
								while($row = get_row_data($result)){
									$id=$row['tenant_id'];
									$surname=$row['surname'];
									$firstname=$row['firstname'];

									echo "<option value=\"$id\">$surname $firstname</option>";

								}

							?>
						</select>
					</div>
				</div>
			</div>
		</div>

		<input type="hidden" name="action" value="add_house"/>

		<div class="form-actions">
			<button class="btn btn-primary" type="submit">Save</button>
			<button class="btn" type="reset">Reset</button>
		</div>
	</form>
	<!-- END FORM -->

 <div id="add_property_errorloc" class="error_strings">
            </div>

<!---->
	<script language="JavaScript" type="text/javascript"
	    xml:space="preserve">//<![CDATA[
	//You should create the validator only after the definition of the HTML form
	  var frmvalidator  = new Validator("add_house");
	 frmvalidator.EnableOnPageErrorDisplaySingleBox();
	 frmvalidator.EnableMsgsTogether();

	frmvalidator.addValidation("house_no","req","Please enter your surname");
	frmvalidator.addValidation("plot_id","req", "Please select the plot_id");
	frmvalidator.addValidation("phone","req", "Please Enter your phone number");
	
	  
    function DoCustomValidation()
    {
	var frm = document.forms["add_house"];
	if(frm.phone.value == 'Null')
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
	"src/js/add.crm.property.js"
));
?>
