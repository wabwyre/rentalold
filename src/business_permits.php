 <?
   $distinctQuery2 = "select count(business_id) as total_rates from ".DATABASE.".business";
   $resultId2 = run_query($distinctQuery2);	
   $arraa = get_row_data($resultId2);
   $total_rows2 = $arraa['total_rates'];
 ?>
 
 <script type="text/javascript">
		$(document).ready(
			function() {
				$("#table1").ingrid({ 
					url: 'remote_business_permits.php',
					height: 400,
					totalRecords: <?=$total_rows2;?>,
					pageNumber: 1,
					recordsPerPage: 0,
					colWidths: [300,100,170,100,100,100]
				});
			}
		); 
	</script>  
 <fieldset><legend class="table_fields">BUSINESS PERMITS</legend> 
   <table id="table1">
 <thead>
  <tr>
   <th>Business Name</th>
   <th>BusinessID#</th>
   <th>Contact Name</th>
   <th>Act.Code</th>
   <th>KRA.Pin#</th>
   <th>Customer#</th>
   <th>EDIT</th>
   
  </tr>
 </thead>
 <tbody>
 
 <?
   $distinctQuery = "select * from ".DATABASE.".business Order by business_name ASC Limit 20";
   $resultId = run_query($distinctQuery);	
   $total_rows = get_num_rows($resultId);
	
   
	$con = 1;
	$total = 0;
	while($row = get_row_data($resultId))
	{
		$trans_id = trim($row['business_id']);
		$ref_id = trim($row['business_name']);
		$head_id = trim($row['activity_code']);
		
		$trans_type = $row['transaction_code'];
		
		$contact_name = $row['contact_person'];
		$pin_number = $row['pin_number'];
		$customer_id = $row['customer_id'];
		$lr_penalty = $row['land_rates_accpenalty'];
		$lr_balance = $row['land_rates_currentbalance'];
		 ?>
		  <tr>
		   <td><?=$ref_id; ?></td>
		   <td><?=$trans_id; ?></td>
		   <td><?=$contact_name; ?></td>
		   <td><?=$head_id; ?></td>
           <td><?=$pin_number; ?></td>
           <td><?=$customer_id; ?></td>
           <td><a href="index.php?num=46&biz=<?=$trans_id; ?>">Manage</a></td>
           
		  </tr>
		 <?
 
	}
	
	?>
  </tbody>
</table>
</fieldset>