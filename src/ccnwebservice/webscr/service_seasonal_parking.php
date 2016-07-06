<?

	$service_type = 1;
	$agent_id = 3;
	$t_status = 1;
	$vehicle_id = 1;
	$agent_id = 3;
	$parking_type = 1;
	$amt = 140;
	
	$zone_id = 1;//$_POST['zone'];
	$phone = $_POST['phone'];
	$plate = $_POST['regNo'];
	$customer_id = 1;
	
	$ticket_date = date("Y-m-d H:i:s");
	
	$start = strtotime(date("Y-m-d H:i:s"));
	$end = $start + 1440;
	
	$book_id = getnextID("ori_ebppp.parking_session", "parking_id",1);
	
	$insert_sql = "INSERT INTO ori_ebppp.parking_session (parking_id,vehicle_id,start_time,end_time,parking_type,zone_id,agent_id,customer_id)
				   VALUES ('$book_id','$vehicle_id','$start','$end','$parking_type','$zone_id','$agent_id','$customer_id')";
	run_query($insert_sql); 
	
	
	
	$trans_id = getnextID("ori_ebppp.transactions", "transaction_id",1);
	$ins_sql = "INSERT INTO ori_ebppp.transactions (transaction_id, agent_id, transaction_type, transaction_amt,
													   transaction_record_id,transaction_time_stamp,transaction_status)
				   VALUES ('$trans_id','$agent_id','$service_type','$amt','$book_id','$start','$t_status')";
	run_query($ins_sql);

	$email = "tintalle.istari@gmail.com";
	
      $message  = "Thank you for purchasing a Parking Ticket for [".$plate."] on [".$ticket_date."]: Your Ticket Number is CNNPARK" .$book_id."_".$trans_id;




?>