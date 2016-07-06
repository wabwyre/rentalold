<?
	include "connection/config.php";
	include "library.php";
	
	$page = $_GET['page'];	
	if($page == 1)
	    $offset = 0;
	else
		$offset = $page * 20;		
?>

 <table id="table1">
 <tbody>
 
 <?
   $distinctQuery = "select * from ".DATABASE.".customer_bills where service_account_type='3' Order by bill_id ASC Limit 20 OFFSET $offset";
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
