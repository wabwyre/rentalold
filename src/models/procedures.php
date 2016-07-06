<?php
	include_once('src/models/Visits.php');
	//This is the Procedures class for the Procedures module
	class Procedures extends Visits{
		public function getAllProcedures($visit_id){
			$query = "SELECT p.*, v.visit_id, sc.service_channel_id, sc.service_option FROM procedures p
			LEFT JOIN visits v ON v.visit_id = p.visit_id
			LEFT JOIN service_channels sc ON sc.service_channel_id = p.service_id
			WHERE p.visit_id = '".$visit_id."'";
			// var_dump($query);exit;
			return $result = run_query($query);
		}

		public function addProcedure(){
			extract($_POST);
			// var_dump($_POST);exit;
			//add procedure
			$query = "INSERT INTO procedures(visit_id, service_id, quantity, description) 
			VALUES(".$visit_id.", '".$service_chan."', '".$quantity."', '".$description."')";
			$result = run_query($query);				
			if($result){
				if($this->generateServiceBill()){	
					// var_dump('generateServiceBill');exit;
					$_SESSION['proceduress'] = '<div class="alert alert-success">
							<button class="close" data-dismiss="alert">&times;</button>
							<strong>Success!</strong> New Medical Procedure has been Added.
						</div>';
				}
			}else{
				var_dump(pg_last_error());exit;
			}
		}
		// public function editProcedures(){
		// 	if(!onEditcheckForExistingEntry('procedures', 'description', $_POST['description'], 'procedure_id', $_POST['edit_id'])){
		// 		$query = "UPDATE procedures SET
		// 		service_option = '".$_POST['service_option']."',
		// 		description = '".$_POST['description']."',				
		// 		WHERE procedure_id = '".$_POST['edit_id']."'";
		// 		$result = run_query($query);
		// 		if($result){
		// 			$_SESSION['proceduress'] = '<div class="alert alert-success">
		// 					<button class="close" data-dismiss="alert">&times;</button>
		// 					<strong>Success!</strong> The Changes were successfully saved.
		// 				</div>';
		// 		}
		// 	}else{
		// 		$_SESSION['proceduress'] = '<div class="alert alert-warning">
		// 			<button class="close" data-dismiss="alert">&times;</button>
		// 			<strong>Warning!</strong> The Medical Procedure('.$_POST["description"].') already exists.
		// 		</div>';
		// 	}
		// }

		public function deleteProcedures(){
			$query = "DELETE FROM procedures WHERE procedure_id = '".$_POST['delete_id']."'";
			$result = run_query($query);
			if($result){
				$_SESSION['proceduress'] = '<div class="alert alert-success">
						<button class="close" data-dismiss="alert">&times;</button>
						<strong>Success!</strong> The Medical Procedure has been removed.
					</div>';
			}
		}
	}		
?>	
	