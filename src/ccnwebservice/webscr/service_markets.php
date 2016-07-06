<?
	//if PAYBILL request was for Parking Service...
	$customer_id = $user_account; 		//number plate of car 
	$agent_trans_id = $trans_id;
	
	$paid_amt = $amount; 			//amount paid to the third party...
	
	$service_id = 10000;
	
	$zone = 1;					//$descr[2];  //geographical region
	
	$parking_type = 1;			//$descr[5]; //is it Day Parking or Hour Parking or Season Parking?
	
	$parking_details = ""; 		//any other details
	
	$today = time();	
	if($parking_type == DAY_PARKING)
	{
		$start_date = $today;  //start of service session timestamp
		$end_date = $today+32400; //end of service session timestamp
	}
	else
	{
		$start_date = $descr[6];
		$end_date = $descr[7];
	}
	$street = $descr[8]; //street where car is parked - optional
	$lot = $descr[9];  //lot where car is parked - optional
	
	
	
	$cartype = "Saloon"; //descr[10]; //type of car parked - saloon,bus,lorry
	$months = 1; //descr[11]; //number of months for season parking - 3/11
	
	//echo $plate ."==<hr>==";
	
	$mark_sess = new MarketSession($reference_id,$user_account,$customer_id,$customer_phone,$today,$start_date,$end_date,$agent_id, $agent_trans_id,$paid_amt);
	traceActivity("....MARKET OBJECT CREATED...");
	if($mark_sess->validateSession()) //validates transaction parameters to match ccn rates
	{
			traceActivity("....MARKET TRANSACTION VALIDATED...");
			
			$mark_sess->postToDB();
			traceActivity("....PARKING OBJECT PUSHED TO DATABASE...");
			
			if($mark_sess->postToComfyPay())
			{
				traceActivity("....PARKING COMPLETION MESSAGE SENT TO COMFYPAY SUCCESSFULLY....");
			}
			else
			{
				traceActivity("....PARKING COMPLETION MESSAGE SENT TO COMFYPAY ..");
			}			
			
			//$park_sess->smsReceiptToCustomer();
			//if($agent_code == "CCNWEB")
			$mark_sess->smsReceiptToCustomer();
			$mark_sess->emailReceiptToCustomer();
			traceActivity("....PARKING RECEIPT SENT TO CUSTOMER...");
			

	}
	else
	{
		traceActivity("....PARKING TRANSACTION NOT VALIDATED...");
	}
	
	
	
	
?>