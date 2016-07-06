<?
	$service_type = "parking_type";
		
	$agent_id = $_POST['agent_id'];
	$phone = $_POST['phone'];
	$plate = $_POST['car_regno'];
	$parking_type = $_POST['parking_type'];
	
	$parking_type = $_POST['parking_type'];
	
	$parking_details = $_POST['parking_details'];
	$start_date = $_POST['start_date'];
	$end_date = $_POST['end_date'];
	$street = $_POST['street'];
	$lot = $_POST['lot'];
	$zone = $_POST['zone'];
	$paid_amt = $_POST['paid_amt'];
	$today = time();	
	
	echo $plate ."==<hr>==";
	
	/*$park_sess = new ParkingSession($plate,$phone,$parking_type,$today,$start_date,$end_date,$agent_id,$zone,$paid_amt,$street,$lot);
	
	$park_sess->validateParking();
	
	$park_sess->postToDB();
	
	$park_sess->smsReceiptToCustomer();*/
	
	//$park_sess->sendToEbppp();
	
	/*$t_status = 1;
	$vehicle_id = 1;
	$agent_id = 3;
	$parking_type = 1;*/
	//$amt = 140;
	
	/*$zone_id = 1;//$_POST['zone'];

	$customer_id = 1;
	
	$ticket_date = date("Y-m-d H:i:s");
	
	$start = strtotime(date("Y-m-d H:i:s"));
	$end = $start + 1440;
	
	

	$email = "tintalle.istari@gmail.com";
	
      $message  = "Thank you for purchasing a Parking Ticket for [".$plate."] on [".$ticket_date."]: Your Ticket Number is CNNPARK" .$book_id."_".$trans_id;*/




?>