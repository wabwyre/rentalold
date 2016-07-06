<table class="table table-striped">
	<thead>
		<tr>
			<th>ID#</th>
			<th>CustAcc#</th>
			<th>Subject</th>
			<th>status</th>
			<th>Reported Time</th>
			<th>Body</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$acc_ids = $masterfile->getCustomerAccountIdsFromMfid($_GET['mf_id']);
			if(is_array($acc_ids) && !empty($acc_ids)){
				foreach ($acc_ids as $acc_id) {
					$result = $masterfile->getSupportTicketsFromCustomerAccIds($acc_id);
		?>
		<tr><td colspan="6" style="background-color: #eee;"><b>Customer Account#: <span style="color: green"><?=$acc_id; ?></span></b></td></tr>
		<?php
				$num_rows = get_num_rows($result);
				if($num_rows >= 1){
					while ($rows = get_row_data($result)) {
		?>
		<tr>
			<td><?=$rows['support_ticket_id']; ?></td>
			<td><b><?=$rows['customer_account_id']; ?></b></td>
			<td><?=$rows['subject']; ?></td>
			<td><?=($rows['status'] == '1') ? "<span class=\"label label-primary\">Closed</span>" : "<span class=\"label label-info\">Open<span>"; ?></td>
			<td><?=date('Y-m-d H:i:s', strtotime($rows['reported_time'])); ?></td>
			<td><?=$rows['body']; ?></td>
		</tr>
		<?php
					}
				}else{
		?>
		<tr><td colspan="6"><i>There are no support tickets for Customer Account#: <?=$acc_id; ?></i></td></tr>
		<?php
					}
				}
			}
		?>
	</tbody>
</table>