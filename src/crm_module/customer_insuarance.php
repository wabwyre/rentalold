<table class="table table-striped">
	<thead>
		<tr>
			<th>ID#</th>
			<th>Policy</th>
			<th>start date</th>
			<th>status</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$result = $masterfile->getCustomerInsurancePolicy($_GET['mf_id']);
			$num_rows = get_num_rows($result);
			if($num_rows >= 1){
				while ($rows = get_row_data($result)) {
		?>
		 <tr>
			<td><?=$rows['insurance_id']; ?></td>
			<td><?=$rows['insurance_policy']; ?></td>
			<td><?=$rows['start_date']; ?></td>
			<td><?
					if ($rows['status'] == 't'){
						echo "Active";
					}else{
						echo "Inactive";
					} 
				?>
			</td>
		</tr>
		<?php }}else{
		?>
		<tr>
			<td colspan="7"><i>There are no insurance policy currently attached to this customer.</i></td>
		</tr>
		<?php } ?>
	</tbody>
</table>