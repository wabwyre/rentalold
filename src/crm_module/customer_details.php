<?php
	$row = $masterfile->getAccountDetails($acc_id);
?>
		<ul class="unstyled span10">
		   <li><span>Customer Name: </span><?=$row['customer_name']; ?></li>
		   <li><span>Issued Phone No. </span><?=$row['issued_phone_number']; ?></li>
		   <li><span>Current Phone No. </span><?=$row['current_phone_number']; ?></li>
		   <li><span>Phone Model. </span><?=$row['model']; ?></li>
		   <li><span>Status </span><?=($row['status'] == 't') ? 'Active' : 'Inactive' ; ?></li>
		</ul>

