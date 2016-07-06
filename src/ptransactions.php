<?
 set_layout("dt-layout.php", array(
	'pageSubTitle' => 'All Transactions',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'Inbox' ),
		array ( 'text'=>'All Transactions' )
	)
));
   $distinctQuery2 = "select * from ".DATABASE.".transactions";
   $resultId2 = run_query($distinctQuery2);	
   $total_rows2 = get_num_rows($resultId2);
 ?> 
 <table id="table1" class="table table-bordered">
 <thead>
  <tr>
   <th style="width:50px;">T.ID#</th>
   <th>Receipt#</th>
   <th>Transaction Date</th>
   <th>Service</th>
   <th>Service Type</th>
   <th>Customer</th>
   <th>Amount</th>
   <th>Agent</th>
   <th>Details</th>
  </tr>
 </thead>
 <tbody>
 
 <?
   $distinctQuery = "	SELECT t.*, s.service_name, st.service_type_name, a.agent_name
   						FROM ".DATABASE.".transactions t
   						LEFT JOIN services s 
   						ON t.service_id = s.service_id
   						LEFT JOIN service_types st
   						ON t.service_type_id = st.service_type_id 
   						LEFT JOIN agents a
   						ON t.agent_id = a.agent_id
   						ORDER BY transaction_id DESC Limit 200";
   $resultId = run_query($distinctQuery);	
   $total_rows = get_num_rows($resultId);

	$con = 1;
	$total = 0;
	while($row = get_row_data($resultId))
	{
		$trans_id = trim($row['transaction_id']);
		$receipt = trim($row['receiptnumber']);
		$cashpaid = trim($row['cash_paid']);
		$completed = $row['completed'];
		$details = $row['details'];
		$agentid = $row['agent_id'];
		$agentname = $row['agent_name'];
		$serviceid = $row['service_id'];
		$service_name = $row['service_name'];
		$agenttransid = $row['agent_trans_id'];
		$servicetypeid = $row['service_type_id'];
		$servicetypename = $row['service_type_name'];
		$test = $row['test'];
		$customerid = $row['customer_id'];
		$trx_date = date("d-m-Y H:i:s",$row['transaction_date']);
		//$datetime = date("d-m-Y H:i:s",$row['date_time']); 
		 ?>
		  <tr>
		   <td><?=$trans_id; ?></td>
		   <td><?=$receipt; ?></td>
		   <td><?=$trx_date; ?></td>
		   <td><?=$service_name; ?></td>
           <td><?=$servicetypename; ?></td>
           <td><?=$customerid; ?></td>
           <td><?=$cashpaid; ?></td>
           <td><?=$agentname; ?></td>
           <td><?=$details; ?></td>
		  </tr>
		 <?
 
	}
	
	?>
  </tbody>
</table>