<table class="table table-striped table-bordered table-advance table-hover">
  <thead>
     <tr>
        <th><i class="icon-user"></i> Customer Name</th>
        <th class="hidden-phone"><i class="icon-question-sign"></i> Phone No</th>
     </tr>
  </thead>
  <tbody>
  	<?php
  		$query = "SELECT af.*, c.* FROM afypoa_file af
      LEFT JOIN customers c ON c.customer_id = af.sponsor_customer_id
      WHERE af.sponsor_customer_id = '".$customer."'";
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