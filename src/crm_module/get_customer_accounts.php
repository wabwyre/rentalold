<?php
	include '../connection/config.php';

	if(!empty($_POST['mf_id'])){
		$cust_acc_ids = getAlreadyAttachedCustAccsIds();
		$condition = (count($cust_acc_ids)) ? ' AND ca.customer_account_id NOT IN('.$cust_acc_ids.')' : '';
		$query = "SELECT ca.*, gd.imei, gdm.model FROM customer_account ca 
		LEFT JOIN gtel_device gd ON gd.device_id = ca.device_id
		LEFT JOIN gtel_device_model gdm ON gdm.device_model_id = gd.device_model_id
		WHERE mf_id = '".$_POST['mf_id']."' AND status IS TRUE $condition";
		// var_dump($query);exit;
		$result = pg_query($query);
		$return = '';

		// loop through all customer accounts
		while ($rows = pg_fetch_assoc($result)) {
			$return[] = $rows;
		}
		echo json_encode($return);
	}

	function getAlreadyAttachedCustAccsIds(){
		$attached_cust_acc_ids = '';
		$query = "SELECT customer_account_id FROM gtel_insurance";
		if($result = pg_query($query)){
			if(pg_num_rows($result)){
				while($rows = pg_fetch_assoc($result)){
					$attached_cust_acc_ids .= $rows['customer_account_id'].', ';
				}
				$cust_acc_ids = rtrim($attached_cust_acc_ids, ', ');
				return $cust_acc_ids;
			}
		}
	}
?>