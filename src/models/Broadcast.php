<?php
	require_once 'src/models/Masterfile.php';
	/**
	* 
	*/
	class Broadcast extends Masterfile
	{
		public function getMessageTypes(){
			$query = "SELECT * FROM message_type";
			return $result = run_query($query);
		}

		public function getAllBroadcasts(){
			$query = "SELECT m.* FROM message m";
			// var_dump($query);exit;
			return run_query($query);
		}

		public function getAllCustomerAccounts(){
			$query = "SELECT CONCAT(m.surname,' ',m.firstname) AS customer_name, ca.issued_phone_number, ca.customer_account_id FROM customer_account ca
			LEFT JOIN masterfile m ON m.mf_id = ca.mf_id
			WHERE b_role = 'client' AND status IS TRUE";
			return run_query($query);
		}

		public function getCustomerNames($recipients, $msg_type_id){
			$str1 = str_replace('{', '', $recipients);
			$str2 = str_replace('}', '', $str1);
			$customer_name = '';
			$mf_ids = explode(',', $str2);

			foreach ($mf_ids as $mf_id) {
				if(!empty($mf_id)){
					$msg_str1 = str_replace('{', '', $msg_type_id);
					$msg_str2 = str_replace('}', '', $msg_str1);

					$msg_type_code = $this->getMsgTypeCode($msg_str2);
//					var_dump($msg_type_code);exit;

					if($msg_type_code != Email) {
						$query = "SELECT 
						CONCAT(m.surname,' ',m.firstname) AS customer_name, 
						ca.issued_phone_number 
						FROM customer_account ca
						LEFT JOIN masterfile m ON m.mf_id = ca.mf_id
						WHERE ca.customer_account_id = '" . sanitizeVariable($mf_id) . "'";
					}else{
						$query = "SELECT CONCAT(surname,' ',firstname,' ',middlename) AS customer_name, email 
						FROM masterfile WHERE mf_id = '".$mf_id."'";
					}
					// var_dump($query);exit;
					$result = run_query($query);
					$rows = get_row_data($result);
					$customer_name .= ($msg_type_code != Email) ? $rows['customer_name'].' - '.$rows['issued_phone_number'].', '."\n" : $rows['customer_name'].' ('.$rows['email'].'), '."\n";
				}
			}
			return rtrim($customer_name, ', '."\n");
		}

		public function getMessageTypeName($mes_types){
			$str1 = str_replace('{', '', $mes_types);
			$str2 = str_replace('}', '', $str1);
			$type_name = '';
			
			$type_ids = explode(',', $str2);
			foreach ($type_ids as $type_id) {
				if(!empty($type_id)){
					$query = "SELECT message_type_name FROM message_type WHERE message_type_id = '".sanitizeVariable($type_id)."'";
					
					$result = run_query($query);
					$rows = get_row_data($result);
					$type_name .= $rows['message_type_name'].', ';
				}
			}
			return rtrim($type_name,', ');
		}

		public function addBroadcast(){
			extract($_POST);
			
			if(empty($broad_cast_type) && empty($send_to) && empty($subject) && empty($body)){

			}else{
				$recip_array = 'array[';
				$recip_mfids = array();
				// check if sending to all customers
				if($send_to == 'All'){
					$result = $this->getAllCustomerAccounts();
					while($rows = get_row_data($result)){
						$recip_array .= $rows['customer_account_id'].',';
						$acc_ids[] = $rows['customer_account_id'];
						$recip_mfids[] = $this->getMfIdFromAccId($rows['customer_account_id']);
					}
				}

				// check if sending to specific customers
				if($send_to == 'Specific'){
					foreach ($recipients as $recip_acc_ids) {
						$recip_array .= $recip_acc_ids.',';
						$recip_mfids[] = $this->getMfIdFromAccId($recip_acc_ids);
						$acc_ids[] = $recip_acc_ids;
					}
				}
				$recip_array = rtrim($recip_array, ',');
				$recip_array .= ']';

				$recip_mfids = array_unique($recip_mfids);
				$mfids_list = 'array[';
				// create a list of unique mf_ids which have been extracted from account ids
				foreach ($recip_mfids as $recip_mfid) {
					$mfids_list .= $recip_mfid.',';
				}
				$mfids_list = rtrim($mfids_list, ',');
				$mfids_list .= ']';

				// check if sending to client groups
				if($send_to == 'client_groups'){
					foreach ($client_groups as $client_group) {
						// get all customers in the selected
						$this->sendMessageToAllClientsInGroup($client_group);
					}
				}else{
					$message = ($message_type == 'custom') ? $body: $pre_message;
					$msg_type_code = $this->getMsgTypeCode($broad_cast_type);
					if($msg_type_code == Email){
						$recip_array = $mfids_list;
					}

					$query = "INSERT INTO message(
					body, 
					subject, 
					sender, 
					recipients, 
					created, 
					message_type_id)
					VALUES(
					'".sanitizeVariable($message)."', 
					'".sanitizeVariable($subject)."',
					'".$_SESSION['mf_id']."', 
					".sanitizeVariable($recip_array).",
					'".date('Y-m-d H:i:s')."', 
					array[$broad_cast_type]) RETURNING message_id";

					// var_dump($query);exit;
					if($result = run_query($query)){
						$rows = get_row_data($result);
						// var_dump($acc_ids);exit;
						if($this->addToCustomerMessages($acc_ids, $rows['message_id'])){
							$_SESSION['broadcast'] = '<div class="alert alert-success">
			                    <button class="close" data-dismiss="alert">×</button>
			                    <strong>Success!</strong>A new broadcast has been added.
			                </div>';
			            }
					}
				}
			}
		}
		
		

		public function getMfIdFromAccId($accId){
			if(!empty($accId)){
				$query = "SELECT mf_id FROM customer_account WHERE customer_account_id = '".sanitizeVariable($accId)."'";
				if($result = run_query($query)){
					$rows = get_row_data($result);
					return $rows['mf_id'];
				}
			}
		}

		public function getMsgTypeCode($msg_id){
			if(!empty($msg_id)){
				$query = "SELECT message_type_code FROM message_type WHERE message_type_id = '".sanitizeVariable($msg_id)."'";
				if($result = run_query($query)){
					$rows = get_row_data($result);
					return $rows['message_type_code'];
				}
			}
		}

		public function addToCustomerMessages($acc_ids, $mes_id){
			// var_dump($acc_ids);exit;
			foreach ($acc_ids as $acc_id) {
				$query = "INSERT INTO customer_messages(
	            customer_account_id, message_id)
	    		VALUES ('".$acc_id."', '".$mes_id."')";
	    		if(run_query($query)){
	    			// return true;
	    		}else{
	    			var_dump(get_last_error());exit;
	    		}
	    	}
	    	return true;
		}

		public function addToCustomerMessage($acc_id, $mes_id){
			$query = "INSERT INTO customer_messages(
            customer_account_id, message_id)
    		VALUES ('".$acc_id."', '".$mes_id."')";
    		if(run_query($query)){
    			$_SESSION['broadcast'] = '<div class="alert alert-success">
                    <button class="close" data-dismiss="alert">×</button>
                    <strong>Success!</strong>A new broadcast has been added.
                </div>';
				return true;
    		}else{
    			var_dump(get_last_error());exit;
    		}
		}

		public function getAllPredefinedMessages(){
			$query = "SELECT * FROM predefined_message";
			return run_query($query);
		}

		public function addPredefinedMessage(){
			if(!empty($_POST['message'])){
				$query = "INSERT INTO predefined_message(predefined_message) VALUES('".sanitizeVariable($_POST['message'])."')";
				if(run_query($query)){
					$_SESSION['predefined'] = '<div class="alert alert-success">
	                    <button class="close" data-dismiss="alert">×</button>
	                    <strong>Success!</strong> Message Added.
	                </div>';
				}else{
					return false;
				}
			}
		}

		public function editPreMessage(){
			if(!empty($_POST['message'])){
				$query = "UPDATE predefined_message SET predefined_message = '".sanitizeVariable($_POST['message'])."' 
				WHERE predefined_mess_id = '".sanitizeVariable($_POST['edit_id'])."'";
				if(run_query($query)){
					$_SESSION['predefined'] = '<div class="alert alert-success">
	                    <button class="close" data-dismiss="alert">×</button>
	                    <strong>Success!</strong> Message Updated.
	                </div>';
				}
			}
		}

		public function deletePreMessage(){
			$query = "DELETE FROM predefined_message WHERE predefined_mess_id = '".$_POST['delete_id']."'";
			if(run_query($query)){
				$_SESSION['predefined'] = '<div class="alert alert-success">
                    <button class="close" data-dismiss="alert">×</button>
                    <strong>Success!</strong> Message Deleted.
                </div>';
			}
		}

		public function getAllClientGroups(){
			$query = "SELECT * FROM masterfile WHERE b_role = 'client group'";
			return run_query($query);
		}

		public function sendMessageToAllClientsInGroup($client_group){
			extract($_POST);
			$message = ($message_type == 'custom') ? $body: $pre_message;

			$mf_ids = $this->getMfidsInClientGroup($client_group);
			if(count($mf_ids)) {
				$mfid_list = 'array[';
				$mf_lst = '';
				foreach ($mf_ids as $mf_id) {
					$mfid_list .= $mf_id.',';
					$mf_lst .= $mf_id.',';
				}

				$mf_lst = rtrim($mf_lst, ',');
				$cust_acc_ids = $this->getAllCustomerAccountsUnderClientInClientGroup($mf_lst);
				if (count($cust_acc_ids)) {
					$recip_array = 'array[';
					foreach ($cust_acc_ids as $cust_acc_id) {
						$recip_array .= $cust_acc_id . ',';
					}
					$recip_array = rtrim($recip_array, ',');
					$recip_array .= ']';
				}

				$mfid_list = rtrim($mfid_list, ',');
				$mfid_list .= ']';
				$msg_type_code = $this->getMsgTypeCode($broad_cast_type);
				//var_dump($msg_type_code);exit;
				if($msg_type_code == Email){
					$recip_array = $mfid_list;
				}
				// var_dump($recip_array);exit;
			}

			$query = "INSERT INTO message(
			body, 
			subject, 
			sender, 
			recipients, 
			created, 
			message_type_id)
			VALUES(
			'".sanitizeVariable($message)."', 
			'".sanitizeVariable($subject)."',
			'".$_SESSION['mf_id']."', 
			".sanitizeVariable($recip_array).",
			'".date('Y-m-d H:i:s')."', 
			array[$broad_cast_type]) RETURNING message_id";
			if($result = run_query($query)){
				$rows = get_row_data($result);
				foreach ($cust_acc_ids as $accountid) {
					$this->addToCustomerMessage($accountid, $rows['message_id']);
				}
			}else{
				var_dump('Create message: '.$query.' '.get_last_error());exit;
			}
		}

		public function getAllCustomerAccountsUnderClientInClientGroup($client_mf_id){
			$query = "SELECT customer_account_id FROM customer_account WHERE mf_id in(".$client_mf_id.")";
			if($result = run_query($query)){
				if(get_num_rows($result)){
					while($rows = get_row_data($result)){
						$return[] = $rows['customer_account_id'];
					}
					return $return;
				}
			}else{
				return false;
			}
		}

		public function getMfidsInClientGroup($client_group){
			$query = "SELECT mf_id FROM masterfile WHERE company_name = '".sanitizeVariable($client_group)."'";
			if($result = run_query($query)) {
				while ($rows = get_row_data($result)) {
					$return[] = $rows['mf_id'];
				}
				return $return;
			}
		}
	}
?>