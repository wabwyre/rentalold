 <?
   $distinctQuery2 = "select count(market_compliance_id) as total_parks from ".DATABASE.".market_compliance";
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
					colWidths: [70,55,120,95,120,120,120]
				});
			}
		); 
	</script>  
 <fieldset><legend class="table_fields">MARKET-QUERIES</legend> 
   <table id="table1">
 <thead>
  <tr>
   <th>ID/PP#</th>
   <th>Q.ID#</th>
   <th>Q.Date</th>
   <th>Q.Result</th>
   <th>MarketInspector</th>
   <th>Agent</th>
   <th>Market</th>
  </tr>
 </thead>
 <tbody>
 
 <?
   $distinctQuery = "select * from ".DATABASE.".market_compliance Order by market_compliance_id DESC Limit 20";
   $resultId = run_query($distinctQuery);	
   $total_rows = get_num_rows($resultId);
	
   
	$con = 1;
	$total = 0;
	while($row = get_row_data($resultId))
	{
		$trans_id = trim($row['market_compliance_id']);
		$ref_id = trim($row['market_number']);
		$head_id = trim($row['transaction_id']);
		
		$buy_date = date("d-m-Y",$row['query_timestamp']);
		$query_date = date("d-m-Y H:i:s",$row['query_timestamp']);
		$end_date = date("d-m-Y H:i:s",$row['time_out']);
		
		$parking_type = $row['market_type_id'];
		$status = $row['status'];
		$agent_id = $row['agent_id'];
		$market_id = $row['market_id'];
		$inspector_id = $row['market_attendant_id'];
		 ?>
		  <tr>
		   <td><?=$ref_id; ?></td>
		   <td><?=$trans_id; ?></td>
		   <td><?=$query_date; ?></td>
		   <td><? echo ($status==1)?"COMPLIANT":"NON-COMPLIANT"; ?></td>
           <td><? echo getStaffName($inspector_id); ?></td>
           <td></td>
           <td><?=getMarketName($market_id); ?></td>

		  </tr>
		 <?
 
	}
	
	?>
  </tbody>
</table>
</fieldset>