<?php
	//fetch savings details
	$query = "SELECT * FROM loan_details WHERE customer_id = '".$customer_id."'";
	// var_dump($query);exit;
	$result = run_query($query);
	$rows = get_row_data($result);
	$loan_id = $rows['loan_id'];
	$loan_repayment_mode = $rows['loan_repayment_mode'];
	$loan_total_amount = $rows['loan_total_amount'];
	$loan_repayment_startdate = $rows['loan_repayment_startdate'];
?>
<ul class="unstyled span12">
   <li><span>Loan ID:</span> <b><?=$loan_id; ?></b></li>
   <li><span>Repayments Start Date:</span> <b><?=$loan_repayment_startdate; ?></b></li>
   <li><span>Repayments Amount:</span> <b><?=$loan_total_amount; ?></b></li>
   <li><span>Repayments Mode:</span> <b><?
   		if($loan_repayment_mode == 1)
   			echo 'Daily';
   		elseif($loan_repayment_mode == 2)
   			echo 'Weekly';
   		else
   			echo 'Yearly';
   ?></b></li>
</ul>
<table id="table1" style="width: 100%" class="table table-bordered">
	<thead>
	  <tr>
		  <th>ID</th>
		  <th>Amount</th>
		  <th>Source Account</th>
		  <th>Target Account</th>
		  <th>Merchant</th>
		  <th>Kashpoa#</th>
		  <th>Repayment Date</th>
		  <th>Status</th>
	  </tr>
	</thead>
	<tbody>	
	<?php
	   	$distinctQuery = "SELECT lr.*, c.surname,c.firstname,c.middlename FROM loan_repayments lr
	   	LEFT JOIN customers c ON c.customer_id = lr.customer_id
	   	WHERE lr.customer_id = '".$customer_id."'";
	   	 //var_dump($distinctQuery);exit;

	   	$resultId = run_query($distinctQuery);
		while($row = get_row_data($resultId)){
			$repayment_id=$row['repayment_id'];
	        $source_account = $row['source_account'];
			$amount=$row['amount'];
			$target_account = $row['target_account'];
			$merchant = $row['surname'].' '.$row['firstname'].' '.$row['middlename'];
			//var_dump($merchant);exit;
			$kashpoa_id = $row['kashpoa_request_id'];
			$repayment_date = $row['repayment_date'];
			$status = $row['status'];
			if($status == '0'){
			  $status = 'Failed';
				}else{
					$status = 'Success';
				}
	?>
		<tr>
			<td><?=$repayment_id; ?></td>
			<td><?=$amount; ?></td>
			<td><?=$source_account; ?></td>
			<td><?=$target_account; ?></td>
			<td><?=$merchant; ?></td>
			<td><?=$kashpoa_id ; ?></td>
			<td><?=$repayment_date; ?></td>
			<td><?=$status; ?></td>
		</tr>
	<?php } ?>
  </tbody>
</table>