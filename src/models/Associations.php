<?php
	include_once('src/models/Masterfile.php');
	/**
	* 
	*/
	class Associations extends Masterfile
	{
		
		function __construct($assoc_code, $customer_id)
		{
			$register_afyapoa_group="INSERT INTO afyapoa_association
            (customer_id,status,assoc_code, date_created)
            VALUES ('".$customer_id."','1','".$assoc_code."','".date("Y-m-d")."') "
                . "RETURNING afyapoa_assoc_id";
        	
        	run_query($register_afyapoa_group);
		}
	}
?>