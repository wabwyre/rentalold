<?php
	include_once('src/models/Masterfile.php');
	/**
	* Created by Eric Murimi
	*/
	class Staff extends Masterfile
	{
		
		function addToStaff()
		{
			extract($_POST);
			// var_dump($_POST); exit;
			if(checkForExistingEntry('staff', 'id_passport', $national_id_number)){
                $_SESSION['add_crm']='<div class="alert alert-warning">
                    <button class="close" data-dismiss="alert">&times;</button>
                    <strong>Warning!</strong> The National ID('.$national_id_number.') already exists.
                </div>';
            }else{
                $query = "INSERT INTO staff(
                    surname, firstname,
                    middlename, id_passport,
                    email, phone_no,
                    role_id
                ) VALUES(
                    '".$surname."', '".$firstname."',
                    '".$middlename."', '".$national_id_number."',
                    '".$email."', '".$phone."',
                    '".$user_role."'
                )";
					// var_dump($query); exit;
                if(run_query($query)){
                    $_SESSION['add_crm']='<div class="alert alert-success">
                        <button class="close" data-dismiss="alert">&times;</button>
                        <strong>Success!</strong> You successfully added a new staff.
                    </div>';
                }else{
                    $_SESSION['add_crm']= pg_last_error();
                }
            }
        }

		public function addLoginAccount($mf_id){
			extract($_POST);
			
			$pass_hashy = sha1(123456);
			$user_role = (isset($user_role)) ? $user_role : 'NULL'; 
		    if(checkForExistingEntry('user_login2', 'username', $email)){
		        $_SESSION['add_crm']='<div class="alert alert-warning">
		                <button class="close" data-dismiss="alert">&times;</button>
		                <strong>Warning!</strong> The email('.$email.') already exists.
		            </div>';
		    }else{
		        $add_login_account = "INSERT INTO user_login2(
		        username, password, email, user_active, user_role, client_mf_id, mf_id)
		        VALUES ('".$email."', '".$pass_hashy."', '".$email."', '1', ".$user_role.", NULL, '".$mf_id."') 
		        RETURNING user_id";

		        if($data = run_query($add_login_account)){
		            $array = get_row_data($data);
		            return $array['user_id'];
		        }else{
		        	var_dump(pg_last_error());exit;
		        }
		    }
		}

		public function editAddressType(){
			extract($_POST);
			//var_dump($_POST);exit;
			if(!onEditcheckForExistingEntry('address_types', 'address_type_name', $address_type_name, 'address_type_id', 
				$address_type_id)){
				$distinctQuery = "UPDATE address_types SET address_type_name = '".sanitizeVariable($address_type_name)."',
                          status = '".sanitizeVariable($status)."'
                    WHERE address_type_id = '".$address_type_id."'";
                    //var_dump($distinctQuery);exit;
	            $result = run_query($distinctQuery);

	            if (!$result) {
	                $errormessage = '<div class="alert alert-error">
	                                    <button class="close" data-dismiss="alert">×</button>
	                                    <strong>Error!</strong> Entry not updated.
	                                </div>'; 
	                $_SESSION['done-edits'] = $errormessage;
	              }else{
	              $_SESSION['done-edits'] = '<div class="alert alert-success">
	                        <button class="close" data-dismiss="alert">×</button>
	                        <strong>Success!</strong> Entry updated successfully.
	                    </div>';
	                    // App::redirectTo('?num=827');
	                }
	        } 
	          else{
	             $errormessage = '<div class="alert alert-warning">
	                                     <button class="close" data-dismiss="alert">×</button>
	                                     <strong>Warning!</strong> The Address Type Name('.$address_type_name.') already exists. Try another!
	                                 </div>'; 
	                 $_SESSION['done-edits'] = $errormessage;
	        }
		}

		public function deleteAddressType(){
		  extract($_POST);
		  $query = "DELETE FROM address_types WHERE address_type_id = '".$address_type_id."'";
				//var_dump($query);exit;
				$result = run_query($query);
				//var_dump($result);exit;
				if($result){
					$_SESSION['done-edits'] = '<div class="alert alert-success">
							<button class="close" data-dismiss="alert">×</button>
							<strong>Success!</strong> The Address Type has been removed Successfully.
						</div>';
						App::redirectTo('?num=827');
				}else{
					$_SESSION['done-edits'] = '<div class="alert alert-error">
							<button class="close" data-dismiss="alert">×</button>
							<strong>Error!</strong> The Address Type Not Revomed.
						</div>';
				}
		}
	}
?>