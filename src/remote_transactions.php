<? 
	include "connection/config.php";
	include "library.php";
	
	$page = $_GET['page'];
	
	if($page == 1)
	    $offset = 0;
	else
		$offset = $page * 20;


?> 
 <table>
 <tbody>
 
 <?
   $distinctQuery = "select * from ".DATABASE.".log_req Order by header_id DESC Limit 20 OFFSET $offset";
   $resultId = run_query($distinctQuery);	
   $total_rows = get_num_rows($resultId);
	
   
	$con = 1;
	$total = 0;
	while($row = get_row_data($resultId))
	{
		$trans_id = trim($row['transaction_id']);
		$ref_id = trim($row['reference_id']);
		$head_id = trim($row['header_id']);
		
		$trans_type = $row['transaction_code'];
		
		$service_code = $row['service_code'];
		$user_account = $row['user_account'];
		$trx_date = $row['date_logged']; 
		
		$amount = $row['amount'];
		
		$agent = $row['agent_id'];
		 ?>
		  <tr>
		   <td><?=$ref_id; ?></td>
		   <td><?=$trans_id; ?></td>
		   <td><?=$trx_date; ?></td>
		   <td><?=$trans_type; ?></td>
           <td><?=$service_code; ?></td>
           <td><?=$user_account; ?></td>
           <td><?=$amount; ?></td>
           <td><?=$agent; ?></td>
		  </tr>
		 <?
 
	}
	
	?>
  </tbody>
</table>