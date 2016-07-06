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
   $distinctQuery = "select * FROM ".DATABASE.".market_attendant Order by attendant_id DESC Limit 20 OFFSET $offset";
   $resultId = run_query($distinctQuery);	
   $total_rows = get_num_rows($resultId);
	
   
	$con = 1;
	$total = 0;
	while($row = get_row_data($resultId))
	{
		$attendant_id=$row['attendant_id'];
		$market_id=$row['market_id'];
		$region_id=$row['region_id'];
		$is_active=$row['is_active'];
		$details=$row['details'];
		 ?>
		  <tr>
		   <td><?=$market_id;?></td>
         <td><?=$region_id; ?> </td>
         <td><?=$is_active; ?></td>
         <td><?=$details; ?></td>
	 <td><a href="index.php?num=&attendant=<?=$option_id; ?>">EDIT</a></td>
         <td><a href="index.php?num=&attendant=<?=$option_id; ?>">DELETE</a></td>
      
		  </tr>
		 <?
 
	}
	
	?>
  </tbody>
</table>
