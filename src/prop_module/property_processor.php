<?php
error_reporting('0');
switch($_POST['action'])
{
case add_property:
	//get the values to add a new property
    $property_name=$_POST['property_name']; 
    $payment_code=$_POST['payment_code'];
    $paybill_no=$_POST['paybill_no'];
    $attached_to=$_POST['attached_to'];
    $units=$_POST['units'];

    $date_created=date('Y-m-d');
                
		//validation
		if (empty($property_name))
		{
		$message="You did not enter the property name";
		} else {
              
        $add_property="INSERT INTO ".DATABASE.".plots(plot_name,payment_code,customer_id,date_created,paybill_number,units)
                VALUES('".$property_name."','".$payment_code."','".$attached_to."','".$date_created."','".$paybill_no."','".$units."') RETURNING plot_id";
        
        if($data=run_query($add_property)){
            $_SESSION['mes'] = '<div class="alert alert-success">
                            <button class="close" data-dismiss="alert">×</button>
                            Your form submitted successfully!
                        </div>';
        }
       
        $id_data = get_row_data($data);
        $id = $id_data['id'];
        //argDump( $data);exit; 
    }        

}
?>
