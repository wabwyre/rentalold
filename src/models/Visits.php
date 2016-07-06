<?php
	include_once('src/models/symptoms.php');
	//This is the visits class for the visits module
	class Visits extends symptoms{
		//get all registered patients
		public function getAllPatients(){
			$query = "SELECT * FROM masterfile";
			$result = run_query($query);
			return $result;
		}

		public function getAllServiceLeaves(){
			$query = "SELECT * FROM service_channels WHERE service_option_type = 'Leaf'";
			$result = run_query($query);
			return $result;
		}

		public function getVisitServices($visit_id){
			$query = "SELECT vs.*, s.* FROM visit_services vs 
			LEFT JOIN service_channels s ON s.service_channel_id = vs.service_channel_id
			WHERE visit_id = '".$visit_id."'";
			$result = run_query($query);
			return $result;
		}

		public function servedBy($visit_id){
			$query = "SELECT p.user_mf_id, m.surname, m.firstname, m.middlename FROM patient_bills p
			LEFT JOIN masterfile m ON m.mf_id = p.user_mf_id
			WHERE p.visit_id = '".$visit_id."'";
			$result = run_query($query);
			return $rows = get_row_data($result);
		}

		public function getReceiptDetails($visit_id){
			$query = "SELECT v.*, m.surname, m.firstname, m.middlename, a.*, iv.ipd_no, ov.opd_no FROM visits v
			LEFT JOIN masterfile m ON m.mf_id = v.mf_id
			LEFT JOIN address a ON a.mf_id = m.mf_id
			LEFT JOIN inpatient_visits iv ON iv.visit_id = v.visit_id
			LEFT JOIN outpatient_visits ov ON ov.visit_id = v.visit_id
			WHERE v.visit_id = '".$visit_id."'";

			$result = run_query($query);
			return $rows = get_row_data($result);
		}

		public function getAllVisits(){
			$query = "SELECT m.*, v.*, vt.*, iv.ipd_no, ov.opd_no, 
			af.afyapoa_id as customer_policy_no, ad.afyapoa_id as dependant_policy_no 
			FROM visits v
			LEFT JOIN masterfile m ON m.mf_id = v.mf_id
			LEFT JOIN afyapoa_file af ON af.mf_id = v.mf_id
			LEFT JOIN afyapoa_dependants ad ON ad.mf_id = v.mf_id
			LEFT JOIN visit_types vt ON vt.visit_type_id = v.visit_type_id
			LEFT JOIN inpatient_visits iv ON iv.visit_id = v.visit_id
			LEFT JOIN outpatient_visits ov ON ov.visit_id = v.visit_id

			WHERE v.client_mf_id = '".$_SESSION['mf_id']."'";
			// var_dump($query);exit;
			$result = run_query($query);

			return $result;
		}

		public function calculateTotalAmount($visit_id){
			$query = "SELECT SUM(s.price) as tot_amount FROM patient_bills pb
			LEFT JOIN service_channels s ON s.service_channel_id = pb.service_channel_id
			WHERE visit_id = '".$visit_id."' GROUP BY visit_id";
			$result = run_query($query);
			$rows = get_row_data($result);
			return $rows['tot_amount'];
		}

		public function addVisit(){
			//validate
			$vali_result = $this->visit_validation();

			$years = $_POST['years'];
			$months = $_POST['months'];
			if(empty($years)){
				$years = 'NULL';
			}elseif(empty($months)){
				$months = 'NULL';
			}

			if($vali_result){
				//add the visit
				$query = "INSERT INTO visits(
            	mf_id, visit_date, visit_status, age_in_yrs, age_in_months, visit_type_id, client_mf_id)
    			VALUES ('".$_POST['mf_id']."', '".$_POST['visit_date']."', 
    				'".$_POST['status']."', ".$years.", ".$months.", '".$_POST['visit_type']."', '".$_SESSION['mf_id']."') 
				RETURNING visit_id";
				$result = run_query($query);
				if($result){
					$data = get_row_data($result);
					if($_POST['visit_type'] == 3){
						if($this->generateIpdNo($data['visit_id'])){
							$_SESSION['visits'] = '<div class="alert alert-success">
								<button class="close" data-dismiss="alert">×</button>
								<strong>Success!</strong> New Visit has been Added.
							</div>';
						}
					}else{
						if($this->generateOpdNo($data['visit_id'])){
							$_SESSION['visits'] = '<div class="alert alert-success">
								<button class="close" data-dismiss="alert">×</button>
								<strong>Success!</strong> New Visit has been Added.
							</div>';
						}
					}
				}
			}
		}

		public function generateIpdNo($visit_id){
			$query = "INSERT INTO inpatient_visits(visit_id) VALUES('".$visit_id."')";
			return run_query($query);
		}

		public function generateOpdNo($visit_id){
			$query = "INSERT INTO outpatient_visits(visit_id) VALUES('".$visit_id."')";
			return run_query($query);
		}

		public function addVisitService(){
			if(!empty($_POST['service_chan'])){
				//add the visit
				$query = "INSERT INTO visit_services(service_channel_id, visit_id, quantity, description)
				VALUES('".$_POST['service_chan']."', '".$_POST['visit_id']."', '".$_POST['quantity']."', '".$_POST['desc']."')";
				$result = run_query($query);
				if($result){
					if($this->generateServiceBill()){
						$_SESSION['visit_profile'] = '<div class="alert alert-success">
								<button class="close" data-dismiss="alert">×</button>
								<strong>Success!</strong> Service has been Added.
							</div>';
					}
				}
			}
		}

		public function generateServiceBill(){
			// var_dump('Generate bill...');exit;
			$price = $this->getServicePrice($_POST['service_chan']);

			$bill_amt = $price * $_POST['quantity'];
			// var_dump('calculate price...');exit;
			$query = "INSERT INTO patient_bills(
				            bill_date, visit_id, bill_amount, amount_paid, total_amount_paid, 
				            balance, user_mf_id, service_channel_id)
				    		VALUES ('".date('Y-m-d H:i:s')."', '".$_POST['visit_id']."', 
				    		'".$bill_amt."', 0, 0, 
				    		'".$bill_amt."', '".$_SESSION['mf_id']."', '".$_POST['service_chan']."')
							RETURNING bill_id";
			$result = run_query($query);
			if($result){
				$data = get_row_data($result);
				if($result = $this->createDebit($data['bill_id'], $bill_amt)){
					return true;
				}else{
					return false;
				}
			}else{
				var_dump(pg_last_error());exit;
			}
		}

		public function createDebit($bill_id, $price){
			$query = "INSERT INTO journal(
			mf_id,
            bill_id, 
            amount, 
            dr_cr,  
            journal_type, 
            particulars,
            stamp)
		    VALUES (
		    	'".$this->getPatientMfid($_POST['visit_id'])."',
		    	'".$bill_id."', 
		    	'".$price."', 
		    	'DR', 
		    	1, 
		        '".$_POST['desc']."',
		        '".time()."')";

			// var_dump($query);exit;

			$result = run_query($query);
			if($result){
				return true;
			}else{
				var_dump(pg_last_error());exit;
				return false;
			}
		}

		public function getServicePrice($service_channel_id){
			$query = "SELECT price FROM service_channels WHERE service_channel_id = '".$service_channel_id."'";
			$result = run_query($query);
			$rows = get_row_data($result);
			return $rows['price'];
		}

		public function getPatientMfid($visit_id){
			$query = "SELECT mf_id FROM visits WHERE visit_id = '".$visit_id."'";
			$result = run_query($query);
			$rows = get_row_data($result);
			return $rows['mf_id'];
		}

		public function editVisitService(){
			if(!empty($_POST['edit_id'])){
				//add the visit
				$query = "UPDATE visit_services SET service_channel_id = '".$_POST['service_chan']."' 
				WHERE service_id = '".$_POST['edit_id']."'";
				$result = run_query($query);
				if($result){
					$_SESSION['visit_profile'] = '<div class="alert alert-success">
							<button class="close" data-dismiss="alert">×</button>
							<strong>Success!</strong> Service has been Updated.
						</div>';
				}
			}
		}

		public function payBill(){
			if(!empty($_POST['visit_id'])){
				$payment_id = $this->recordPayment();

				$result = $this->getPatientBillsWithBalance($_POST['visit_id']);
				// var_dump(pg_last_error());exit;
				while ($rows = get_row_data($result)) {
					$service_id = $rows['service_channel_id'];
					$bill_id = $rows['bill_id'];
					$bill_amount = $rows['bill_amount'];
					$total_amount_paid = $rows['total_amount_paid'];
					$label = 'cash_per_bill'.$bill_id;
					$service_id = $_POST['service_id'.$bill_id];

					$new_total = $total_amount_paid + $_POST[$label];
					$balance = $bill_amount - $new_total;

					// var_dump($bill_amount);exit;
					// if($balance >= $new_total){
						if(!empty($_POST[$label]) && ($_POST[$label] != 0)){
							$query = "UPDATE patient_bills SET 
							amount_paid = '".$_POST[$label]."', balance='".$balance."',
							total_amount_paid = '".$new_total."'
							WHERE bill_id = ".$bill_id."";

							if(run_query($query)){
								if($this->createCredit($bill_id)){
									// var_dump('createCredit');exit;
									if($this->recordPaymentDetails($bill_id, $payment_id, $service_id)){
										// var_dump('recordPaymentDetails');exit;
										$_SESSION['pay_bill'] = '<div class="alert alert-success">
									 		<button class="close" data-dismiss="alert">×</button>
									 		<strong>Success!</strong> Payment has been recorded.
									 	</div>';
									 	App::redirectTo('?num=5003&visit_id='.$_POST['visit_id']);
									}
								}
							}
						}
					// }else{
					// 	var_dump('Balance is not greater or equal to the new totoal');exit;
					// }
				}
			}
		}

		public function waiverBills(){
			if(!empty($_POST['visit_id'])){

				$result = $this->getPatientBillsWithBalance($_POST['visit_id']);
				while ($rows = get_row_data($result)) {
					$service_id = $rows['service_channel_id'];
					$bill_id = $rows['bill_id'];
					$waiver_amount = $rows['waiver_amount'];
					$balance = $rows['balance'];
					$label = 'waiver'.$bill_id;
					$service_id = $_POST['service_id'.$bill_id];

					$updated_waiver_waiver = $waiver_amount + $_POST[$label];

					if($balance >= $updated_waiver_waiver){
						if(!empty($_POST[$label]) && ($_POST[$label] != 0)){
							$query = "UPDATE patient_bills SET 
							waiver_amount = '".$updated_waiver_waiver."'
							WHERE bill_id = ".$bill_id."";
							// var_dump($query);exit;

							if(run_query($query)){
								if($this->addWaiver($bill_id)){
									$_SESSION['pay_bill'] = '<div class="alert alert-success">
								 		<button class="close" data-dismiss="alert">×</button>
								 		<strong>Success!</strong> Waiver has been added successfully.
								 	</div>';
								}
							}else{
								var_dump(pg_last_error());exit;
							}
						}
					}
				}
			}
		}

		public function addWaiver($bill_id){
			$query = "INSERT INTO waivers(bill_id, waiver_amount, description, visit_id, what_time) 
			VALUES('".$bill_id."', '".$_POST['waiver'.$bill_id]."', '".$_POST['desc']."', '".$_POST['visit_id']."', '".date('Y-m-d H:i:s')."')";
			// var_dump($query);exit;
			$result = run_query($query);
			if($result){
				return $result;
			}else{
				var_dump(pg_last_error());
			}
		}

		public function createCredit($bill_id){
			$query = "INSERT INTO journal(
			mf_id,
            bill_id, 
            amount, 
            dr_cr,  
            journal_type, 
            particulars,
            stamp)
		    VALUES (
		    	'".$_POST['mf_id']."',
		    	'".$bill_id."', 
		    	'".$_POST['cash_per_bill'.$bill_id]."', 
		    	'CR', 
		    	1, 
		        '".$_POST['desc']."',
		        '".time()."')";
			// var_dump($query);exit;
			$result = run_query($query);
			if($result){
				return $result;
			}else{
				var_dump('pay bill: '.pg_last_error());exit;
			}
		}

		public function recordPaymentDetails($bill_id, $payment_id, $service_id){
			$query = "INSERT INTO payment_details(
            bill_id, payment_id, amount_paid, mpesa_ref, visit_id, service_channel_id)
   			VALUES ('".$bill_id."', '".$payment_id."', '".$_POST['cash_per_bill'.$bill_id]."',
   			 '".$_POST['mpesa_ref']."', '".$_POST['visit_id']."', '".$service_id."')";
   			$result = run_query($query);
   			if($result){
   				return $result;
   			}else{
   				var_dump(pg_last_error());exit;
   			}
		}

		public function recordPayment(){
			$query = "INSERT INTO payments(payment_amount, payment_mode, mpesa_ref, visit_id) 
			VALUES('".$_POST['cash_received']."', '".$_POST['payment_mode']."', 
				'".$_POST['mpesa_ref']."', '".$_POST['visit_id']."') RETURNING payment_id";
			// App::traceActivity($query);
			if ($result = run_query($query)) {
				$rows = get_row_data($result);
				return $rows['payment_id'];
			}else{
				App::traceActivity(pg_last_error());
			}
		}

		public function getRecNo($visit_id){
			$query = "SELECT p.payment_id FROM payments p
			WHERE p.visit_id = '".$visit_id."'";
			// var_dump($query);exit;
			$result = run_query($query);
			$rows = get_row_data($result);
			return $rows['payment_id'];
		}

		public function checkForanExistingBill($vis_id){
			$query = "SELECT * FROM patient_bills WHERE visit_id = '".$vis_id."'";
			$result = run_query($query);
			// var_dump($query);exit;
			$num_rows = get_num_rows($result);
			if($num_rows >= 1){
				return true;
			}else{
				return false;
			}
		}

		public function getLastPaidAmount($service_channel_id, $v_id){
			if(!empty($v_id)){
				$query = "SELECT pb.total_amount_paid, pb.bill_amount, pb.balance, vs.* FROM patient_bills pb 
				LEFT JOIN visit_services vs ON vs.visit_id = pb.visit_id
				WHERE pb.visit_id = '".$v_id."' AND vs.service_channel_id = '".$service_channel_id."'";
				// var_dump($query);exit;
				$result = run_query($query);
				$rows = get_row_data($result);
				return $rows;
			}
		}

		public function getBillBalance($vs_id){
			$query = "SELECT balance, total_amount_paid FROM patient_bills WHERE visit_id = '".$vs_id."'";
			$result = run_query($query);
			return $rows = get_row_data($result);
		}

		public function removeVisitService(){
			if(!empty($_POST['delete_id'])){
				//add the visit
				$query = "DELETE FROM patient_bills
				WHERE bill_id = '".$_POST['delete_id']."'";
				$result = run_query($query);
				if($result){
					$_SESSION['visit_profile'] = '<div class="alert alert-success">
							<button class="close" data-dismiss="alert">×</button>
							<strong>Success!</strong> Service has been removed.
						</div>';
				}
			}
		}

		public function getVisitTypes(){
			$query = "SELECT * FROM visit_types";
			return $result = run_query($query);
		}

		public function editVisit(){
			//validate
			$vali_result = $this->visit_validation();

			$years = $_POST['years'];
			$months = $_POST['months'];
			if(empty($years)){
				$years = 'NULL';
			}elseif(empty($months)){
				$months = 'NULL';
			}

			if($vali_result){
				//add the visit
				$query = "UPDATE visits
				SET mf_id='".$_POST['mf_id']."', visit_date='".$_POST['visit_date']."', 
				visit_status='".$_POST['status']."', age_in_yrs=".$years.",age_in_months=".$months.", 
				visit_type_id = '".$_POST['visit_type']."'
				WHERE visit_id = '".$_POST['edit_id']."'";
				// var_dump($query);exit;
				$result = run_query($query);
				if($result){
					$_SESSION['visits'] = '<div class="alert alert-success">
							<button class="close" data-dismiss="alert">×</button>
							<strong>Success!</strong> Visit details were updated successfully.
						</div>';
				}
			}
		}

		public function deleteVisit(){
			if(!empty($_POST['delete_id'])){
				$delete_id = $_POST['delete_id'];

				$query = "DELETE FROM visits WHERE visit_id = '".$delete_id."'";
				$result = run_query($query);
				if($result){
					$_SESSION['visits'] = '<div class="alert alert-success">
							<button class="close" data-dismiss="alert">×</button>
							<strong>Success!</strong> Visit has been removed.
						</div>';
				}else{
					$_SESSION['visits'] = '<div class="alert alert-warning">
						<button class="close" data-dismiss="alert">×</button>
						<strong>Warning!</strong> The visit record cannot be deleted yet since it is still referenced elsewhere in the system.
					</div>';
				}
			}
		}

		public function visit_validation(){
			if(empty($_POST['mf_id'])){
				$_SESSION['visits'] = '<div class="alert alert-warning">
						<button class="close" data-dismiss="alert">×</button>
						<strong>Warning!</strong> You must choose a patient.
					</div>';
			}elseif(empty($_POST['visit_date'])){
				$_SESSION['visits'] = '<div class="alert alert-warning">
						<button class="close" data-dismiss="alert">×</button>
						<strong>Warning!</strong> The visit date is required.
					</div>';
			}elseif(empty($_POST['status'])){
				$_SESSION['visits'] = '<div class="alert alert-warning">
						<button class="close" data-dismiss="alert">×</button>
						<strong>Warning!</strong> The status is required.
					</div>';
			}else{
				return true;
			}
		}

		public function getAllAilments(){
			$query = "SELECT * FROM ailments WHERE parent_id is null";
			$result = run_query($query);
			return $result;
		}

		public function addmedicalreport(){
				//add the medical report
				$query = "INSERT INTO medical_report(remarks, ailment_id, visit_id)
				VALUES('".$_POST['remarks']."', '".$_POST['ailment_id']."', '".$_POST['visit_id']."')";
				$result = run_query($query);
				if($result){
					$_SESSION['medical_report'] = '<div class="alert alert-success">
							<button class="close" data-dismiss="alert">×</button>
							<strong>Success!</strong> Medical Report Added successfully!.
						</div>';
				}
		}

		public function getMedicalReport($visit_id){
			$query = "SELECT mr.*, a.*, al.* FROM medical_report mr
			LEFT JOIN visits a ON a.visit_id = mr.visit_id
			LEFT JOIN ailments al ON al.ailment_id = mr.ailment_id
			WHERE mr.visit_id = '".$visit_id."'";
			$result = run_query($query);
			return $result;
		}

		public function deleteMedicalReport(){
			if(!empty($_POST['delete_id'])){
				$delete_id = $_POST['delete_id'];

				$query = "DELETE FROM medical_report WHERE report_id = '".$delete_id."'";
				$result = run_query($query);
				if($result){
					$_SESSION['medical_report'] = '<div class="alert alert-success">
							<button class="close" data-dismiss="alert">×</button>
							<strong>Success!</strong> The Medical Report has been removed successfully!.
						</div>';
				}
			}
		}

		public function editMedicalReport(){
				//edit the medical report
				$query = "UPDATE medical_report SET  remarks = '".$_POST['remarks']."' , 
				ailment_id = '".$_POST['ailment_id']."'
				WHERE report_id = '".$_POST['edit_id']."'";
				$result = run_query($query);
				if($result){
					$_SESSION['medical_report'] = '<div class="alert alert-success">
							<button class="close" data-dismiss="alert">×</button>
							<strong>Success!</strong> The Medical Report has been Updated successfully!.
						</div>';
				}
		}

		public function getPatientBill($visit_id){
			$query = "SELECT pb.*, s.* FROM patient_bills pb
			LEFT JOIN service_channels s ON s.service_channel_id = pb.service_channel_id
			WHERE pb.visit_id = '".$visit_id."'
			ORDER BY pb.bill_id DESC";
			// var_dump($query);exit;
			$result = run_query($query);
			return $result;
		}

		public function getPatientBillsWithBalance($visit_id){
			$query = "SELECT pb.*, s.* FROM patient_bills pb
			LEFT JOIN service_channels s ON s.service_channel_id = pb.service_channel_id
			WHERE pb.visit_id = '".$visit_id."' AND pb.balance > 0
			ORDER BY pb.bill_id DESC";
			$result = run_query($query);
			if($result){
				return $result;
			}else{
				var_dump(pg_last_error());exit;
			}
		}

		public function getPaymentDetails($payment_id){
			$query = "SELECT pd.*, p.payment_amount, sc.service_option, sc.price FROM payment_details pd
			LEFT JOIN service_channels sc ON sc.service_channel_id = pd.service_channel_id
			LEFT JOIN payments p ON p.payment_id = pd.payment_id
			WHERE pd.payment_id = '".$payment_id."'";
			// var_dump($query);exit;
			$result = run_query($query);
			return $result;
		}

		// public function getServiceDetails($service_channel_id){
		// 	$query = "SELECT * FROM service_channels WHERE service_channel_id = '".$service_channel_id."'";
		// 	$result = run_query($query);
		// 	return $rows = get_row_data($result);
		// }

		// public function getPatientBill($visit_id){
		// 	$query = "SELECT pb.*, v.*, m.*, s.* FROM patient_bills pb
		// 	LEFT JOIN visits v ON v.visit_id = pb.visit_id
		// 	LEFT JOIN masterfile m ON m.mf_id = pb.user_mf_id
		// 	LEFT JOIN visit_services vs ON vs.visit_id = v.visit_id
		// 	LEFT JOIN service_channels s ON s.service_channel_id = vs.service_channel_id
		// 	WHERE pb.visit_id = '".$visit_id."'";
		// 	// var_dump($query);exit;
		// 	$result = run_query($query);
		// 	return $result;
		// }

		public function getAllVisitsReport($filter){
			$query = "SELECT m.*, v.*, vt.*, iv.ipd_no, ov.opd_no FROM visits v
			LEFT JOIN masterfile m ON m.mf_id = v.mf_id
			LEFT JOIN customer_types vt ON vt.customer_type_id = v.visit_type_id
			LEFT JOIN inpatient_visits iv ON iv.visit_id = v.visit_id
			LEFT JOIN outpatient_visits ov ON ov.visit_id = v.visit_id
			 $filter";
			$result = run_query($query);
			return $result;
		}

		public function getPatientBills($mf_id){
			$query = "SELECT pb.*, s.*, m.* FROM patient_bills pb
			LEFT JOIN service_channels s ON s.service_channel_id = pb.service_channel_id
			LEFT JOIN masterfile m ON m.mf_id = pb.user_mf_id
			WHERE m.mf_id = '".$mf_id."'";
			// var_dump($query);exit;
			$result = run_query($query);
			return $result;
		}

		public function getPatientVisits($mf_id){
			$query = "SELECT m.*, v.*, vt.*, iv.ipd_no, ov.opd_no FROM visits v
			LEFT JOIN masterfile m ON m.mf_id = v.mf_id
			LEFT JOIN customer_types vt ON vt.customer_type_id = v.visit_type_id
			LEFT JOIN inpatient_visits iv ON iv.visit_id = v.visit_id
			LEFT JOIN outpatient_visits ov ON ov.visit_id = v.visit_id
			WHERE v.mf_id = '".$mf_id."'";
			$result = run_query($query);
			return $result;
		}

		public function getPaymentsPerVisit($visit_id){
			$query = "SELECT * FROM payments WHERE visit_id = '".$visit_id."'";
			return $result = run_query($query);
		}

		public function getCustomerBills($mf_id){
			$query = "SELECT pb.*, v.*, s.* FROM patient_bills pb
			LEFT JOIN visits v ON v.visit_id = pb.Visit_id
			LEFT JOIN service_channels s ON s.service_channel_id = pb.service_channel_id
			WHERE v.mf_id = '".$mf_id."'";
			// var_dump($query);exit;
			$result = run_query($query);
			return $result;
		}

		public function getWaivers($filter){
			$query = "SELECT * FROM waivers $filter";
			$result = run_query($query);
			if($result){
				return $result;
			}
		}

		public function addVisitType(){
			extract($_POST);

			$query = "INSERT INTO visit_types(visit_type_name, visit_type_code)
    		VALUES ('".$visit_type_name."', '".$visit_type_code."')";

    		$result = run_query($query);
    		if($result){
    			$_SESSION['done-add'] = '<div class="alert alert-success">
					<button class="close" data-dismiss="alert">×</button>
					<strong>Success!</strong> A new Visit Type has been added.
				</div>';
    		}
		}

		public function editVisitType(){
			extract($_POST);

			$query = "UPDATE visit_types SET visit_type_name = '".$visit_type_name."', visit_type_code = '".$visit_type_code."'
			WHERE visit_type_id = '".$edit_id."'";

    		$result = run_query($query);
    		if($result){
    			$_SESSION['edit-visit-type'] = '<div class="alert alert-success">
					<button class="close" data-dismiss="alert">×</button>
					<strong>Success!</strong> The visit type has been updated.
				</div>';
    		}
		}

		public function deleteVisitType(){
			extract($_POST);

			$delete = "DELETE FROM visit_types WHERE visit_type_id = '".$edit_id."'";
			if(run_query($delete)){
				$_SESSION['edit-visit-type'] = '<div class="alert alert-success">
					<button class="close" data-dismiss="alert">×</button>
					<strong>Success!</strong> The visit type has been deleted.
				</div>';
			}else{
				$_SESSION['edit-visit-type'] = pg_last_error();
			}
		}

		public function copyTableRecords(){
			$query = "SELECT c.*, af.afyapoa_id, af.mf_id FROM afyapoa_file af
			LEFT JOIN customers c ON c.customer_id = af.customer_id";

			$result = run_query($query);
			if($result){
				while($rows = get_row_data($result)){
					$afyapoa_id = $rows['afyapoa_id'];

					$query = "INSERT INTO public.masterfile(
		            surname, active, firstname, middlename, id_passport, regdate_stamp, time_stamp, images_path, b_role)
		    		VALUES ('".$rows['surname']."', '".$rows['status']."', '".$rows['firstname']."', 
		    			'".$rows['middlename']."', '".$rows['national_id_number']."', 
		    		'".date('Y-m-d H:i:s', $rows['regdate_stamp'])."', '".$rows['regdate_stamp']."','".$rows['images_path']."', 
		    		'Customer') RETURNING mf_id";
					
					$result2 = run_query($query);
					if($result2){
						//get the returned mf_id
						$return = get_row_data($result2);

						//update the mf_id on afyapoa_dependants
						$query2 = "UPDATE afyapoa_file SET mf_id = '".$return['mf_id']."' WHERE afyapoa_id = '".$afyapoa_id."'";
						if(run_query($query2)){
							$_SESSION['visits'] = '<div class="alert alert-success">
								<button class="close" data-dismiss="alert">×</button>
								<strong>Success!</strong> This is the way to go.
							</div>';
						}
					}
				}
			}
		}

		public function copyDependantRecords(){
			$query = "SELECT * FROM afyapoa_dependants";
			// var_dump($query);exit;
			$result = run_query($query);
			if($result){
				while($rows = get_row_data($result)){
					extract($rows);
					$full_name = explode(' ', $dependant_names);
					if(isset($full_name[0])){
						$firstname = $full_name[0];
					}else{
						$firstname = NULL;
					}
					
					if(isset($full_name[1])){
						$middlename = $full_name[1];
					}else{
						$middlename = NULL;
					}

					if(isset($full_name[2])){
						$surname = $full_name[2];
					}else{
						$surname = NULL;
					}

					$query = "INSERT INTO public.masterfile(
		            surname, active, firstname, middlename, id_passport, time_stamp, 
		            gender, dob, b_role)
		    		VALUES ('".$surname."', '".$status."', '".$firstname."', '".$middlename."', NULL, 
		    			'".time()."', '".$dependant_gender."', '".$dependant_dob."', 'Dependant') RETURNING mf_id";
					
					$result2 = run_query($query);
					if($result2){
						//get the returned mf_id
						$return = get_row_data($result2);

						//update the mf_id on afyapoa_dependants
						$query = "UPDATE afyapoa_dependants SET mf_id = '".$return['mf_id']."' WHERE dependant_id = '".$dependant_id."'";
						if(run_query($query)){
							$_SESSION['visits'] = '<div class="alert alert-success">
								<button class="close" data-dismiss="alert">×</button>
								<strong>Success!</strong> successfully copied dependants to masterfile.
							</div>';
						}
					}
				}
			}
		}

		public function getRevenueChannel($one){
			$query = "SELECT * FROM revenue_channel WHERE tab_id = ".$one." AND mf_id = '".$_SESSION['mf_id']."'";
			// var_dump($query);exit;
			$result = run_query($query);
			$row = get_row_data($result);
			return $row;
		}

		public function getServiceChannel($one){
			$query = "SELECT * FROM service_channels WHERE tab_id = '".$one."'";
			//var_dump($query);exit;
			$result = run_query($query);
			$row = get_row_data($result);
			return $row;
		}

		public function getAllTests($visit_id){
			$query = "SELECT vt.*, sc.service_option FROM visit_tests vt
			LEFT JOIN service_channels sc ON sc.service_channel_id = vt.service_id 
			WHERE visit_id = '".$visit_id."'";

		     $result = run_query($query);
		     return $result;
		}

		public function addTests(){
			extract($_POST);

			$query = "INSERT INTO visit_tests(service_id, description, results, remarks, quantity, visit_id)
    		VALUES ('".$service_id."', '".$description."','".$results."', '".$remarks."','".$quantity."', '".$visit_id."')";

    		$result = run_query($query);
    		if($result){
    			if($this->generateBill()){
						$_SESSION['tests'] = '<div class="alert alert-success">
								<button class="close" data-dismiss="alert">×</button>
								<strong>Success!</strong> Tests Data added Successfully.
							</div>';
					}
    		}
		}

		public function generateBill(){
			$price = $this->getServicePrice($_POST['service_id']);
			$bill_amt = $price * $_POST['quantity'];

			$query = "INSERT INTO patient_bills(
				            bill_date, visit_id, bill_amount, amount_paid, total_amount_paid, 
				            balance, user_mf_id, service_channel_id)
				    		VALUES ('".date('Y-m-d H:i:s')."', '".$_POST['visit_id']."', 
				    		'".$bill_amt."', 0, 0, 
				    		'".$bill_amt."', '".$_SESSION['mf_id']."', '".$_POST['service_id']."')
							RETURNING bill_id";
							//var_dump($query);exit;
			$result = run_query($query);
			if($result){
				$data = get_row_data($result);
				if($result = $this->createServiceDebit($data['bill_id'], $bill_amt)){
					return $result;
				}
			}
		}

		public function createServiceDebit($bill_id, $bill_amt){
			$query = "INSERT INTO journal(
			mf_id,
            bill_id, 
            amount, 
            dr_cr,  
            journal_type, 
            particulars,
            stamp)
		    VALUES (
		    	'".$_SESSION['mf_id']."',
		    	'".$bill_id."', 
		    	'".$bill_amt."', 
		    	'DR', 
		    	1, 
		        '".$_POST['description']."',
		        '".time()."')";
			 //var_dump($query);exit;
			$result = run_query($query);
			return $result;
		}

		public function getAllPharmacy($visit_id){
			$query = "SELECT ps.*, sc.service_option FROM pharmacy_services ps
			LEFT JOIN service_channels sc ON sc.service_channel_id = ps.service_id 
			WHERE visit_id = '".$visit_id."'";

			$result = run_query($query);
		     return $result;
		}

		public function addPharmacy(){
			extract($_POST);

			$query = "INSERT INTO pharmacy_services(service_id, description, quantity, visit_id)
    		VALUES ('".$service_id."','".$description."','".$quantity."', '".$visit_id."')";
              //var_dump($query);exit;
    		$result = run_query($query);
    		if($result){
    			if($this->generateBill()){
					$_SESSION['pharmacy'] = '<div class="alert alert-success">
						<button class="close" data-dismiss="alert">×</button>
						<strong>Success!</strong> Pharmacy Details added Successfully.
					</div>';
				}
    		}
		}

		public function addComplaint(){			
			$complaints = '';
			foreach($_POST['complaints'] as $option){
				$complaints .= $option.', ';
			}

			$complaints = rtrim($complaints, ', ');

			$query = "INSERT INTO complaints(
            complaints, description, visit_id)
    		VALUES ('".$complaints."', '".$_POST['description']."', '".$_POST['visit_id']."')";

    		$result = run_query($query);
    		if($result){
    			$_SESSION['complaints'] = '<div class="alert alert-success">
					<button class="close" data-dismiss="alert">×</button>
					<strong>Success!</strong> Complaints have been recorded.
				</div>';
    		}
		}

		public function getVisitComplaints($visit_id){
			$query = "SELECT * FROM complaints WHERE visit_id = '".$visit_id."'";
			return $result = run_query($query);
		}

		public	function onEditCheckForExisting($tablename, $column_name, $id, $skip_column, $skip_id){
		  $check_query = "SELECT $column_name FROM $tablename WHERE $column_name = '".$id."' AND $skip_column <> '".$skip_id."'";
		  $result = run_query($check_query);
		  $num_rows = get_num_rows($result);
		  if($num_rows >= 1){
		    return true;
		  }else{
		    return false;
		  }
		}

		public function deleteComplaints(){
			extract($_POST);
			// var_dump($_POST);exit;
			$query = "DELETE FROM complaints WHERE complaints_id = '".$delete_id."'";
			if(run_query($query)){
				$_SESSION['complaints'] = '<div class="alert alert-success">
					<button class="close" data-dismiss="alert">×</button>
					<strong>Success!</strong> Complaints have been deleted.
				</div>';
			}
		}
	}
?>