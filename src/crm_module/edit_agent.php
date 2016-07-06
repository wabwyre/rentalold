<?php
//get the value
if (isset($_GET['customer'])){
	$customer=$_GET['customer'];
	
	//get the row
	$query="SELECT a.*, c.*, ct.*, ad.post_office_box, ad.postal_code, ad.premises, ad.street, ad.town, ad.county FROM afyapoa_agent a 
      LEFT JOIN customers c ON c.customer_id = a.customer_id
      LEFT JOIN ndovu_address ad ON ad.address_id = c.address_id
      LEFT JOIN customer_types ct ON ct.customer_type_id = c.customer_type_id
      WHERE c.customer_id = '".$customer."'
   ";
}

$data=run_query($query);
$row=get_row_data($data);
$surname = $row['surname'];
$firstname = $row['firstname'];
$middlename = $row['middlename'];

$customer_name = strtoupper($surname.' '.$firstname.' '.$middlename);

set_layout("form-layout.php", array(
	'pageSubTitle' => 'EDIT AGENTS',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'#', 'text'=>'Home' ),
		array ( 'text'=>'CRM' ),
		array ( 'url'=>'?num=811', 'text'=>'All Agents' ),
		array ( 'text'=>'edit crm' )
	),
	'pageWidgetTitle'=>'EDIT AGENT { <span style="color:green;">'.$customer_name.'</span> }'
));

set_css(array(
	'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.css',
	'assets/plugins/bootstrap-datepicker/css/datepicker.css'
));
set_js(array(
	'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.js',
	'assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js'
)); 

if(isset($_SESSION['edit_agent'])){
    echo "<p style='color:#f00; font-size:16px;'>".$_SESSION['edit_agent']."</p>";
    unset($_SESSION['edit_agent']);
}

    //the values
    $customer_id=$row['customer_id'];
    $selected1 = ''; $selected2 = ''; $selected3 = '';
    // if($payment_mode == 1)
    // 	$selected1 = 'selected';
    // else if($payment_mode == 2)
    // 	$selected2 = 'selected';
    // else if($payment_mode == 3)
    // 	$selected3 = 'selected';

    // $start_date = date('Y-m-d', $row['date_started']);
    $ro_customer_id = $row['ro_customer_id'];
    $champ_customer_id = $row['champ_customer_id'];
    $super_champ_customer_id = $row['super_champ_customer_id'];
  	$status = $row['status'];
  	$choice1 = '';
  	$choice2 = '';
  	if($status == 1)
  		$choice1 = 'selected';
  	elseif($status == 2)
  		$choice2 = 'selected'; 

  	$image_path = $row['images_path'];
      if($image_path == ''){
         $image_path = 'crm_images/photo.jpg';
      }
?>
    <!-- BEGIN FORM -->
		<form action=""  id="edit_crm" method="post" enctype="multipart/form-data" class="form-horizontal">
   <div class="row-fluid">
		<div class="span6">
			<div class="control-group">
				<label for="customer_id" class="control-label">Customer ID:</label>
				<div class="controls">
					<input type="text" name="customer_id" class="span12" value="<?=$customer_id; ?>" readonly style="background-color: #ccc" />
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
                            ?>
                            <option value="<?=$fetch['customer_id']; ?>" <?=($fetch['customer_id'] == $ro_customer_id) ? 'selected' : ''; ?>><?=$fetch['surname'].' '.$fetch['firstname'].' '.$fetch['middlename']; ?></option>
                            <?php
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
                            ?>
                            <option value="<?=$fetch['customer_id']; ?>" <?=($fetch['customer_id'] == $champ_customer_id) ? 'selected' : ''; ?>><?=$fetch['surname'].' '.$fetch['firstname'].' '.$fetch['middlename']; ?></option>
                            <?php
                                    }
                                }
                            ?>
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
                            ?>
                            <option value="<?=$fetch['customer_id']; ?>" <?=($fetch['customer_id'] == $super_champ_customer_id) ? 'selected' : ''; ?>><?=$fetch['surname'].' '.$fetch['firstname'].' '.$fetch['middlename']; ?></option>
                            <?php
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
			<label class="control-label">Upload Profile Photo:</label>
	        <div class="controls">
	        <div class="fileupload fileupload-new" data-provides="fileupload">
	            <div class="fileupload-new thumbnail" style="width: 100px; height: 100px;"><img src="<?=$image_path; ?>" /></div>
	            <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 100px; max-height: 100px; line-height: 20px;"></div>
	            <div>
	                <span class="btn btn-file"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span><input class="span12" type="file" name="profile-pic"/></span>
	                <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
	            </div>
	        </div> 
	        </div>
	    </div>
   </div>
	<div class="form-actions">
		<input type="hidden" name="afyapoa_customer_id" value="<?=$customer_id; ?>"/>
		<input type="hidden" name="action" value="edit_agent"/>
        <?php viewActions($_GET['num'], $_SESSION['role_id']); ?>
	</div>
								
</form>
<!-- END FORM -->  