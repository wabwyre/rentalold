<table class="table table-striped table-bordered table-advance table-hover">
	<thead>
		<tr>
			<th>ID#</th>
			<th>Bill ID#</th>
			<th>Payment Date</th>
			<th>Claim Airtime</th>
			<th>Account Code</th>
			<th>Late?</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$acc_codes = $masterfile->getCustomerAccountCodesFromMfid($_GET['mf_id']);
			if(is_array($acc_codes) && !empty($acc_codes)){
				foreach ($acc_codes as $code) {
					$result = $masterfile->getLoanRepaymentsFromCustomerAccCode($code);
		?>
		<tr><td colspan="6" style="background-color: #eee;"><b>Customer Account Code: <span style="color: green"><?=$code; ?></span></b></td></tr>
		<?php
				$num_rows = get_num_rows($result);
				if($num_rows >= 1){
					while ($rows = get_row_data($result)) {
		?>
		<tr>
			<td><?=$rows['repay_id']; ?></td>
			<td><?=$rows['bill_id']; ?></td>
			<td><?=$rows['repayment_date']; ?></td>
			<td><?=($rows['claim_airtime'] == 't') ? "<span class=\"label label-success\">Claimed</span>" : "<span class=\"label label-primary\">Pending<span>"; ?></td>
			<td><?=$rows['account_code']; ?></td>
			<td><?=($rows['claim_airtime'] == 't') ? "<span class=\"label label-success\">Yes</span>" : "<span class=\"label label-primary\">No<span>"; ?></td>
		</tr>
		<?php
					}
				}else{
		?>
		<tr><td colspan="6"><i>There are no loan repayments for Customer Code: <?=$code; ?></i></td></tr>
		<?php
					}
				}
			}
		?>
	</tbody>
</table>