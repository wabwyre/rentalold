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
   $distinctQuery = "select * FROM ".DATABASE.".markets_register Order by customer_id DESC Limit 20 OFFSET $offset";
   $resultId = run_query($distinctQuery);	
   $total_rows = get_num_rows($resultId);
	
   
	$con = 1;
	$total = 0;
	while($row = get_row_data($resultId))
	{
		$customer_id = $row['customer_id'];
		$id_no = $row['id_no'];
		$telephone= trim($row['telephone']);
	    $date_time= $row['date_time'];
		$record_id=$row['record_id'];
		 ?>
		   <tr>
		   <td><?=$customer_id; ?></td>
		   <td><?=$id_no; ?></td>
		   <td><?=$telephone; ?></td>
           <td><?=$date_time; ?></td>
           <td><?=$record_id; ?></td>
		 <td><a href="index.php?num=405&m_register=<?=$customer_id; ?>">EDIT</a></td>
         <td><a href="index.php?num=38&m_register=<?=$customer_id; ?>">DELETE</a></td>
      
		  </tr>
		 <?
 
	}
	
	?>
  </tbody>
</table>
