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
   $distinctQuery = "select * FROM ".DATABASE.".market_items Order by market_item_id DESC Limit 20 OFFSET $offset";
   $resultId = run_query($distinctQuery);	
   $total_rows = get_num_rows($resultId);
	
   
	$con = 1;
	$total = 0;
	while($row = get_row_data($resultId))
	{
		$market_item_id=$row['market_item_id'];
		$market_item_name=$row['market_item_name'];
		$market_item_description=$row['market_item_description'];
		 ?>
		  <tr>
		     <td><?=$market_item_name; ?></td>
		   <td><?=$market_item_description; ?></td>
		 
		 <td><a href="index.php?num=16&mark=<?=$market_item_id; ?>">Edit</a></td>
         <td><a href=index.php?num=">Delete</a></td>
      
		  </tr>
		 <?
 
	}
	
	?>
  </tbody>
</table>
