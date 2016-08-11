<?php
include_once('src/models/House.php');
$House = new House;


switch($_POST['action'])
{
//    case add_house:
//	//get the values to add a new property
//	$house_no=$_POST['house_no'];
//	$rent_amount=$_POST['rent_amount'];
//	$tenant=$_POST['tenant'];
//	$attached_to=$_POST['plot_id'];
//		//validation
//		if (empty($house_no))
//		{
//		$message="You did not enter the house no";
//		} else {
//
//		$add_house="INSERT INTO ".DATABASE.".houses(house_number,rent_amount,attached_to,tenant_id)
//				VALUES('".$house_no."','".$rent_amount."','".$attached_to."','".$tenant."') RETURNING house_id";
//		if($data=run_query($add_house)){
//			$_SESSION['mes2'] = '<div class="alert alert-success">
//			<button class="close" data-dismiss="alert">×</button>
//			Your form submitted successfully!
//		</div>';
//		}
//
//		$id_data = get_row_data($data);
//		$id = $id_data['house_id'];
//		//argDump( $data);exit;
//		}
//		break;

	//add a new house
	case add_house:
		logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
		$House->addHouse();

		break;

	//add an attribute to a house\
	 case add_attribute:
 		//var_dump($_POST);exit;
	    logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
	    $House->addAttrb();
	    break;

	case edit_attribute:
	    logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
		$House->editAttribute();
	    break;

	case delete_attribute:
	    logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
		$House->deleteAttribute();
	    break;

	//attach an attribute to a house\
	case add_house_specs:
		//var_dump($_POST);exit;
		logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
		$House->attachHouseAttribute();
		$_SESSION['warnings'] = $House->getWarnings();
		break;

	case edit_house_spec:
		extract($_POST);
		//var_dump($_POST);exit();
		logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
		$House->editHouseAttribute();
		$_SESSION['warnings'] = $House->getWarnings();
		break;

	case delete_house_spec:
		extract($_POST);
		//var_dump($_POST);exit();
		logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
		$House->detachHouseAttribute();
		break;

//	case edit_house_:
//		extract($_POST);
////		var_dump($_POST);die();
//	if($_POST['action'] == "edit_house")
//		{
//		$house_id=$_POST['house_id'];
//		$house_number=$_POST['house_no'];
//	   	$rent_amount=$_POST['rent_amount'];
//		$tenant=$_POST['tenant'];
//		$attached_to=$_POST['plot_id'];
//
//		//update the customer
//		$query="UPDATE ".DATABASE.".houses SET house_number='$house_number',
//		rent_amount='$rent_amount', tenant_id='$tenant', attached_to='$attached_to' WHERE house_id = '$house_id'";
//
//		$data=run_query($query);
//		if ($data)
//		{
//		$_SESSION['done-edits']='<div class="alert alert-success">
//	            <button class="close" data-dismiss="alert">x</button>
//	            You updated the house information successfully.
//	        	</div>';
//		}
//	}
//	break;


	case delete_house:
		logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
		$House->deleteHOuse();
		break;
	case edit_house:
		logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
		$House->editHouse();
		break;
}
?>
