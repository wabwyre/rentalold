<table class="table table-striped table-bordered table-advance table-hover">
  <thead>
     <tr>
      <th><i class="icon-user"></i> Customer Id </th>
        <th>Policy#</th>
        <th><i class="icon-user"></i> Customer Name</th>
        <th class="hidden-phone"><i class="icon-question-sign"></i> Phone No</th>
        <th class="hidden-phone"><i class="icon-question-sign"></i> Amount</th>
        <th><i class="icon-time"></i>Start Date</th>
     </tr>
  </thead>
  <tbody>
  	<?php
  		$query = "SELECT ac.*, c.surname, c.firstname, c.middlename, c.phone from afyapoa_commissions ac
  		left join customers c on c.customer_id = ac.customer_id
  		where ac.customer_id = '".$customer_id."' order by commission_id desc LIMIT 10";
  		$result = run_query($query);
  		while ($rows = get_row_data($result)) {
  			$customer_name = $rows['surname'].' '.$rows['firstname'].' '.$rows['middlename'];
  			$phone = $rows['phone'];
  			$amount = $rows['amount'];
        $date_started = $rows['date_issued'];
        $customer_id = $rows['customer_id'];
        $policy_no = $rows['policy_number'];
  	?>
  	<tr>
      <td><?=$customer_id; ?></td>
      <td><?=$policy_no; ?></td>
  		<td><?=$customer_name; ?></td>
  		<td><?=$phone; ?></td>
  		<td><?=$amount; ?></td>
      <td><?=$date_started; ?></td>
  	</tr>
  	<?php }	?>
  </tbody>
</table>