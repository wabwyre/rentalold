<?php
set_layout("dt-layout.php", array(
	'pageSubTitle' => 'AFYAPOA Medical Service Providers (MSP)',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'MSP' ),
		array ( 'text'=>'All MSPs' )
	)
	
));

?>
<div class="widget">
	<div class="widget-title"><h4><i class="icon-reorder"></i> All MSPs</h4></div>
	<div class="widget-body form">
    <table id="table1" style="width: 100%" class="table table-bordered">
 		<thead>
			  <tr>
				  <th>MSP ID#</th>
				  <th>Cust ID#</th>
				  <th>Name</th>
				  <th>Phone</th>
				  <th>MSP TYPE</th>
				  <!-- <th>Edit</th> -->
	              <th>PROFILE</th>
			  </tr>
 		</thead>
 	<tbody>
 <?php
 
   $distinctQuery = "SELECT ar.*, c.* "
           . "FROM afyapoa_msps ar "
           . "LEFT JOIN customers c "
           . "ON c.customer_id = ar.customer_id "
           . "Order by afyapoa_msp_id DESC ";
           //var_dump($distinctQuery);exit;
   $resultId = run_query($distinctQuery);	
   $total_rows = get_num_rows($resultId);
	
   
	$con = 1;
	$total = 0;
	while($row = get_row_data($resultId))
	{
		$customer_id=$row['customer_id'];
        $afyapoa_id = $row['afyapoa_msp_id'];
		$surname=$row['surname'];
		$start_date=$row['start_date'];
		$active=$row['active'];
		$customer_type_id=$row['customer_type_id'];
                $msp_type_id = $row['msp_type_id'];

                if($msp_type_id == 1)
                        $type_name = "Pharmacy";
                elseif($msp_type_id == 2)
                        $type_name = "Clinic";
                elseif($msp_type_id == 3)
                        $type_name = "Dentist";
                else
                        $type_name = "None";
                
                
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
			<td><?=$type_name; ?> </td>		
                        
		<td><a id="edit_link" href="index.php?num=821&msp=<?=$afyapoa_id; ?>" class="btn btn-mini"><i class="icon-eye-open"></i> Profile</a></td>
		
       </tr>
		 <?php }?>
	</tbody>
</table>
<div class="clearfix"></div>
</div></div>

