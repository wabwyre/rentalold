<?php
$options="SELECT count(markets_session_id)  as total_sessions FROM markets_session FULL JOIN transactions ON  markets_session.transaction_id=transactions.transaction_id";
$option=run_query($options);
$optio=get_row_data($option);
$opti=$optio['total_sessions'];

?>
<script type="text/javascript">
		$(document).ready(
			function() {
				$("#table1").ingrid({ 
					url: 'remote_market_tickets.php',
					height: 400,
					totalRecords: <?=$opti;?>,
					pageNumber: 1,
					recordsPerPage: 0,
					colWidths: [100,100,100,100,100,100,100]
				});
			}
		); 
	</script>  
 <fieldset><legend class="table_fields">ISSUED MARKET TICKETS</legend> 
   <table id="table1">
 <thead>
  <tr>
   <th>CUSTOMER ID</th>
   <th>MARKET TYPE ID</th>
   <th>MARKET ID</th>
   <th>MARKET DATE</th>
   <th>STATUS</th>
   <th>CASH PAID</th>
   <th>RECEIPT NUMBER</th>
 
  </tr>
 </thead>
 <tbody>
 
 <?
   $distinctQuery = "SELECT  markets_session.customer_marketid,markets_session.market_type_id,markets_session.market_id,markets_session.market_date,markets_session.status,transactions.cash_paid,transactions.receiptnumber FROM markets_session FULL JOIN transactions ON markets_session.transaction_id=transactions.transaction_id Order by markets_session.markets_session_id DESC Limit 20";
   $resultId = run_query($distinctQuery);	
   $total_rows = get_num_rows($resultId);
	
   
	$con = 1;
	$total = 0;
	while($row = get_row_data($resultId))
	{
		$customer_id=$row['customer_marketid'];
		$market_type_id=$row['market_type_id'];
		$market_id=$row['market_id'];
		$market_date=$row['market_date'];
		$status=$row['status'];
		$cash_paid=$row['cash_paid'];
		$receiptnumber=$row['receiptnumber'];
 ?>
		  <tr>
		<td><?=$customer_id; ?></td>
        <td><?=$market_type_id; ?></td>
        <td><?=$market_id; ?></td>
        <td><?=$market_date; ?></td>
        <td><?=$status; ?></td>
        <td><?=$cash_paid; ?></td>
        <td><?=$receiptnumber; ?></td>
       </tr>
		 <?
 
	}
	   
	?>
   
  </tbody>
</table>
</fieldset>