<?php
error_reporting(0);
set_title('Add Plot');
/**
 * Set the page layout that will be used
 */
set_layout("form-layout.php", array(
	'pageSubTitle' => 'Add A Plot',
	'pageSubTitleText' => 'allow one to add a new plot',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'PLOTS' ),
		array ( 'text'=>'Add New Plot' )
	),
	'pageWidgetTitle' => 'Plot Details'
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
	<form action="" method="post" id="add_property" enctype="multipart/form-data" class="form-horizontal">
		<div class="alert alert-error hide">
            <button class="close" data-dismiss="alert">x</button>
            You have some form errors. Please check below.
        </div>
        <div class="alert alert-success hide">
            <button class="close" data-dismiss="alert">x</button>
            Your form validation is successful!
        </div> 
        <?php if(isset($_SESSION['mes'])){ echo $_SESSION['mes']; unset($_SESSION['mes']); } ?>                           
        <div class="row-fluid">
			<div class="span6">
				<div class="control-group">
					<label for="property_name" class="control-label">Plot Name<span class="required">*</span></label>
					<div class="controls">
						<input type="text" name="property_name" required/>
					</div>
				</div>
			</div>
		</div>

		<div class="row-fluid">
			<div class="span6">
				<div class="control-group">
					<label for="units" class="control-label">Units:<span class="required">*</span></label>
					<div class="controls">
						<input type="number" placeholder="Enter no of units in plot" name="units" required/>
					</div>
				</div>
			</div>
		</div>

		<div class="row-fluid">
			<div class="span6">
				<div class="control-group">
					<label for="payment_code" class="control-label">Payment Code:</label>
					<div class="controls">
						<input type="text" name="payment_code" required/>
					</div>
				</div>
			</div>
		</div>

		<div class="row-fluid">
			<div class="span6">
				<div class="control-group">
					<label for="paybill_no" class="control-label">Paybill No:</label>
					<div class="controls">
						<input type="number" name="paybill_no" required/>
					</div>
				</div>
			</div>
		</div>
        
		<div class="row-fluid">
			<div class="span12">
				<div class="control-group">
					<label for="attached_to" class="control-label">Customer:<span class="required">*</span></label>
					<div class="controls">
						<select name="attached_to" required>
							<option value="">--Choose a Customer--</option>
								<?php

                                $query = run_query("SELECT * FROM customers ORDER BY surname ASC");

                                if ( $query !== false )
                                {
                                        while ( $fetch = get_row_data($query) )
                                        {
                                                echo "<option value='".$fetch['customer_id']."'>".$fetch['surname']." ".$fetch['firstname']."</option>";
                                        }
                                }
                                ?>
						</select>
					</div>
				</div>
			</div>
		</div>		

		<input type="hidden" name="action" value="add_property"/>

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
	  var frmvalidator  = new Validator("add_property");
	 frmvalidator.EnableOnPageErrorDisplaySingleBox();
	 frmvalidator.EnableMsgsTogether();

	frmvalidator.addValidation("prop_name","req","Please enter your surname");
	frmvalidator.addValidation("prop_units","req", "Please enter the no of units");
	
	  
    function DoCustomValidation()
    {
	var frm = document.forms["edit_prop"];
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
	"src/js/add.crm.property.js"
));
?>
