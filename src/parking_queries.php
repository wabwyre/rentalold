 <?
   $distinctQuery2 = "select count(parking_compliance_id) as total_parks from ".DATABASE.".parking_compliance";
   $resultId2 = run_query($distinctQuery2);	
   $arraa = get_row_data($resultId2);
   $total_rows2 = $arraa['total_parks'];
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
					colWidths: [70,55,120,95,70,190,190,190,80]
				});
			}
		); 
	</script>  
 <fieldset><legend class="table_fields">PARKING-QUERIES</legend> 
   <table id="table1">
 <thead>
  <tr>
   <th>CAR#</th>
   <th>Q.ID#</th>
   <th>Q.Date</th>
   <th>Q.Result</th>
   <th>Clamp</th>
   <th>Inspector</th>
   <th>Street</th>
   <th>Clamper</th>
   <th>SMS Sent</th>
  </tr>
 </thead>
 <tbody>
 
 <?
   $distinctQuery = "select * from ".DATABASE.".parking_compliance Order by parking_compliance_id DESC Limit 20";
   $resultId = run_query($distinctQuery);	
   $total_rows = get_num_rows($resultId);
	
   
	$con = 1;
	$total = 0;
	while($row = get_row_data($resultId))
	{
		$trans_id = trim($row['parking_compliance_id']);
		$ref_id = trim($row['plate_number']);
		$head_id = trim($row['transaction_id']);
		
		$buy_date = date("d-m-Y",$row['parking_date']);
		$query_date = date("d-m-Y H:i:s",$row['query_timestamp']);
		$end_date = date("d-m-Y H:i:s",$row['time_out']);
		
		$parking_type = $row['parking_type_id'];
		$status = $row['status'];
		$agent_id = $row['parking_attendant_id'];
		$street_id = $row['street_id'];
		$clamping_flag = $row['clamping_flag'];
		$notified_clamper = $row['notified_clamper'];
		$sms_sent = $row['sms_sent'];
		
		 ?>
		  <tr>
		   <td><?=$ref_id; ?></td>
		   <td><?=$trans_id; ?></td>
		   <td><?=$query_date; ?></td>
		   <td><? echo ($status==1)?"COMPLIANT":"NON-COMPLIANT"; ?></td>
           <td><? echo ($clamping_flag==1)?"CLAMP":"NON"; ?></td>
           <td><?=$agent_id; ?> (<? echo getStaffName($agent_id); ?>)</td>
           <td><?=getStreetName($street_id); ?></td>
           <td><?=$notified_clamper; ?> (<? if($notified_clamper > 0) echo getStaffName($notified_clamper); ?>)</td>
           <td><? if($sms_sent == 1) echo "SENT"; ?></td>

		  </tr>
		 <?
 
	}
	
	?>
  </tbody>
</table>
</fieldset>