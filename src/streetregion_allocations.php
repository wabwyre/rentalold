 <?
 	if($_POST['action'] == "add_region_assignment")
	{
		$inspector = $_POST['region'];
		$street = $_POST['street'];
		
		$insert_sql = "UPDATE ".DATABASE.".streets set region_id='$inspector' where street_id ='$street'";
		//traceActivity($insert_sql);
		run_query($insert_sql);
	}
 	
 
   $today = date("Y-m-d");
   $distinctQuery2 = "select count(assignment_id) as total_parks from ".DATABASE.".inspectors_allocation WHERE timestamp='$today'";
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
					colWidths: [90,180,80,150,150,60]
				});
			}
		); 
	</script>  

<fieldset>
<legend class="table_fields"><strong>PARKING->Manage Streets &amp; Regions</strong>
</legend>
<div class="table_fields">
<strong>Allocate Region/Street:</strong><br /><form id="form1" name="form1" method="post" action="">
Select Region:
  <select name="region" class="components" id="region" >
<?
$query_courses = "select * from ".DATABASE.".region order by region_name ASC";
$result_crs = run_query($query_courses);
while($ents = get_row_data($result_crs))
{
	$code = $ents['region_id'];
	$title = $ents['region_name'] . "[".$ents['region_code']."]";
	print "<option value={$code}>{$title}</option>";
}
?> </select> 

 Select Street: 
 <select name="street" class="components" id="street" >
<?
$query_courses = "select * from ".DATABASE.".streets order by street_name ASC";
$result_crs = run_query($query_courses);
while($ents = get_row_data($result_crs))
{
	$code = $ents['street_id'];
	$title = $ents['street_name'].":".$ents['street_id'];
	print "<option value={$code}>{$title}</option>";
}
?> </select> 
 
   <input style="background-color:#900; color:#FFF; font-weight:bold;" type="submit" name="add_inspector" id="add_inspector" value="Update Street-Region Assignment" />
   <input name="action" type="hidden" id="action" value="add_region_assignment" />
</form>
</div>
<table id="table1">
 <thead>
  <tr>
   <th>Street#</th>
   <th>StreetName#</th>
   <th>Region#</th>
   <th>Region Name</th>
   <th>Capacity</th>
  </tr>
 </thead>
 <tbody>
 
 <?
   $distinctQuery = "select * from ".DATABASE.".streets Order by street_name ASC Limit 50";
   $resultId = run_query($distinctQuery);	
   $total_rows = get_num_rows($resultId);
	
   
	$con = 1;
	$total = 0;
	while($row = get_row_data($resultId))
	{
		$street_id = trim($row['street_id']);
		$region_id = trim($row['region_id']);
		$street_name= trim($row['street_name']);
		
				
		$capacity = $row['capacity'];

		 ?>
		  <tr>
		   <td><?=$street_id; ?></td>
		   <td><?=$street_name; ?></td>
		   <td><?=$region_id; ?></td>
		   <td><?=getRegionName($region_id); ?></td>
           <td><?=$capacity; ?></td>
           
          </tr>
		 <?
 
	}
	
	?>
  </tbody>
</table>
</fieldset>