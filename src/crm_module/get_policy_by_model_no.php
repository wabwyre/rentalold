<?php
	include '../connection/config.php';

	if (!empty($_POST['customer_account_id'])){
		$query = "SELECT gdm.device_model_id FROM customer_account ca
		LEFT JOIN gtel_device gd ON gd.device_id = ca.device_id
		LEFT JOIN gtel_device_model gdm ON gdm.device_model_id = gd.device_model_id
		WHERE ca.customer_account_id = '".$_POST['customer_account_id']."'
		";
		if($result = pg_query($query)){
			if(pg_num_rows($result)){
				$rows = pg_fetch_assoc($result);
				$service_data = getPolicyTypeServiceId($rows['device_model_id']); 
				if(count($service_data)){
					echo json_encode($service_data);
				}
			}
		}
	}

	function getPolicyTypeServiceId($model_id){
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