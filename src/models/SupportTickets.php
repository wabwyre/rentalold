<?php
include_once('src/models/GpayWallet.php');
include_once('src/models/Broadcast.php');
include_once('src/models/House.php');

class SupportTickets extends House{
 	public function allSuportTickets(){
 		$query ="SELECT st.*, ca.customer_account_id, CONCAT(m.surname,' ',m.firstname,' ',m.middlename) AS customer_name, sta.assigned_to FROM support_ticket st
 		LEFT JOIN customer_account ca ON ca.customer_account_id = st.customer_account_id
 		LEFT JOIN masterfile m ON m.mf_id = st.reported_by
 		LEFT JOIN support_ticket_assignment sta ON sta.support_ticket_id = st.support_ticket_id";
 		$result = run_query($query);
		return $result;
 	}

	public function AllReferrals($condition = ''){
		$query ="SELECT * FROM referrals WHERE referrals_id IS NOT NULL $condition";
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
    	$reciever = $this->getMfidFromCustomerAccId($recip_id);
    	$recipients = "{ $recip_id }";
         //var_dump($recipients);exit;
    	$message_type_id = $this->getSupportMessageTypeId('PUSH_NOTIFICATION');
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

 	public function getSupportMessageTypeId($code){
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

	public function getVoucherCategories(){
		$query = "SELECT * FROM category
    	";
		// var_dump($query);exit;
		return run_query($query);
	}

	public function addCategory(){
		extract($_POST);
		$validate = array(
			'category_name'=>array(
				'name'=> 'Category Name ',
				'required'=>true,
				'unique'=>'category'
			),
			'category_code'=>array(
				'name'=> 'Category Code',
				'required'=>true,
				'unique'=>'category'
			)
		);
		// var_dump($validate);
		$this->validate($_POST, $validate);
		if ($this->getValidationStatus()){
			//if the validation has passed, run a query to insert the details
			//into the database
			if($this-> addCategoryDetails($category_code, $category_name)){
				$this->flashMessage('support', 'success', 'Voucher Category has been added.');
			}else{
				$this->flashMessage('support', 'error', 'Failed to create voucher category! ' . get_last_error());
			}
		}

	}

	public function addCategoryDetails($category_code, $category_name){
		$result = $this->insertQuery('category',
			array(
				'category_name' => $category_name,
				'category_code' => $category_code
			)
		);

		return $result;
	}
	
	public function editCategory(){
		extract($_POST);
		$validate = array(
			'category_name'=>array(
				'name'=> 'Category Name ',
				'required'=>true,
				'unique2' => array(
					'table' => 'category',
					'skip_column' => 'category_id',
					'skip_value' => $post['edit_id']
				)
			),
			'category_code'=>array(
				'name'=> 'Category Code',
				'required'=>true,
				'unique2' => array(
					'table' => 'category',
					'skip_column' => 'category_id',
					'skip_value' => $post['edit_id']
				)
			)
		);

		$this->validate($_POST, $validate);
		if ($this->getValidationStatus()){
			//if the validation has passed, run a query to insert the details
			//into the database
			if($this-> editCategoryDetails($category_code, $category_name)){
				$this->flashMessage('support', 'success', 'Voucher Category has been Updated.');
			}else{
				$this->flashMessage('support', 'error', 'Failed to update voucher category! ' . get_last_error());
			}
		}
	}
	
	public function editCategoryDetails($category_code, $category_name){
		$result = $this->updateQuery(
			'category',
			"category_name = '" . sanitizeVariable($category_name) . "',
                category_code = '" . sanitizeVariable($category_code) . "'
                ",
			"category_id = '".$post['edit_id']."'"
		);

		return $result;
	}
}
?>
