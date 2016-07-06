<?php
	//fetch savings details
	$query = "SELECT * FROM savings_details WHERE savings_customer_id = '".$customer_id."'";
	//var_dump($query);exit;
	$result = run_query($query);
	$rows = get_row_data($result);
	$start_date = $rows['savings_startdate'];
	$savings_amount = $rows['savings_total_amount'];
	$savings_mode = $rows['savings_mode'];
	$savings_account_no = $rows['savings_account_no'];
?>

<ul class="unstyled span12">
   <li><span>Start Date:</span> <b><?=$start_date; ?></b></li>
   <li><span>Savings Amount:</span><b> <?=$savings_amount; ?></b></li>
   <li><span>Savings Mode:</span><b> <?
   		if($savings_mode == 1)
   			echo 'Daily';
   		elseif($savings_mode == 2)
   			echo 'Weekly';
   		else
   			echo 'Yearly';
   ?></b></li>
   <li><span>Savings Account:</span><b> <?=$savings_account_no; ?></b></li>
</ul>
<table id="table1" style="width: 100%" class="table table-bordered">
	<thead>
	  <tr>
		  <th>Savings ID</th>
		  <th>Savings Date</th>
		  <th>Amount</th>
		  <th>Kashpoa#</th>
		  <th>Status</th>
		  <th>Source Account</th>
		  <th>Target Account</th>
	  </tr>
	</thead>
	<tbody>	
 <?php
   	$distinctQuery = "SELECT * FROM user_savings WHERE customer_id = '".$customer_id."'";
   	// var_dump($distinctQuery);exit;
   	$resultId = run_query($distinctQuery);
	while($row = get_row_data($resultId)){
		$savings_id=$row['savings_id'];
        $savings_date = $row['savings_date'];
		$amount=$row['amount'];
		$Kashpoa_id=$row['kashpoa_request_id'];
        $status = $row['status'];
        if($status == '0'){
			$status = 'Failed';
		}else{
			$status = 'Success';
		}
		$source_account=$row['source_account'];
		$target_account=$row['target_account'];
 ?>
		<tr>
			<td><?=$savings_id; ?></td>
			<td><?=$savings_date; ?></td>
			<td><?=$amount; ?></td>
			<td><?=$Kashpoa_id; ?></td>
			<td><?=$status; ?></td>
			<td><?=$source_account; ?></td>
			<td><?=$target_account; ?></td>
		</tr>
	<?php } ?>
  </tbody>
</table>