<table class="table table-striped table-bordered table-advance table-hover">
	<thead>
		<tr>
			<th>ID#</th>
			<th>Bill ID#</th>
			<th>Amount</th>
			<th>Airtime Serial No</th>
			<th>Status</th>
			<th>Claimed Date</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$acc_ids = $masterfile->getCustomerAccountIdsFromMfid($_GET['mf_id']);
			if(is_array($acc_ids) && !empty($acc_ids)){
				foreach ($acc_ids as $acc_id) {
					$result = $masterfile->getAirtimeTicketsFromCustomerAccIds($acc_id);
		?>
		<tr><td colspan="6"><b>Customer Account#: <span style="color: green"><?=$acc_id; ?></span></b></td></tr>
		<?php
				$num_rows = get_num_rows($result);
				if($num_rows >= 1){
					while ($rows = get_row_data($result)) {
		?>
		<tr>
			<td><?=$rows['airtime_claim_id']; ?></td>
			<td><b><?=$rows['bill_id']; ?></b></td>
			<td><?=$rows['airtime_amount']; ?></td>
			<td><?=$rows['airtime_serial_no']; ?></td>
			<td><?=($rows['claimed'] == '1') ? "<span class=\"label label-primary\">Closed</span>" : "<span class=\"label label-info\">Open<span>"; ?></td>
			<td><?=date('Y-m-d', strtotime($rows['airtime_claimed_date'])); ?></td>
		</tr>
		<?php
					}
				}else{
		?>
		<tr><td colspan="6"><i>There are no Airtime Claims for Customer Account#: <?=$acc_id; ?></i></td></tr>
		<?php
					}
				}
			}
		?>
	</tbody>
</table>