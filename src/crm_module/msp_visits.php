<table id="table1" style="width: 100%" class="table table-bordered">
 		<thead>
			  <tr>
			  <th>Visit ID#</th>
			  <th>Cust ID#</th>
			  <th>MSP ID</th>
			  <th>Visit Date</th>
			  <th>Bill Amount</th>
			  <th>Mcare Ref</th>		  
			  </tr>
 		</thead>
 	<tbody>
 <?php
   $distinctQuery = "SELECT mv.*, c.* "
           . "FROM msp_visits mv "
           . "LEFT JOIN customers c "
           . "ON mv.customer_id = c.customer_id "
           . "LEFT JOIN afyapoa_msp a ON a.afyapoa_msp_id = mv.msp_id "
           . "WHERE mv.msp_id = '".$msp."' ";
           //var_dump($distinctQuery);exit;
        
   $resultId = run_query($distinctQuery);	
   $total_rows = get_num_rows($resultId);
	
   
	$con = 1;
	$total = 0;
	while($row = get_row_data($resultId))
	{
		$visit_id=$row['visit_id'];
        $customer_id = $row['customer_id'];
		$surname=$row['surname'];
		$firstname=$row['firstname'];
        $middle_name=$row['middlename'];
        $names = $surname . " ".$firstname;
		$visit_date=$row['visit_date'];
		$bill_amount=$row['bill_amount'];
		$msp_id=$row['msp_id'];
		$mcare_ref=$row['mcare_ref'];

           
 ?>
		  <tr>
			<td><?=$visit_id; ?></td>
			<td><?=$names; ?></td>
			<td><?=$msp_id; ?> </td>
			<td><?=$visit_date; ?> </td>
			<td><?=$bill_amount; ?> </td>		
            <td><?=$mcare_ref; ?> </td>	
       </tr>
		 <?php
 
	}
	   
	?>
  
  </tbody>
</table>
<div class="clearfix"></div>