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
   $distinctQuery = "select * from ".DATABASE.".market_types Order by market_type_id DESC Limit 20 OFFSET $offset";
   $resultId = run_query($distinctQuery);	
   $total_rows = get_num_rows($resultId);
	
   
	$con = 1;
	$total = 0;
	while($row = get_row_data($resultId))
	{
		$market_type_id = trim($row['market_type_id']);
		$market_code = trim($row['market_code']);
		$market_type_name= trim($row['market_type_name']);
	    $detail= $row['detail'];
		 ?>
		  <tr>
		     <td><?=$market_code; ?></td>
		   <td><?=$market_type_name; ?></td>
		   <td><?=$detail; ?></td>
		 <td><a href="index.php?num=16&market=<?=$market_type_id; ?>">Edit</a></td>
         <td><a href=index.php?num=">Delete</a></td>
      
		  </tr>
		 <?
 
	}
	
	?>
  </tbody>
</table>
