<?
	/*
		*EBPPP SCRIPT TO RECEIVE TRANSACTION REQUEST FROM COMFYPAY MIDDLEWARE
		*AUTHOR: JAIRUS OBUHATSA
		*DATE: 14/07/2011
	*/
	traceActivity("\nNew Hit..");
	include "../connection/config.php";
	//echo "<hr>DATA CONNECTION DONE...1<hr>";	
	include "../library.php";
	//echo "<hr>Library Loaded...1<hr>";
	include "../agent_functions.php";
	//echo "<hr>Agent Functions Loaded...1<hr>";
	include "service_functions.php";
	//echo "<hr>Service Functions Loaded...1<hr>";
	include "../model/Parking.php";
	//echo "<hr>Parking module Loaded...1<hr>";
	include "../model/Markets.php";
	//echo "<hr>Markets module Loaded...1<hr>";
	include "../MenuService/menuservice_1_7.php";
	//echo "<hr>Menu Service Loaded...1<hr>";
	
	$menu = new MenuService($service_type_url,$services_url,$options_url,$inputs_url);
	
	/************************************************************************************************************
	RETRIEVE DATA SENT VIA HEADERS
	*************************************************************************************************************/
	
	$timestamp = time();
	//echo "<hr>DATA CONNECTION DONE...22";	
	
	if($_POST['TRANSACTIONCODE'])
	{
		$trans_id = $_POST['TRANSACTIONID'];  //transaction id from sender
		$trans_code = $_POST['TRANSACTIONCODE']; //Paybill,QueryBill,Compliance
		$option_code = $_POST['SERVICECODE'];  //Parking/Markets/SBP etc
		$user_account = $_POST['USERACCOUNT']; //Service Anchor like plate_number
		$agent_code = $_POST['AGENTCODE']; //keyword code of third party agent
		$description = $_POST['DESCRIPTION']; //Transaction Details
		$amount = $_POST['AMOUNT'];
		$date_logged = $_POST['DATELOGGED'];
		traceActivity("..=Agent[$agent_code]POST=$trans_code=$option_code=$user_account=$description=$amount=$date_logged");		
	}
	else
	{
		$headers = apache_request_headers();
		
		foreach ($headers as $header => $value) 
		{
			$value1 = $header;
			$value1_data = $value;		 
		}
	
		$trans_id = $headers['TRANSACTIONID'];  //transaction id from sender
		$trans_code = $headers['TRANSACTIONCODE']; //Paybill,QueryBill,Compliance
		$option_code = $headers['SERVICECODE'];  //Parking/Markets/SBP etc
		$user_account = $headers['USERACCOUNT']; //Service Anchor like plate_number
		$agent_code = $headers['AGENTCODE'];
		$description = $headers['DESCRIPTION']; //Transaction Details
		$amount = $headers['AMOUNT'];
		$date_logged = $headers['DATELOGGED'];
		/*$reference_id = $headers['REFERENCEID'];
		$resp_status = $headers['RESPSTATUS'];*/
		traceActivity("..=Agent[$agent_code]HEADERS=$trans_code=$option_code=$user_account=$description=$amount=$date_logged");	
	}
/************************************************************************************************************
LOG TRANSACTION REQUEST FROM COMFYPAY MIDDLE-WARE
*************************************************************************************************************/
	//echo "<hr>Logging Done...1<hr>";
	traceActivity("...ATTEMPT TO LOG...");	
	$header_id = getnextID(DATABASE.".log_req", "header_id",1);
	$reference_id = $header_id;
	$timestamp = time();
	$insert_sql = "INSERT INTO ".DATABASE.".log_req 			
							(header_id,timestamp,transaction_id,transaction_code,service_code,user_account,
							 description,amount,date_logged,reference_id,resp_status)
							 
						   VALUES ('$header_id','$timestamp','$trans_id','$trans_code','$option_code','$user_account','$description',
						   			'$amount','$date_logged','$reference_id','$resp_status')";
	run_query($insert_sql); 

	logPostsFromHenry($trans_id,$trans_code,$option_code,$user_account,
							 $description,$amount,$date_logged,$reference_id,$resp_status,$headers2,$headers);

	traceActivity("...REQUEST LOGGED...");	
/************************************************************************************************************
HAND-SHAKE SEND HEADERS BACK TO COMFYPAY MIDDLEWARE
/************************************************************************************************************/
	
	header('Host: localhost');
	header('Connection: close');
	header('Content-type: application/x-www-form-urlencoded');
	header('Content-length: 0');
	header('');

	header("REFERENCEID:$reference_id");
	header("RESPSTATUS:REQACK");
	header("TRANSACTIONID:$trans_id");
	header("DATETIME:$timestamp");
	
/************************************************************************************************************/
//DETERMINE THE TRANSACTION CODE AND DIRECT TRANSACTION...
/************************************************************************************************************/
	if($trans_code == "PAYBILL")
	{
		//echo "<hr>in Paybill...=".$service_code."=<hr>";
		traceActivity("....PAYBILL INVOKED...");
		
		$service_id = getServiceIDOfOptionCode($option_code);
		//echo "<hr>option details fetched...".$details['ServiceID']."<hr>";	
		
		$action = getServiceTypeOfServiceID($service_id);
		//echo "<hr>Service Type fetched..<hr>";
		
		$option_id = getOptionIDOfOptionCode($service_code);
		
		$total_inputs = getNumberofInputsInOptionID($option_id);
			
		switch ($action) {
			case PARKING_TYPE:
			{
				traceActivity("....PARKING INVOKED...");
				include "service_parking.php";
				break;
			}
			case MARKETS_TYPE:
			{
				traceActivity("....MARKETS INVOKED...");
				include "service_markets.php";
				break;
			}
			default:
				//error... no service mentioned
			break;
		}
	}
	elseif($trans_code == "QUERYBILL")
	{
	}
	elseif($trans_code == "COMPLIANCE")
	{
	}
	elseif($trans_code == "RATECARD")
	{
	}
	
/************************************************************************************************************/

/************************************************************************************************************/

//generateServicesXML();
//generateParkingServicesXML();
//echo "<hr>HTTP-POST FROM COMFYPAY RECEIVED BY BIBI...<hr>";


//include "../library.php";
/*include "service_functions.php";
include "../model/Parking.php";
include "../model/Markets.php";*/

//echo "<hr>Agent was validated...";

/*if(validateAgent($_POST['agent_id']))
{
	echo "<hr>Agent was validated...";
	$action = $_POST['action'];
	
}*/
	function traceActivity($text)
	{
		$today = time();
		
		$myFile = "jairoposts.txt";
		$fh = fopen($myFile,'a');			
		
		fwrite($fh, $today."==".$text."\n");	   
		fclose($fh);
	}			
?>