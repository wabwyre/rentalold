<table id="table1" style="width: 100%" class="table table-bordered">
	<thead>
	  <tr>
		  <th>Request Id</th>
		  <th>Customer Name</th>
		  <th>Amount</th>
		  <th>Status</th>
		  <th>Date Time</th>
		  <th>Request Type</th>
	  </tr>
	</thead>
	<tbody>	
	<?php
	   	$distinctQuery = "SELECT v.*, a.*, af.customer_id, af.afyapoa_id, c.surname, c.firstname, c.middlename FROM afyapoa_kashpoa_requests a
	   	LEFT JOIN ndovu_requests_view v ON v.request_id = a.request_id
	   	LEFT JOIN afyapoa_file af ON af.afyapoa_id = a.afyapoa_id
	   	LEFT JOIN customers c ON c.customer_id = af.customer_id
	   	WHERE a.afyapoa_id = '".$policy_no."'";
	   	//var_dump($distinctQuery);exit;

	   	$resultId = run_query($distinctQuery);
		while($row = get_row_data($resultId)){
			$request_id=$row['request_id'];
	        $date_time = date('Y-M-d H:i:s', $row['request_timestamp']);
			$amount=$row['amount'];
			// $target_account = $row['target_account'];
			$name = $row['name'];
			$status = $row['status'];
            $type_name = $row['request'];
	?>
		<tr>
			<td><?=$request_id; ?></td>
			<td><?=$name; ?></td>
			<td><?=$amount; ?></td>
			<td><?=$status; ?></td>
			<td><?=$date_time; ?></td>
			<td><?=$type_name; ?></td>
		</tr>
	<?php } ?>
  </tbody>
</table>