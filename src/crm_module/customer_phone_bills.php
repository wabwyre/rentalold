<table class="table table-bordered table-hover live_table">
	<thead>
		<tr>
			<th>B.Date</th>
			<th>B.Amount</th>
			<th>B.Amount Paid</th>
			<th>B.Balance</th>
			<th>B.Due Date</th>
			<th>B.Status</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$bills = $masterfile->getCustomerBillsForPhone($acc_details['customer_code']);
			if(count($bills)){
				foreach($bills as $rows){
		?>
		<tr>
			<td><?php echo $rows['bill_date']; ?></td>
			<td><?php echo $rows['bill_amount']; ?></td>
			<td><?php echo $rows['bill_amount_paid']; ?></td>
			<td><?php echo $rows['bill_balance']; ?></td>
			<td><?php echo $rows['bill_due_date']; ?></td>
			<td><?php echo ($rows['bill_status'] == '1') ? 'Paid' : 'Pending'; ?></td>
		</tr>
		<?php }} ?>
	</tbody>
</table>