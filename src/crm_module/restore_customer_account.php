<?php
/**
 * Created by PhpStorm.
 * User: emurimi
 * Date: 4/29/16
 * Time: 4:24 PM
 */
include '../connection/config.php';

if(!empty($_POST['customer_acc_id'])) {
    $delete_id = $_POST['customer_acc_id'];
    $customer_code = getCustomerCodeFromCustomerAccountId($delete_id);

    $return = '';
    $query1 = "UPDATE customer_account SET status = '1' WHERE customer_account_id = '" . $delete_id . "'";
    if (pg_query($query1)) {
        $query2 = "UPDATE gtel_insurance SET status = '1' WHERE customer_account_id = '" . $delete_id . "'";
        if (pg_query($query2)) {
            $query3 = "UPDATE customer_billing_file SET status = '1' WHERE customer_account_code = '" . $customer_code . "'";
            if (pg_query($query3)) {
                $query4 = "UPDATE journal SET status = '1' WHERE service_account = '" . $customer_code . "'";
                if (pg_query($query4)) {
                    if(checkIfBillHasBeenCleared($customer_code)) {
                        $query5 = "UPDATE customer_bills SET bill_status = '1' 
                                          WHERE service_account = '" . $customer_code . "'";
                    }else{
                        $query5 = "UPDATE customer_bills SET bill_status = '0' WHERE service_account = '".$customer_code."'";
                    }
                    if (pg_query($query5)) {
                        $return = array('status' => 1);
                    }
                }
            }
        }
    }
    echo json_encode($return);
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

function getCustomerCodeFromCustomerAccountId($customer_account_id){
    if(!empty($customer_account_id)) {
        $query = "SELECT customer_code FROM customer_account 
                WHERE customer_account_id = '" . $customer_account_id . "'";
        $result = pg_query($query);
        if ($result) {
            if (pg_num_rows($result)) {
                $rows = pg_fetch_assoc($result);
                return $rows ['customer_code'];
            }
        }
    }else{
        return false;
    }
}

function checkIfBillHasBeenCleared($customer_code){
    $query = "SELECT bill_balance FROM customer_bills WHERE service_account = '".$customer_code."'";
    if($result = pg_query($query)){
        if(pg_num_rows($result)){
            $rows = pg_fetch_assoc($result);
            if($rows['bill_balance'] == 0){
                return true;
            }else{
                return false;
            }
        }
    }
}