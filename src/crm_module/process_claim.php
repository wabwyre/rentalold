<?php
session_start();
include '../connection/config.php';

logAction('process_insurance_claim', $_SESSION['sess_id'], $_SESSION['mf_id']);

extract($_POST);
$return = array();

if(!empty($_POST['claim-id']) && !empty($_POST['case-type'])){
	$claim_id = $_POST['claim-id'];
	$case_type = $_POST['case-type'];

	$query = "SELECT * FROM customer_insurance_claim WHERE claim_id = '".$claim_id."'";
	if($result = pg_query($query)){
		$rows = pg_fetch_assoc($result);
		$ins_data = getCustomerAccDataFromInsId($rows['insurance_id']);
		sendEmail($case_type, $ins_data['customer_account_id'], $claim_id, $ins_data['mf_id']);
	}
}

function sendEmail($case_type, $acc_id, $claim_id, $mf_id){
	$recipients = "{ ".$mf_id." }";
	$body = "Dear Customer, \n\n";
	if($case_type == 'First fix'){
		$body .= "Your insurance claim is being processed: \n";
		$body .= "Type: $case_type\n";
		$body .= "Cost: 0\n";
		$body .= "Thank you.\n";
		$body .= "Gtel care.";
	}elseif($case_type == 'Second fix'){
		$body .= "Your insurance claim is being processed: \n";
		$body .= "Type: $case_type\n";
		$body .= "Cost: You will be required to pay 50% of the total cost of the $case_type.\n\n";
		$body .= "Thank you.\n";
		$body .= "Gtel care.";
	}elseif($case_type == 'Third fix'){
		$body .= "Your insurance claim is being processed: \n";
		$body .= "Type: $case_type\n";
		$body .= "Cost: You will be required to pay the full amount for the $case_type.\n";
		$body .= "Thank you.\n";
		$body .= "Gtel care.";
	}
	$subject = "$case_type - Claim No: $claim_id";
	$email = getMessageTypeId('EMAIL');
	$message_type_id = "{ $email }";

	if($message_id = sendMessage($body, $subject, $_SESSION['mf_id'], $recipients, $message_type_id)){
		if(addCustMessage($acc_id, $message_id)){
			if(closeClaim($claim_id)){
				$return['success'] = "Processing claim was successful.";
				$return['status'] = true;
			}
		}else{
			$return['fail'] = "Process claim failed!";
			$return['status'] = false;
		}
	}else{
		$return['fail'] = "Process claim failed!";
		$return['status'] = false;
	}
	echo json_encode($return);
}

function sendMessage($body, $subject, $sender, $recipients, $message_type_id){
	$stamp = date('Y-m-d H:i:s');
	$query = "INSERT INTO public.message( body, subject, sender, recipients, created, message_type_id)
		VALUES ('".sanitizeVariable($body)."', '".sanitizeVariable($subject)."', '".sanitizeVariable($sender)."',
		 '".sanitizeVariable($recipients)."', '".$stamp."', '".sanitizeVariable($message_type_id)."') RETURNING message_id";
	// var_dump($query);exit;
	if($result = pg_query($query)){
		$rows = pg_fetch_assoc($result);
		return $rows['message_id'];
	}else{
		return false;
	}
}

function sanitizeVariable($var){
    return $var = pg_escape_string(trim($var));
}

function addCustMessage($customer_account_id, $message_id){
	$query = "INSERT INTO customer_messages(customer_account_id, message_id) 
	VALUES('".sanitizeVariable($customer_account_id)."', '".$message_id."')";
	if(pg_query($query)){
		return true;
	}else{
		return false;
	}
}

function getMessageTypeId($code){
	$query = "SELECT message_type_id FROM message_type WHERE message_type_code = '".$code."'";
	$result = pg_query($query);
	if($result){
		$rows = pg_fetch_assoc($result);
		return $rows['message_type_id'];
	}
}

function closeClaim($claim_id){
	$query = "UPDATE customer_insurance_claim SET status = '0' WHERE claim_id = '".sanitizeVariable($claim_id)."'";
	if(pg_query($query))
		return true;
	else
		return false;
}

function getMfIdFromAccId($acc_id){
	$query = "SELECT mf_id FROM customer_account WHERE customer_account_id = '".sanitizeVariable($acc_id)."'";
	if($result = pg_query($query)){
		$rows = pg_fetch_assoc($result);
		return $rows['mf_id'];
	}
}

function logAction($case_name, $session_id, $staff_customer_id){
    date_default_timezone_set('Africa/Nairobi');
    $timestamp = date('Y-m-d H:i:s');
    $query = "INSERT INTO audit_trail(session_id, mf_id, case_name, datetime) VALUES ('".$session_id."', '".$staff_customer_id."', '".$case_name."', '".$timestamp."')";
    if(pg_query($query)){
        return true;
    }else{
        return false;
    }
}

function getCustomerAccDataFromInsId($ins_id){
	$query = "SELECT * FROM customer_insurance WHERE insurance_id = '".sanitizeVariable($ins_id)."'";
	if($result = pg_query($query)){
		return pg_fetch_assoc($result);
	}
}