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
   $distinctQuery = "select * FROM ".DATABASE.".markets_allocation Order by allocation_id DESC Limit 20 OFFSET $offset";
   $resultId = run_query($distinctQuery);	
   $total_rows = get_num_rows($resultId);
	
   
	$con = 1;
	$total = 0;
	while($row = get_row_data($resultId))
	{
		$allocation_id = $row['allocation_id'];
		$inspector_id = $row['inspector_id'];
		$market_id= trim($row['market_id']);
	    $allocation_date= $row['allocation_date'];
		$allocated_date=$row['allocated_date'];
		 ?>
		   <tr>
		 <td><?=$allocation_id; ?></td>
		   <td><?=$inspector_id; ?></td>
		   <td><?=$market_id; ?></td>
           <td><?=$allocation_date; ?></td>
           <td><?=$allocated_date; ?></td>
		 <td><a href="index.php?num=&m_allocation=<?=$allocation_id; ?>">EDIT</a></td>
         <td><a href="index.php?num=&m_allocation=<?=$allocation_id; ?>">DELETE</a></td>
      
		  </tr>
		 <?
 
	}
	
	?>
  </tbody>
</table>
