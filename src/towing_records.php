 <?
   $distinctQuery2 = "select count(towing_transaction_id) as total_tows from ".DATABASE.".towing_transactions";
   $resultId2 = run_query($distinctQuery2);	
   $arraa = get_row_data($resultId2);
   $total_rows2 = $arraa['total_tows'];
 ?>
 
 <script type="text/javascript">
		$(document).ready(
			function() {
				$("#table1").ingrid({ 
					url: 'remote_parking_compliance.php',
					height: 400,
					totalRecords: <?=$total_rows2;?>,
					pageNumber: 1,
					recordsPerPage: 0,
					colWidths: [70,75,120,95,100,120,120]
				});
			}
		); 
	</script>  
 <fieldset><legend class="table_fields">TOWING-RECORDS</legend> 
   <table id="table1">
 <thead>
  <tr>
   <th>CAR#</th>
   <th>Tow.ID#</th>
   <th>Tow.Date</th>
   <th>Status</th>
   <th>ClampID</th>
   <th>Tower</th>
   <th>Street</th>
   <th>Pudlock</th>
  </tr>
 </thead>
 <tbody>
 
 <?
   $distinctQuery = "select * from ".DATABASE.".towing_transactions Order by towing_transaction_id DESC Limit 20";
   $resultId = run_query($distinctQuery);	
   $total_rows = get_num_rows($resultId);
	
   
	$con = 1;
	$total = 0;
	while($row = get_row_data($resultId))
	{
		$trans_id = trim($row['towing_transaction_id']);
		$ref_id = trim($row['plate_number']);
		$clamp_id = trim($row['clamping_transaction_id']);
		
		$buy_date = date("d-m-Y",$row['parking_date']);
		$query_date = date("d-m-Y H:i:s",$row['towing_time']);
		$end_date = date("d-m-Y H:i:s",$row['time_out']);
		
		$query_id = $row['parking_compliance_id'];
		$status = $row['isactive'];
		$agent_id = $row['agent_id'];
		$street_id = $row['street_id'];
		$clamping_flag = $row['clamping_flag'];
		 ?>
		  <tr>
		   <td><?=$ref_id; ?></td>
		   <td><?=$trans_id; ?></td>
		   <td><?=$query_date; ?></td>
		   <td><? echo ($status==1)?"ACTIVE":"RELEASED"; ?></td>
           <td><?=$clamp_id; ?></td>
           <td><?=$agent_id; ?> (<? //echo getStaffName($agent_id); ?>)</td>
           <td><?=getStreetName($street_id); ?></td>
			<td><?=$pudlock; ?></td>
		  </tr>
		 <?
 
	}
	
	?>
  </tbody>
</table>
</fieldset>