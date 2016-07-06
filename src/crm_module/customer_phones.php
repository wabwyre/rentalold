<table class="table table-striped table-bordered table-advance table-hover">
	<thead>
		<tr>
			<th>Account#</th>
			<th>Model</th>
			<th>IMEI</th>
			<th>Service a/c code</th>
			<th>Issued Phone#</th>
			<th>First Auth. Deactivated</th>
			<th>Total Loan Amt</th>
			<th>Loan Bal</th>
			<th>View Bill</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$result = $masterfile->getCustomerPhones($_GET['mf_id']);
			$num_rows = get_num_rows($result);
			if($num_rows >= 1){
				while ($rows = get_row_data($result)) {
					$loan_amt = $masterfile->getLoanAmount($rows['device_model_id']);
					$amount_paid = $masterfile->getAmountPaidSoFarForPhone($rows['customer_code']);
		?>
		<tr>
			<td><?=$rows['customer_account_id']; ?></td>
			<td><?=$rows['model']; ?></td>
			<td><?=$rows['imei']; ?></td>
			<td><?=$rows['customer_code']; ?></td>
			<td><?=$rows['issued_phone_number']; ?></td>
			<td><?=($rows['first_auth_deactivated'] == 'f') ? 'Yes' : 'No'; ?></td>
			<td><?php echo 'Ksh. '.number_format($loan_amt, 2); ?></td>
			<td><?php echo 'Ksh. '.number_format($masterfile->calculateLoanBalance($loan_amt, $amount_paid), 2); ?></td>
	        <td><a id="edit_link" href="index.php?num=832&acc_id=<?=$rows['customer_account_id']; ?>" class="btn btn-mini"> <i class="icon-eye-open"></i> View Bill</a> </td>
		</tr>
		<?php }}else{
		?>
		<tr>
			<td colspan="7"><i>There are no phones currently attached to this customer currently.</i></td>
		</tr>
		<?php } ?>
	</tbody>
</table>