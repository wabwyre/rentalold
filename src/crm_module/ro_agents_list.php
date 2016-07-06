<table class="table table-striped table-bordered table-advance table-hover">
  <thead>
     <tr>
        <th><i class="icon-user"></i> Agent Name</th>
        <th class="hidden-phone"><i class="icon-question-sign"></i> Phone No</th>
     </tr>
  </thead>
  <tbody>
  	<?php
  		$query = "select distinct(aa.ro_customer_id), aa.afyapoa_agent_id, c.* from afyapoa_agent aa left join customers c on c.customer_id = aa.customer_id where aa.ro_customer_id = '8452' order by afyapoa_agent_id desc limit 10";
      // var_dump($query);exit;
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