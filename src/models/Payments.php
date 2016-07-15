<?php
//	include_once('src/models/Houses.php');
//	/**
//	*
//	*/
	class Payments
	{
		
		public function addToBillingFile($service_account, $billing_interval, $billing_amount, $billing_amount_balance, $service_bill_id){
	        $query = "INSERT INTO customer_billing_file(
	        created_by, service_account, start_date, 
	        billing_interval, billing_amount, billing_amount_balance, service_bill_id,
	        created)
			VALUES ('".$_SESSION['user_id']."', '".sanitizeVar($service_account)."', '".date('Y-m-d')."', 
	        '".sanitizeVar($billing_interval)."', '".sanitizeVar($billing_amount)."', '".sanitizeVar($billing_amount_balance)."', '".sanitizeVar($service_bill_id)."',
	        '".date('Y-m-d H:i:s')."') RETURNING billing_file_id";
	        traceActivity('Billing File: '.$query);
	        $result = run_query($query);
	        if($result){
	            return $result;
	        }else{
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
	    		VALUES ('".sanitizeVar($bill_due_date)."', '".sanitizeVar($billing_amount)."', 
	    		'".date('Y-m-d')."', '".sanitizeVar($bill_status)."', 
	    		'".sanitizeVar($bill_amount_paid)."', '".sanitizeVar($bill_balance)."', 
	    		'".sanitizeVar($billing_file_id)."', '".sanitizeVar($service_account)."',
	    		'".sanitizeVar($mf_id)."', '".sanitizeVar($service_channel_id)."')";
	        traceActivity($ins_sql);
	        if(run_query($ins_sql)){
	            return true;
	        }else{
	            return false;
	        }
	    } 

	    public function getServiceBill($house_id){
			$query = "SELECT * FROM revenue_service_bill WHERE product_id='".$house_id."'";
			// traceActivity($query);
// 			var_dump($query);exit;
			$result = run_query($query);
			if($result){
				return get_row_data($result);
			}else{
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
			return false;
		}
	}
	}
?>