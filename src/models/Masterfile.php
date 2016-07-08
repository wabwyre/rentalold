<?php
	include_once('src/models/LoanRepayments.php');
	/**
	* 
	*/
	class Masterfile extends LoanRepayments
	{
		public function addCustomer($cu, $ag, $mc, $target_path, $mf_id){
			extract($_POST);

			$mobile_pin = 1234;

			$password = sha1(123456);

			$regdate_stamp = time();

		    $register_user="INSERT INTO ".DATABASE.".customers(surname,start_date,active,customer_type_id,
		    firstname,username,password,middlename,regdate_stamp,national_id_number,
		    phone,email,balance,images_path, time_date, mobile_pin, status, userlevelid,
		    cu, ag, mc, mf_id)
		    VALUES('".$surname."','".$start_date."','".$status."','".$customer_type_id.
		    "','".$firstname."','".$email."','".$password."','".$middlename.
		    "','".$regdate_stamp."','".$national_id_number."','".$phone."','".$email."','".$balance.
		    "','".$target_path."','".strtotime(date('Y-m-d H:m:s'))."','{$mobile_pin}', '0', '1', "
		    . "'".$cu."', '".$ag."', '".$mc."', '".$mf_id."') RETURNING customer_id";
			
			// var_dump($register_user);exit;
		    
		    $data=run_query($register_user);
		   
		    $id_data = get_row_data($data);
		    return $customer_id = $id_data['customer_id'];
		}
		
		public static function findMasterFileByRoleName($role_name)
		{
			$query = "SELECT * FROM masterfile mf INNER JOIN user_login2 ul ON "
					."mf.mf_Id = ul.mf_id INNER JOIN user_roles ur ON "
					."ul.user_role = ur.role_id WHERE ur.role_status is true "
					."AND mf.active is TRUE AND ur.role_name = '$role_name'";			
			$result = run_query($query);
			return $result;
		}

		public function getCustomerAddresses($mf_id){
			
			$query = "SELECT a.*, at.address_type_name, cr.county_name FROM address a
			LEFT JOIN address_types at ON at.address_type_id = a.address_type_id 
			LEFT JOIN county_ref cr ON cr.county_ref_id = a.county
			WHERE mf_id = '".sanitizeVariable($mf_id)."'
			 ORDER BY at.address_type_name";
			return run_query($query);
		}

		public function getCustomerPhones($mf_id){
			$query = "SELECT ca.*, gdm.model, gdm.device_model_id, gd.imei FROM customer_account ca
			LEFT JOIN gtel_device gd ON gd.device_id = ca.device_id 
			LEFT JOIN gtel_device_model gdm ON gdm.device_model_id = gd.device_model_id
			WHERE mf_id = '".sanitizeVariable($mf_id)."'";
			return run_query($query);
		}

		public function getCustomerPhonesAccDetails($mf_id){
			extract($_POST);
			$query = "SELECT cb.*, ca.customer_account_id FROM customer_bills cb
			LEFT JOIN customer_account ca ON ca.mf_id = cb.mf_id 
			WHERE ca.mf_id = '".sanitizeVariable($mf_id)."' ";
			return run_query($query);
		}

		public function getCustomerBillsForPhone($customer_code){
			$return = array();
			$query = "SELECT * FROM customer_bills cb WHERE service_account = '".sanitizeVariable($customer_code)."'";
			if($result = run_query($query)){
				if(get_num_rows($result)){
					while ($rows = get_row_data($result)) {
						$return[] = $rows;
					}
					return $return;
				}
			}
		}

		public function getPhonePayments($customer_code){
			$query = "SELECT * FROM transactions t WHERE service_account = '".sanitizeVariable($customer_code)."'";
			if($result = run_query($query)){
				if(get_num_rows($result)){
					while ($rows = get_row_data($result)) {
						$return[] = $rows;
					}
					return $return;
				}
			}
		}

		public function getPhoneLoanRepayment($customer_code){
			$return = array();
			$query = "SELECT lr.* FROM loan_repayments lr
			WHERE lr.account_code = '".sanitizeVariable($customer_code)."'";
			if($result = run_query($query)){
				if(get_num_rows($result)){
					while ($rows = get_row_data($result)) {
						$return[] = $rows;
					}
					return $return;
				}
			}
		}

		public function getCustomerTickets($mf_id){
			$query = "SELECT * FROM support_ticket 
			WHERE reported_by = '".sanitizeVariable($mf_id)."'";
			return run_query($query);
		}

		public function getCustomerInsurancePolicy($mf_id){
			$query = "SELECT gi.* FROM gtel_insurance gi
			LEFT JOIN customer_account ca ON ca.customer_account_id = gi.customer_account_id
			WHERE ca.mf_id = '".sanitizeVariable($mf_id)."'";
			return run_query($query);
		}

		public function getCustomerAccountIdsFromMfid($mf_id){
			$acc_ids = '';
			$query = "SELECT customer_account_id FROM customer_account
			WHERE mf_id = '".sanitizeVariable($mf_id)."'";
			$result = run_query($query);
			$num_rows = get_num_rows($result);
			if($num_rows >= 1){
				while ($row= get_row_data($result)) {
					$acc_ids[] = $row['customer_account_id'];
				}
				return $acc_ids;
			}			
		}

		public function getCustomerAccountCodesFromMfid($mf_id){
			$acc_ids = '';
			$query = "SELECT customer_code FROM customer_account
			WHERE mf_id = '".sanitizeVariable($mf_id)."'";
			$result = run_query($query);
			$num_rows = get_num_rows($result);
			if($num_rows >= 1){
				while ($row= get_row_data($result)) {
					$acc_ids[] = $row['customer_code'];
				}
				return $acc_ids;
			}			
		}

		public function getCustomerCode($mf_id){
			"SELECT customer_code FROM customer_account 
			WHERE mf_id =  '".$mf_id."' ";
		}

		public function getCustomerLoanRepayments($mf_id){
			$query ="SELECT lp.* FROM loan_repayments lp
			LEFT JOIN customer_account ca ON ca.customer_code = lp.account_code
			WHERE ca.mf_id = '".sanitizeVariable($mf_id)."' ";
			return run_query($query);
		}

		public function getSupportTicketsFromCustomerAccIds($customer_account_id){
			$query = "SELECT * FROM support_ticket
			WHERE customer_account_id = '".sanitizeVariable($customer_account_id)."'";
			return run_query($query);
		}

		public function getLoanRepaymentsFromCustomerAccCode($code){
			$query = "SELECT * FROM loan_repayments
			WHERE account_code = '".sanitizeVariable($code)."'";
			return run_query($query);
		}
		
		public function getAirtimeTicketsFromCustomerAccIds($customer_account_id){
			$query = "SELECT * FROM airtime_claim
			WHERE customer_account_id = '".sanitizeVariable($customer_account_id)."'";
			return run_query($query);
		}

		public function getStaffCustomerTickets($mf_id){
			$query = "SELECT st.* FROM support_ticket_assignment sta
			LEFT JOIN support_ticket st ON sta.support_ticket_id = st.support_ticket_id
			WHERE sta.assigned_to = '".sanitizeVariable($mf_id)."'";
			return run_query($query);
		}

		public function checkSupportTickets($mf_id){
			$query = "SELECT * FROM support_ticket_assignment 
			WHERE assigned_to = '".sanitizeVariable($mf_id)."' 
			";
			// var_dump($query);exit;
			$result = run_query($query);
			$num_rows = get_num_rows($result);
			return ($num_rows > 0) ? true: false;

		}

		public function checkClientSupportTickets($mf_id){
			$query = "SELECT * FROM support_ticket 
			WHERE customer_account_id = '".sanitizeVariable($mf_id)."' ";
			// var_dump($query);exit;
			$result = run_query($query);
			$num_rows = get_num_rows($result);
			return ($num_rows > 0) ? true: false;

		}

		public function getCustomerReferrals($mf_id){
			$query ="SELECT * FROM referrals 
			WHERE referee_mf_id = '".sanitizeVariable($mf_id)."' ";
			return run_query($query);
		}

		public function getCustomerCreditScore($mf_id){
			$query ="SELECT * FROM credit_score_conf ";
			return run_query($query);
		}

		public function addToMasterfile($target_path){
			extract($_POST);
			// disabling an input field do the folliwing to avoid undefined variable
			$customer_type_id = (isset($customer_type_id) && !empty($customer_type_id)) ? $customer_type_id : 'NULL'; 
			$company_name = (isset($company_name) && !empty($company_name)) ? $company_name : 'NULL';
			$gender = (isset($gender) && !empty($gender)) ? $gender : 'NULL';
			$target_path = (isset($images_path) && !empty($images_path)) ? $images_path : 'NULL';
			// var_dump($_POST);exit;
			if(!checkForExistingEntry('masterfile', 'id_passport', $national_id_number)){
				if(!checkForExistingEntry('masterfile', 'email', $email)){
					$query = "INSERT INTO public.masterfile(surname, 
					            firstname, 
					            middlename,
					            email, 
					            id_passport, 
					            time_stamp, 
					            gender, 
					            images_path,
					            company_name,
					            b_role, 
					            customer_type_id,
					            regdate_stamp)
	    			VALUES ('".sanitizeVariable($surname)."', 
			    		'".sanitizeVariable($firstname)."', 
			    		'".sanitizeVariable($middlename)."', 
			    		'".sanitizeVariable($email)."', 
			    		'".sanitizeVariable($national_id_number)."', 
		    			'".time()."', 
		    			'".sanitizeVariable($gender)."',
		    			'".sanitizeVariable($target_path)."',
		    			".sanitizeVariable($company_name).", 
		    			'".sanitizeVariable($b_role)."', 
		    			".sanitizeVariable($customer_type_id).",
		    			'".sanitizeVariable($regdate_stamp)."') RETURNING mf_id";
	    			// var_dump($query); exit;
					if($result = run_query($query)){
						$rows = get_row_data($result);
						return $rows['mf_id'];
					}else{
						var_dump($query.pg_last_error());exit;
					}
				}else{
					$_SESSION['done-deal']='<div class="alert alert-warning">
						<button class="close" data-dismiss="alert">&times;</button>
						<strong>Warning!</strong> The Following ('.$email.') already exists.
					</div>';
					// App::redirectTo('?num=803');
				}
			}else{
				$_SESSION['done-deal']='<div class="alert alert-warning">
					<button class="close" data-dismiss="alert">&times;</button>
					<strong>Warning!</strong> The Following ('.$national_id_number.') already exists.
				</div>';
				// App::redirectTo('?num=803');
			}
		}

		public function addAddress($mf_id){
			extract($_POST);
			$query = "INSERT INTO address(phone, 
					            postal_address, 
					            town, 
					            mf_id, 
					            address_type_id, 
					            county, 
					            ward, 
					            street, 
					            building,
					            postal_code, 
					            house_no)
    		VALUES ('".sanitizeVariable($phone_number)."', 
    		'".sanitizeVariable($postal_address)."', 
    		'".sanitizeVariable($town)."', 
    		'".sanitizeVariable($mf_id)."', 
    		'".sanitizeVariable($address_type_id)."', 
    		'".sanitizeVariable($county)."', 
    		'".sanitizeVariable($ward)."', 
    		'".sanitizeVariable($street)."', 
    		'".sanitizeVariable($building)."',
    		'".sanitizeVariable($postal_code)."',
    		'".sanitizeVariable($house)."')";
    		// var_dump($query); exit;
    		if (run_query($query)) {
    			return true;
    		}else{
    			return false;
    		}
    		
		}

		public function addCustomerFile($mf_id){
			extract($_POST);
			$query = "INSERT INTO customer_file(mf_id, 
				balance)
				VALUES('".$mf_id."',
					'0')";
    		// var_dump($query); exit;					
				if (run_query($query)) {
	    			return true;
	    		}else{
	    			return false;
    			}
		}

		public function addDependantToMasterfile(){
			extract($_POST);

			$full_name = explode(' ', $dependant_name);
			$firstname = $full_name[0];
			$middlename = (isset($full_name[1])) ? $full_name[1] : '';
			$surname = (isset($full_name[2])) ? $full_name[2] : '';

			$query = "INSERT INTO public.masterfile(
            surname, active, firstname, middlename, id_passport, time_stamp, 
            gender, dob, b_role)
    		VALUES ('".$surname."', '".$status."', '".$firstname."', '".$middlename."', NULL, 
    			'".time()."', '".$gender."', '".$dob."', 'Dependant') RETURNING mf_id";
			if($result = run_query($query)){
				$rows = get_row_data($result);
				return $rows['mf_id'];
			}
		}

		public function registerCurrentAccount($account_number, $customer_id){
			$insert_account = "insert into accounts(account_number,account_type_id,customer_id,date_created,account_status,account_balance)
            Values('".$account_number."',1,'".$customer_id."','".date("Y-m-d")."',1,0)";
    		if(run_query($insert_account)){
    			return true;
    		}else{
    			pg_last_error();
    		}
		}

		public function flashMessage2($status){
			if($status){
				$_SESSION['add_crm']='<div class="alert alert-success">
					<button class="close" data-dismiss="alert">×</button>
					<strong>Success!</strong> You successfully added a new customer.
				</div>';
			}else{
				$_SESSION['add_crm']='<div class="alert alert-error">
					<button class="close" data-dismiss="alert">×</button>
					<strong>Error!</strong>You have some form errors. Please check below.
				</div>';
			}
			App::redirectTo('?num=803');
		}

		public function createDefaultRevenueChannels($mf_id){
			$query1 = "INSERT INTO revenue_channel(revenue_channel_name, head_code_id, subcode_id, revenue_channel_code, mf_id, tab_id)
		    VALUES ('Tests', NULL, NULL, 'TS', '".$mf_id."', NULL)";
		    
		    if(run_query($query1)){

			    $query2 = "INSERT INTO revenue_channel(revenue_channel_name, head_code_id, subcode_id, revenue_channel_code, mf_id, tab_id)
			    VALUES ('Procedures', NULL, NULL, 'PD', '".$mf_id."', NULL)";
			    if(run_query($query2)){

			    	$query3 = "INSERT INTO revenue_channel(revenue_channel_name, head_code_id, subcode_id, revenue_channel_code, mf_id, tab_id)
				    VALUES ('Pharmacy', NULL, NULL, 'PM', '".$mf_id."', NULL)";
				    if(run_query($query3)){

				    	$query4 = "INSERT INTO revenue_channel(revenue_channel_name, head_code_id, subcode_id, revenue_channel_code, mf_id, tab_id)
					    VALUES ('General Services', NULL, NULL, 'GS', '".$mf_id."', NULL)";
					    if(run_query($query4)){
					    	return true;
					    }

				    }
			    }
		   	}else{
		   		var_dump(pg_last_error());exit;
		   	}
		}

		public function checkForExistingRevenueChannelName($revenue_name, $mf_id){
			$query = "SELECT * FROM revenue_channel WHERE revenue_channel_name = '".$revenue_name."' AND mf_id = '".$mf_id."'";
			$result = run_query($query);
			$num_row = get_num_rows($result);
			if($num_row == 1){
				return true;
			}else{
				return false;
			}
		}

		public function addAddressType(){
			extract($_POST);
		   if(!checkForExistingEntry('address_types', 'address_type_name', $address_type_name)){
	            $distinctQuery = "INSERT INTO address_types(address_type_name, status) 
	                    VALUES('".$address_type_name."','".$status."')";
	            $result = run_query($distinctQuery);

	            if (!$result) {
	                $errormessage = '<div class="alert alert-error">
	                                    <button class="close" data-dismiss="alert">×</button>
	                                    <strong>Error!</strong> Entry not added.
	                                </div>'; 
	                $_SESSION['done-add'] = $errormessage;
	              }else{
	              $_SESSION['done-add'] = '<div class="alert alert-success">
	                        <button class="close" data-dismiss="alert">×</button>
	                        <strong>Success!</strong> Entry added successfully.
	                    </div>';
	                }
	        } 
	          else{
	             $errormessage = '<div class="alert alert-warning">
	                                     <button class="close" data-dismiss="alert">×</button>
	                                     <strong>Warning!</strong> The Address Type Name('.$address_type_name.') already exists. Try another!
	                                 </div>'; 
	                 $_SESSION['done-add'] = $errormessage;
	        }
		}


		// public function editAddressType(){
		// 	extract($post);
		// 	if(!onEditcheckForExistingEntry('address_types', 'address_type_name', $address_type_name, 'address_type_id', 
		// 		$address_type_id)){
		// 		$distinctQuery = "UPDATE phone_list SET address_type_name = '".sanitizeVariable($address_type_name)."',
  //                         status = '".sanitizeVariable($status)."'
  //                   WHERE address_type_id = '".$address_type_id."'";
	 //            $result = run_query($distinctQuery);

	 //            if (!$result) {
	 //                $errormessage = '<div class="alert alert-error">
	 //                                    <button class="close" data-dismiss="alert">×</button>
	 //                                    <strong>Error!</strong> Entry not updated.
	 //                                </div>'; 
	 //                $_SESSION['done-edits'] = $errormessage;
	 //              }else{
	 //              $_SESSION['done-edits'] = '<div class="alert alert-success">
	 //                        <button class="close" data-dismiss="alert">×</button>
	 //                        <strong>Success!</strong> Entry updated successfully.
	 //                    </div>';
	 //                }
	 //        } 
	 //          else{
	 //             $errormessage = '<div class="alert alert-warning">
	 //                                     <button class="close" data-dismiss="alert">×</button>
	 //                                     <strong>Warning!</strong> The Address Type Name('.$address_type_name.') already exists. Try another!
	 //                                 </div>'; 
	 //                 $_SESSION['done-edits'] = $errormessage;
	 //        }
		// }

		public function addCustomerAddress(){
			extract($_POST);
			// var_dump($_POST); exit;
		    if(!checkForExistingEntry('address', 'postal_address', $postal_address, 'address_type_id', $address_type_id)){
	            $distinctQuery = "INSERT INTO address(phone,
	            								postal_address,
	            								town,
	            								address_type_id,
	            								ward,
	            								street,
	            								building,
	            								house_no,
	            								mf_id,
	            								county) 
	                    VALUES('".sanitizeVariable($phone_no)."',                    		
	                    		'".sanitizeVariable($postal_address)."',
	                    		'".sanitizeVariable($town)."',
	                    		'".sanitizeVariable($address_type_id)."',
	                    		'".sanitizeVariable($ward)."',
	                    		'".sanitizeVariable($street)."',
	                    		'".sanitizeVariable($building)."',
	                    		'".sanitizeVariable($house_no)."',
	                    		'".sanitizeVariable($mf_id)."',
	                    		'".sanitizeVariable($county)."')";
	                    		// var_dump($distinctQuery); exit;
	            $result = run_query($distinctQuery);

	            if (!$result) {
	                $errormessage = '<div class="alert alert-error">
	                                    <button class="close" data-dismiss="alert">×</button>
	                                    <strong>Error!</strong> Entry not added.
	                                </div>'; 
	                $_SESSION['done-deal'] = $errormessage;
	              }else{
	              $_SESSION['done-deal'] = '<div class="alert alert-success">
	                        <button class="close" data-dismiss="alert">×</button>
	                        <strong>Success!</strong> Entry added successfully.
	                    </div>';
	                }
	        } 
	          else{
	             $errormessage = '<div class="alert alert-warning">
	                                     <button class="close" data-dismiss="alert">×</button>
	                                     <strong>Warning!</strong> The Postal Address ('.$postal_address.') already exists. Try another!
	                                 </div>'; 
	                 $_SESSION['done-deal'] = $errormessage;
	        }
		}

		public function editAddress(){
			extract($_POST);
			if(!onEditcheckForExistingEntry('address', 'postal_address', $postal_address, 'address_id', $edit_id)){
				$query = "UPDATE address SET 
						phone = '".sanitizeVariable($phone_no)."',
						postal_address = '".sanitizeVariable($postal_address)."',
						town = '".sanitizeVariable($town)."',
						ward = '".sanitizeVariable($ward)."',
						address_type_id = '".sanitizeVariable($address_type_id)."',
						street = '".sanitizeVariable($street)."',
						building = '".sanitizeVariable($building)."',
						house_no = '".sanitizeVariable($house_no)."',
						county = '".sanitizeVariable($county)."'
                    WHERE address_id = '".$_POST['edit_id']."' ";

	            $result = run_query($query);
	            // var_dump($query); exits;
	            if (!$result) {
	                $errormessage = '<div class="alert alert-error">
	                                    <button class="close" data-dismiss="alert">×</button>
	                                    <strong>Error!</strong> Entry not updated.
	                                </div>'; 
	                $_SESSION['done-deal'] = $errormessage;
	              }else{
	              $_SESSION['done-deal'] = '<div class="alert alert-success">
	                        <button class="close" data-dismiss="alert">×</button>
	                        <strong>Success!</strong> Entry updated successfully.
	                    </div>';
	                }
	        } 
	          else{
	             $errormessage = '<div class="alert alert-warning">
	                                     <button class="close" data-dismiss="alert">×</button>
	                                     <strong>Warning!</strong> The Postal Address ('.$postal_address.') already exists. Try another!
	                                 </div>'; 
	                 $_SESSION['done-deal'] = $errormessage;
	        }
		}

		public function deleteAddress(){
			$query = "DELETE FROM address WHERE address_id = '".$_POST['delete_id']."'";
			$result = run_query($query);
			if($result){
				$_SESSION['done-deal'] = '<div class="alert alert-success">
						<button class="close" data-dismiss="alert">&times;</button>
						<strong>Success!</strong> The Address has been removed.
					</div>';
			}
		}

		public function getMasterfileData($mf_id){
			// $query =
		}

		public function getAllInsuarancePolicy(){
			$query = "SELECT gi.*, t.*, m.id_passport, m.mf_id, a.phone, extract(year FROM gi.start_date)::bigint as year, extract(month FROM gi.start_date) as month, extract(day FROM gi.start_date) as day FROM gtel_insurance gi 
			LEFT JOIN transactions t ON t.transaction_id = gi.transaction_id
			LEFT JOIN masterfile m ON m.mf_id = t.transacted_by
			LEFT JOIN address a ON a.mf_id = m.mf_id ";
			// var_dump($query); exit;
			return $result = run_query($query);
		}

		public function getInsuranceData($acc_id){
			$query = "SELECT * FROM gtel_insurance WHERE customer_account_id = '".$acc_id."'";
			if($result = run_query($query)){
				return get_row_data($result);
			}
		}

		public function getAllInsuaranceClaim($ins_id){
			$query = "SELECT ic.*, gt.insurance_id FROM customer_insurance_claim ic 
			LEFT JOIN gtel_insurance gt ON gt.insurance_id = ic.insurance_id
			WHERE ic.insurance_id = '".sanitizeVariable($ins_id)."' ";
			// var_dump($query); exit;
			return $result = run_query($query);
		}

		public function getCustomerNameFromInsId($ins_id){
			$query = "SELECT full_name, mf_id FROM customer_insurance WHERE insurance_id = '".sanitizeVariable($ins_id)."'";
			if($result = run_query($query)){
				return get_row_data($result);
			}
		}

		public function getAllMasterfileByBrole($b_role = null){
			$condition = (is_null($b_role)) ? '': "WHERE b_role = '".$b_role."'";

			$query = "SELECT *, CONCAT(surname,' ',firstname,' ',middlename) AS full_name FROM masterfile $condition";
			// var_dump($query);exit;
			return run_query($query);
		}

		public function createCustomerBill($bill_amount, $bill_date, $bill_status, $bill_amount_paid, $bill_balance, $mf_id, $service_channel_id, $service_account){
			$query = "INSERT INTO customer_bills(
		            bill_amount, 
		            bill_date, 
		            bill_status, 
		            bill_amount_paid, 
		            bill_balance, 
		            mf_id, 
		            service_channel_id, 
		            service_account)
   	 		VALUES ('".sanitizeVariable($bill_amount)."', 
	   	 			'".sanitizeVariable($bill_date)."', 
	   	 			'".sanitizeVariable($bill_status)."', 
	   	 			'".sanitizeVariable($bill_amount_paid)."', 
	   	 			'".sanitizeVariable($bill_balance)."', 
	            	'".sanitizeVariable($mf_id)."', 
	            	'".sanitizeVariable($service_channel_id)."', 
	            	'".sanitizeVariable($service_account)."'
            	) RETURNING bill_id";

            if($result = run_query($query)){
            	$rows = get_row_data($result);
            	return $rows['bill_id'];
            }else{
            	var_dump('Create Bill: '.$query.' '.get_last_error());exit;
            }
		}

		public function debitJournal($cash_paid, $dr_cr, $journal_type, $service_account, $particulars, $stamp, $customer){
			$query = "INSERT INTO journal(
            	amount, 
            	dr_cr, 
            	journal_type, 
            	service_account, 
            	particulars, 
            	stamp, 
            	customer)
   	 		VALUES ('".sanitizeVariable($amount)."', 
   	 			'DR', 
   	 			1, 
   	 			'".sanitizeVariable($service_account)."', 
   	 			'".sanitizeVariable($particulars)."', 
   	 			'".time()."', 
   	 			'".sanitizeVariable($customer)."')";
   	 		if(run_query($query)){
   	 			return true;
   	 		}else{
   	 			var_dump('Debit journal: '.get_last_error());exit;
   	 		}
		}

		public function getBillAmtFromServiceCode($service_code){
			$query = "SELECT price, service_channel_id FROM service_channels WHERE option_code = '".$service_code."'";
			if($result = run_query($query)){
				$num_rows = get_num_rows($result);
				if($num_rows >= 1){
					$rows = get_row_data($result);
					return $rows;
				}else{
					$_SESSION['done-deal'] = '<div class="alert alert-error">
                        <button class="close" data-dismiss="alert">×</button>
                        <strong>Error!</strong> There is no currently configured service option for the option code('.$service_code.'). Kindly do so in the Revenue Manager.
                    </div>';
                    App::redirectTo('?num=829');
				}
			}
		}

		public function getCustomerAccCode($customer_account_id){
			$query = "SELECT customer_code FROM customer_account WHERE customer_account_id = '".$customer_account_id."'";
			if($result = run_query($query)){
				$rows = get_row_data($result);
				return $rows['customer_code'];// becomes the service acount
			}
		}

		public function getPolicyTypeOptionCode($service_id){
			$query = "SELECT option_code FROM service_channels WHERE service_channel_id = '".$service_id."'";
			if($result = run_query($query)){
				if(get_num_rows($result)){
					$rows = get_row_data($result);
					return $rows['option_code'];
				}
			}
		}

		public function addPolicy(){
			//add the policy
			extract($_POST);
				// create customer bill which is to return bill id
					// first get the bill amount from service which is the price in service_channels table using the service option code
					$device_id = $this->getDeviceIDByCustomerAccountID($customer_account_id);
					$device_model_id = $this->getDeviceModelIDByDeviceID($device_id);
					$service_id = $this->getServiceIDByDeviceModelID($device_model_id);
					$insurance_policy = $service_id;
					$option_code = $this->getPolicyTypeOptionCode($insurance_policy); 
					if($option_code == gold){
						$bill_data = $this->getBillAmtFromServiceCode(gold);
					}elseif($option_code == platinum){
						$bill_data = $this->getBillAmtFromServiceCode(platinum);
					}
					// traceActivity($bill_data['price']);
					$customer_code = $this->getCustomerAccCode($customer_account_id);

					$bill_id = $this->createCustomerBill($bill_data['price'], date('Y-m-d'), 0, 0, $bill_data['price'], $customer, $bill_data['service_channel_id'], $customer_code);

					if($bill_id >= 1){
						// create debit journal
						$this->createJournal($bill_id, $bill_data['price'], 'DR', 1, $customer_code, '', time(), $customer);
					}

					// update the bill
					if($this->updateBillBalance($bill_id, $bill_data['price'], 0, 1)){
						// credit journal
						if($this->createJournal($bill_id, $bill_data['price'], 'DR', 1, $customer_code, 'For Insurance Policy', time(), $customer)){
							// create transaction
							$result = $this->addPayment($bill_data['price'], date('Y-m-d H:i:s'), $customer_code, $customer, $bill_id, $bill_data['service_channel_id'], '');
							if($result){
								$rows = get_row_data($result);
								$transaction_id = $rows['transaction_id'];

								// finally create the insurance policy for the phone
								if(!empty($customer_account_id)){


									if(is_numeric($transaction_id) && $transaction_id >= 1){
										$result = $this->createInsurancePolicy($insurance_policy, $insurance_term_in_years, $start_date, $customer_account_id, $transaction_id, $status);
						            	if($result){
						                	$_SESSION['done-deal'] = '<div class="alert alert-success">
						                        <button class="close" data-dismiss="alert">×</button>
						                        <strong>Success!</strong> New GTEL Insurance Policy was Added successfully.
						                    </div>';
						           	 	}
						           	}
						        }else{
						        	$_SESSION['done-deal'] = '<div class="alert alert-warning">
				                        <button class="close" data-dismiss="alert">×</button>
				                        <strong>Warning!</strong> You must select a phone.
				                    </div>';
						        }
							}
						}
					}

		}

		public function createInsurancePolicy($service_option, $insurance_term_in_years, $start_date, $customer_account_id, $transaction_id, $status){
			$query = "INSERT INTO gtel_insurance(insurance_term_in_years, start_date, customer_account_id, transaction_id, status, service_channel_id) 
            VALUES( 
            	'".sanitizeVariable($insurance_term_in_years)."', 
            	'".sanitizeVariable($start_date)."', 
            	'".sanitizeVariable($customer_account_id)."',
            	'".sanitizeVariable($transaction_id)."',
            	'".sanitizeVariable($status)."',
            	'".sanitizeVariable($service_option)."'
            	)";
            // var_dump($query);exit;
            if(run_query($query)){
            	return true;
            }else{
            	var_dump('Create Insurance Policy: '.$query.' '.get_last_error());exit;
            }
		}

		public function getCompanyName($mf_id){
			$query = "SELECT surname FROM masterfile WHERE mf_id = mf_id AND b_role = 'client_group' ";
			// var_dump($query); exit;
			if($result = run_query($query)){
				if(get_num_rows($result)){	
					$rows = get_row_data($result);
					return $rows['surname'];// title of the company
				}
			}
		}

		public function getCompanyNameByClient($mf_id){
			$query = "SELECT surname FROM masterfile WHERE mf_id = '".$mf_id."' AND b_role = 'client_group' ";
			// var_dump($query); exit;
			if($result = run_query($query)){
				if(get_num_rows($result)){	
					$rows = get_row_data($result);
					return $rows['surname'];// title of the company
				}
			}
		}

		public function getAllMasterfileByName($mf_id){
			$query = "SELECT *, CONCAT(surname,' ',firstname,' ',middlename) AS full_name FROM masterfile WHERE mf_id = '".$mf_id."' ";
			// var_dump($query);exit;
			$result = run_query($query);
			$rows = get_row_data($result);
			return $rows['full_name'];
		}

		public function createCustomerWallet($mf_id){
			$query = "INSERT INTO customer_file(mf_id, balance) VALUES('".sanitizeVariable($mf_id)."', 0)";
			if(run_query($query)){
				return true;
			}else{
				return false;
			}
		}

		public function addInsuranceClaim($mf_id){
			extract($_POST);
			// var_dump($_POST); exit;
		    if(!$this->checkForExistingClaim($case_type, $insurance_id)){
	            $query = "INSERT INTO customer_insurance_claim(insurance_id,
							claim_type,
							case_type,
							status,
							claim_date,
							description,
							claim_mf_id) 
                VALUES('".sanitizeVariable($insurance_id)."',
                		'".sanitizeVariable($claim_type)."',
                		'".sanitizeVariable($case_type)."',
                		'".sanitizeVariable($status)."',
                		'".sanitizeVariable($claim_date)."',
                		'".sanitizeVariable($description)."',
                		'".sanitizeVariable($mf_id)."')";
                		// var_dump($query); exit;
	            $result = run_query($query);

	            if (!$result) {
	                $errormessage = '<div class="alert alert-error">
	                                    <button class="close" data-dismiss="alert">&times;</button>
	                                    <strong>Error!</strong> Insurance Claim not added.
	                                </div>'; 
	                $_SESSION['done-deal'] = $errormessage;
	              }else{
	              $_SESSION['done-deal'] = '<div class="alert alert-success">
	                        <button class="close" data-dismiss="alert">&times;</button>
	                        <strong>Success!</strong> Insurance Claim added successfully.
	                    </div>';
	                }
	        } 
	          else{
	             $errormessage = '<div class="alert alert-warning">
	                                     <button class="close" data-dismiss="alert">&times;</button>
	                                     <strong>Warning!</strong> The Insurance Claim ('.$case_type.') had already been done!
	                                 </div>'; 
	                 $_SESSION['done-deal'] = $errormessage;
	        }
		}

		public function editInsuranceClaim(){
			extract($_POST);
			if(!$this->onEditcheckForExistingClaim($case_type, $insurance_id, 'claim_id', $_POST['edit_id'])){
				if(!$this->ifClaimisClosed($edit_id)){
					$query = "UPDATE customer_insurance_claim SET 
							claim_type = '".sanitizeVariable($claim_type)."',
							case_type = '".sanitizeVariable($case_type)."',
							status = '".sanitizeVariable($status)."',
							claim_date = '".sanitizeVariable($claim_date)."',
							description = '".sanitizeVariable($description)."'
	                    WHERE claim_id = '".$_POST['edit_id']."' ";

		            $result = run_query($query);
		            // var_dump($query); exits;
		            if (!$result) {
		                $errormessage = '<div class="alert alert-error">
		                                    <button class="close" data-dismiss="alert">&times;</button>
		                                    <strong>Error!</strong> Insurance Claim not updated.
		                                </div>'; 
		                $_SESSION['done-deal'] = $errormessage;
		              }else{
		              $_SESSION['done-deal'] = '<div class="alert alert-success">
		                        <button class="close" data-dismiss="alert">&times;	</button>
		                        <strong>Success!</strong> Insurance Claim updated successfully.
		                    </div>';
		                }
	            }else{
	            	$_SESSION['done-deal'] = '<div class="alert alert-warning">
		                        <button class="close" data-dismiss="alert">&times;	</button>
		                        <strong>Warning!</strong> Insurance Claim has already been closed!.
		                    </div>';
	            }
	        } 
	          else{
	             $errormessage = '<div class="alert alert-warning">
	                                     <button class="close" data-dismiss="alert">&times;</button>
	                                     <strong>Warning!</strong> The Insurance Claim ('.$case_type.') already exists. Try another!
	                                 </div>'; 
	                 $_SESSION['done-deal'] = $errormessage;
	        }
		}

		public function deleteInsuranceClaim(){
			$query = "DELETE FROM customer_insurance_claim WHERE claim_id = '".$_POST['delete_id']."'";
			$result = run_query($query);
			if($result){
				$_SESSION['done-deal'] = '<div class="alert alert-success">
						<button class="close" data-dismiss="alert">&times;</button>
						<strong>Success!</strong> The Insurance Claim has been successfully removed.
					</div>';
			}
		}

		public function checkForExistingClaim($case_type, $ins_id){
			$query = "SELECT * FROM customer_insurance_claim WHERE case_type = '".$case_type."' AND insurance_id = '".$ins_id."' AND case_type <> 'Third fix'";
			if($result = run_query($query)){
				if(get_num_rows($result)){
					return true;
				}else{
					return false;
				}
			}
		}

		public function onEditcheckForExistingClaim($case_type, $ins_id, $skip_column, $skip_id){
			$query = "SELECT * FROM customer_insurance_claim WHERE (case_type = '".$case_type."' AND insurance_id = '".$ins_id."' AND case_type <> 'Third fix') AND $skip_column <> '".$skip_id."'";
			if($result = run_query($query)){
				if(get_num_rows($result)){
					return true;
				}else{
					return false;
				}
			}
		}

		public function ifClaimisClosed($claim_id){
			$query = "SELECT status FROM customer_insurance_claim WHERE claim_id = '".$claim_id."'";
			if($result = run_query($query)){
				$rows = get_row_data($result);
				if($rows['status'] == 'f'){
					return true;
				}else{
					return false;
				}
			}
		}	

		public function getServiceIDByDeviceModelID($device_model_id){
		   $query = "SELECT service_id FROM gtel_device_model 
		       WHERE device_model_id = '".sanitizeVariable($device_model_id)."'";
		   traceActivity($query);
		   //var_dump('Get Pending Bills: '.$query.' '.get_last_error());exit;
		   if($result = run_query($query)){
		    $row = get_row_data($result);
		    return $row['service_id'];
		   }
		  }

		public function getDeviceModelIDByDeviceID($device_id){
		   $query = "SELECT device_model_id FROM gtel_device 
		       WHERE device_id = '".sanitizeVariable($device_id)."'";
		   traceActivity($query);
		   //var_dump('Get Pending Bills: '.$query.' '.get_last_error());exit;
		   if($result = run_query($query)){
		    $row = get_row_data($result);
		    return $row['device_model_id'];
		   }
		  }

		public function getDeviceIDByCustomerAccountID($account_code){
		   $query = "SELECT device_id FROM customer_account 
		       WHERE customer_account_id = '".sanitizeVariable($account_code)."'";
		   traceActivity($query);
		   //var_dump('Get Pending Bills: '.$query.' '.get_last_error());exit;
		   if($result = run_query($query)){
		    $row = get_row_data($result);
		    return $row['device_id'];
		   }
		}

		public function getGpayBalance($mf_id){
			if(!empty($mf_id)){
				$query = "SELECT balance FROM customer_file WHERE mf_id = '".$mf_id."'";
				$result = run_query($query);
				if($num_rows = get_num_rows($result)){
					$rows = get_row_data($result);
					return 'Ksh. '.number_format($rows['balance'], 2);
				}else{
					return '<i>Customer file(Gpay Wallet) does not exist for this customer</i>';
				}
			}
		}

		public function getCustomerAccCodeFromCustomerAccId($acc_id){
			if(!empty($acc_id)){
				$query = "SELECT customer_code FROM customer_account WHERE customer_account_id = '".sanitizeVariable($acc_id)."'";
				$result = run_query($query);
				$rows = get_row_data($result);
				return $rows['customer_code'];
			}
		}

		public function getCreditScoreValueByScoreCount($score_count = 0){
			$query = "SELECT * FROM credit_score_conf";
			if($result = run_query($query)){
				if(get_num_rows($result)){
					$score = '';
					while($rows = get_row_data($result)){
						// var_dump($rows);exit;
						$score = $this->getScoreName($rows['min'], $rows['max'], $score_count, $rows['credit_score_name']);
						if(!empty($score)){
							$score .= $score;
						}
					}
				}
			}
		}

		public function getCreditScoreCountFromMfid($mf_id){
			if(!empty($mf_id)){
				$query = "SELECT credit_score_count FROM customer_account_credit_score WHERE mf_id = '".$mf_id."'";
				if($result = run_query($query)){
					if(get_num_rows($result)){
						$rows = get_row_data($result);
						return $rows['credit_score_count'];
					}else{
						return 0;
					}
				}
			}
		}

		public function getScoreName($min, $max, $count, $score){
			// echo $min.' '.$max.' '.$count.' '.$score.'<br/>';
			if($count >= $min && $count <= $max){
				echo $score;
			}
		}

		public static function getCurrBizzRole($mf_id){
			if(!empty($mf_id)){	
				$query = "SELECT b_role FROM masterfile WHERE mf_id = '".$mf_id."'";
				$result = run_query($query);
				if($result){
					if(get_num_rows($result)){
						$rows = get_row_data($result);
						return $rows['b_role'];
					}else{
						return false;
					}
				}
			}
		}	


		public static function userLoginExists($mf_id){
			if (!empty($mf_id)) {
				$query = "SELECT * FROM user_login2 WHERE mf_id = '".$mf_id."' ";
				$result = run_query($query);
				// var_dump($query); exit;
				if ($result) {
					if(get_num_rows($result)){
						return true;
					}else{
						return false;
					}
				}
			}
		}

		public function editBussrole(){
			extract($_POST);
			if ($b_role =='staff') {
				if (!$this->userLoginExists($mf_id)) {
					$create_login = $this->addLoginAccount($mf_id);
				}else{
					if(self::activateLoginAccount($mf_id)){
						return true;
					}else{
						return false;
					}
				}
			}else if ($b_role == 'client') {
				if(self::blockAccount($mf_id)){
					return true;
				}else{
					return false;
				}
			}else if($b_role == 'client_group'){
				if(self::blockAccount($mf_id)){
				return true;
				}else{
					return false;
				}
			}
		}

		public function addLoginAccount($mf_id){
			extract($_POST);
			
			$pass_hashy = sha1(123456);
			$user_role = (isset($user_role) && !empty($user_role)) ? $user_role : 'NULL'; 
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

		public static function blockAccount($mf_id){
			$query = "UPDATE user_login2 SET user_active = '0' WHERE mf_id = '".$mf_id."' ";
			if(run_query($query)){
				return true;
			}else{
				return false;
			}			
		}

		public static function activateLoginAccount($mf_id){
			$query = "UPDATE user_login2 SET user_active = '1' WHERE mf_id = '".$mf_id."' ";
			if(run_query($query)){
				return true;
			}else{
				return false;
			}
		}

		public function getAllUserRole(){
			$query = "SELECT role_name FROM user_roles ";
			var_dump($query);exit;
			return $result = run_query($query);
		}

		public function blockUser($mf_id){
			$query = "UPDATE user_login2 SET user_active = '0', status = '0' WHERE mf_id = '".$mf_id."'";
			if(run_query($query)){
				return true;
			}else{
				return false;
			}
		}

		public function getAllCustomerAccCodesAndIds($mf_id){
			$acc_data = array();

			$query = "SELECT customer_account_id, customer_code FROM customer_account WHERE mf_id = '".$mf_id."'";
			if($result = run_query($query)){
				if(get_num_rows($result)){
					while($rows = get_row_data($result)){
						$acc_data[] = $rows;
					}
					return $acc_data;
				}
			}
		}

		public function disableCustomerAccountRecords($mf_id){
			extract($_POST);
			$query1 = "UPDATE customer_account SET status = '0' WHERE mf_id = '".$mf_id."'";
			if(run_query($query1)){
				$acc_data  = $this->getAllCustomerAccCodesAndIds($mf_id);
				if(count($acc_data)){
					$count = 1;
					foreach ($acc_data as $account) {
						$query2 = "UPDATE gtel_insurance SET status = '0' WHERE customer_account_id = '".$account['customer_account_id']."'";
						if(run_query($query2)){
							$query3 = "UPDATE customer_billing_file SET status = '0' WHERE customer_account_code = '".$account['customer_code']."'";
							if(run_query($query3)){
								$query4 = "UPDATE journal SET status = '0' WHERE service_account = '".$account['customer_code']."'";
								if(run_query($query4)){
									$query5 = "UPDATE customer_bills SET bill_status = '2' WHERE service_account = '".$account['customer_code']."'";
									if(run_query($query5)){
										$_SESSION['done-deal'] = '<div class="alert alert-success">
					                        <button class="close" data-dismiss="alert">×</button>
					                        <strong>Success!</strong> Masterfile has been deleted!.
					                    </div>';
					                    App::redirectTo('index.php?num=801&mf_id='.$mf_id);
									}
								}
							}
						}
						$count++;
					}
					var_dump($count);die();
				}else{
					$_SESSION['done-deal'] = '<div class="alert alert-success">
                        <button class="close" data-dismiss="alert">×</button>
                        <strong>Success!</strong> Masterfile has been deleted!.
                    </div>';
                    App::redirectTo('index.php?num=801&mf_id='.$mf_id);
				}
			}
		}

		public function deleteMasterfile(){
			if(!empty($_POST['delete_id'])){
				$query = "DELETE FROM masterfile WHERE mf_id = '".$_POST['delete_id']."'";
				if(run_query($query)){
					$_SESSION['done-deal'] = '<div class="alert alert-success">
                        <button class="close" data-dismiss="alert">×</button>
                        <strong>Success!</strong> Masterfile has been permanently deleted!.
                    </div>';
				}else{
					var_dump(get_last_error());exit;
				}
			}
		}

		public function getPolicyType(){
			$query = "SELECT sc.service_channel_id, sc.service_option FROM service_channels sc
			WHERE option_code = '".platinum."' OR option_code = '".gold."'";
			if($result = run_query($query)){
				return $result;
			}else{
				return false;
			}
		}

		public function getUser($mf_id){
			$query = "SELECT CONCAT(surname,' ',firstname,' ',middlename) AS full_name FROM masterfile WHERE mf_id = '".$mf_id."'";
			if($result = run_query($query)){
				if(get_num_rows($result)){
					$rows = get_row_data($result);
					return $rows['full_name'];
				}
			}
		}

		public function getAmountPaidSoFarForPhone($acc_code){
			$query = "select SUM(cash_paid) as amount_paid_so_far from transactions where service_account = '".$acc_code."'";
			if($result = run_query($query)){
				if(get_num_rows($result)){
					$rows = get_row_data($result);
					return (!is_null($rows['amount_paid_so_far'])) ? $rows['amount_paid_so_far'] : 0;
				}else{
					return 0;
				}
			}
		}

		public function getLoanAmount($model_id){
			$query = "SELECT * FROM service_bills_and_options WHERE product_id = '".sanitizeVariable($model_id)."'";
			if($result = run_query($query)){
				if(get_num_rows($result)){
					$rows = get_row_data($result);
					return $rows['loan_amount'];
				}else{
					return 'No configured Bill for this model!';
				}
			}
		}

		public function calculateLoanBalance($loan_amount, $cash_paid){
			if(is_numeric($loan_amount) && is_numeric($cash_paid)){	
				$loan_balance = $loan_amount - $cash_paid;
				return $loan_balance;
			}
		}

		public function getAccountDetails($acc_id){
			$query = "SELECT * FROM customers_and_accounts
			WHERE customer_account_id = '".sanitizeVariable($acc_id)."'";
			if($result = run_query($query)){
				if(get_num_rows($result)){
					return get_row_data($result);
				}
			}
		}

		public function getPolicyTypeServiceId($model_id){
		if(!empty($model_id)){
			$query = "SELECT gdm.service_id, sc.service_option FROM gtel_device_model gdm
			LEFT JOIN service_channels sc ON sc.service_channel_id = gdm.service_id
			WHERE device_model_id = '".$model_id."'";
			// var_dump($query);exit;
			if($result = pg_query($query)){
				if(pg_num_rows($result)){
					return pg_fetch_assoc($result);
				}
			}
		}
	}
}


				