<?php
set_layout("dt-layout.php", array(
	'pageSubTitle' => 'AFYAPOA AGENTS',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'CRM' ),
		array ( 'text'=>'All Agents' )
	)
	
));
?>
<div class="widget">
	<div class="widget-title"><h4><i class="icon-reorder"></i> All Agents</h4></div>
	<div class="widget-body form">
    <table id="table1" style="width: 100%" class="table table-bordered">
 		<thead>
			  <tr>
				<th>Agent ID#</th>
				<th>Customer ID#</th>
				<th>Names</th>
				<th>Phone</th>
				<th>Edit</th>
				<th>Profile</th>
			  </tr>
 		</thead>
 	<tbody>
 <?php
   	$distinctQuery = "SELECT DISTINCT(ag.customer_id), ag.*, c.* "
           . "FROM afyapoa_agent ag "
           . "LEFT JOIN customers c "
           . "ON ag.customer_id = c.customer_id "
           . "Order by afyapoa_agent_id DESC ";

   	$resultId = run_query($distinctQuery);
	while($row = get_row_data($resultId)){
		$customer_id=$row['customer_id'];
        $afyapoa_id = $row['afyapoa_agent_id'];
		$surname=$row['surname'];
		$start_date=$row['start_date'];
		$active=$row['active'];
		$customer_type_id=$row['customer_type_id'];
                    
        $surname=$row['surname'];
		$firstname=$row['firstname'];
        $middle_name=$row['middlename'];
        
        $names = $surname . " ".$firstname;
                
		$address_id=$row['address_id'];
		
		$regdate_stam=$row['regdate_stamp'];
		$regdate_stamp=date("d-m-Y",$regdate_stam);
		$national_id_number=$row['national_id_number'];
		$phone=$row['phone'];
		$passport=$row['passport'];
		// $premium =$row['total_premium'];
		// $paid_premium =$row['paid_premium'];
  //       $loan_amount = $row['loan_amount'];
		
		// $timedate=date("d-m-Y", $row['time_date']);
 ?>
		<tr>
			<td><?=$afyapoa_id; ?></td>
			<td><?=$customer_id; ?></td>
			<td><?=$names; ?></td>
			<td><?=$phone; ?> </td>	
			<td><a id="edit_link" href="index.php?num=822&customer=<?=$customer_id; ?>" class="btn btn-mini"><i class="icon-edit"></i> Edit</a></td>
			<td><a id="edit_link" href="index.php?num=817&customer=<?=$customer_id; ?>" class="btn btn-mini"><i class="icon-eye-open"></i> Profile</a></td>
       	</tr>
	 	<?php } ?>
  </tbody>
</table>
<div class="clearfix"></div>
</div></div>

