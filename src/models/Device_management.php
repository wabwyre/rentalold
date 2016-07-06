<?php
	include_once('src/models/Broadcast.php');

	class DeviceManagement extends Broadcast{
		public function getAllPhones(){
			$query = "SELECT gd.*,gdm.*,ca.*, CONCAT(m.surname,' ',m.firstname,' ',m.middlename) AS customer_name FROM gtel_device gd
             LEFT JOIN gtel_device_model gdm ON gdm.device_model_id = gd.device_model_id
             LEFT JOIN customer_account ca ON ca.device_id = gd.device_id
             LEFT JOIN masterfile m ON m.mf_id = ca.mf_id
             WHERE ca.status IS TRUE
             ";
			return $result = run_query($query);
		}

        public function getAllInactiveAccounts(){
            $query = "SELECT * from devices_and_customer_accounts WHERE status IS NOT TRUE";
            return $result = run_query($query);
        }

		public function getReferee($referee_mf_id){
			if(!empty($referee_mf_id)){
				$query = "SELECT CONCAT(m.surname,' ',m.firstname) AS referee FROM referrals r 
				LEFT JOIN masterfile m ON m.mf_id = r.referee_mf_id
				WHERE referee_mf_id = '".$referee_mf_id."'";
				$result = run_query($query);
				$rows = get_row_data($result);
				return $rows['referee'];
			}else{
				return '';
			}
		}

		public function addPhone(){
			$date = date('Y-m-d');
			$date_time = date('Y-m-d H:i:s');

			//add the device
			extract($_POST);
			if(!checkForExistingEntry('gtel_device', 'imei', $_POST['imei'])){
				if(checkForExistingEntry('customer_account', 'customer_code', $customer_code)){
			    	$_SESSION['phone'] = '<div class="alert alert-warning">
		                <button class="close" data-dismiss="alert">&times;</button>
		                <strong>Warning!</strong> The customer code('.$customer_code.') already exists.
		            </div>';
			    }elseif($referee == $customer){
			    	$_SESSION['phone'] = '<div class="alert alert-warning">
		                <button class="close" data-dismiss="alert">&times;</button>
		                <strong>Warning!</strong> The Customer and Referee cannot be the same!
		            </div>';
			    }else{
		            //var_dump($_POST);exit;
		            // run_query('BEGIN TRANSACTION;');
		            $query = "INSERT INTO gtel_device(device_model_id, imei) 
		            VALUES('".sanitizeVariable($model_id)."','".sanitizeVariable($imei)."')RETURNING device_id";
		            // var_dump($query);exit;
		            $result = run_query($query);
		            if($result){
					    $data = get_row_data($result);
					    if($this->createCustomerAccount($data['device_id'], $repayment_due_date)){
					    	$bill_date = date('Y-m-d');
							// get service bill details
							$serv_bill_details = $this->getServiceBill($model_id);
							$billing_result = $this->addToBillingFile($customer_code, $serv_bill_details['bill_interval'],
				            $serv_bill_details['amount'], $serv_bill_details['amount'],
				            $serv_bill_details['revenue_bill_id'], $bill_date);
				            $billing_array = get_row_data($billing_result);			
				            $nxt_mth = date('m') + 1;
				            $customer_bill_due_date = date('Y-'.$nxt_mth.'-d');

				            if($billing_array['billing_file_id'] >= 1){
				            	$bill_result = $this->createBill($customer_bill_due_date, $serv_bill_details['amount'], $bill_date, 0, 0, $serv_bill_details['amount'], $billing_array['billing_file_id'], $customer_code, $customer, $serv_bill_details['service_channel_id']);

				            	if($bill_result){
				            		$journal_result = $this->recordJournalDebit($customer, $serv_bill_details['amount'], $customer_code, 'Monthly Loan Repayment Bill');
				            		if($journal_result){
				            			$_SESSION['phone'] = '<div class="alert alert-success">
					                        <button class="close" data-dismiss="alert">×</button>
					                        <strong>Success!</strong>The New Phone was Added successfully.
					                    </div>';
					                    // run_query('END TRANSACTION;');
				            		}
				            	}
				            }
						}
					}
				}
	        }else{
		        $_SESSION['phone'] = '<div class="alert alert-warning">
	                <button class="close" data-dismiss="alert">&times;</button>
	                <strong>Warning!</strong> The IMEI Number ('.$_POST['imei'].') already exists.
	            </div>';
	        }
		}

		public function createCustomerAccount($device, $repayment_due_day){
			$curr_month = date('m');
			$next_month = $curr_month + 1;

			// $next_payment_date = date('Y-0'.$next_month.'-0'.$repayment_due_day);

			extract($_POST);
			$referee = (!empty($referee)) ? $referee : 'NULL';
			// var_dump($_POST);exit;
		    $query = "INSERT INTO customer_account(mf_id, device_id,issued_phone_number, customer_code, referee_mf_id, repayment_date) 
	        VALUES('".sanitizeVariable($customer)."','".sanitizeVariable($device)."',
	        	'".sanitizeVariable($issued_phone)."', '".sanitizeVariable($customer_code)."', 
	        	".sanitizeVariable($referee).", '".sanitizeVariable($repayment_due_day)."')";
	        // var_dump($query);exit;
	        $result = run_query($query);
	        if($result){
	        	return $result;
	        }else{
	        	var_dump('Create Customer Account: '.get_last_error());exit;
	        }
		}

		public function editPhone(){
            extract($_POST);

            //update the Pos Device
            $query = "UPDATE customer_account 
            SET issued_phone_number = '".sanitizeVariable($issued_phone)."'
            WHERE customer_account_id = '".$edit_id."'";

            if($result = run_query($query)){
                $device_id = $this->getDeviceId($edit_id);
                $query = "UPDATE gtel_device SET imei = '".sanitizeVariable($imei)."' 
                WHERE device_id = '".$device_id."'";

                if(!onEditCheckForExistingEntry('gtel_device', 'imei', $_POST['imei'], 'device_id', $device_id)) {
                    if (run_query($query)) {
                        $this->flashMessage('phone', 'alert alert-success', 'Success', 'Customer Account has been updated');
                    }
                }else{
                    $this->flashMessage('phone', 'alert alert-warning', 'Warning', 'The IMEI Number ('.$_POST['imei'].') already exists.');
                }
            }
		}

        public function getDeviceId($customer_account_id){
            if(!empty($customer_account_id)) {
                $query = "SELECT device_id FROM customer_account WHERE customer_account_id = '" . $customer_account_id . "'";
                if ($result = run_query($query)) {
                    if (get_num_rows($result)) {
                        $rows = get_row_data($result);
                        return $rows['device_id'];
                    }
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }

		public function checkDeleteModel($device){
			$query = "SELECT * FROM customer_account 
			WHERE device_id = '".sanitizeVariable($device)."' 
			";
			// var_dump($query);exit;
			$result = run_query($query);
			$num_rows = get_num_rows($result);
			return ($num_rows > 0) ? true: false;

	    }

		public function deletePhone()
        {
            extract($_POST);
            $customer_code = $this->getCustomerCodeFromCustomerAccountId($delete_id);

            $query1 = "UPDATE customer_account SET status = '0' WHERE customer_account_id = '" . $delete_id . "' RETURNING device_id";
            if($result = run_query($query1)){
                $query2 = "UPDATE gtel_insurance SET status = '0' WHERE customer_account_id = '" . $delete_id . "'";
                if(run_query($query2)){
                    $query3 = "UPDATE customer_billing_file SET status = '0' WHERE customer_account_code = '" . $customer_code . "'";
                    if(run_query($query3)){
                        $query4 = "UPDATE journal SET status = '0' WHERE service_account = '" . $customer_code . "'";
                        if(run_query($query4)){
                            $query5 = "UPDATE customer_bills SET bill_status = '2' 
                                      WHERE service_account = '".$customer_code."'";
                            if(run_query($query5)){
								// send push notification to customer account
								$body = "Dear Customer, \n";
								$body .= 'Your Customer Account has been deleted.';
								$subject = 'Account Removal';
								$recipient = $delete_id;
								$mess_type_id = $this->getMessageTypeFromMessageTypeCode('PUSH_NOTIFICATION');
								if($result = $this->addMessage($body, $subject, $_SESSION['mf_id'], $recipient, $mess_type_id)){
									$rows = get_row_data($result);
									if($this->addToCustomerMessage($delete_id, $rows['message_id'])){
										$this->flashMessage('phone', 'alert alert-success', 'Success', 'The Customer Account has been removed');
									}
								}
                            }
                        }
                    }
                }
            }
		}

		public function getMessageTypeFromMessageTypeCode($type_code){
			if(!empty($type_code)){
				$query = "SELECT message_type_id FROM message_type WHERE message_type_code = '".$type_code."'";
				if($result = run_query($query)){
					if(get_num_rows($result)){
						$rows = get_row_data($result);
						return $rows['message_type_id'];
					}
				}else{
					var_dump($query.get_last_error());exit;
				}
			}
		}

	public function addMessage($body, $subject, $sender, $recipients, $message_type_id){
		$query = "INSERT INTO public.message(
            body, 
            subject, 
            sender, 
            recipients, 
            message_type_id,
            status)
			VALUES (
			'".sanitizeVariable($body)."', 
			'".sanitizeVariable($subject)."', 
			'".sanitizeVariable($sender)."', 
			array[$recipients],
			array[$message_type_id],
			0) RETURNING message_id";
		if($result = run_query($query)){
			return $result;
		}else{
			var_dump($query.get_last_error());exit;
		}
	}

    public static function splash($name){
        if(isset($_SESSION[$name])){
            echo $_SESSION[$name];
            unset($_SESSION[$name]);
        }
    }

    public static function createSession($name, $value){
        return $_SESSION[$name] = $value;
    }

        public function getCustomerCodeFromCustomerAccountId($customer_account_id){
            if(!empty($customer_account_id)) {
                $query = "SELECT customer_code FROM customer_account 
                WHERE customer_account_id = '" . $customer_account_id . "'";
                $result = run_query($query);
                if ($result) {
                    if (get_num_rows($result)) {
                        $rows = get_row_data($result);
                        return $rows ['customer_code'];
                    }
                }
            }else{
                return false;
            }
        }

		public function getAllDevices(){
			$query = "SELECT * FROM gtel_device_model";
			//var_dump($query);exit;
			$result = run_query($query);
			return $result;
		}

		public function getAllDevicesGroups(){
			$query = "SELECT * FROM attributes";
			//var_dump($query);exit;
			$result = run_query($query);
			return $result;
		}

		public function addAttribute(){
			//add the device
			extract($_POST);
			//var_dump($_POST);exit;
			if(!checkForExistingEntry('attributes', 'name', $_POST['name'])){
	            //var_dump($_POST);exit;
	            $query = "INSERT INTO attributes(name) 
	            VALUES('".sanitizeVariable($name)."')";
	            //var_dump($query);exit;
	            $result = run_query($query);
	            if($result){
	                $_SESSION['devices'] = '<div class="alert alert-success">
	                        <button class="close" data-dismiss="alert">×</button>
	                        <strong>Success!</strong>The New Attribute was Added successfully.
	                    </div>';
	            }
	        }else{
		        $_SESSION['devices'] = '<div class="alert alert-warning">
		                <button class="close" data-dismiss="alert">&times;</button>
		                <strong>Warning!</strong> The Attribute Name ('.$_POST['name'].') already exists.
		            </div>';
	        }
		}

		public function editAttribute(){
			        extract($_POST);
					//update the attribute name
			if(!onEditcheckForExistingEntry('attributes', 'name', $_POST['name'], 'attribute_id', $_POST['edit_id'])){
            $query = "UPDATE attributes SET name = '".sanitizeVariable($name)."'
                       WHERE attribute_id = '".$edit_id."'";
                    //var_dump($query);exit;
                    $result = run_query($query);
                    if($result){
                        $_SESSION['devices'] = '<div class="alert alert-success">
                                <button class="close" data-dismiss="alert">×</button>
                                <strong>Success!</strong> The Attribute Name was Updated successfully.
                            </div>';
                    }
            }else{
	            $_SESSION['devices'] = '<div class="alert alert-warning">
	                <button class="close" data-dismiss="alert">&times;</button>
	                <strong>Warning!</strong> The Attribute Name ('.$_POST['name'].') already exists.
	            </div>';
            }
		}

		public function checkDeleteAttribute($attribute_id){
		$query = "SELECT * FROM gtel_device_models_attributes 
		WHERE attribute_id = '".sanitizeVariable($attribute_id)."' 
		";
		// var_dump($query);exit;
		$result = run_query($query);
		$num_rows = get_num_rows($result);
		return ($num_rows > 0) ? true: false;

	}

		public function deleteAttribute(){
			extract($_POST);
			$data = $this->checkDeleteAttribute($_POST['delete_id']);
			if(!$data){
				$query = "DELETE FROM attributes WHERE attribute_id = '".$_POST['delete_id']."'";
			$result = run_query($query);
				if($result){
					$_SESSION['devices'] = '<div class="alert alert-success">
							<button class="close" data-dismiss="alert">×</button>
							<strong>Success!</strong> The Attribute has been removed.
						</div>';
				
			    }
			}else{
					$_SESSION['devices'] = '<div class="alert alert-warning">
							<button class="close" data-dismiss="alert">×</button>
							<strong>Warning!</strong> You cannot delete the attribute name? its in use.
						</div>';
				}
			
		}

		public function getDeviceName(){
			$query = "SELECT * FROM gtel_device_model gdm
			INNER JOIN revenue_service_bill rsb ON rsb.product_id = gdm.device_model_id";
			return $result = run_query($query);
		}

		public function addDevice(){
			//add the device
			extract($_POST);
			if(!checkForExistingEntry('gtel_device_model', 'model', $model_name)){
	            // var_dump($_POST);exit;
	            $query = "INSERT INTO gtel_device_model(model,service_id) 
	            VALUES('".sanitizeVariable($model_name)."','".sanitizeVariable($insurance_policy)."')";
	            // var_dump($query);exit;
	            $result = run_query($query);
	            if($result){
	                $_SESSION['devices'] = '<div class="alert alert-success">
	                        <button class="close" data-dismiss="alert">×</button>
	                        <strong>Success!</strong> New GTEL Model was Added successfully.
	                    </div>';
	            }
	        }else{
		        $_SESSION['devices'] = '<div class="alert alert-warning">
		                <button class="close" data-dismiss="alert">&times;</button>
		                <strong>Warning!</strong> The GTEL Model ('.$model_name.') already exists.
		            </div>';
	        }
		}

		public function editDevice(){
					//update Phone type
			extract($_POST);
			if(!onEditcheckForExistingEntry('gtel_device_model', 'model', $model, 'device_model_id', $edit_id)){
	            $query = "UPDATE gtel_device_model SET model = '".sanitizeVariable($model)."',
	                       service_id = '".sanitizeVariable($insurance_policy)."'
	                    WHERE device_model_id = '".$edit_id."'";
	                    //var_dump($query);exit;
	                    $result = run_query($query);
	                    if($result){
	                        $_SESSION['devices'] = '<div class="alert alert-success">
	                                <button class="close" data-dismiss="alert">×</button>
	                                <strong>Success!</strong> The GTEL Model was Updated successfully.
	                            </div>';
	                    }
            }else{
                $_SESSION['devices'] = '<div class="alert alert-warning">
                    <button class="close" data-dismiss="alert">&times;</button>
                    <strong>Warning!</strong> The GTEL Model ('.$model.') already exists.
                </div>';
            }
		}

		public function checkDeleteModelType($model){
			$query = "SELECT * FROM gtel_device 
			WHERE device_model_id = '".sanitizeVariable($model)."' 
			";
			// var_dump($query);exit;
			$result = run_query($query);
			$num_rows = get_num_rows($result);
			return ($num_rows > 0) ? true: false;

	    }

		public function deleteDevice(){
			$data = $this->checkDeleteModelType($_POST['delete_id']);
			if(!$data){
				$query = "DELETE FROM gtel_device_model WHERE device_model_id = '".$_POST['delete_id']."'";
				$result = run_query($query);
				if($result){
					$_SESSION['devices'] = '<div class="alert alert-success">
							<button class="close" data-dismiss="alert">×</button>
							<strong>Success!</strong> The GTEL Model has been removed.
						</div>';
				}
			}else{
                $_SESSION['devices'] = '<div class="alert alert-warning">
                        <button class="close" data-dismiss="alert">×</button>
                        <strong>Warning!</strong> You cannot delete the GTEL Model? its in use.
                    </div>';
            }
		}

        public function createFeedback($name = '', $config = array()){
            $class = $config['class'];
            $message_title = $config['message_title'];
            $message = $config['message'];

            return $_SESSION[$name] = '<div class="'.$class.'">
            <button class="close" data-dismiss="alert">&times;</button>
            <strong>'.$message_title.'</strong> '.$message.'</div>';
        }

        public function flashMessage($name, $class, $message_title, $message){
            $config = array(
                'class' => $class,
                'message_title' => $message_title,
                'message' => $message
            );
            $this->createFeedback($name, $config);
        }

	public function listAllDevices($filter_key){
		$condition = (!empty($filter_key)) ? "WHERE imei_number = '".sanitizeVariable($filter_key)."'" : '';
		$query = "SELECT pl.*, ptl.model_name, CONCAT(m.surname,' ',m.firstname,' ',m.middlename) AS customer_name FROM phone_list pl
		LEFT JOIN phone_type_list ptl ON ptl.model_id = pl.model_id
		LEFT JOIN masterfile m ON m.mf_id = pl.customer_mf_id
		$condition";
		return $result = run_query($query);
	}

	public function getAllIMEIs(){
		$query = "SELECT pl.*, ptl.model_name FROM phone_list pl
		LEFT JOIN phone_type_list ptl ON ptl.model_id = pl.model_id";
		return $result = run_query($query);
	}

	public function getAllCustomers(){
		$query = "SELECT m.*, CONCAT(m.surname,' ',m.firstname,' ',m.middlename) AS customer_name FROM masterfile m WHERE b_role = 'client'";
		// var_dump($query);exit;
		return $result = run_query($query);
	}

	public function attachDevice(){
		extract($_POST);
		if(!empty($customer) && !empty($device_id) && is_numeric($device_id)){
			$query = "UPDATE phone_list SET customer_mf_id = '".sanitizeVariable($customer)."', status = '1' WHERE phone_id = '".sanitizeVariable($device_id)."'";
			// var_dump($customer);exit;
			if(run_query($query)){
				$_SESSION['devices'] = '<div class="alert alert-success">
							<button class="close" data-dismiss="alert">×</button>
							<strong>Success!</strong> Device has been successfully attached.
						</div>';
			}else{
				$_SESSION['devices'] = get_last_error();
			}
		}else{
			$_SESSION['devices'] = '<div class="alert alert-warning">
						<button class="close" data-dismiss="alert">×</button>
						<strong>Warning!</strong> Invalid form data. Please try again!
					</div>';
		}
	}

	public function listAllAttributes(){
		$query = "SELECT * FROM attributes";
		//var_dump($query);exit;
		return run_query($query);
	}
        
       public function checkIfModelAttributeisAttached($model,$attribute){
		$query = "SELECT * FROM gtel_device_models_attributes 
		WHERE device_model_id = '".sanitizeVariable($model)."' AND attribute_id = '".sanitizeVariable($attribute)."' 
		";
		//var_dump($query);exit;
		$result = run_query($query);
		$num_rows = get_num_rows($result);
		if($num_rows == 1){
			return true;
		}
	}

	public function checkifPhoneisIssued($phone){
		$query = "SELECT * FROM phone_list WHERE phone_id = '".sanitizeVariable($phone)."'";
		// var_dump($query);exit;
		$result = run_query($query);
		$rows = get_row_data($result);
		if($rows['status'] == 1){
			return true;
		}else{
			return false;
		}
	}

	public function getDeviceDetails($phone_id){
		$query = "SELECT pl.*, ptl.model_name FROM phone_list pl
		LEFT JOIN phone_type_list ptl ON ptl.model_id = pl.model_id
		WHERE phone_id = '".sanitizeVariable($phone_id)."'";
		$result = run_query($query);
		return get_row_data($result);
	}

	public function getDeviceApps($phone_id){
		$query = "SELECT da.*, pa.app_name FROM device_apps da
		LEFT JOIN phone_apps pa ON pa.app_id = da.app_id
		WHERE phone_id = '".$phone_id."'";
		return run_query($query);
	}

	public function manageDeviceApps(){
		//loop through all the apps in the device first
		$result = $this->getDeviceApps($_POST['device_id']);
		while ($rows = get_row_data($result)) {
			$device_app_id = $rows['device_app_id'];

			// check if an up has been checked/unchecked
			if(isset($_POST['status'.$device_app_id])){
				//update the status to active
				(isset($_POST['edit_id'.$device_app_id])) ? $this->setStatusTrue($_POST['edit_id'.$device_app_id]) : '';
			}else{
				//update the status to inactive
				(isset($_POST['edit_id'.$device_app_id])) ? $this->setStatusFalse($_POST['edit_id'.$device_app_id]) : '';
			}
		}
	}

	public function setStatusTrue($device_app_id){
		if(!empty($device_app_id)){
			$query = "UPDATE device_apps SET active = '1' WHERE device_app_id = '".sanitizeVariable($device_app_id)."'";
			if(run_query($query)){
				$_SESSION['manage_apps'] = '<div class="alert alert-success">
							<button class="close" data-dismiss="alert">×</button>
							<strong>Success!</strong> The changes have been saved.
						</div>';
	 		}
	 	}
	}

	public function setStatusFalse($device_app_id){
		if(!empty($device_app_id)){
			$query = "UPDATE device_apps SET active = '0' WHERE device_app_id = '".sanitizeVariable($device_app_id)."'";
			// var_dump($query);exit;
			if(run_query($query)){
				$_SESSION['manage_apps'] = '<div class="alert alert-success">
							<button class="close" data-dismiss="alert">×</button>
							<strong>Success!</strong> The changes have been saved.
						</div>';
	 		}
	 	}
	}

	public function getallModelAttributes($model){
		$query = "SELECT gdma.*, gdm.*, a.* FROM gtel_device_models_attributes gdma 
		LEFT JOIN gtel_device_model gdm ON gdm.device_model_id = gdma.device_model_id
		LEFT JOIN attributes a ON a.attribute_id = gdma.attribute_id 
		WHERE gdma.device_model_id = '".sanitizeVariable($model)."' ";
		$result = run_query($query);
		return $result;
	}

	public function getModelDetails($model){
		$query = "SELECT * FROM gtel_device_model WHERE device_model_id = '".sanitizeVariable($model)."'";
		$result = run_query($query);
		return $rows = get_row_data($result);
	}

	public function getGroupDevicesApps(){
		$query = "SELECT pa.*, da.* FROM device_apps da
		LEFT JOIN phone_apps pa ON pa.app_id = da.app_id";
		// var_dump($query);exit;
		return $result = run_query($query);
	}

	public function getActiveGroupDevicesApps($group_id){
		$query = "SELECT dga.*, da.*, pa.app_name FROM phone_apps dga
		LEFT JOIN device_apps da ON da.app_id = dga.app_id
		LEFT JOIN device_group_app_allocations pa ON pa.app_id = dga.app_id
		WHERE group_id = '".$group_id."' AND active IS TRUE";
		// var_dump($query);exit;
		return $result = run_query($query);
	}

	public function addModelAttribute(){
			//add the device
			extract($_POST);
			//var_dump($_POST);exit;
			if(!checkForExistingData('gtel_device_models_attributes', 'attribute_id', $attribute_id, 'attribute_value', $attribute_value, 'device_model_id', $device_model_id)){
	            //var_dump($_POST);exit;
	            $query = "INSERT INTO gtel_device_models_attributes(device_model_id, attribute_id, attribute_value) 
	            VALUES('".sanitizeVariable($device_model_id)."','".sanitizeVariable($attribute_id)."',
	            	'".sanitizeVariable($value)."')";
	         // var_dump($query);exit;
	            $result = run_query($query);
	            if($result){
	                $_SESSION['model'] = '<div class="alert alert-success">
	                        <button class="close" data-dismiss="alert">×</button>
	                        <strong>Success!</strong>The Model Attribute was Added Successfully.
	                    </div>';
	            }
	        }else{
		        $_SESSION['model'] = '<div class="alert alert-warning">
		                <button class="close" data-dismiss="alert">&times;</button>
		                <strong>Warning!</strong> The Attribute id('.$_POST['attribute_id'].') already exists.
		            </div>';
	        }
		}

	public function editModelAttribute(){
		extract($_POST);
			if(!onEditcheckForExistingEntry('gtel_device_models_attributes', 'attribute_value', $attribute_value, 'attribute_id', $edit_id)){
	            $query = "UPDATE gtel_device_models_attributes SET attribute_value = '".sanitizeVariable($attribute_value)."'
	                    WHERE attribute_id = '".$edit_id."'";
	                    //var_dump($query);exit;
	                    $result = run_query($query);
	                    if($result){
	                        $_SESSION['model'] = '<div class="alert alert-success">
	                                <button class="close" data-dismiss="alert">×</button>
	                                <strong>Success!</strong> The GTEL Model Attribute was Updated successfully.
	                            </div>';
	                    }
            }else{
                $_SESSION['model'] = '<div class="alert alert-warning">
                    <button class="close" data-dismiss="alert">&times;</button>
                    <strong>Warning!</strong> The GTEL Model Attribute ('.$attribute_value.') already exists.
                </div>';
            }
	}

	public function activateAppsForAllGroupDevices(){
		//loop through all the apps in the device first
		//$result = $this->getGroupDevicesApps();
		$_SESSION['err'] ="";
		$total_apps = $_POST['total_apps'];
		$count = 1;
		while ($count <= $total_apps){//$rows = get_row_data($result)) {
			
			$curr_box = "status".$count;
			if(isset($_POST["edit_id".$count])){
				$curr_app_id = "edit_id".$count;
			}
			// check if an up has been checked/unchecked
			if(isset($_POST[$curr_box])){
				// var_dump('checked');exit;
				//add device group app allocation
				if($this->activateGroupDeviceApps($_POST[$curr_app_id], $_POST['group_id'])){
					//update the status to active for all the device in the selected group
					if(!$this->checkForExistingGroupApp($_POST['group_id'], $_POST[$curr_app_id])){
						$this->addGroupAppAllocation($_POST['group_id'], $_POST[$curr_app_id]);
					}
				}
			}else{
				if(isset($_POST["edit_id".$count])){
					if($this->removeGroupAppAllocation($_POST['group_id'], $_POST[$curr_app_id])){
						//update the status to inactive for all the device in the selected group
						$this->deactivateGroupDeviceApps($_POST[$curr_app_id], $_POST['group_id']);
					}
				}
			}
			/*}else{
				if($this->removeGroupAppAllocation($_POST['group_id'], $rows['app_id'])){
					//update the status to inactive for all the device in the selected group
					$this->deactivateGroupDeviceApps($_POST['edit_id'.$device_app_id], $_POST['group_id']);
				}else{
					var_dump(get_last_error());exit;
				}
			}*/
			$count++;
		}
	}

	public function getGroupDeviceIds($group_id){
		$return = '';
		$query = "SELECT * FROM device_group_allocations WHERE group_id = '".sanitizeVariable($group_id)."'";
		// var_dump($query);exit;
		$result = run_query($query);
		if($result){
			return $result;
		}
	}

	public function activateGroupDeviceApps($app_id, $group_id){
		$phone_ids = '';
		$result = $this->getGroupDeviceIds($group_id);
		while ($rows = get_row_data($result)) {
			$phone_ids .= $rows['phone_id'].',';
		}
		$phone_ids = rtrim($phone_ids, ',');

		$query = "UPDATE device_apps SET active = '1' WHERE phone_id IN ($phone_ids) AND app_id = '".$app_id."'";
		if(run_query($query)){
			return true;
		}
		// var_dump($query);exit;
	}

	public function deactivateGroupDeviceApps($app_id, $group_id){
		$result = $this->getGroupDeviceIds($group_id);
		while ($rows = get_row_data($result)) {
			// var_dump($rows);exit;
			$query = "UPDATE device_apps SET active = '0' WHERE phone_id = '".$rows['phone_id']."' AND app_id = '".$app_id."'";
			// var_dump($query);exit;
			if(run_query($query)){
				$_SESSION['manage_apps'] = '<div class="alert alert-success">
					<button class="close" data-dismiss="alert">×</button>
					<strong>Success!</strong> The changes have been saved.
				</div>';
			}else{
				return false;
			}
		}
	}

	public function addGroupAppAllocation($group_id, $app_id){
		$query = "INSERT INTO device_group_app_allocations(group_id, app_id) VALUES('".sanitizeVariable($group_id)."', '".sanitizeVariable($app_id)."')";
		if(run_query($query)){
			// $_SESSION['manage_apps'] = '<div class="alert alert-success">
			// 	<button class="close" data-dismiss="alert">×</button>
			// 	<strong>Success!</strong> The changes have been saved.
			// </div>';
		}
	}

	public function removeGroupAppAllocation($group_id, $app_id){
		$query = "DELETE FROM device_group_app_allocations WHERE group_id ='".sanitizeVariable($group_id)."' AND app_id = '".sanitizeVariable($app_id)."'";
		if(run_query($query)){
			return true;
		}
	}

	public function checkForExistingGroupApp($group_id, $app_id){
		$query = "SELECT * FROM device_group_app_allocations WHERE group_id = '".sanitizeVariable($group_id)."' AND app_id = '".$app_id."'";
		// var_dump($query);exit;
		$result = run_query($query);
		$num_rows = get_num_rows($result);
		if($num_rows == 1){
			return true;
		}
	}

	public function detachDevices(){
		extract($_POST);
		$query = "DELETE FROM gtel_device_models_attributes WHERE attribute_id = '".sanitizeVariable($delete_id)."'";
		    $result = run_query($query);
				//var_dump($result);exit;
				if($result){
					$_SESSION['model'] = '<div class="alert alert-success">
						<button class="close" data-dismiss="alert">×</button>
						<strong>Success!</strong> The Model Specification has been Removed Successfully.
					</div>';
				}else{
					$_SESSION['model'] = '<div class="alert alert-error">
						<button class="close" data-dismiss="alert">×</button>
						<strong>Error!</strong> The Model Specifications cannot be Deleted.
					</div>';
				}
	}

	public function detachCustomerFromDevice(){
		$query = "UPDATE phone_list SET status = '0', customer_mf_id = NULL WHERE phone_id = '".sanitizeVariable($_POST['device_id'])."'";
		if(run_query($query)){
			$_SESSION['devices'] = '<div class="alert alert-success">
				<button class="close" data-dismiss="alert">×</button>
				<strong>Success!</strong> The Device has been Detached Successfully.
			</div>';
		}
	}

	public function addToBillingFile(
            $customer_account_code, $billing_interval,
            $billing_amount, $billing_amount_balance,
            $service_bill_id, $start_date){

			// var_dump($customer_account_id);exit;
            $query = "INSERT INTO customer_billing_file(
            created_by, customer_account_code, start_date, 
            billing_interval, billing_amount, billing_amount_balance, service_bill_id,
            created)
    VALUES ('".sanitizeVariable($_SESSION['mf_id'])."', '".$customer_account_code."', '".$start_date."', 
            '".$billing_interval."', '".$billing_amount."', '".$billing_amount_balance."', '".$service_bill_id."',
            '".date('Y-m-d H:i:s')."') RETURNING billing_file_id";
            // traceActivity('Billing File: '.$query);
            $result = run_query($query);
            if($result){
                return $result;
            }else{
                //var_dump('Billing file: '.get_last_error());exit;
                return false;
            }
        }

    public function createBill($bill_due_date, $billing_amount, $bill_date, $bill_status, $bill_amount_paid, $bill_balance, $billing_file_id, $service_account, $mf_id, $service_channel_id){
        // var_dump($_POST);exit;
        $ins_sql = "INSERT INTO customer_bills(
            bill_due_date, bill_amount, 
            bill_date, bill_status, 
            bill_amount_paid, bill_balance, 
            billing_file_id, service_account, 
            mf_id, service_channel_id)
    		VALUES ('".sanitizeVariable($bill_due_date)."', '".sanitizeVariable($billing_amount)."', 
    		'".date('Y-m-d')."', '".sanitizeVariable($bill_status)."', 
    		'".sanitizeVariable($bill_amount_paid)."', '".sanitizeVariable($bill_balance)."', 
    		'".sanitizeVariable($billing_file_id)."', '".sanitizeVariable($service_account)."',
    		'".sanitizeVariable($mf_id)."', '".sanitizeVariable($service_channel_id)."');";
    		// traceActivity($ins_sql);
        if(run_query($ins_sql))
        {
            return true;
        }else{
            //var_dump('Create Bill: '.$ins_sql.' '.get_last_error());exit;
            return false;
        }
    } 

    public function recordJournalDebit($mf_id, $bill_amount, $service_account, $particulars){
		$query = "INSERT INTO journal(
                        journal_date,
                        mf_id, 
                        amount, 
                        dr_cr, 
                        journal_type,
                        particulars,
                        service_account,
                        journal_code,
                        stamp)
                            VALUES (
                                '".date('Y-m-d')."',
                                ".$mf_id.",
                                ".$bill_amount.", 
                                'DR', 
                                1,
                                '".$particulars."',
                                '".$service_account."',
                                'SA',
                                '".time()."')";
		
		if(run_query($query)){
			return true;
		}else{
			//var_dump('Record Journal: '.get_last_error());exit;
			return false;
		}
	}

	public function getServiceBill($model_id){
		$query = "SELECT * FROM revenue_service_bill WHERE product_id='".$model_id."'";
		// var_dump($query);exit;
		$result = run_query($query);
		if($result){
			$rows = get_row_data($result);
			return $rows;
		}else{
			//var_dump(get_last_error());exit;
			return false;
		}
	}

	public function getRevChannel($service_id){
		$query = "SELECT revenue_channel_id FROM service_channels WHERE service_channel_id = '".$service_id."'";
		$result = run_query($query);
		$rows = get_row_data($result);
		return $rows['revenue_channel_id'];
	}

	public function getReferees(){
		$query = "SELECT r.*, CONCAT(m.surname,' ',m.firstname,' ',m.middlename) AS referee_name FROM referrals r 
		LEFT JOIN masterfile m ON m.mf_id = r.referee_mf_id";
		$result = run_query($query);
		if($result)
			return $result;
		else
			//var_dump('Get Referee: '.get_last_error());exit;
			return false;
	}

	public function deleteCustomerAccount(){
		if(!empty($_POST['delete_id'])){
			$query = "DELETE FROM gtel_device WHERE device_id = '".$_POST['delete_id']."'";
			if(run_query($query)){
				$this->flashMessage('done-deal', 'alert alert-success', 'Success', 'The Customer Account has been permanently deleted from the system.');
			}else{
				//var_dump($query.get_last_error());exit;
				return false;
			}
		}
	}

	public function getPhonePolicyType(){
			$query = "SELECT sc.service_channel_id, sc.service_option FROM service_channels sc
			WHERE option_code = '".platinum."' OR option_code = '".gold."'";
				if($result = run_query($query)){
					return $result;
				}else{
					return false;
				}
		}
}
?>
