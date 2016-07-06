<? 
	include "../connection/config.php";
	include "../library.php";
	
	$page = $_GET['page'];
	
	if($page == 1)
	    $offset = 0;
	else
		$offset = $page * 20;


?> 
   <table id="table1">
 <tbody>
 
 <?
   $distinctQuery = "select * from ".DATABASE.".waiver_blocks Order by waiver_block_id DESC Limit 20 OFFSET $offset";
   $resultId = run_query($distinctQuery);	
   $total_rows = get_num_rows($resultId);
	
   
	$con = 1;
	$total = 0;
	while($row = get_row_data($resultId))
	{
		$trans_id = trim($row['waiver_block_id']);
		$ref_id = trim($row['waiver_block_startdate']);
		$head_id = trim($row['waiver_block_enddate']);
		
		$trans_type = $row['waiver_block_discount'];
		
		$contact_name = $row['waiver_id'];
		
		 ?>
		  <tr>
		   <td><?=$trans_id; ?></td>
		   <td><?=$ref_id; ?></td>
		   <td><?=$head_id; ?></td>
		   <td><?=$trans_type; ?></td>
           <td><?=$contact_name; ?></td>
         
		  </tr>
		 <?
 
	}
	
	?>
  </tbody>
</table>
