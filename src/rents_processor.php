<?

	$processed = 0;
	
	switch($_POST['action'])
	{
		case addnewhousetype:
			//check if house type already existing
			$searchquery = "select * from house_types where house_type_name = '".$housetype."' ";
			$rs = run_query($searchquery);
			$rslt = get_num_rows($rs);
			if ($rslt != 0){
				//error("Error:- Duplicate house type - Operation failed !");
				$message = "Error:- Duplicate house type - Operation failed !";
				echo $message;
			}	
		break;
		
		case addnewhouseestate:
			//check if house type already existing
			$searchquery1 = "select * from house_estates where house_estate_name = '".$houseestate."' ";
			$rs1 = run_query($searchquery1);
			$rslt1 = get_num_rows($rs1);
			if ($rslt1 != 0){
				//error("Error:- Duplicate house type - Operation failed !");
				$message = "Error:- Duplicate house estate - Operation failed !";
				echo $message;
			}	
		break;
		
		default:
		
		break;
		
		$processed = 1;
	}

?>
