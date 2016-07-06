<?	//if PAYBILL request was for Parking Service...
	$plate = $user_account; 		//number plate of car 
	$agent_trans_id = $trans_id;
	
	$paid_amt = $amount; 			//amount paid to the third party...
	
	$service_id = 10000;
	

	
	$zone = 1;					//$descr[2];  //geographical region
	
	$parking_type = getParkingTypeByKeyword($keyword);			//$descr[5]; //is it Day Parking or Hour Parking or Season Parking?
	$option_name = getParkingOptionNameByKeyword($keyword);
	$parking_details = ""; 		//any other details
	
	$today = time();
	
	$endofday = strtotime(date("Y-m-d ")." 23:59:59");
	if($parking_type == DAY_PARKING)
	{
		$start_date = $today;  //start of service session timestamp
		$end_date = $endofday;//$today+32400; //end of service session timestamp
		traceActivity("...DAY PARKING[".$parking_type."-".$keyword."]...");
	}
	else
	{
		$parking_type = 2;
		$start_date = $today;
		$end_date = $today+2678400;
		traceActivity("...MONTH PARKING[".$parking_type."-".$keyword."]...");
	}
	$street = $descr[8]; //street where car is parked - optional
	$lot = $descr[9];  //lot where car is parked - optional
	
	
	
	$cartype = "Saloon"; //descr[10]; //type of car parked - saloon,bus,lorry
	$months = 1; //descr[11]; //number of months for season parking - 3/11
	
	
	
	//echo $plate ."==<hr>==";
	
	$park_sess = new ParkingSession($reference_id,$plate,$phone,$email,$parking_type,$today,$start_date,$end_date,
									$agent_id,$agent_trans_id,$zone,$option_name,$paid_amt,$street,$lot,$cartype,$months);
	traceActivity("....PARKING OBJECT CREATED...");
	if($park_sess->validateParking()) //validates transaction parameters to match ccn rates
	{
			traceActivity("....PARKING TRANSACTION VALIDATED...");
			
			$park_sess->postToDB();
			traceActivity("....PARKING OBJECT PUSHED TO DATABASE...");
			
			if($park_sess->postToComfyPay())
			{
				traceActivity("....PARKING COMPLETION MESSAGE SENT TO COMFYPAY SUCCESSFULLY....");
			}
			else
			{
				traceActivity("....PARKING COMPLETION MESSAGE SENT TO COMFYPAY ..");
			}			
			
			//
			//if($agent_code == "COMFYUSSD" || $agent_code == "CCNAGENTWAP")
			$park_sess->smsReceiptToCustomer();
			//else
				$park_sess->emailReceiptToCustomer();
			traceActivity("....PARKING RECEIPT SENT TO CUSTOMER...");
	}
	else
	{
		$park_sess->postExistingParkingToComfyPay();
		traceActivity("....PARKING TRANSACTION NOT VALIDATED...");
	}
	
	
	function getParkingTypeByKeyword($keyword)
	{
		$ins_sql = "SELECT parking_type_id FROM ".DATABASE.".parking_options WHERE parking_option_code ='$keyword'";
			//traceActivity("<hr>".$ins_sql."<br>");			
			$result = run_query($ins_sql);
			$arr=get_row_data($result);
			return $arr['parking_type_id'];
	}
	function getParkingOptionNameByKeyword($keyword)
	{
		$ins_sql = "SELECT parking_option_name FROM ".DATABASE.".parking_options WHERE parking_option_code ='$keyword'";
			//traceActivity("<hr>".$ins_sql."<br>");			
			$result = run_query($ins_sql);
			$arr=get_row_data($result);
			return $arr['parking_option_name'];
	}
	
	
?>