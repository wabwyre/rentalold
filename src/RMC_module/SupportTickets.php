<?php
include_once('src/models/GpayWallet.php');

class SupportTickets extends GpayWallet{
 	public function allSuportTickets(){
 		$query ="SELECT st.*, ca.customer_account_id, CONCAT(m.surname,' ',m.firstname,' ',m.middlename) AS customer_name, sta.assigned_to FROM support_ticket st
 		LEFT JOIN customer_account ca ON ca.customer_account_id = st.customer_account_id
 		LEFT JOIN masterfile m ON m.mf_id = st.reported_by
 		LEFT JOIN support_ticket_assignment sta ON sta.support_ticket_id = st.support_ticket_id";
 		$result = run_query($query);
		return $result;
 	}

 	public function reassignStaff(){
 		extract($_POST);
 		//var_dump($_POST);exit;
 		$email = $this->getStaffEmail($_POST['staff']);
 		$query = "UPDATE support_ticket_assignment SET assigned_to = '".$staff."' 
 		WHERE support_ticket_id = '".$support_ticket_id."' AND assigned_to = '".$origin_staff."'";
 		// var_dump($query);exit;
 		$result = run_query($query);
 		if($result){
	            	 if($result = $this->ResendStaffEmail($_POST['staff'])){
				       if($result){
	                    $_SESSION['support'] = '<div class="alert alert-success">
	                            <button class="close" data-dismiss="alert">×</button>
	                            <strong>Success!</strong> The Support Ticket was Re-Assigned to a Staff Successfully.
	                        </div>';
	                         App::redirectTo('index.php?num=all_support');
			            } 
                }
            }
    }
 

 	public function getAllSupportCustomerAccounts(){
			$query = "SELECT CONCAT(m.surname,' ',m.firstname) AS customer_name, ca.issued_phone_number, ca.customer_account_id,ca.status FROM customer_account ca
			LEFT JOIN masterfile m ON m.mf_id = ca.mf_id
			WHERE m.b_role = 'client' AND status is TRUE";
			return run_query($query);
	}

	public function getSupportCustomerName($acc){
			$query = "SELECT CONCAT(m.surname,' ',m.firstname) AS cust_name FROM customer_account ca
			LEFT JOIN masterfile m ON m.mf_id = ca.mf_id
			WHERE ca.customer_account_id = '".$acc."'";
			$result= run_query($query);
			$row= get_row_data($result);
		    return $row['cust_name'];
	}

 	public function checkIFSupportTicketIsAssigned($support){
			$query = "SELECT * FROM support_ticket_assignment 
			WHERE support_ticket_id = '".sanitizeVariable($support)."' 
			";
			// var_dump($query);exit;
			$result = run_query($query);
			$num_rows = get_num_rows($result);
			return ($num_rows > 0) ? true: false;

	}

	public function getAssignedTo($mf_id){
		if(!empty($mf_id)){
			$query = "SELECT CONCAT(m.surname,' ',m.firstname) AS assigned_to FROM masterfile m 
			WHERE m.mf_id = '".$mf_id."'";
			$result= run_query($query);
			$row= get_row_data($result);
		    return $row['assigned_to'];
		}
	}

	public function getAllStaffAassignment(){
		$query = "SELECT m.*, CONCAT(m.surname,' ',m.firstname,' ',m.middlename) AS customer_name FROM masterfile m WHERE b_role = 'staff' AND active is TRUE";
		// var_dump($query);exit;
		return $result = run_query($query);
	}

