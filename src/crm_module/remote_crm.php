 <?php
//row to be deleted
$customer=$_GET['customer'];
if (isset($customer))
{
//delete the row
$delete_customers="DELETE FROM ".DATABASE.".ccn_customers WHERE ccn_customer_id=$customer";
$delete_customer=run_query($delete_customers);

if ($delete_customer)
    {
      echo "<p><font color='#006600'>The Item has been deleted</font></p>";
    }
}


?>
<? 
	include "../connection/config.php";
	include "../library.php";
	
	$page = $_GET['page'];
	
	if($page == 1)
	    $offset = 0;
	else
		$offset = $page * 20;


?> 
   <table id="table1">
 <tbody>
 
 <?
   $distinctQuery = "SELECT * FROM ".DATABASE.".ccn_customers Order by ccn_customer_id DESC Limit 20  OFFSET $offset";
   $resultId = run_query($distinctQuery);	
   $total_rows = get_num_rows($resultId);
	
   
	$con = 1;
	$total = 0;
	while($row = get_row_data($resultId))
	{
	 $ccn_customer_id=$row['ccn_customer_id'];
		$surname=$row['surname'];
		$start_date=$row['start_date'];
		$active=$row['active'];
		$customer_type_id=$row['customer_type_id'];
                if(isset($customer_type_id))
                    {
                    $customer_type_name=getCustomerTypeName($customer_type_id);
                    }
		$firstname=$row['firstname'];
		$address_id=$row['address_id'];
		if(isset($address_id))
		{
		$address_name=getAddressName($address_id);
		}
		$middle_name=$row['middlename'];
		$regdate_stam=$row['regdate_stamp'];
		$regdate_stamp=date("d-m-Y",$regdate_stam);
		$national_id_number=$row['national_id_number'];
		$phone=$row['phone'];
		$passport=$row['passport'];
		$balance=$row['balance'];
		$username=$row['username'];
                $email=$row['email'];
		$timedate=date("d-m-Y",$row['time_date']);
		 ?>
		  <tr>
			<td><?=$surname; ?></td>
			<td><?=$customer_type_name; ?></td>
			<td><?=$address_name; ?></td>
			<td><?=$phone; ?> </td>
			<td><?=$balance; ?> </td>
			<td><?=$username; ?> </td>

		<td><a id="edit_link" href="index.php?num=802&customer=<?=$ccn_customer_id; ?>">Edit</a></td>
		<td><a id="delete_link" href="index.php?num=801&customer=<?=$ccn_customer_id; ?>" onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
		<td><a id="edit_link" href="index.php?num=805&customer=<?=$ccn_customer_id; ?>">Profile</a></td>
		  </tr>
		 <?
 
	}
	
	?>
  </tbody>
</table>
