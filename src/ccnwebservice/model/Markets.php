<?
	class MarketSession{
	
		public $id;
		public $customer_marketid;
		public $market_id;
		public $market_code;
		public $today;
		public $agent_id;
		public $stall;
		public $amt;
		public $receipt;
		public $customer_phone;
		public $type;
	
		function MarketSession($reference_id,$market_id,$customer_marketid,$customer_phone,$today,$start_date,$end_date,$agent_id, $agent_trans_id,$paid_amt)
		{
			$this->market_id = $market_id;
			$this->customer_marketid = $customer_marketid;
			$this->reference_id = $reference_id;
			$this->today = $today;
			$this->start_date = $start_date;
			$this->end_date = $end_date;
			$this->agent_id = $agent_id;
			$this->stall = $stall;
			$this->amt = $paid_amt;		
			$this->customer_phone = $customer_phone;	
			$this->agent_trans_id = $agent_trans_id;	
		}
		
		function validateSession()
		{
			return true;	
		}
		
		function smsReceiptToCustomer()
		{ 
			  //start asynchronous process to send sms...      
			  $server = "localhost";
			  $path = "http://localhost/bibi/server/send_markets_sms.php";
			  $get_string = "?action=send_sms&customer_phone=".$this->customer_phone."&car_no=".$this->market_id."&receipt=".
								$this->receipt."&today=".$this->today;  
			  $url = $path . $get_string;     
			  
			  JobStartAsync($server, $url);
		}
		
		function postToDB()
		{
			$service_type = 5;
			$market_id = 1;
			$market_type_id = 1;
			echo "<br>Market Details Posted to EBPPP Database<br>";
			$book_id = getnextID(DATABASE.".markets_session", "markets_session_id",1);
			$trans_id = getnextID(DATABASE.".transactions", "transaction_id",1);
			
			$this->id = $book_id;
			$this->transaction_id = $trans_id;
			
			$this->receipt = "CCNMK" .$book_id."T".$trans_id;			
			
			$ins_sql = "INSERT INTO ".DATABASE.".transactions(transaction_id, receiptnumber, agent_id, agent_trans_id, service_id, cash_paid,
															  transaction_date,completed)
						   VALUES ('$trans_id','$this->receipt','$this->agent_id','$this->agent_trans_id','$service_type','$this->amt','$this->today','FALSE')";
			echo "<hr>".$ins_sql;			
			run_query($ins_sql);
			
			
			$insert_sql = "INSERT INTO ".DATABASE.".markets_session 			
							(markets_session_id,transaction_id,customer_marketid,market_type_id,market_date,
							 time_in,time_out,status,market_id,agent_id)
							 
						   VALUES ('$book_id','$this->transaction_id','$this->customer_marketid','$market_type_id','$this->today',
						   			'2345354354','234532453','1','$market_id','$this->agent_id')";
			traceActivity("<hr>".$insert_sql."<br>");		
			
			$result = run_query($insert_sql);
			if(!$result)
			{
			   // echo "Did not work...".pg_last_error(); 
				traceActivity("\n===".pg_last_error()."==");
			}
			
			
			$update_sql = "UPDATE ".DATABASE.".log_req set 
						   ccn_trans_id='$this->transaction_id', 
						   ccn_receipt='$this->receipt' where 
						   header_id='".$this->reference_id."'";
				
			//traceActivity("<hr>".$insert_sql."<br>");	
			$result = run_query($update_sql);
			if(!$result)
			{
			   // echo "Did not work...".pg_last_error(); 
				traceActivity("\n===".pg_last_error()."==");
			}
		}
		
		function postToComfyPay()
		{
			$datetime = date("m-d-Y");	 
			
			$report ="BILL SUCCESS RECPT:".$this->receipt . " DATE_TIME:".$datetime;
			
			$client = new SoapClient("http://192.168.100.13/bibi/soap/ccn_ebppp.wsdl");
			//echo "<hr>";
			$return_string = array('uspCode' => "CCN", 
								   'uspPassword' => "123456",
								   'uspTransCode' => "BUYSERVICE",
									'ebpppRequestId' => $this->agent_trans_id,
									'transStatus' => "SUCCESS",
									'uspReceipt' => $this->receipt,
									'uspTransId' => $this->reference_id, 
									'uspResponse' => $report);
			$client->uspReturn($return_string);
			
			
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
		
		
		function getCustomerId()
		{
			return $this->customer_id;
		}
		
		function getMarketReceipt()
		{
			return $this->receipt;
		}
		
		function getMarketDate()
		{
			return $this->today;
		}
		
		function getMarketType()
		{
			return $this->type;
		}
			
	}


?>