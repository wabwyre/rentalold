<table id="table1" class="table table-bordered">
 <thead>
  <tr>
   <th>Trans#</th>
   <th>Payment Mode</th>
   <th>Cash Paid</th>
   <th>Customer Acc#</th>
   <th>Transaction Date</th>
   <th>Details</th>
  </tr>
 </thead>
 <tbody>

<?php
 	$rows = $masterfile->getPhonePayments($acc_details['customer_code']);
	if(count($rows)){	
		foreach($rows as $row){
			$trans_id = trim($row['transaction_id']);
			$paymentmode = trim($row['payment_mode']);
    		$cashpaid= $row['cash_paid'];
			$receiptnumber = $row['service_account'];
    		$tdate = $row['transaction_date'];
			$details = $row['details'];
		
?>
	<tr>
		<td><?=$trans_id; ?></td>
		<td><?=$paymentmode; ?></td>
		<td><?=$cashpaid; ?></td>
	    <td><?=$receiptnumber; ?></td>
	    <td><?=$tdate; ?></td> 
		<td><?=$details; ?></td>    
	</tr>
<?php }} ?>
  </tbody>
</table>