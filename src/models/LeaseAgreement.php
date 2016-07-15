<?php
include_once('src/models/Payments.php');
/**
* 
*/
class LeaseAgreement extends Payments
{
	
	public function addLeaseAgreement(){
		extract($_POST);
// 		var_dump($_POST);exit;
		if(!empty($tenant) && !empty($house) && !empty($start_date) && !empty($end_date)){
			$query = "BEGIN TRANSACTION;";
			$query .= "INSERT INTO lease(tenant, house_id, start_date, end_date) 
			VALUES('".sanitizeVariable($tenant)."', '".sanitizeVariable($house)."', '".sanitizeVariable($start_date)."', '".sanitizeVariable($end_date)."')";
			if(run_query($query)){
				traceActivity('1 Created  Lease Agreement');
				$service_account = $this->getHouseNo($house);
				$bill_details = $this->getServiceBill($house);
				if(count($bill_details)){
					$result = $this->addToBillingFile(
						$service_account, 
						$bill_details['bill_interval'], 
						$bill_details['amount'], 
						$bill_details['amount'], 
						$bill_details['revenue_bill_id']
					);
					if($result){
						traceActivity('2 Created Billing File');
						$billing_file = get_row_data($result);
						if($billing_file['billing_file_id']){
							$bill_result = $this->createBill($bill_details['bill_due_time'], $bill_details['amount'], date('Y-m-d'), 0, $bill_details['amount'], 0, $billing_file['billing_file_id'],
								$service_account, 
								$tenant, 
								$bill_details['service_channel_id']);
							if($bill_result){
								traceActivity('3 Created Bill');
								if($this->recordJournalDebit($tenant, $bill_details['amount'], $service_account, 'Lease Agreement')){
									traceActivity('4 Created Jounal');
									$_SESSION['lease_agreement'] = '<div class="alert alert-success">
										<button class="close" data-dismiss="alert">&times;</button>
										<strong>Success! </strong> Lease Agreement has been added
									</div>';
									run_query('END TRANSACTION;');
								}
							}
						}
					}else{
						
					}
				}
			}
		}
	}

	public function getAllLeaseAgreements(){
		$return = array();

		$query = "SELECT lg.*, CONCAT(t.surname,' ',t.firstname,' ',t.middlename) AS tenant, t.mf_id, h.house_number FROM lease lg
		LEFT JOIN masterfile t ON t.mf_id = lg.tenant
		LEFT JOIN houses h ON h.house_id = lg.house_id
		";
		if($result = run_query($query)){
			if(get_num_rows($result)){
				while ($rows = get_row_data($result)) {
					$return[] = $rows;			
				}
				return $return;
			}
		}
	}

	public function getAllTenants(){
		$return = array();
		$query= "SELECT CONCAT(surname,' ',firstname,' ',middlename) AS tenant,* FROM masterfile WHERE b_role='tenant'";
		if($result = run_query($query)){
			if(get_num_rows($result)){
				while ($rows = get_row_data($result)) {
					$return[] = $rows;
				}
				return $return;
			}
		}
	}

	public function getHouses(){
		$result= run_query("SELECT * FROM houses_and_plots");
		return $result;
	}

	public function getHouseNo($number){
		$result= run_query("SELECT * FROM houses_and_plots WHERE house_id = '".$number."'");
		return $result;
	}
}