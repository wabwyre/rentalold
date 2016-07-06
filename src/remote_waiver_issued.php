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
   $distinctQuery = "SELECT * FROM ".DATABASE.".rates_waiver Order by waiver_id DESC Limit 20 OFFSET $offset";
   $resultId = run_query($distinctQuery);	
   $total_rows = get_num_rows($resultId);
	
   
	$con = 1;
	$total = 0;
	while($row = get_row_data($resultId))
	{
	  	$waiver_id = $row['waiver_id'];
		$waiver_startdate=$row['waiver_startdate'];
		$waiver__enddate = $row['waiver_enddate'];
		$waiver_year = $row['waiver_year'];
	
		 ?>
		  <tr>
		 <td><?=$waiver_id; ?></td>
		   <td><?=$waiver_startdate; ?></td>
		   <td><?=$waiver_enddate; ?></td>
		   <td><?=$waiver_year; ?></td>
		  </tr>
		 <?
 
	}
	
	?>
  </tbody>
</table>
