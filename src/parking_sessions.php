 <?
   $distinctQuery2 = "select count(parking_id) as total_parks from ".DATABASE.".parking_session";
   $resultId2 = run_query($distinctQuery2);	
   $arraa = get_row_data($resultId2);
   $total_rows2 = $arraa['total_parks'];
 ?>
 
 <script type="text/javascript">
		$(document).ready(
			function() {
				$("#table1").ingrid({ 
					url: 'remote_parking_session.php',
					height: 400,
					totalRecords: <?=$total_rows2;?>,
					pageNumber: 1,
					recordsPerPage: 0,
					colWidths: [70,70,80,80,120,120,80,70,120,70,80,100]
				});
			}
		); 
	</script>  
 <fieldset><legend class="table_fields">PARKING-SESSIONS</legend> 
   <table id="table1">
 <thead>
  <tr>
   <th>CAR#</th>
   <th>ParkID#</th>
   <th>P.Date</th>
   <th>P.Type</th>
   <th>TimeIn</th>
   <th>TimeOut</th>
   <th>CCNTrans#</th>
   <th>Status</th>
   <th>Option</th>
   <th>Amount</th>
   <th>Phone</th>
   <th>Receipt</th>
  </tr>
 </thead>
 <tbody>
 
 <?
   $distinctQuery = "select * from ".DATABASE.".parking_session Order by parking_id DESC Limit 20";
   $resultId = run_query($distinctQuery);	
   $total_rows = get_num_rows($resultId);
	
   
	$con = 1;
	$total = 0;
	while($row = get_row_data($resultId))
	{
		$trans_id = trim($row['parking_id']);
		$ref_id = trim($row['plate_number']);
		$head_id = trim($row['transaction_id']);
		
		$buy_date = date("d-m-Y",$row['parking_date']);
		$start_date = date("d-m-Y H:i:s",$row['time_in']);
		$end_date = date("d-m-Y H:i:s",$row['time_out']);
		
		$parking_type = $row['parking_type_id'];
		$status = $row['status'];
		$option = $row['option'];
		$amt = $row['amt'];
		$phone = $row['phone'];
		$receipt = $row['receipt'];
		 ?>
		  <tr>
		   <td><?=$ref_id; ?></td>
		   <td><?=$trans_id; ?></td>
		   <td><?=$buy_date; ?></td>
		   <td><?=getParkingTypeNameByTypeId($parking_type); ?></td>
           <td><?=$start_date; ?></td>
           <td><?=$end_date; ?></td>
           <td><?=$head_id; ?></td>
           <td><? echo ($status==1)? "ACTIVE": "EXPIRED"; ?></td>
           <td><?=$option; ?></td>
           <td><?=$amt; ?></td>
           <td><?=$phone; ?></td>
           <td><?=$receipt; ?></td>
		  </tr>
		 <?
 
	}
	
	?>
  </tbody>
</table>
</fieldset>