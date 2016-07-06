<?php
	include_once('src/models/Masterfile.php');
	/**
	* 
	*/
	class Merchants extends Masterfile
	{
		
		function __construct($customer_id)
		{
			extract($_POST);

			$register_kashpoa_merchantfile = "INSERT INTO ndovu_merchants
            (customer_id,merchant_status, loan_balance,date_created,commission_rate)
            VALUES ('".$customer_id."',1,0,'".date("Y-m-d")."',0) ";

        	if(run_query($register_kashpoa_merchantfile)){
        		return true;
        	}
		}
	}
?>