<?
set_layout("dt-layout.php", array(
	'pageSubTitle' => 'Incoming Querybill Transactions',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'Inbox' ),
		array ( 'text'=>'Query Bill (Queries)' )
	)
));
 
   $distinctQuery2 = "select * from ".DATABASE.".log_req WHERE transaction_code = 'QUERYBILL'";
   $resultId2 = run_query($distinctQuery2);	
   $total_rows2 = get_num_rows($resultId2);
 ?>
  
 <table id="table1" class="table table-bordered">
 <thead>
  <tr>
   <th style="width:50px;">R.ID#</th>
   <th>EB.ID#</th>
   <th>DateTime</th>
   <th>TransType</th>
   <th>OptionCode</th>
   <th>UserAccount</th>
   <th>Amount</th>
   <th>Agent</th>
   <th>CCNTrans#</th>
   <th>CCNReceipt</th>
  </tr>
 </thead>
 <tbody>
 
 <?
   $distinctQuery = "select * from ".DATABASE.".log_req WHERE transaction_code = 'QUERYBILL' Order by header_id DESC Limit 20";
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
		$trx_date = date("d-m-Y H:i:s",$row['timestamp']); 
		
		$amount = $row['amount'];
		
		$agent = $row['agent_id'];
		$ccn_trans_id = $row['ccn_trans_id'];
		$ccn_receipt = $row['ccn_receipt'];
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
           <td><?=$ccn_trans_id; ?></td>
           <td><?=$ccn_receipt; ?></td>
		  </tr>
		 <?
 
	}
	
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
           <td></td>
           <td></td>
		  </tr>
  </tbody>
</table>
