<table class="table table-striped table-bordered table-advance table-hover">
	<thead>
		<tr>
			<th>ID#</th>
			<th>Subject</th>
			<th>status</th>
			<th>Reported Time</th>
			<th>Body</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$result = $masterfile->getStaffCustomerTickets($_GET['mf_id']);
			 $data = $masterfile->checkSupportTickets($_GET['mf_id']);
					if($data){
				while ($rows = get_row_data($result)) {

		?>
		<tr>
			<td><?=$rows['support_ticket_id']; ?></td>
			<td><?=$rows['subject']; ?></td>
			<td><?=($rows['status'] == '1') ? "<span class=\"label label-primary\">Closed</span>" : "<span class=\"label label-info\">Open<span>"; ?></td>
			<td><?=date('Y-m-d H:i:s', strtotime($rows['reported_time'])); ?></td>
			<td><?=$rows['body']; ?></td>
		</tr>
		<?php }}else{
		?>
		<tr>
			<td colspan="7"><i>There are no currently support tickets assigned to this staff.</i></td>
		</tr>
		<?php } ?>
	</tbody>
</table>