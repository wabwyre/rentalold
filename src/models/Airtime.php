<?php
	class Airtime{
		public function processTxtFile(){
			// upload the txt file
			$target_path='';

			$allowedExts = array("txt");
	        $temp = explode(".", $_FILES["txt"]["name"]);
	        $extension = end($temp);
	        $timestamp = 'airtime_'.date('Y_m_d_H_i_s_');

	        // var_dump($extension);exit;
			if (in_array($extension, $allowedExts)) {
	            if ($_FILES["txt"]["error"] > 0) {
	               "Return Code: " . $_FILES["txt"]["error"] . "<br>";
	            } else {
                 	$target_path = "assets/txt/".$timestamp."".$_FILES["txt"]["name"];
                 	if(move_uploaded_file($_FILES["txt"]["tmp_name"], $target_path)){
                 		// get the contents of the txt file
                 		$myFile = $target_path;
						// var_dump($myFile);exit;
						// echo "got file...";
						
						if(file_exists($myFile))
						{
							// var_dump('file exists');exit;
						   	$fh = fopen($myFile,'r');
						   	$toread = filesize($myFile);
						   	$allfile = fread($fh,$toread);
						   	$wordChunks = explode("\n", $allfile);
						   	// var_dump($wordChunks);exit;
						}
						
						$count = 0;
						$counter = '';
						// echo "start inserting...";
						while($wordChunks[$count]){
							$data = $wordChunks[$count];
							$dataline = explode(',',$data);
							// var_dump($dataline);exit;

							$end_date = explode('"', $dataline[1]);
							$end_date = explode('/', $end_date[1]);
							$expiry_date = date($end_date[2].'-'.$end_date[1].'-'.$end_date[0]);
							// var_dump($expiry_date);exit;

							$pindata1 = explode('"', $dataline[2]);
							$pin_part1 = $pindata1[1];

							$pindata2 = explode('"', $dataline[3]);
							$pin_part2 = $pindata2[1];
							$pin = $pin_part2.''.$pin_part1;

							$ser_arr = explode('"', $dataline[4]);
							$serial = $ser_arr[1];

							if(!empty($serial) && !empty($pin) && !empty($expiry_date)){
								if(!checkForExistingEntry('airtime_vouchers', 'voucher_serial', $serial)){
									if($this->createVoucher($serial, $_POST['denom'], $pin, $expiry_date)){
										$_SESSION['upload_txt']='<div class="alert alert-success">
											<button class="close" data-dismiss="alert">×</button>
											<strong>Done!</strong> Finished the import.
										</div>';
									}else{
										$counter .= $count.', ';
									}
								}else{
									$_SESSION['upload_txt'] = '<div class="alert alert-warning">
									<button class="close" data-dismiss="alert">&times;</button> 
									<strong>Warning!</strong> Serial('.$serial.') already exists!
									</div>';
								}
							}
							$count++;
						}
						$counter = rtrim($counter, ', ');
						$this->createAirtimeUpload($count, $counter);
					}
				}
			}	
		}

		public function getAllDenoms(){
			$query = "SELECT * FROM airtime_denoms";
			return run_query($query);
		}

		public function createVoucher($serial, $denom, $pin, $expiry_date){
			$query = "INSERT INTO public.airtime_vouchers(
            voucher_serial, voucher_denom, voucher_pin, expiry_date)
    		VALUES ('".sanitizeVariable($serial)."', '".sanitizeVariable($denom)."', 
    			'".sanitizeVariable($pin)."', '".sanitizeVariable($expiry_date)."');";

    		if(run_query($query)){
    			return true;
    		}else{
    			return false;
    		}
		}

		public function createAirtimeUpload($voucher_count, $error){
			$query = "INSERT INTO public.airtime_uploads(
            uploader_mf_id, upload_date, voucher_count, error_report)
    		VALUES ('".$_SESSION['mf_id']."', '".date('Y-m-d')."', 
    			'".sanitizeVariable($voucher_count)."', '".sanitizeVariable($error)."')";
    		if(run_query($query)){
    			return true;
    		}else{
    			var_dump('Create Airtime Upload: '.$query.' '.get_last_error());exit;
    		}
		}

		public function getUploadHistory(){
			$query = "SELECT au.*, CONCAT(m.surname,' ',m.firstname,' ',m.middlename) AS user_name FROM airtime_uploads au
			LEFT JOIN masterfile m ON m.mf_id = au.uploader_mf_id";
			return run_query($query);
		}

		public function getAllVouchers(){
			$query = "SELECT av.*, ca.mf_id, ad.value FROM airtime_vouchers av
			LEFT JOIN airtime_claim ac ON ac.airtime_claim_id = av.voucher_claim_id
			LEFT JOIN customer_account ca ON ca.customer_account_id = ac.customer_account_id
			LEFT JOIN airtime_denoms ad ON ad.id = av.voucher_denom
			";
			return run_query($query);
		}

		public function getCustomerNameFromMfid($mf_id){
			if(!empty($mf_id)){
				$query = "SELECT CONCAT(surname,' ',firstname,' ',middlename) as customer_name FROM masterfile
				WHERE mf_id = '".$mf_id."'";
				$result = run_query($query);
				$rows = get_row_data($result);
				return $rows['customer_name'];
			}
		}

		public function getAirtimeClaims(){
			$query = "SELECT ac.*, ca.mf_id FROM airtime_claim ac
			LEFT JOIN customer_account ca ON ca.customer_account_id = ac.customer_account_id";
			return run_query($query);
		}
	}
?>