<?

			$report ="asdfasdfasdf";
				
			// open the connection to majorcalendar      
			  $host = "192.168.100.75:80";
			  $path = "http://192.168.100.75/ebppcgi/ebppcgi.ebppcgi";
			  $post_string = "ReferenceID=18&TransactionID=555&StatusCode=72&Report=".$report;       
			  
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
				 fputs($fp, "TRANSACTIONID:505\r\n\r\n");
				 fputs($fp, "STATUSCODE: 72\r\n\r\n");
				 fputs($fp, $post_string . "\r\n\r\n"); 
		
				 // loop through the response from the server and append to variable
				 while(!feof($fp)) 
				 { 
					$post_response .= fgets($fp, 1024); 
				 } 
		
				 fclose($fp); // close connection
			  }
			  
			  echo $post_response;
?>