 <?
   $distinctQuery2 = "select count(house_id) as total_houses from ".DATABASE.".house_rent";
   $resultId2 = run_query($distinctQuery2);	
   $arraa = get_row_data($resultId2);
   $total_rows2 = $arraa['total_houses'];
 ?>
 
 <script type="text/javascript">
		$(document).ready(
			function() {
				$("#table1").ingrid({ 
					url: 'remote_land_rates.php',
					height: 400,
					totalRecords: <?=$total_rows2;?>,
					pageNumber: 1,
					recordsPerPage: 0,
					colWidths: [100,80,250,170,100,100,100,100,50]
				});
			}
		); 
	</script>  
 <fieldset><legend class="table_fields">RENTS(HOUSES&STALLS)</legend> 
   <table id="table1">
 <thead>
  <tr>
   <th>HS/STALL#</th>
   <th>Entry#</th>
   <th>Estate</th>
   <th>Contact Name</th>
   <th>Rate</th>
   <th>Arrears</th>
   <th>Curr.Balance</th>
   <th>Customer ID</th>
   <th>EDIT</th>
  </tr>
 </thead>
 <tbody>
 
 <?
   $distinctQuery = "select * from ".DATABASE.".house_rent Order by house_number ASC Limit 20";
   $resultId = run_query($distinctQuery);	
   $total_rows = get_num_rows($resultId);
	
   
	$con = 1;
	$total = 0;
	while($row = get_row_data($resultId))
	{
		$trans_id = trim($row['house_id']);
		$ref_id = trim($row['house_number']);
		$house_estate = trim($row['house_estate']);
		
		$trans_type = $row['transaction_code'];
		
		$contact_name = $row['contact_name'];
		$house_rate = $row['house_rate'];
		$arrears = $row['total_arrears'];
		$customer_id = $row['customer_id'];
		$curr_balance = $row['current_balance'];
		 ?>
		  <tr>
		   <td><?=$ref_id; ?></td>
		   <td><?=$trans_id; ?></td>
		   <td><?=$house_estate; ?></td>
           <td><?=$contact_name; ?></td>		   
           <td><?=$house_rate; ?></td>
           <td><?=$arrears; ?></td>
           <td><?=$curr_balance; ?></td>
           <td><?=$customer_id; ?></td>
           <td><a href="index.php?num=55">Manage</a></td>
		  </tr>
		 <?
 
	}
	
	?>
  </tbody>
</table>
</fieldset>