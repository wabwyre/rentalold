<?
	class ParkingSession{
	
		public $car_no;
		public $today;
		public $start_date;
		public $end_date;
		public $customer_phone;
		public $customer_email;
		public $agent_id;
		public $zone;
		public $street;
		public $lot;
		public $amt;
		public $receipt;
		public $parkingtype;
		public $cartype;
		public $id;
		public $transaction_id;
		public $agent_trans_id;
		public $months;
		public $reference_id;
	
		function ParkingSession($reference_id,$car_no,$customer_phone,$customer_email,$parkingtype,$today,$start_date,$end_date,
								$agent_id, $agent_trans_id,$zone,$amt,$street,$lot,$cartype,$months)
		{
			$this->car_no = $car_no;
			$this->today = $today;
			$this->start_date = $start_date;
			$this->end_date = $end_date;
			$this->zone = $zone;
			$this->street = $street;
			$this->lot = $lot;
			$this->amt = $amt;		
			$this->customer_phone = $customer_phone;	
			$this->customer_email = $customer_email;	
			$this->parkingtype = $parkingtype;	
			$this->cartype = $cartype;	
			$this->months = $months;
			$this->reference_id = $reference_id;
			$this->agent_id = $agent_id;
			$this->agent_trans_id = $agent_trans_id;
			
			$update_sql = "UPDATE ".DATABASE.".log_req set agent_id='".$this->agent_id."' where header_id='".$this->reference_id."'";
				
			//traceActivity("<hr>".$insert_sql."<br>");	
			$result = run_query($update_sql);
			if(!$result)
			{
			   // echo "Did not work...".pg_last_error(); 
				traceActivity("\n===".pg_last_error()."==");
			}
		}
		
		function validateParking()
		{ 
			return true;
			/*switch($this->parkingtype)
			{
				case DAY_PARKING://if Day Parking
						if(getDayParkingRate($this->start_date, $this->zone, $this->cartype) == $this->amt)
						    return true;
						else
							return false;
					  break;
				case SEASON_PARKING://if Seasonal Parking
						if(getSeasonalParkingRate($this->start_date,$this->zone,$this->cartype,$this->months) == $this->amt)
						    return true;
						else
							return false;						
					  break;
				case RESERVED_PARKING://if Parking				
					  break;
				case VIP_PARKING://if Seasonal Parking						
					  break;
				case LOADING_PARKING://if Seasonal Parking						
					  break;
				default:				
					  break;
			}			
			return true;	*/	
		}
		
		function smsReceiptToCustomer()
		{ 
			  //start asynchronous process to send sms...      
			  $server = "localhost";
			  $path = "http://localhost/bibi/server/send_parking_sms.php";
			  $get_string = "?action=send_sms&customer_phone=".$this->customer_phone."&car_no=".$this->car_no."&receipt=".
								$this->receipt."&today=".$this->today;  
			  $url = $path . $get_string;     
			  
			  JobStartAsync($server, $url);
		}
		
		function emailReceiptToCustomer()
		{ 
			  $server = "localhost";
			  $path = "http://localhost/bibi/server/send_parking_email.php";
			  $get_string = "?action=send_sms&customer_email=".$this->customer_email."&car_no=".$this->car_no."&receipt=".
								$this->receipt."&today=".$this->today;  
			  $url = $path . $get_string;     
			  
			  JobStartAsync($server, $url);
		}
		
		
		function postToDB()
		{ 
			$service_type = 10000;
			echo "<br>Parking Details Posted to EBPPP Database<br>";
			$book_id = getnextID(DATABASE.".parking_session", "parking_id",1);
			$trans_id = getnextID(DATABASE.".transactions", "transaction_id",1);
			
			$this->id = $book_id;
			$this->transaction_id = $trans_id;
			
			$this->receipt = "CCNPK" .$book_id."T".$trans_id;			
			
			$ins_sql = "INSERT INTO ".DATABASE.".transactions(transaction_id, receiptnumber, agent_id, agent_trans_id, service_id, cash_paid,
															  transaction_date,completed)
						   VALUES ('$trans_id','$this->receipt','$this->agent_id','$this->agent_trans_id','$service_type','$this->amt','$this->today','FALSE')";
			//echo "<hr>".$ins_sql;			
			run_query($ins_sql);
			
			
			$insert_sql = "INSERT INTO ".DATABASE.".parking_session 			
							(parking_id,transaction_id,plate_number,parking_type_id,parking_date,
							 time_in,time_out,status,region_id)
							 
						   VALUES ('$book_id','$this->transaction_id','$this->car_no','$this->parkingtype','$this->today',
						   			'2345354354','234532453','1','$this->zone')";
				
			//traceActivity("<hr>".$insert_sql."<br>");	
			$result = run_query($insert_sql);
			if(!$result)
			{
			   // echo "Did not work...".pg_last_error(); 
				traceActivity("\n===".pg_last_error()."==");
			}
			
			
			$update_sql = "UPDATE ".DATABASE.".log_req set ccn_trans_id='$this->transaction_id', ccn_receipt='$this->receipt' where header_id='".$this->reference_id."'";
				
			//traceActivity("<hr>".$insert_sql."<br>");	
			$result = run_query($update_sql);
			if(!$result)
			{
			   // echo "Did not work...".pg_last_error(); 
				traceActivity("\n===".pg_last_error()."==");
			}
			
		}
		
		/*
		*FUNCTION TO POST HEADERS TO COMFYPAY
		*
		function postToComfyPay()
		{
			$datetime = date("m-d-Y");	
			
			$report ="RECPT:".$this->receipt . "*DATETIME:".$datetime;
				
			$client = new SoapClient("http://192.168.100.75/ComfyPaySwitch/ComfyPaySwitchService.asmx?WSDL");
			
			$result = $client->__soapCall('USPRequest2', array('ReferenceID'=>$this->reference_id,
												'TransactionID'=>$this->agent_trans_id,
												'Status'=>PARKING_COMPLETE,
												'Report'=>$report));												
			traceActivity("....AGENT Transaction [$this->agent_trans_id] Confirmed... $this->reference_id ... ".PARKING_COMPLETE."...");
			if($result->USPRequest2Result == 1)
			    return true;
		}*/
		
		
		
		function postToComfyPay()
		{
			$datetime = date("m-d-Y");	 
			
			$report ="BILL SUCCESS RECPT:".$this->receipt . " DATE_TIME:".$datetime;
			
			// open the connection to majorcalendar      
			  $host = "192.168.100.3";
			  $path = "http://192.168.100.3/usp-cgi/Comfy.uspcgi";
			  
			  $post_string = "TRANSACTIONCODE=PAYBILL&TRANSACTIONID=".$this->agent_trans_id."&STATUSCODE=72&RESPCODE=0&REPORT=".$report;  
			  //$post_string = "ReferenceID=".$this->reference_id."&TransactionID=".$this->agent_trans_id."&StatusCode=72&Report=".$report;       
			  
			  $fp = fsockopen($host,"80",$err_num,$err_str,30); 
			  if(!$fp) 
			  {
				 $log_error = "fsockopen error no. $errnum: $errstr";
				 return false;         
			  } 
			  else 
			  {  
				 echo "<hr>connection was successful...";
		
				 fputs($fp, "POST $path HTTP/1.1\r\n"); 
				 fputs($fp, "Host: $host\r\n"); 
				 fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n"); 
				 fputs($fp, "Content-length: ".strlen($post_string)."\r\n"); 
				 fputs($fp, "Connection: close\r\n\r\n"); 
				 fputs($fp, $post_string . "\r\n\r\n"); 
		
				 // loop through the response from the server and append to variable
				 while(!feof($fp)) 
				 { 
					$post_response .= fgets($fp, 1024); 
				 } 
		
				 fclose($fp); // close connection
			  }
			traceActivity($post_string);
			traceActivity($post_response);
			
			$update_sql = "UPDATE ".DATABASE.".log_req set response_time='".date("Y-m-d H:i:s")."' where header_id='".$this->reference_id."'";
				
			//traceActivity("<hr>".$insert_sql."<br>");	
			$result = run_query($update_sql);
			if(!$result)
			{
			   // echo "Did not work...".pg_last_error(); 
				traceActivity("\n===".pg_last_error()."==");
			}
		}
		
		function getParkingCarNo()
		{
			return $this->car_no;
		}
		
		function getParkingReceipt()
		{
			return $this->receipt;
		}
		
		function getParkingDate()
		{
			return $this->today;
		}
		
		function getParkingType()
		{
			return $this->parkingtype;
		}
		
	}
	
	//function to validate a parking ticket given the receipt number
	function validateParkingReceipt($receipt)
	{
		$sql = "SELECT * FROM ".DATABASE.".parking where plate_number ='$car_no' AND (time_in < '$today' and time_out > '$today')";
		$result = run_query($sql);
		if(get_num_rows($result))
			return true;
		else
			return false;	
	}

	//function to validate a parking ticket given the registration number and date
	function validateParkingCar($car_no,$today)
	{
		$sql = "SELECT * FROM ".DATABASE.".parking where plate_number ='$car_no' AND (time_in < '$today' and time_out > '$today')";
		$result = run_query($sql);
		if(get_num_rows($result))
			return true;
		else
			return false;
	}
	
	//Get the Day's Parking rate for a zone, given the time and car-type
	function getDayParkingRate($time,$zone,$cartype,$months)
	{
		$sql = "SELECT * FROM ".DATABASE.".parking' where start_date < '$time' and end_date > '$time'";
		$result = run_query($sql);
		$array = get_row_data($result);
		return $array['parking_rate'];
	}
	
	//Get Seasonal Parking rate for a zone, given the time and car-type
	function getSeasonalParkingRate($time, $zone,$cartype)
	{
		$sql = "SELECT * FROM ".DATABASE.".parking' where start_date < '$time' and end_date > '$time'";
		$result = run_query($sql);
		$array = get_row_data($result);
		return $array['parking_rate'];
	}
?>