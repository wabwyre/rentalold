<?
	//if PAYBILL request was for Parking Service...
	$plate = strtoupper(str_replace(" ","",$user_account)); 	//number plate of car 
	$agent_trans_id = $trans_id;
	
	$route = 44;
	
	$paid_amt = $amount; //amount paid to the third party...
	
	//$service_id = 10000;	
	if($service_id == 40)//SeasonalTicket...
	{	
		traceActivity("<br>In PSV Seasonal Ticket  ".$description."<br>");
		$receipt = postPSVSeasonalToDB($agent_id,$agent_trans_id,$paid_amt,$plate,$route,$reference_id);
		returnToComfyPay($agent_trans_id,$receipt,$reference_id);
	}
	elseif($service_id == 50)//Change Route...
	{
		traceActivity("<br>In PSV Route Change ".$description."<br>");
		$receipt = postPSVRouteChangeToDB($agent_id,$agent_trans_id,$paid_amt,$plate,$route,$reference_id);
		setNewPSVRoute($plate,$route);
		returnToComfyPay($agent_trans_id,$receipt,$reference_id);
	}
	elseif($service_id == 60)
	{
		traceActivity("<br>In PSV Register ".$description."<br>");	
		$receipt = postPSVRegistrationToDB($agent_id,$agent_trans_id,$amt,$car_no,$route,$reference_id);
		addNewPSVVehicle($plate,$route);
		returnToComfyPay($agent_trans_id,$receipt,$reference_id);
	}

	function postPSVSeasonalToDB($agent_id,$agent_trans_id,$amt,$car_no,$route,$reference_id)
		{ 
			$service_type = 3;
			$service_id = 40;
			$today = time();
			echo "<br>PSV Parking Details Posted to EBPPP Database<br>";
			$book_id = getnextID(DATABASE.".psv_parking", "psv_parking_id",1);
			$trans_id = getnextID(DATABASE.".transactions", "transaction_id",1);
			
			$id = $book_id;
			$transaction_id = $trans_id;
			
			$receipt = "CCNPSVPK" .$book_id."T".$trans_id;			
			
			addNewTransaction($trans_id,$receipt,$agent_id,$agent_trans_id,$service_id,$service_type,$amt,$today);
			
			
			$insert_sql = "INSERT INTO ".DATABASE.".psv_parking 			
							(psv_parking_id,transaction_id,car_reg,start_date,end_date,psv_parking_status,psv_parking_route)
							 
						   VALUES ('$book_id','$transaction_id','$car_no','2345354354','234532453','1','$route')";
				
			traceActivity("<hr>".$insert_sql."<br>");	
			$result = run_query($insert_sql);
			if(!$result)
			{
			   // echo "Did not work...".pg_last_error(); 
				traceActivity("\n===".pg_last_error()."==");
			}
			
			
			updateRequestID($transaction_id,$receipt,$reference_id);
			return $receipt;
		}
		
		function returnToComfyPay($agent_trans_id,$receipt,$reference_id)
		{
			$datetime = date("m-d-Y");	 
			
			$report ="BILL SUCCESS RECPT:".$receipt . " DATE_TIME:".$datetime;
			
			$client = new SoapClient("http://192.168.100.13/bibi/soap/ccn_ebppp.wsdl");
			//echo "<hr>";
			$return_string = array('uspCode' => "CCN", 
								   'uspPassword' => "123456",
								   'uspTransCode' => "BUYSERVICE",
									'ebpppRequestId' => $agent_trans_id,
									'transStatus' => "SUCCESS",
									'uspReceipt' => $receipt,
									'uspTransId' => $reference_id, 
									'uspResponse' => $report);
			$client->uspReturn($return_string);
			
			// open the connection to majorcalendar      
			  $host = "192.168.100.3";
			  $path = "http://192.168.100.3/usp-cgi/Comfy.uspcgi";
			  
			  $post_string = "TRANSACTIONCODE=PAYBILL&TRANSACTIONID=".$agent_trans_id."&STATUSCODE=72&RESPCODE=0&REPORT=".$report;  
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
			
			$update_sql = "UPDATE ".DATABASE.".log_req set response_time='".date("Y-m-d H:i:s")."' where header_id='".$reference_id."'";
				
			//traceActivity("<hr>".$insert_sql."<br>");	
			$result = run_query($update_sql);
			if(!$result)
			{
			   // echo "Did not work...".pg_last_error(); 
				traceActivity("\n===".pg_last_error()."==");
			}
		}
		
		function postPSVRouteChangeToDB($agent_id,$agent_trans_id,$amt,$car_no,$route,$reference_id)
		{ 
			$service_type = 3;
			$service_id = 40;
			$today = time();
			echo "<br>PSV Route Change Details Posted to EBPPP Database<br>";
			$book_id = getnextID(DATABASE.".psv_route_changes", "psv_route_change_id",1);
			$trans_id = getnextID(DATABASE.".transactions", "transaction_id",1);
			
			$id = $book_id;
			$transaction_id = $trans_id;
			
			$receipt = "CCNPSVRC" .$book_id."T".$trans_id;			
			
			addNewTransaction($trans_id,$receipt,$agent_id,$agent_trans_id,$service_id,$service_type,$amt,$today);
			
			
			$insert_sql = "INSERT INTO ".DATABASE.".psv_route_changes 			
							(psv_route_change_id,transaction_id,car_reg,new_route,change_time)
							 
						   VALUES ('$book_id','$transaction_id','$car_no','$route','$today')";
				
			traceActivity("<hr>".$insert_sql."<br>");	
			$result = run_query($insert_sql);
			if(!$result)
			{
			   // echo "Did not work...".pg_last_error(); 
				traceActivity("\n===".pg_last_error()."==");
			}
			
			updateRequestID($transaction_id,$receipt,$reference_id);
			
			return $receipt;
		}
		
		
		function postPSVRegistrationToDB($agent_id,$agent_trans_id,$amt,$car_no,$route,$reference_id)
		{ 
			$service_type = 3;
			$service_id = 40;
			$today = time();
			echo "<br>PSV Registratioin Details Posted to EBPPP Database<br>";
			$book_id = getnextID(DATABASE.".psv_registrations", "psv_reg_id",1);
			$trans_id = getnextID(DATABASE.".transactions", "transaction_id",1);
			
			$id = $book_id;
			$transaction_id = $trans_id;
			
			$receipt = "CCNPSVRG" .$book_id."T".$trans_id;			
			
			addNewTransaction($trans_id,$receipt,$agent_id,$agent_trans_id,$service_id,$service_type,$amt,$today);
			
			
			$insert_sql = "INSERT INTO ".DATABASE.".psv_registrations			
							(psv_reg_id,transaction_id,car_reg,psv_route,reg_time,owner_name)
							 
						   VALUES ('$book_id','$transaction_id','$car_no','$route','$today','Jairus Obuhatsa')";
				
			traceActivity("<hr>".$insert_sql."<br>");	
			$result = run_query($insert_sql);
			if(!$result)
			{
			   // echo "Did not work...".pg_last_error(); 
				traceActivity("\n===".pg_last_error()."==");
			}
			
			
			updateRequestID($transaction_id,$receipt,$reference_id);
			return $receipt;
		}
		
		function updateRequestID($transaction_id,$receipt,$reference_id)
		{
			$update_sql = "UPDATE ".DATABASE.".log_req set 
						   ccn_trans_id='$transaction_id', 
						   ccn_receipt='$receipt' where 
						   header_id='".$reference_id."'";				
			//traceActivity("<hr>".$insert_sql."<br>");	
			$result = run_query($update_sql);
			if(!$result)
			{
			   // echo "Did not work...".pg_last_error(); 
				traceActivity("\n===".pg_last_error()."==");
			}
		}
		
		
		function setNewPSVRoute($plate,$route)
		{
			$update_sql = "UPDATE ".DATABASE.".psv_vehicles set 
						   psv_current_route='$route' where 
						   psv_reg_no='".$plate."'";				
			//traceActivity("<hr>".$insert_sql."<br>");	
			$result = run_query($update_sql);
			if(!$result)
			{
				traceActivity("\n===".pg_last_error()."==");
			}
		}
		
		function addNewPSVVehicle($plate,$route)
		{
			
			$book_id = getnextID(DATABASE.".psv_vehicles", "psv_vehicle_id",1);
			$update_sql = "INSERT INTO ".DATABASE.".psv_vehicles (psv_vehicle_id,psv_reg_no,customer_id,psv_current_route)
														 VALUES('$book_id','$plate','1','$route')"; 						   			
			//traceActivity("<hr>".$insert_sql."<br>");	
			$result = run_query($update_sql);
			if(!$result)
			{
				traceActivity("\n===".pg_last_error()."==");
			}
		}
		
		
		function addNewTransaction($trans_id,$receipt,$agent_id,$agent_trans_id,$service_id,$service_type,$amt,$today)
		{
			$ins_sql = "INSERT INTO ".DATABASE.".transactions(transaction_id, receiptnumber, agent_id, agent_trans_id, 
															  service_id, service_type_id, cash_paid,transaction_date,completed)
															  
						   							   VALUES('$trans_id','$receipt','$agent_id','$agent_trans_id',
															  '$service_id','$service_type','$amt','$today','FALSE')";
			traceActivity("<hr>".$ins_sql);			
			run_query($ins_sql);
		}
		
		/*function smsAutoReceiptToCustomer($sms_path,$customer_phone,$car_no,)
		{ 
			  //start asynchronous process to send sms...      
			  $server = "localhost";
			  $path = "http://localhost/bibi/server/send_parking_sms.php";
			  $get_string = "?action=send_sms&customer_phone=".$this->customer_phone."&car_no=".$this->car_no."&receipt=".
								$this->receipt."&today=".$this->today;  
			  $url = $path . $get_string;     
			  
			  JobStartAsync($server, $url);
		}*/
	
?>