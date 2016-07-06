<table class="table table-bordered table-hover live_table">
	<thead>
		<tr>
			<th>Repayment#</th>
			<th>Repayment Date</th>
			<th>Bill#</th>
			<th>Claim Airtime</th>
			<th>Transaction#</th>
			<th>Late</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$bills = $masterfile->getPhoneLoanRepayment($acc_details['customer_code']);
			if(count($bills)){
				foreach($bills as $rows){
		?>
		<tr>
			<td><?php echo $rows['repay_id']; ?></td>
			<td><?php echo $rows['repayment_date']; ?></td>
			<td><?php echo $rows['bill_id']; ?></td>
			<td><?php echo ($rows['claim_airtime'] == 'f') ? 'Pending' : 'Claimed'; ?></td>
			<td><?php echo $rows['transaction_id']; ?></td>
			<td><?php echo ($rows['late'] == 'f') ? 'Yes' : 'No'; ?></td>
		</tr>
		<?php }} ?>
	</tbody>
</table>