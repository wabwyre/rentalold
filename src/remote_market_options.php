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
   $distinctQuery = "select * FROM ".DATABASE.".options Order by option_id DESC Limit 20 OFFSET $offset";
   $resultId = run_query($distinctQuery);	
   $total_rows = get_num_rows($resultId);
	
   
	$con = 1;
	$total = 0;
	while($row = get_row_data($resultId))
	{
		$option_id=$row['option_id'];
		$keyword=$row['keyword'];
		$option_code=$row['option_code'];
		$service_id=$row['service_id'];
		$option_nature=$row['option_nature'];
		$option_name=$row['option_name'];
		$description=$row['description'];
		$last_updated=$row['last_updated'];
		$leaf=$row['leaf'];
		$rate=$row['rate'];
		$parent_option_id=$row['parent_option_id'];
		 ?>
		  <tr>
		    <td><?=$keyword; ?></td>
         <td><?=$option_code; ?> </td>
         <td><?=$service_id; ?> </td>
         <td><?=$option_nature; ?> </td>
         <td><?=$option_name; ?> </td>
         <td> <?=$description; ?></td>
         <td><?=$last_updated; ?> </td>
         <td><?=$leaf; ?></td>
         <td><?=$rate; ?></td>
         <td><?=$parent_option_id; ?></td>
         

		 <td><a href="index.php?num=400&mark=<?=$market_item_id; ?>">EDIT</a></td>
         <td><a href="index.php?num=401&mark=<?=$market_item_id; ?>">DELETE</a></td>
      
      
      
		  </tr>
		 <?
 
	}
	
	?>
  </tbody>
</table>
