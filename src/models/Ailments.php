<?php
	class Ailments {
		public function getAllAilments(){
			$query = "SELECT * FROM ailments WHERE client_mf_id = '".$_SESSION['mf_id']."'";
			return $result = run_query($query);
		}

		public function getParentAilments(){
			$query = "SELECT * FROM ailments WHERE parent_id IS NULL";
			return $result = run_query($query);
		}

		public function getParentName($id){
			$query = "SELECT ailment_name FROM ailments WHERE ailment_id = '".$id."'";
			$result = run_query($query);
			$rows = get_row_data($result);
			return $rows['ailment_name'];
		}

		public function addAilment(){
			//validate
			$vali_result = $this->validation();

			if($vali_result){
				//check if the ailment exists
				if(!checkForExistingEntry('ailments', 'ailment_name', $_POST['ailment_name'])){
					//add the ailment
					$query = "INSERT INTO ailments(ailment_name, parent_id, client_mf_id) 
					VALUES('".$_POST['ailment_name']."', ".$_POST['parent_id'].", '".$_SESSION['mf_id']."')";
					$result = run_query($query);
					if($result){
						$_SESSION['ailments'] = '<div class="alert alert-success">
								<button class="close" data-dismiss="alert">×</button>
								<strong>Success!</strong> New Ailment has been Added.
							</div>';
					}
				}else{
					$_SESSION['ailments'] = '<div class="alert alert-warning">
						<button class="close" data-dismiss="alert">×</button>
						<strong>Warning!</strong> The ailment('.$_POST["ailment_name"].') already exists.
					</div>';
				}
			}
		}

		public function editAilment(){
			//validate
			$vali_result = $this->validation();

			if($vali_result){
				//check if the ailment exists
				if(!onEditcheckForExistingEntry('ailments', 'ailment_name', $_POST['ailment_name'], 'ailment_id', $_POST['edit_id'])){
					//add the ailment
					$query = "UPDATE ailments SET ailment_name = '".$_POST['ailment_name']."', parent_id = ".$_POST['parent_id']."
					WHERE ailment_id = '".$_POST['edit_id']."'";
					$result = run_query($query);
					if($result){
						$_SESSION['ailments'] = '<div class="alert alert-success">
								<button class="close" data-dismiss="alert">×</button>
								<strong>Success!</strong> The Changes were successfully saved.
							</div>';
					}
				}else{
					$_SESSION['ailments'] = '<div class="alert alert-warning">
						<button class="close" data-dismiss="alert">×</button>
						<strong>Warning!</strong> The ailment('.$_POST["ailment_name"].') already exists.
					</div>';
				}
			}
		}

		public function deleteAilment(){
			$query = "DELETE FROM ailments WHERE ailment_id = '".$_POST['delete_id']."'";
			$result = run_query($query);
			if($result){
				$_SESSION['ailments'] = '<div class="alert alert-success">
						<button class="close" data-dismiss="alert">×</button>
						<strong>Success!</strong> The Ailment has been removed.
					</div>';
			}
		}

		public function validation(){
			if(empty($_POST['ailment_name'])){
				$_SESSION['ailments'] = '<div class="alert alert-warning">
						<button class="close" data-dismiss="alert">×</button>
						<strong>Warning!</strong> You must fill in the ailment name.
					</div>';
			}elseif(empty($_POST['parent_id'])){
				$_SESSION['ailments'] = '<div class="alert alert-warning">
						<button class="close" data-dismiss="alert">×</button>
						<strong>Warning!</strong> You must choose the parent.
					</div>';
			}else{
				return true;
			}
		}
	}
?>