 <?
   $distinctQuery2 = "select count(bill_id) as total_parking_bills from ".DATABASE.".customer_bills where service_account_type='1'";
   $resultId2 = run_query($distinctQuery2);	
   $arraa = get_row_data($resultId2);
   $total_rows2 = $arraa['total_parking_bills'];
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
					colWidths: [70,55,120,145,100,100,120,100]
				});
			}
		); 
	</script>  
 <fieldset><legend class="table_fields">PARKING-BILLS</legend> 
   <table id="table1">
 <thead>
  <tr>
   <th>CAR#</th>
   <th>B.ID#</th>
   <th>B.Date</th>
   <th>Bill Name</th>
   <th>Bill Amount</th>
   <th>STATUS</th>
   <th>Due.Date</th>
   <th>Customer</th>
   
  </tr>
 </thead>
 <tbody>
 
 <?
   $distinctQuery = "select * from ".DATABASE.".customer_bills where service_account_type='1' Order by bill_id DESC Limit 20";
   $resultId = run_query($distinctQuery);	
   $total_rows = get_num_rows($resultId);
	
   
	$con = 1;
	$total = 0;
	while($row = get_row_data($resultId))
	{
		$trans_id = trim($row['bill_id']);
		$ref_id = trim($row['service_account']);
		$service_bill_id = trim($row['service_bill_id']);
		
		$bill_date = date("d-m-Y H:i:s",$row['bill_date']);
		$due_date = date("d-m-Y H:i:s",$row['bill_due_date']);
		$end_date = date("d-m-Y H:i:s",$row['time_out']);
		
		$parking_type = $row['parking_type_id'];
		$status = $row['bill_status'];
		$agent_id = $row['agent_id'];
		$bill_amount = $row['bill_amt'];
		$clamping_flag = $row['clamping_flag'];
		 ?>
		  <tr>
		   <td><?=$ref_id; ?></td>
		   <td><?=$trans_id; ?></td>
		   <td><?=$bill_date; ?></td>
           <td><?=getServiceBillName($service_bill_id); ?></td>
           <td>Ksh. <?=number_format($bill_amount,2); ?></td>
		   <td><? echo ($status==0)?"PENDING":"PAID"; ?></td>
           <td><?=$due_date; ?></td>
           <td><?=$customer_id; ?></td>

		  </tr>
		 <?
 
	}
	
	?>
  </tbody>
</table>
</fieldset>