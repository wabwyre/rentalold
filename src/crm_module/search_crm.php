<?php
set_layout("dt-layout.php", array(
	'pageSubTitle' => 'AFYAPOA Associations/Groups',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'CRM' ),
		array ( 'text'=>'Search Masterfile' )
	)
	
));

//row to be deleted
if (isset($_GET['customer']))
{
	$customer=$_GET['customer'];
	//delete the row
	$delete_customers="DELETE FROM ".DATABASE.".ccn_customers WHERE ccn_customer_id='$customer'";
	$delete_customer=run_query($delete_customers);

	if ($delete_customer)
	{
		echo "<p><font color='#006600'>The Item has been deleted</font></p>";
	}
}

$resultId = false;
if ( isset($_POST['search_item']) && !empty($_POST['search_item']) )
{
	$search = trim($_POST['search_item']);
	$query = "
		SELECT m.*, ul.username, ct.customer_type_name FROM masterfile m 
		LEFT JOIN user_login2 ul ON ul.mf_id = m.mf_id
		LEFT JOIN customer_types ct ON ct.customer_type_id = m.customer_type_id
		WHERE surname LIKE '%".sanitizeVariable($search)."%' OR 
		firstname LIKE '%".sanitizeVariable($search)."%' OR
		middlename LIKE '%".sanitizeVariable($search)."%' OR 
		ul.username LIKE '%".sanitizeVariable($search)."%'
	";	
	$resultId = run_query($query);
	//argDump($query);exit;
}

/**
 * Set page layout
 */
set_layout("dt-layout.php");
?>
		<!-- BEGIN PAGE -->  
	        <div class="span12">
				<div class="row-fluid">
				<!-- BEGIN PAGE TITLE -->
				<h3 class="page-title">
					Search for a Masterfile
					<small></small>
				</h3>
				<!-- END PAGE TITLE -->

				<!-- BEGIN PAGE CONTENT -->
				<div class="row-fluid">
					<div class="span12">
						<div class="row-fluid">
							<div class="widget">
								<div class="widget-title"><h4>Search Parameters</h4></div>
								<div class="widget-body form">
									<form name="market type" method="post" action="" class="form-horizontal">
										<div class="control-group">
											<label for="surname" class="control-label">Search String</label>
											<div class="controls">
												<input name="search_item" type="text" id="search_item" size="50" />
												<span class="help-block">Surname/First Name/Username/Middle Name</span>
											</div>
										</div>
										
										<input name="action" type="hidden" class="header_del_sub" id="action" value="showCustomer" />
										
										<div class="form-actions">
											<button class="btn btn-primary" type="submit">Search</button>
											<button class="btn" type="reset">Reset</button>
										</div>
									</form>
								</div>
							</div>
<?php if ( $resultId !== false ) { ?>

							<div class="widget">
								<div class="widget-title"><h4>Search Results</h4></div>
								<div class="widget-body form">
									<table id="table1" class="table table-bordered">
										<thead>
											<tr class="table_fields">
												<th>MF#</th>
												<th>Start Date</th>
												<th>Surname</th>
												<th>Middle Name</th>
												<th>Customer Type</th>
												<!-- <th>Phone Number</th> -->
												<th>Username</th>
												<th>B. Role</th>
												<th>Edit</th>
												<th>Profile</th>
											</tr>
										</thead>
										<tbody>
<?php
	$con = 1;
	$total = 0;
	//argDump(get_row_data($resultId));exit;
	
	while ( $row = get_row_data($resultId) )
	{
		$customer_id = $row['mf_id'];
		$surname = $row['surname'];
		$firstname = $row['firstname'];
		
		$middle_name = $row['middlename'];
		$regdate_stam = $row['regdate_stamp'];
		$regdate_stamp = date("d-m-Y", strtotime($regdate_stam));
		$username = $row['username'];
		//$email = $row['email'];
		$date_started = date('d-M-Y', $row['time_stamp']);
		
		$customer_type_name = $row['customer_type_name'];
		$b_role = $row['b_role'];
 ?>
<tr>
	<td><?=$customer_id; ?></td>
	<td><?=$date_started; ?></td>
	<td><?=$surname; ?></td>
	<td><?=$middle_name; ?></td>
	<td><?=$customer_type_name; ?></td>
	<td><?=$username; ?> </td>
	<td><?=$b_role; ?></td>		
	<td><a id="edit_link" href="index.php?num=802&customer=<?=$customer_id; ?>" class="btn btn-mini"><i class="icon-edit"></i> Edit</a></td>
	<td><a id="edit_link" href="index.php?num=810&customer=<?=$customer_id; ?>" class="btn btn-mini"><i class="icon-eye-open"></i> Profile</a></td>
</tr>
<?php
		$total++;
	} /* End of while loop */
	
	// If there were no records to show
	if ( $total == 0 ) {
?>
<?php }?>
										<tbody>
									</table> <div class="clearfix"></div>
								</div>
							</div>
<?php
} /* End of showing searched results */
?>

						</div>
					</div>
				</div>
				<!-- END PAGE CONTENT -->
				
			</div>
		</div>
		<!-- END PAGE --> 

