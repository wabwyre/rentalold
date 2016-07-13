<?php

switch($_POST['action'])
{
case add_house:
	//get the values to add a new property
    $house_no=$_POST['house_no'];
    $rent_amount=$_POST['rent_amount'];
    $tenant=$_POST['tenant'];
    $attached_to=$_POST['plot_id'];
		//validation
		if (empty($house_no))
		{
		$message="You did not enter the house no";
		} else {
              
        $add_house="INSERT INTO ".DATABASE.".houses(house_number,rent_amount,attached_to,tenant_id)
                VALUES('".$house_no."','".$rent_amount."','".$attached_to."','".$tenant."') RETURNING house_id";
        if($data=run_query($add_house)){
            $_SESSION['mes2'] = '<div class="alert alert-success">
            <button class="close" data-dismiss="alert">×</button>
            Your form submitted successfully!
        </div>'; 
        }
       
        $id_data = get_row_data($data);
        $id = $id_data['house_id'];
        //argDump( $data);exit; 
    }
break;
case edit_house:
	if($_POST['action'] == "edit_house")
		{
		$house_id=$_POST['house_id']; 
		$house_number=$_POST['house_no'];
	   	$rent_amount=$_POST['rent_amount'];
		$tenant=$_POST['tenant'];
		$attached_to=$_POST['plot_id'];  

		//update the customer
		$query="UPDATE ".DATABASE.".houses SET house_number='$house_number', 
		rent_amount='$rent_amount', tenant_id='$tenant', attached_to='$attached_to' WHERE house_id = '$house_id'";

		$data=run_query($query);
		if ($data)	
		{	
		$_SESSION['done-edits']='<div class="alert alert-success">
	            <button class="close" data-dismiss="alert">x</button>
	            You updated the house information successfully.
	        	</div>';
		}
	}   

}     
?>
