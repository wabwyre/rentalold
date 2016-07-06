<? 
	include "connection/config.php";
	include "library.php";
	
	$page = $_GET['page'];
	
	if($page == 1)
	    $offset = 0;
	else
		$offset = $page * 20;


?> 
   <table id="table1">
 <tbody>
 
 <?
   $distinctQuery = "SELECT * FROM ".DATABASE.".transactions Order by transaction_id DESC Limit 20 OFFSET $offset";
   $resultId = run_query($distinctQuery);	
   $total_rows = get_num_rows($resultId);
	
   
	$con = 1;
	$total = 0;
	while($row = get_row_data($resultId))
	{
		$trans_id = trim($row['land_rate_id']);
		$ref_id = trim($row['plot_number']);
		$head_id = trim($row['header_id']);
		
		$trans_type = $row['transaction_code'];
		
		$contact_name = $row['contact_name'];
		$lr_arrears = $row['land_rates_arrears'];
		$lr_annual = $row['land_rates_annual'];
		$lr_penalty = $row['land_rates_accpenalty'];
		$lr_balance = $row['land_rates_currentbalance'];
		$customer_id=$row['customer_id'];
		 ?>
		  <tr>
		  <td><?=$trans_id; ?></td>
		   <td><?=$ref_id; ?></td>
		   <td><?=$head_id; ?></td>
		   <td><?=$trans_type; ?></td>
           <td><?=$contact_name; ?></td>
           <td><?=$lr_arears?></td>
           <td><?=$lr_annual; ?></td>
           <td><?=$trans_penalty; ?></td>
           <td><?=$lr_balance; ?></td>
           <td><?=$normal; ?></td>
           <td><?=$test; ?> </td>
           <td><?=$date_time; ?></td>
           <td><?=$customer_id;?></td>
         
		  </tr>
		 <?
 
	}
	
	?>
  </tbody>
</table>
