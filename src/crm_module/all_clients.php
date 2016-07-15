<?php
	set_layout("dt-layout.php", array(
		'pageSubTitle' => 'All Tenants',
		'pageSubTitleText' => '',
		'pageBreadcrumbs' => array (
			array ( 'url'=>'index.php', 'text'=>'Home' ),
			array ( 'text'=>'CRM' ),
			array ( 'text'=>'All Tenats' )
		)

	));

?>
<div class="widget">
	<div class="widget-title"><h4><i class="icon-reorder"></i> All Tenants</h4></div>
	<div class="widget-body form">
    <table id="table1" style="width: 100%" class="table table-bordered">
 		<thead>
			<tr>
			  	<th>MF#</th>
				<th>Start Date</th>
				<th>Surname</th>
				<th>First Name</th>
				<th>Id No#</th>
				<th>Phone No#</th>
				<th>B. Role</th>
				<th>Edit</th>
				<th>Profile</th>			  
			</tr>
 		</thead>
 	<tbody>
 	<?php

   $distinctQuery = "SELECT m.*, ul.username, a.phone FROM masterfile m 
   LEFT JOIN user_login2 ul ON ul.mf_id = m.mf_id
   LEFT JOIN address a ON a.mf_id = m.mf_id
   WHERE m.b_role = 'client' AND active IS TRUE";
    $resultId = run_query($distinctQuery);	
    $total_rows = get_num_rows($resultId);
    $con = 1;     
    $total = 0;     
    while($row = get_row_data($resultId))     {
        $mf_id = $row['mf_id'];
        $regdate_stamp = $row['regdate_stamp'];
        $surname = $row['surname'];
        $firstname = $row['firstname'];
        $id_passport = $row['id_passport'];
        $phone = $row['phone'];
        $b_role = $row['b_role'];        
	?>
		<tr>
			<td><?=$mf_id; ?></td>
			<td><?=$regdate_stamp; ?></td>
			<td><?=$surname; ?></td>
			<td><?=$firstname; ?></td>
			<td><?=$id_passport; ?></td>
			<td><?=$phone; ?></td>
			<td><?=$b_role; ?></td>		
			<td><a id="edit_link" href="index.php?num=802&mf_id=<?=$mf_id; ?>" class="btn btn-mini"><i class="icon-edit"></i> Edit</a></td>
			<td><a id="edit_link" href="index.php?num=810&mf_id=<?=$mf_id; ?>" class="btn btn-mini"><i class="icon-eye-open"></i> Profile</a></td>
		</tr>
<?php
 
	}
	   
	?>
  
  </tbody>
</table>
<div class="clearfix"></div>
</div>
</div>

