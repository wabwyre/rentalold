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
   $distinctQuery = "select * from ".DATABASE.".business Order by business_name ASC Limit 20 OFFSET $offset";
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
           
		  </tr>
		 <?
 
	}
	
	?>
  </tbody>
</table>
