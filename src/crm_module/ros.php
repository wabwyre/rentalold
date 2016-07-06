<?php
set_layout("dt-layout.php", array(
	'pageSubTitle' => 'AFYAPOA Relationship Officers',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'CRM' ),
		array ( 'text'=>'Relationship Officers' )
	)
	
));
?>
<div class="widget">
	<div class="widget-title"><h4><i class="icon-reorder"></i> All ROs</h4></div>
	<div class="widget-body form">
    <table id="table1" style="width: 100%" class="table table-bordered">
 		<thead>
			  <tr>
			  <th>Ro ID#</th>
			  <th>Customer ID#</th>
			  <th>Name</th>
			  <th>Phone</th>
			  <th>Profile</th>
			  </tr>
 		</thead>
 	<tbody>
 <?php
   	$distinctQuery = "SELECT DISTINCT(ar.ro_customer_id), c.*, ag.afyapoa_agent_id
	FROM afyapoa_agent ar 
	LEFT JOIN customers c ON ar.ro_customer_id = c.customer_id 
	LEFT JOIN afyapoa_agent ag ON ar.ro_customer_id = ag.customer_id 
	WHERE ar.ro_customer_id <> 0 and ar.ro_customer_id is not null";
	
   	$resultId = run_query($distinctQuery);
	while($row = get_row_data($resultId))	{
		$customer_id=$row['customer_id'];
        $afyapoa_id = $row['afyapoa_agent_id'];
		$surname=$row['surname'];
		$start_date=$row['start_date'];
		$active=$row['active'];
		$customer_type_id=$row['customer_type_id'];

        if(isset($customer_type_id)){
        //$customer_type_id=getCustomerTypeId($customer_type_id);
        }
                    
        $surname=$row['surname'];
		$firstname=$row['firstname'];
        $middle_name=$row['middlename'];
                
        $names = $surname . " ".$firstname;
                
		$address_id=$row['address_id'];
		if(isset($address_id))
		{
		//$address_name=getAddressName($address_id);
		}
		
		$regdate_stam=$row['regdate_stamp'];
		$regdate_stamp=date("d-m-Y",$regdate_stam);
		$national_id_number=$row['national_id_number'];
		$phone=$row['phone'];
		$passport=$row['passport'];
		
		$timedate=date("d-m-Y", $row['time_date']);
 ?>
	  	<tr>
			<td><?=$afyapoa_id; ?></td>
			<td><?=$customer_id; ?></td>
			<td><?=$names; ?></td>
			<td><?=$phone; ?></td>
			<td><a href="index.php?num=818&customer=<?=$customer_id; ?>" class="btn btn-mini"><i class="icon-eye-open"></i> Profile</a></td>
       </tr>
		 <?php
 
	}
	   
	?>
  
  </tbody>
</table>
<div class="clearfix"></div>
</div></div>

