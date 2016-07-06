<?php
	//This is the symptom class for the symptom module
	class symptoms{
		public function getSymptom(){
			$query = "SELECT * FROM symptoms";
			return $result = run_query($query);
		}

		//Add all patients symptoms
		public function addSymptom(){
			extract($_POST);
			if(!checkForExistingEntry('symptoms', 'symptom_name', $_POST['symptom_name'])){
				//add the station
				$query = "INSERT INTO symptoms(symptom_name) 
				VALUES('".$symptom_name."')";
				$result = run_query($query);
				if($result){
					$_SESSION['symptomss'] = '<div class="alert alert-success">
							<button class="close" data-dismiss="alert">×</button>
							<strong>Success!</strong> New Petrol Station has been Added.
						</div>';
				}
			}else{
				$_SESSION['symptomss'] = '<div class="alert alert-warning">
					<button class="close" data-dismiss="alert">×</button>
					<strong>Warning!</strong> The Petrol Station ('.$_POST["symptom_name"].') already exists.
				</div>';
			}
		}

		public function editSymptom(){
			if(!onEditcheckForExistingEntry('symptoms', 'symptom_name', $_POST['symptom_name'], 'symptom_id', $_POST['edit_id'])){
				//add the ailment
				$query = "UPDATE symptoms SET
				symptom_name = '".$_POST['symptom_name']."' 
				WHERE symptom_id = '".$_POST['edit_id']."'";
				$result = run_query($query);
				if($result){
					$_SESSION['symptomss'] = '<div class="alert alert-success">
							<button class="close" data-dismiss="alert">×</button>
							<strong>Success!</strong> The Changes were successfully saved.
						</div>';
				}
			}else{
				$_SESSION['symptomss'] = '<div class="alert alert-warning">
					<button class="close" data-dismiss="alert">×</button>
					<strong>Warning!</strong> The Petrol Station('.$_POST["symptom_name"].') already exists.
				</div>';
			}
		}

		public function deleteSymptom(){
			$query = "DELETE FROM symptoms WHERE symptom_id = '".$_POST['delete_id']."'";
			$result = run_query($query);
			if($result){
				$_SESSION['symptomss'] = '<div class="alert alert-success">
						<button class="close" data-dismiss="alert">×</button>
						<strong>Success!</strong> The Petrol Station has been removed.
					</div>';
			}
		}				
	}

?>