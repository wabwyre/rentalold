 <?
 	if($_POST['action'] == "add_tower_assignment")
	{
		$inspector = $_POST['tower'];
		$street = $_POST['region'];
		
		$insert_sql = "INSERT INTO ".DATABASE.".towers_allocation 			
							(staff_id,region_id,timestamp)
							 
						   VALUES ('$inspector','$street','".date("Y-m-d")."')";
		//traceActivity($insert_sql);
		run_query($insert_sql);
	}
 	
 
   $today = date("Y-m-d");
   $distinctQuery2 = "select count(assignment_id) as total_parks from ".DATABASE.".towers_allocation WHERE timestamp='$today'";
   $resultId2 = run_query($distinctQuery2);	
   $arraa = get_row_data($resultId2);
   $total_rows2 = $arraa['total_parks'];
 ?>
 	<script type="text/javascript">
		$(document).ready(
			function() 
			{
				$("#table1").ingrid({ 
					url: 'remote_parking_session.php',
					height: 400,
					totalRecords: <?=$total_rows2;?>,
					pageNumber: 1,
					recordsPerPage: 0,
					colWidths: [90,80,80,150,350,120]
				});
			}
		); 
	</script>  

<fieldset>
<legend class="table_fields"><strong>PARKING->Towers Allocations For Today [<?=$today; ?>]</strong></legend> 
<div class="table_fields">
<strong>Allocate Tower:</strong><br /><form id="form1" name="form1" method="post" action="">
Select Tower:
  <select name="tower" class="components" id="tower" >
<?
$query_courses = "select * from ".DATABASE.".staff where userlevelid='22' order by surname ASC";
$result_crs = run_query($query_courses);
while($ents = get_row_data($result_crs))
{
	$code = $ents['staff_id'];
	$title = $ents['surname'] . " " .$ents['first_name'] . " " .$ents['lastname']."[".$ents['staff_id']."]";
	print "<option value={$code}>{$title}</option>";
}
?> </select> 

 Select Region: 
 <select name="region" class="components" id="region" >
<?
$query_courses = "select * from ".DATABASE.".region order by region_name ASC";
$result_crs = run_query($query_courses);
while($ents = get_row_data($result_crs))
{
	$code = $ents['region_id'];
	$title = $ents['region_name'].":".$ents['region_id'];
	print "<option value={$code}>{$title}</option>";
}
?> </select> 
 
   <input style="background-color:#900; color:#FFF; font-weight:bold;" type="submit" name="add_inspector" id="add_inspector" value="Add Tower Assignment" />
   <input name="action" type="hidden" id="action" value="add_tower_assignment" />
</form>
</div>
<table id="table1">
 <thead>
  <tr>
   <th>Date</th>
   <th>Alloc#</th>
   <th>Staff#</th>
   <th>Staff Name</th>
   <th>Region</th>
   
   <th>Total Tows</th>
  </tr>
 </thead>
 <tbody>
 
 <?
   $distinctQuery = "select * from ".DATABASE.".towers_allocation where timestamp ='$today' Order by assignment_id DESC Limit 20";
   $resultId = run_query($distinctQuery);	
   $total_rows = get_num_rows($resultId);
	
   
	$con = 1;
	$total = 0;
	while($row = get_row_data($resultId))
	{
		$trans_id = trim($row['assignment_id']);
		$ref_id = trim($row['staff_id']);
		$street_id = trim($row['region_id']);
		
				
		$thedate = $row['timestamp'];

		 ?>
		  <tr>
		   <td><?=$thedate; ?></td>
		   <td><?=$trans_id; ?></td>
		   <td><?=$ref_id; ?></td>
		   <td><?=getStaffName($ref_id); ?></td>
           <td><?=getRegionName($street_id); ?></td>
           <td align="right"><?=getTotalTowsToday($ref_id); ?></td>
          </tr>
		 <?
 
	}
	
	?>
  </tbody>
</table>
</fieldset>