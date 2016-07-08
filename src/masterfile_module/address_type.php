<table id="table1" class="table table-bordered">
    <thead>
        <tr>
            <th>Address type Id</th>
            <th>Address type Name</th>
            <th>Address Status</th>
            <th>Edit</th>
        </tr>
    </thead>                      
    <tbody>

        <?php
          $distinctQuery = "SELECT * from address_types
                            Order by address_type_id DESC";
          $resultId = run_query($distinctQuery);
          $total_rows = get_num_rows($resultId);

            $con = 1;
            $total = 0;
            while($row = get_row_data($resultId))
            {
		$address_type_name = $row['address_type_name'];
		$address_type_id = $row['address_type_id'];
		$status = $row['status'];

		 ?>
		<tr>
		    <td><?=$address_type_id; ?></td>
			<td><?=$address_type_name; ?></td>
			<td>
			<?if($status == '1'){
		        echo 'Active';
		      }else{
		        echo 'Inactive';
		      }?>
           </td>
            <td><a href="?num=728&address_type_id=<?=$address_type_id; ?>" class="btn btn-mini"><i class="icon-edit"></i> Edit</td>
		  </tr>
		 <?php
 	}
	?>
  </tbody>
</table>