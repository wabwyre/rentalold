<?php
set_layout("dt-layout.php", array(
	'pageSubTitle' => 'AFYAPOA Champions',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'CRM' ),
		array ( 'text'=>'Champions' )
	)
	
));

$query="SELECT count(afyapoa_champion_id)  as total_customers FROM afyapoa_champion";
$data=run_query($query);
$the_rows=get_row_data($data);
$customer_num=$the_rows['total_customers'];

?>
<div class="widget">
	<div class="widget-title"><h4><i class="icon-reorder"></i> All Champions</h4></div>
	<div class="widget-body form">
    <table id="table1" style="width: 100%" class="table table-bordered">
 		<thead>
			  <tr>
			  <th>Champ ID#</th>
			  <th>Cust ID#</th>
			  <th>Name</th>
			  <th>Phone</th>
				<th>Profile</th>
			  </tr>
 		</thead>
 	<tbody>
 <?php 
   $distinctQuery = "SELECT DISTINCT(ar.champ_customer_id), c.*, ag.afyapoa_agent_id
FROM afyapoa_agent ar 
LEFT JOIN customers c ON ar.champ_customer_id = c.customer_id 
LEFT JOIN afyapoa_agent ag ON ar.champ_customer_id = ag.customer_id 
WHERE ar.champ_customer_id <> 0 and ar.champ_customer_id is not null";
   $resultId = run_query($distinctQuery);	
   $total_rows = get_num_rows($resultId);
	
   
	$con = 1;
	$total = 0;
	while($row = get_row_data($resultId))
	{
		$customer_id=$row['customer_id'];
        $afyapoa_id = $row['afyapoa_agent_id'];
		$surname=$row['surname'];
		$start_date=$row['start_date'];
		$active=$row['active'];
		$customer_type_id=$row['customer_type_id'];

                if(isset($customer_type_id))
                    {
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
		
		// $timedate=date("d-m-Y",$row['time_date']);
 ?>
		  <tr>
			<td><?=$afyapoa_id; ?></td>
			<td><?=$customer_id; ?></td>
			<td><?=$names; ?></td>
			<td><?=$phone; ?> </td>
		<td><a id="edit_link" href="index.php?num=819&customer=<?=$customer_id; ?>" class="btn btn-mini"><i class="icon-eye-open"></i> Profile</a></td>
       </tr>
		 <?php
 
	}
	   
	?>
  
  </tbody>
</table>
<div class="clearfix"></div>
</div></div>


