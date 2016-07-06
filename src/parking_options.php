 <?
   $distinctQuery2 = "select count(parking_option_id) as total_parks from ".DATABASE.".parking_options";
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
					colWidths: [90,80,80,80,180,120]
				});
			}
		); 
	</script>  

<fieldset><legend class="table_fields">PARKING-OPTIONS</legend> 
<table id="table1">
 <thead>
  <tr>
   <th>Keyword#</th>
   <th>P.Option#</th>
   <th>Veh.Type</th>
   <th>Park.Type</th>
   <th>Option Name</th>
   <th>Amount</th>
  </tr>
 </thead>
 <tbody>
 
 <?
   $distinctQuery = "select * from ".DATABASE.".parking_options Order by parking_option_id DESC Limit 20";
   $resultId = run_query($distinctQuery);	
   $total_rows = get_num_rows($resultId);
	
   
	$con = 1;
	$total = 0;
	while($row = get_row_data($resultId))
	{
		$trans_id = trim($row['parking_option_id']);
		$ref_id = trim($row['parking_option_code']);
		$head_id = trim($row['transaction_id']);
		
				
		$parking_type = $row['parking_type_id'];
		$amt = $row['amount'];
		$vehicle_type = $row['vehicle_type_id'];
		$name = $row['parking_option_name'];

		 ?>
		  <tr>
		   <td><?=$ref_id; ?></td>
		   <td><?=$trans_id; ?></td>
		   <td><?=getVehicleTypeName($vehicle_type); ?></td>
		   <td><?=getParkingTypeNameByTypeId($parking_type); ?></td>
           <td><?=$name; ?></td>
           <td align="right"><div align="right">Ksh. <?=number_format($amt,2); ?></div></td>
          </tr>
		 <?
 
	}
	
	?>
  </tbody>
</table>
</fieldset>