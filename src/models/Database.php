<?php
	/**
	* 
	*/
	class Database{
		private $_data = array();

		public function insertQuery($table, $inputs = array(), $return_field = ''){
            $field_string = '';
            $input_string = '';

			if(!empty($return_field))
				$return_field = 'RETURNING '.$return_field;
			else
				$return_field = '';

			if(!empty($table)){
				if(count($inputs)){
					foreach ($inputs as $index => $value) {
                        $field_string .= "$index,";
						$input_string .= ($value != 'NULL') ? "'".sanitizeVariable($value)."'," : sanitizeVariable($value).",";
					}

                    $field_string = rtrim($field_string, ',');
                    $input_string = rtrim($input_string, ',');

					$query = "INSERT INTO $table(".$field_string.") VALUES(".$input_string.") $return_field";
//                    var_dump($query);exit;
					if($result = run_query($query)){
						if(empty($return_field))
							return $result;
						else
							return get_row_data($result);
					}else{
						return false;
					}
				}
			}
		}

		public function updateQuery($table, $fields_values, $condition = ''){
			if(!empty($table) && !empty($fields_values)){
				$condition = (!empty($condition)) ? 'WHERE '.$condition : '';

				$query = "UPDATE $table SET ".$fields_values." $condition";
				if(run_query($query)){
					return true;
				}else{
					return false;
				}
			}
		}

		public function deleteQuery($table, $condition){
			if(!empty($table) && !empty($condition)){
				$condition = (!empty($condition)) ? 'WHERE '.$condition : '';
				$query = "DELETE FROM ".$table." $condition";
				if(run_query($query)){
					return true;
				}else{
					return false;
				}
			}
		}

		public function selectQuery($table, $fields, $condition = '', $order_field = '', $order_type = ''){
			$return = array();
			/*
				example:
				selectQuery(
		 			'subjects', 
		 			'*', 
		 			"school_id = '".$_SESSION['school_id']."'"
		 		);
			*/
			$field_string = '';
			if(!empty($table)){
				if(is_array($fields)){
					if(count($fields)){
						foreach ($fields as $field) {
							$field_string .= $field.',';
						}
					}
				}

				if(count($fields)){
					$field_string = rtrim($field_string, ',');
					$field_string = (!is_array($fields)) ? $fields : $field_string; 
					$condition = (!empty($condition)) ? 'WHERE '.$condition: '';
					$order_string = (!empty($order_field) && !empty($order_type)) ? 'ORDER BY '.$order_field.' '.$order_type : '';

					$query = "SELECT ".$field_string." FROM $table $condition $order_string";
					if($result = run_query($query)){
						if(get_num_rows($result)){
							while ($rows = get_row_data($result)) {
								$return[] = $rows;
							}
							return $return;
						}
					}else{
						return false;
					}
				}
			}
		}

		public function getRows(){
			return $this->_data;
		}

		public function getStatus($status){
			return ($status == 't') ? 'Active' : 'Inactive';
		}

		public function beginTranc(){
			run_query("BEGIN TRANSACTION;");
		}

		public function endTranc(){
			run_query("END TRANSACTION;");
		}
	}
?>