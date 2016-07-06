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
 $distinctQuery="";
 if( (isset($_GET['type']) && $_GET['type'] = 'prov')){
   $distinctQuery = "select * from ".DATABASE.".land_rates WHERE is_provisional = '1' Order by land_rate_id DESC Limit 20 OFFSET $offset";
 }else
 {
$distinctQuery = "select * from ".DATABASE.".land_rates Order by land_rate_id DESC Limit 20 OFFSET $offset";
 }
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
		   <td><?=$ref_id; ?></td>
		   <td><?=$trans_id; ?></td>
		   <td><?=$contact_name; ?></td>
		   <td><?=$lr_arrears; ?></td>
           <td><?=$lr_annual; ?></td>
           <td><?=$lr_penalty; ?></td>
           <td><?=$lr_balance; ?></td>
           <td><?=$trans_type; ?></td>
           <td><?=$customer_id; ?></td>
           <td><a href="index.php?num=16&biz=<?=$trans_id; ?>">Manage</a></td>
		  </tr>
		 <?

	}

	?>
  </tbody>
</table>
