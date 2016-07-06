<table class="table table-striped table-bordered table-advance table-hover">
  <thead>
     <tr>
        <th><i class="icon-user"></i> Agent Name</th>
        <th class="hidden-phone"><i class="icon-question-sign"></i> Phone No</th>
     </tr>
  </thead>
  <tbody>
  	<?php
  		$query = "select distinct(aa.champ_customer_id), c.* from afyapoa_agent aa 
  		left join customers c on c.customer_id = aa.customer_id
  		where aa.champ_customer_id = '".$customer_id."' order by afyapoa_agent_id desc limit 10";
  		$result = run_query($query);
  		while ($rows = get_row_data($result)) {
  			$agent_name = $rows['surname'].' '.$rows['firstname'].' '.$rows['middlename'];
  			$phone = $rows['phone'];
  	?>
  	<tr>
  		<td><?=$agent_name; ?></td>
  		<td><?=$phone; ?></td>
  	</tr>
  	<?php }	?>
  </tbody>
</table>