	public function addSupport(){
		extract($_POST);
		$status = '0';
		$staff = $_SESSION['mf_id'];
		$query = "INSERT INTO support_ticket(customer_account_id, subject, reported_by, 
            status, body)
		VALUES('".sanitizeVariable($customer)."','".sanitizeVariable($subject)."',
		'".sanitizeVariable($staff)."','".sanitizeVariable($status)."','".sanitizeVariable($body)."')";
		//var_dump($query);exit;
		 $result = run_query($query);
        if($result){
            $_SESSION['support'] = '<div class="alert alert-success">
                    <button class="close" data-dismiss="alert">×</button>
                    <strong>Success!</strong> The Support Ticket was Recorded Successfully.
                </div>';
                 App::redirectTo('index.php?num=all_support');
        }
	}

	public function getStaffEmail($staff){
      $query = "SELECT email FROM user_login2
			WHERE mf_id = '".$staff."'";
			 //var_dump($query);exit;
			$result = run_query($query);
			$rows = get_row_data($result);
			return $rows['email'];
	}

	public function SendStaffEmail($staff){
		extract($_POST);
		$message_type_code = 'EMAIL';
		$message_type = $this->getMessageTypeId($message_type_code);
		$mess = 'array['.$message_type.']';
		$subject = 'Ticket Assignment#'.$support_ticket_id.'';
		$message = "Dear Gtel Staff,\r\n";
        $message .= "You Have been Assigned A Support Ticket:\r\n";
        $message .= "Please Login To the system to Address the raised Support Ticket.\r\n\r\n";
        $message .= "Thanks,\r\n";
        $message .= "Gtel-Care Team";
        $reciever = 'array['.$staff.']';
        $sender = $_SESSION['mf_id'];

		$query = "INSERT INTO message(body, subject, sender, recipients,message_type_id) 
	    VALUES('".sanitizeVariable($message)."','".sanitizeVariable($subject)."','".sanitizeVariable($sender)."'
	     ,".$reciever.",".$mess.")";
	     //var_dump($query);exit;
	     $result = run_query($query);
	     return $result;

	}

	public function ResendStaffEmail($staff){
		extract($_POST);
		$message_type_code = 'EMAIL';
		$message_type = $this->getMessageTypeId($message_type_code);
		$mess = 'array['.$message_type.']';
		$subject = 'Ticket Re-Assignment#'.$support_ticket_id.'';
		$message = "Dear Gtel Staff,\r\n";
        $message .= "You Have been Assigned A Support Ticket:\r\n";
        $message .= "Please Login To the system to Address the raised Support Ticket.\r\n\r\n";
        $message .= "Thanks,\r\n";
        $message .= "Gtel-Care Team";
        $reciever = 'array['.$staff.']';
        $sender = $_SESSION['mf_id'];

		$query = "INSERT INTO message(body, subject, sender, recipients,message_type_id) 
	    VALUES('".sanitizeVariable($message)."','".sanitizeVariable($subject)."','".sanitizeVariable($sender)."'
	     ,".$reciever.",".$mess.")";
	     //var_dump($query);exit;
	     $result = run_query($query);
	     return $result;

	}

	public function assignStaff(){
		extract($_POST);
		$email = $this->getStaffEmail($_POST['staff']);
		//var_dump($email);exit;
		if(!checkForExistingEntry('support_ticket_assignment', 'support_ticket_id', $support_ticket_id)){
		$query = "INSERT INTO support_ticket_assignment(support_ticket_id,assigned_to)
		VALUES('".sanitizeVariable($support_ticket_id)."','".sanitizeVariable($staff)."')";
		//var_dump($query);exit;
		 $result = run_query($query);
	            if($result){
	            	 if($result = $this->SendStaffEmail($_POST['staff'])){
				       if($result){
	                    $_SESSION['support'] = '<div class="alert alert-success">
	                            <button class="close" data-dismiss="alert">×</button>
	                            <strong>Success!</strong> The Support Ticket was Assigned to a Staff Successfully.
	                        </div>';
	                         App::redirectTo('index.php?num=all_support');
			            } 
                }
            }
        }
	}

	public function AllReferrals(){
		$query ="SELECT * FROM referrals ";
 		$result = run_query($query);
		return $result;
	}

	public function mySupportTickets(){
		$query = "SELECT sta.*, st.* FROM support_ticket_assignment sta 
		LEFT JOIN support_ticket st ON st.support_ticket_id = sta.support_ticket_id
		WHERE sta.assigned_to = '".$_SESSION['mf_id']."'";
		//var_dump($query);exit;
		return run_query($query);
	}

	public function getSupportMessageTypes(){
			$query = "SELECT * FROM message_type WHERE message_type_code ='EMAIL'";
			//var_dump($query);exit;
			return $result = run_query($query);
	}

	public function getSendToClient($id){
		$query ="SELECT customer_account_id FROM support_ticket 
 		WHERE support_ticket_id = '".$id."'";
 		$result = run_query($query);
 		$row= get_row_data($result);
		return $row['customer_account_id'];
	}

	public function respondToSupportIssue(){
         extract($_POST);
        $customer_account = $this->getSendToClient($support_ticket_id);
        $sender = $_SESSION['mf_id'];
        $reciever = 'array['.$customer_account.']';
        $message = 'array['.$message_type.']';
        $body_message = "Dear Customer,\n\n";
    	$body_message .= $body;
 		$body_message .="\n\nGTEL-Care";
 
        $query = "INSERT INTO message(body, subject, sender, recipients,message_type_id) 
	      VALUES('".sanitizeVariable($body_message)."','".sanitizeVariable($subject)."','".sanitizeVariable($sender)."'
	      ,".$reciever.",".$message.")RETURNING message_id";
	          //var_dump($query);exit;
	     $result = run_query($query);
          if($result){
		    $data = get_row_data($result);
				if($result = $this->addTOSupportMessage($data['message_id'])){
					if($result){
		                $_SESSION['support'] = '<div class="alert alert-success">
		                        <button class="close" data-dismiss="alert">×</button>
		                        <strong>Success!</strong>The Message was send successfully.
		                    </div>';
		                     App::redirectTo('index.php?num=issued_tickets');
				}
			}
		}
	}

	public function addTOSupportMessage($mess){
		extract($_POST);
        $query = "INSERT INTO support_tickets_messages(support_ticket_id, message_id) 
	      VALUES('".sanitizeVariable($support_ticket_id)."','".sanitizeVariable($mess)."')RETURNING message_id";
	          //var_dump($query);exit;
	     $result = run_query($query);
	     if($result){
		    $data = get_row_data($result);
				if($result = $this->addToCustomerInbox($data['message_id'])){
					return $result;
			}
		}
    }

    public function addToCustomerInbox($data){
    	extract($_POST);
        $customer_account = $this->getSendToClient($support_ticket_id);
    	$query = "INSERT INTO customer_messages(customer_account_id, message_id) VALUES('".$customer_account."','".$data."')";
    	//var_dump($query);exit;
		$result =run_query($query);
		return $result;
    }

    public function getTicketDetails($ticket_id){
    	$query = "SELECT st.*, CONCAT(m.surname,' ',m.firstname) AS customer_name, sta.assigned_to FROM support_ticket st
    	LEFT JOIN customer_account ca ON ca.customer_account_id = st.customer_account_id
    	LEFT JOIN masterfile m ON m.mf_id = ca.mf_id
    	LEFT JOIN support_ticket_assignment sta ON sta.support_ticket_id = st.support_ticket_id
    	WHERE st.support_ticket_id = '".$ticket_id."'";
    	$result = run_query($query);
    	return $rows = get_row_data($result);
    }

    public function getTicketComments($ticket_id){
    	$query = "SELECT stm.*, m.body, m.sender, m.created, CONCAT(mf.surname,' ',mf.firstname) AS user_name FROM support_tickets_messages stm
    	LEFT JOIN message m ON m.message_id = stm.message_id
    	LEFT JOIN masterfile mf ON m.sender =  mf.mf_id 
    	WHERE stm.support_ticket_id = '".$ticket_id."'";
    	// var_dump($query);exit;
    	return run_query($query);
    }

    public function addComment(){
    	extract($_POST);
    	$recipients = "{ $recip_id }";

    	$message_type_id = $this->getMessageTypeId('INBOX');
    	$mess_type = "{ $message_type_id }";
    	$body = "Dear Customer,\n\n";
    	$body .= $comment;
 		$body .="\n\nGTEL-Care";
 		$query = "INSERT INTO message(body, subject, sender, recipients, message_type_id) 
 		VALUES ('".sanitizeVariable($body)."', '".sanitizeVariable($subject)."', '".$_SESSION['mf_id']."', '".$recipients."', '".$mess_type."') RETURNING message_id";
    	//var_dump($query); exit;
		$result = run_query($query);
        if($result){
        	$rows = get_row_data($result);
        	// add customer message
        	if($this->addCustomerMessage($ticket_id, $rows['message_id'])){
            	$_SESSION['done-deal'] = '<div class="alert alert-success">
                    <button class="close" data-dismiss="alert">×</button>
                    <strong>Success!</strong> Comment was Successfully Recorded.
                </div>';
               App::redirectTo('index.php?num=view_ticket&ticket_id='.$ticket_id);
            }
        }else{
        	var_dump(get_last_error());exit;
        }
 	}

 	public function addCustomerMessage($customer_account_id, $message_id){
 		$query = "INSERT INTO support_tickets_messages(support_ticket_id, message_id) 
 		VALUES('".sanitizeVariable($customer_account_id)."', '".$message_id."')RETURNING support_ticket_id";
 		//var_dump($query);exit;
 		$result = run_query($query);
 		if($result){
        	$rows = get_row_data($result);
        	// add customer message
        	if($this->addReponseMessage($rows['support_ticket_id'], $message_id)){
            	$_SESSION['done-deal'] = '<div class="alert alert-success">
                    <button class="close" data-dismiss="alert">×</button>
                    <strong>Success!</strong> Comment was Successfully Recorded.
                </div>';
                App::redirectTo('index.php?num=view_ticket&ticket_id='.$customer_account_id);
            }
        }else{
        	var_dump(get_last_error());exit;
        }
 	}
     
    public function addReponseMessage($ticket_id, $message_id){
    	 extract($_POST);
        $customer_account = $this->getSendToClient($ticket_id);
    	$query = "INSERT INTO customer_messages(customer_account_id, message_id) 
 		VALUES('".sanitizeVariable($customer_account)."', '".$message_id."')";
 		//var_dump($query);exit;
 		$result = run_query($query);
 		return $result;
    }

 	public function getMessageTypeId($code){
 		$query = "SELECT message_type_id FROM message_type WHERE message_type_code = '".$code."'";
 		$result = run_query($query);
 		if($result){
 			$rows = get_row_data($result);
 			return $rows['message_type_id'];
 		}
 	}

 	public function getMfidFromCustomerAccId($acc_id){
 		if(!empty($acc_id)){
	 		$query = "SELECT mf_id FROM customer_account WHERE customer_account_id = '".$acc_id."'";
	 		$result = run_query($query);
	 		$rows = get_row_data($result);
	 		return $rows['mf_id'];
	 	}else{
	 		var_dump(get_last_error());exit;
	 	}
 	}
}
?>
