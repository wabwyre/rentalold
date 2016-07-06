<?
	session_start();
	$_SESSION['sessionId'] = $_POST['user_id'];
	include_once "../library.php";

	$service_type = 1;
	$agent_id = 3;
	$t_status = 1;
	$vehicle_id = 1;
	$agent_id = 3;
	$parking_type = 1;
	$amt = 140;
	
	$zone_id = 1;//$_POST['zone'];
	$phone = "0720810193";//$_POST['phone'];
	$plate = "KAJ494V";//$_POST['car'];
	$customer_id = 1;
	
	
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
      $message  = "Thank you for purchasing a Parking Ticket: Your Ticket Number is CNNPARK" .$book_id."_".$trans_id;
      $phone = "0720810193";
	  $sender_id = "CityCouncil";
      
      // open the connection to majorcalendar      
      $host = "www.majorcalendar.com";
      $path = "http://www.majorcalendar.com/smsapi/send_sms.php";
      $post_string = "action=send_sms&phone=".$phone."&message=".$message."&email=".$email."&sender_id=".$sender_id;       
      
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

    echo "<hr>".$post_response;
		
?>
