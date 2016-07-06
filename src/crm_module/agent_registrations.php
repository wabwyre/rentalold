<table class="table table-striped table-bordered table-advance table-hover">
  <thead>
     <tr>
        <th><i class="icon-user"></i> Customer Id </th>
        <th>Policy#</th>
        <th><i class="icon-user"></i> Customer Name</th>
        <th class="hidden-phone"><i class="icon-question-sign"></i> Phone No</th>
        <th><i class="icon-time"></i>Start Date</th>
     </tr>
  </thead>
  <tbody>
  	<?php
  		$query = "SELECT af.*, c.* from afyapoa_file af 
  		left join customers c on af.customer_id = c.customer_id 
      where agent_customer_id = '".$customer_id."' order by afyapoa_id desc limit 10";
  		$result = run_query($query);
  		while ($rows = get_row_data($result)) {
  			$customer_name = $rows['surname'].' '.$rows['firstname'].' '.$rows['middlename'];
  			$phone = $rows['phone'];
        $date_started = date('Y-M-d', $rows['date_started']);
        $customer_id = $rows['customer_id'];
        $afyapoa_policy_no = $rows['afyapoa_id'];
  	?>
  	<tr>
      <td><?=$customer_id; ?></td>
      <td><?=$afyapoa_policy_no; ?></td>
  		<td><?=$customer_name; ?></td>
  		<td><?=$phone; ?></td>
      <td><?=$date_started; ?></td>
  	</tr>
  	<?php }	?>
  </tbody>
</table>