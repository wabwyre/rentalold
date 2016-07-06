<? 
	include "connection/config.php";
	include "library.php";
	
	$page = $_GET['page'];
	
	if($page == 1)
	    $offset = 0;
	else
		$offset = $page * 10;


?> 
   <table id="table1">
 <tbody>
 
 <?
   $distinctQuery = "SELECT * FROM ".DATABASE.".cess_package_items Order by cess_package_id DESC Limit 10 OFFSET $offset";
   $resultId = run_query($distinctQuery);	
   $total_rows = get_num_rows($resultId);
	
   
	$con = 1;
	$total = 0;
	while($row = get_row_data($resultId))
	{
		$cess_package_id=$row['cess_package_id'];
		$cess_item_name=$row['cess_item_name'];
		$cess_package_name=$row['cess_package_name'];
		$quantity=$row['quantity'];
		$cost=$row['cost'];
		
		
		 ?>
		  <tr>
		  <td><?=$cess_package_id; ?></td>
          <td><?=$cess_item_name; ?></td>
          <td><?=$cess_package_name; ?></td>
          <td><?=$quantity; ?></td>
          <td><?=$cost; ?></td>
          
            <td><a href="index.php?num=41&cess=<?=$cess_package_id; ?>">INVOICE</a></td>
      
		  </tr>
		 <?
 
	}
	
	?>
  </tbody>
</table>
