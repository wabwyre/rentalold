 <?
   $distinctQuery2 = "select count(clamping_transaction_id) as total_clamps from ".DATABASE.".clamping_transactions";
   $resultId2 = run_query($distinctQuery2);	
   $arraa = get_row_data($resultId2);
   $total_rows2 = $arraa['total_clamps'];
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
					colWidths: [70,55,120,80,100,190,140,120]
				});
			}
		); 
	</script>  
 <fieldset><legend class="table_fields">CLAMPING-RECORDS</legend> 
   <table id="table1">
 <thead>
  <tr>
   <th>CAR#</th>
   <th>C.ID#</th>
   <th>C.Date</th>
   <th>Status</th>
   <th>QueryID</th>
   <th>Clamper</th>
   <th>Street</th>
   <th>Pudlock</th>
  </tr>
 </thead>
 <tbody>
 
 <?
   $distinctQuery = "select * from ".DATABASE.".clamping_transactions Order by clamping_transaction_id DESC Limit 20";
   $resultId = run_query($distinctQuery);	
   $total_rows = get_num_rows($resultId);
	
   
	$con = 1;
	$total = 0;
	while($row = get_row_data($resultId))
	{
		$trans_id = trim($row['clamping_transaction_id']);
		$ref_id = trim($row['plate_number']);
		$head_id = trim($row['transaction_id']);
		
		$pudlock = $row['padlock_id'];
		$query_date = date("d-m-Y H:i:s",$row['clamping_time']);
		$end_date = date("d-m-Y H:i:s",$row['time_out']);
		
		$clamper_id = trim($row['clamper_id']);
		
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
		   <td><? echo ($status==TRUE)?"ACTIVE":"UN-CLAMPED"; ?></td>
           <td><?=$query_id; ?></td>
           <td><?=$clamper_id; ?> (<? if($clamper_id > 0)  echo getStaffName($clamper_id); ?>)</td>
           <td><?=getStreetName($street_id); ?></td>
			<td><?=$pudlock; ?></td>
		  </tr>
		 <?
 
	}
	
	?>
  </tbody>
</table>
</fieldset>