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
   $distinctQuery = "select * from ".DATABASE.".markets_session Order by markets_session_id DESC Limit 20 OFFSET $offset";
   $resultId = run_query($distinctQuery);	
   $total_rows = get_num_rows($resultId);
	
   
	$con = 1;
	$total = 0;
	while($row = get_row_data($resultId))
	{
		$trans_id = trim($row['markets_session_id']);
		$ref_id = trim($row['customer_marketid']);
		$head = trim($row['transaction_id']);
		
		$buy_date = date("d-m-Y",$row['market_date']);
		$start_date = date("d-m-Y H:i:s",$row['time_in']);
		$end_date = date("d-m-Y H:i:s",$row['time_out']);
		
		$market_type = $row['market_type_id'];
		$status = $row['status'];
		$option = $row['option'];
		$amt = $row['amt'];
		$phone = $row['phone'];
		$trans = $row['transaction_id'];
		 ?>
		  <tr>
		     <td><?=$ref_id; ?></td>
		   <td><?=$trans_id; ?></td>
		   <td><?=$buy_date; ?></td>
		   <td><?=getMarketTypeNameByTypeId($market_type); ?></td>
           <td><?=$start_date; ?></td>
           <td><?=$end_date; ?></td>
           <td><?=$head; ?></td>
           <td><? echo ($status==1)? "ACTIVE": "EXPIRED"; ?></td>
           <td><?=$option; ?></td>
           <td><?=$amt; ?></td>
           <td><?=$phone; ?></td>
           <td><?  echo getReceipt($trans); ?></td>
		  </tr>
		 <?
 
	}
	
	?>
  </tbody>
</table>
