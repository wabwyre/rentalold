<?php
	include_once('src/models/Masterfile.php');
	/**
	* 
	*/
	class AfyapoaMsps extends Masterfile
	{
		
		public function createAfyapoaMsp($customer_id, $msp_code)
		{
			extract($_POST);
			$msp_type_id = ($msp_type == '') ? NULL : $msp_type;
			$register_afyapoa_msp="INSERT INTO afyapoa_msps
            (customer_id,status,msp_code, date_created,msp_type_id,county_id,region_id,
            longitude,latitude)
            VALUES ('".$customer_id."','1','".$msp_code."','".date("Y-m-d")."','".
                $msp_type_id."',0,0,0,0) "
                . "RETURNING afyapoa_msp_id";
                // var_dump($register_afyapoa_msp);exit;
        	if(run_query($register_afyapoa_msp)){
        		return true;
        	}else{
        		// var_dump(pg_last_error());exit;
        	}
		}

		public function createMspUser($target_path){
			extract($_POST);

			$query = "INSERT INTO 
	        masterfile(
	            surname, active,
	            firstname, middlename,
	            id_passport, gender,
	            images_path, regdate_stamp,
	            b_role, time_stamp
	        ) 
	        VALUES(
	            '".$surname."', '".$status."',
	            '".$firstname."', '".$middlename."',
	            '".$national_id_number."', '".$gender."',
	            '".$target_path."', '".date('Y-m-d H:i:s')."',
	            '".$b_role."', '".time()."'
	        ) RETURNING mf_id";

	        $password = 123456;//rand(100000, 999999);
	        mail($email, 'Your Afyapoa Password', $password);
	        $pass_hash = sha1($password);

	        if(checkForExistingEntry('masterfile', 'id_passport', $national_id_number)){
	        	$_SESSION['add_crm']='<div class="alert alert-warning">
	                <button class="close" data-dismiss="alert">×</button>
	                <strong>Warning!</strong> The Id No('.$national_id_number.') already exists.
	            </div>';
	        }else{
		        $result = run_query($query);
		        if($result){
		            $data = get_row_data($result);

		            if(checkForExistingEntry('user_login2', 'username', $email)){
		            	$_SESSION['add_crm']='<div class="alert alert-warning">
			                <button class="close" data-dismiss="alert">×</button>
			                <strong>Warning!</strong> The Username('.$email.') already exists.
			            </div>';
		            }else{
			            $query2 = "INSERT INTO user_login2(username, password, email, user_active, user_role, staff_customer_id, client_mf_id, mf_id) 
			            VALUES('".$email."', '".$pass_hash."', '".$email."', '".$status."', '".$user_role."', NULL, '".$_SESSION['mf_id']."', '".$data['mf_id']."')";
			            if(run_query($query2)){
			            	return true;
			            }else{
			            	var_dump(pg_last_error());
			            }
			        }
				}
			}
		}
	}
?>