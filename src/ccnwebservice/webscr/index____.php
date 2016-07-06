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
	include "../defaults.php";
	//echo "<hr>Menu Service Loaded...1<hr>";
	
	//$menu = new MenuService($service_type_url,$services_url,$options_url,$inputs_url);
	
	/************************************************************************************************************
	RETRIEVE DATA SENT VIA HEADERS	
	*************************************************************************************************************/
	
	$timestamp = time();
	//echo "<hr>DATA CONNECTION DONE...22";	
	
	if($_POST['TRANSACTIONCODE'])
	{
		$trans_id = $_POST['TRANSACTIONID'];  //transaction id from sender
		$trans_code = $_POST['TRANSACTIONCODE']; //Paybill,QueryBill,Compliance
		$service_code = $_POST['SERVICECODE'];  //Parking/Markets/SBP etc
		$user_account = $_POST['USERACCOUNT']; //Service Anchor like plate_number
		$agent_code = $_POST['AGENTCODE']; //keyword code of third party agent
		$description = $_POST['DESCRIPTION']; //Transaction Details
		$amount = $_POST['AMOUNT'];
		$date_logged = $_POST['DATELOGGED'];
		traceActivity("...Agent[$agent_code]POST=$trans_code=$service_code=$user_account=$description=$amount=$date_logged");		
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
		$service_code = $headers['SERVICECODE'];  //Parking/Markets/SBP etc
		$user_account = $headers['USERACCOUNT']; //Service Anchor like plate_number
		$agent_code = $headers['AGENTCODE'];
		$description = $headers['DESCRIPTION']; //Transaction Details
		$amount = $headers['AMOUNT'];
		$date_logged = $headers['DATELOGGED'];
		/*$reference_id = $headers['REFERENCEID'];
		$resp_status = $headers['RESPSTATUS'];*/
		traceActivity("...Agent[$agent_code]HEADERS=$trans_code=$service_code=$user_account=$description=$amount=$date_logged");	
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
							 
						   VALUES ('$header_id','$timestamp','$trans_id','$trans_code','$service_code','$user_account','$description',
						   			'$amount','$date_logged','$reference_id','$resp_status')";
	run_query($insert_sql); 

	logPostsFromHenry($trans_id,$trans_code,$service_code,$user_account,
							 $description,$amount,$date_logged,$reference_id,$resp_status,$headers2,$headers);

	traceActivity("...REQUEST LOGGED[".$header_id."]...");	
	
/************************************************************************************************************
DATA-MINE THE REQUEST////
*************************************************************************************************************/	
	
	$service_id = getServiceIDOfOptionCode($service_code);
	//echo "<hr>option details fetched...".$details['ServiceID']."<hr>";	
	$keyword = getKeyWordOfOptionCode($service_code);
	
	$action = getServiceTypeOfServiceID($service_id);
	//echo "<hr>Service Type fetched..<hr>";
		
	$option_id = getOptionIDOfOptionCode($service_code);
		
	$total_inputs = getNumberofInputsInOptionID($option_id);	
	
	$descr = explode("*",$description); //transaction_code * option_code * inputs * agentcode * email * phone //echo "<hr>".$description;
	
	$agent_index = 1 + $total_inputs + 1;
	$email_index = 1 + $total_inputs + 2;
	$phone_index = 1 + $total_inputs + 3;
	
	$agent_code = $descr[$agent_index];		//"CCNWEB";
	$phone = $descr[$phone_index];			//"0720810193";//$descr[2]; //customer phone number	
	$email = $descr[$email_index];			//$descr[3]; //customer email address	
	
	$inputs = $descr[2];
	
	traceActivity("...Inputs[".$total_inputs."] == AgentIndex[".$agent_index."] == AgentCode[".$agent_code.
					"] == Phone[".$phone."] == Email[".$email."]");
	
	$agent_id = getAgentIDByCode($agent_code);  //3rd party agent	
	
	
	
	$update_sql = "UPDATE ".DATABASE.".log_req set agent_id='".$agent_id."' where header_id='".$reference_id."'";
				
	//traceActivity("...".$update_sql."<br>");	
	$result = run_query($update_sql);
	if(!$result)
	{
	   // echo "Did not work...".pg_last_error(); 
		traceActivity("\n===".pg_last_error()."==");
	}
	
	
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
	if($trans_code == "BUYSERVICE")
	{
		//echo "<hr>in Paybill...=".$service_code."=<hr>";
		traceActivity("......BUYSERVICE INVOKED[".$action."]...");
			
		switch ($action) {
			case PARKING_TYPE:
			{
				traceActivity(".........PARKING INVOKED...");
				include "service_parking.php";
				break;
			}
			case MARKETS_TYPE:
			{
				traceActivity(".........MARKETS INVOKED...");
				include "service_markets.php";
				break;
			}
			case PSV_TYPE:
			{
				traceActivity(".........PSV INVOKED...");
				include "service_psv.php";
				break;
			}
			default:
				traceActivity(".........NOTHING INVOKED...");
			break;
		}
	}
	elseif($trans_code == "QUERYBILL")
	{
		traceActivity("......QUERYBILL INVOKED[".$keyword."]...");
		if($keyword == "QB_HOUSE")
		{
			$house_id = $inputs;
			if(houseExists($house_id))
				returnBillForHouse($trans_id,$trans_type,$reference_id,$house_id);
			else
				returnAccountNonExistent($trans_id,$trans_type,$reference_id,$house_id);
		}
		elseif($keyword == "QB_LANDRATE")
		{
			$rate_id = $inputs;
			if(landRateExists($rate_id))
				returnBillForLandRate($trans_id,$trans_type,$reference_id,$rate_id);
			else
				returnAccountNonExistent($trans_id,$trans_type,$reference_id,$rate_id);
		}
		elseif($keyword == "QB_BUSINESS")
		{
			$biz_id = $inputs;
			if(businessExists($biz_id))
				returnBillForBusiness($trans_id,$trans_type,$reference_id,$biz_id);
			else
				returnAccountNonExistent($trans_id,$trans_type,$reference_id,$biz_id);
		}
		elseif($keyword == "QB_CAR")
		{
			$car_no = $inputs;
			if(checkPendingBill($car_no) > 0)
				returnBillForCar($trans_id,$trans_type,$reference_id,$car_no);
			else
				returnComplianceStatus($trans_id,"VEHICLE",$reference_id,$car_no,"NOT CAPTURED IN THE SYSTEM FOR TODAY AS AT ".date("Y-m-d H:i:s"));
		}
		else
			returnDummyFor($trans_id,$trans_code,$reference_id);
	}
	elseif($trans_code == "COMPLIANCE")
	{
		traceActivity("......COMPLIANCE INVOKED[".$keyword."]...");
		if($keyword == "C_HSNUM")
		{
			$house_id = $inputs;
			if(checkPendingBill($house_id) > 0)
				returnComplianceStatus($trans_id,"HOUSE-RENT",$reference_id,$house_id,"NON-COMPLIANT");
			else
				returnComplianceStatus($trans_id,"HOUSE-RENT",$reference_id,$house_id,"COMPLIANT");
		}
		elseif($keyword == "C_LRNUM")
		{
			$rate_id = $inputs;
			$bill = checkPendingBill($rate_id);
			$curr_balance = getLandRateBalance($rate_id);
			
			traceActivity("..BUSINESS[".$rate_id."]...BILL:[".$bill."] ...CURRENT BALANCE[".$curr_balance."]");
			
			if($bill > 0 || $curr_balance > 0)
				returnComplianceStatus($trans_id,"PLOT-NUMBER",$reference_id,$rate_id,"NON-COMPLIANT");
			else
				returnComplianceStatus($trans_id,"PLOT-NUMBER",$reference_id,$rate_id,"COMPLIANT");
		}
		elseif($keyword == "C_BIZID")
		{
			$biz_id = $inputs;
			traceActivity("......COMPLIANCE BIZ_ID[".$biz_id."]...");
			$bill = checkPendingBill($biz_id);
			if( $bill> 0)
				returnComplianceStatus($trans_id,"BUSINESS-ID",$reference_id,$biz_id,"NON-COMPLIANT");
			else
				returnComplianceStatus($trans_id,"BUSINESS-ID",$reference_id,$biz_id,"COMPLIANT");
		}
		elseif($keyword == "C_CARNO")
		{
			$car_no = $inputs;
			$bill = checkPendingBill($car_no);
			$curr_status = getCarSessionStatus($car_no);
			
			traceActivity("..BUSINESS[".$rate_id."]...BILL:[".$bill."] ...CURRENT BALANCE[".$curr_balance."]");
			
			if($bill > 0)
				returnComplianceStatus($trans_id,"VEHICLE",$reference_id,$car_no,"NON-COMPLIANT");
			elseif($curr_status)
				returnComplianceStatus($trans_id,"VEHICLE",$reference_id,$car_no,"COMPLIANT");
			else
			    returnComplianceStatus($trans_id,"VEHICLE",$reference_id,$car_no,"NOT CAPTURED IN THE SYSTEM FOR TODAY AS AT ".date("Y-m-d H:i:s"));
		}
		elseif($keyword == "C_MAKID")
		{
			$mak_id = $inputs;
			if(checkPendingBill($mak_id) > 0)
				returnComplianceStatus($trans_id,"MARKET",$reference_id,$mak_id,"NON-COMPLIANT");
			else
				returnComplianceStatus($trans_id,"MARKET",$reference_id,$mak_id,"COMPLIANT");
		}
		else
		{
			$receipt = $inputs;
			checkReceiptCompliance($receipt,$trans_id,$reference_id);
		}
	}
	elseif($trans_code == "PAYBILL")
	{
		//insert into transactions table...
		//update bills table
		returnDummyFor($trans_id,$trans_code,$reference_id);
	}
	elseif($trans_code == "VALIDATERECEIPT")
	{
		returnDummyFor($trans_id,$trans_code,$reference_id);
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
	function returnDummyFor($trans_id,$trans_type,$reference_id)
	{
		$report = "CCN: REQUEST ".$trans_type." WAS SUCCESSFUL";
		$client = new SoapClient("http://192.168.100.13/bibi/soap/ccn_ebppp.wsdl");
			//echo "<hr>";
			$return_string = array('uspCode' => "CCN", 
								   'uspPassword' => "123456",
								   'uspTransCode' => "BUYSERVICE",
									'ebpppRequestId' => $trans_id,
									'transStatus' => "SUCCESS",
									'uspReceipt' => "xxx",
									'uspTransId' => $reference_id, 
									'uspResponse' => $report);
			$client->uspReturn($return_string);
	}
	
	function returnComplianceStatus($trans_id,$nature,$reference_id,$acc_id,$status)
	{
		$report = "CCN: YOUR ".$nature." Account[".$acc_id."] IS ".$status." Contact Customer Care in-case of any questions...";
		$client = new SoapClient("http://192.168.100.13/bibi/soap/ccn_ebppp.wsdl");
			//echo "<hr>";
			$return_string = array('uspCode' => "CCN", 
								   'uspPassword' => "123456",
								   'uspTransCode' => "COMPLIANCE",
									'ebpppRequestId' => $trans_id,
									'transStatus' => "SUCCESS",
									'uspReceipt' => "xxx",
									'uspTransId' => $reference_id, 
									'uspResponse' => $report);
			$client->uspReturn($return_string);
	}
	
	function returnDummyForBusiness($trans_id,$trans_type,$reference_id,$biz_id)
	{
		$report = "CCN: REQUEST ".$trans_type." WAS SUCCESSFUL. YOUR TOTAL BILL IS: Ksh. " .getBusinessRate($biz_id);
		$client = new SoapClient("http://192.168.100.13/bibi/soap/ccn_ebppp.wsdl");
			//echo "<hr>";
			$return_string = array('uspCode' => "CCN", 
								   'uspPassword' => "123456",
								   'uspTransCode' => "BUYSERVICE",
									'ebpppRequestId' => $trans_id,
									'transStatus' => "SUCCESS",
									'uspReceipt' => "xxx",
									'uspTransId' => $reference_id, 
									'uspResponse' => $report);
			$client->uspReturn($return_string);
	}

	function returnBillForBusiness($trans_id,$trans_type,$reference_id,$biz_id)
	{
		$report = "CCN: QUERYBILL FOR BUSINESS[".$biz_id."] WAS SUCCESSFUL. YOUR TOTAL BILL IS: Ksh. " .getBusinessRate($biz_id);
		$client = new SoapClient("http://192.168.100.13/bibi/soap/ccn_ebppp.wsdl");
			//echo "<hr>";
			$return_string = array('uspCode' => "CCN", 
								   'uspPassword' => "123456",
								   'uspTransCode' => "QUERYBILL",
									'ebpppRequestId' => $trans_id,
									'transStatus' => "SUCCESS",
									'uspReceipt' => "xxx",
									'uspTransId' => $reference_id, 
									'uspResponse' => $report);
			$client->uspReturn($return_string);
	}
	
	function returnBillForHouse($trans_id,$trans_type,$reference_id,$house_id)
	{
		$report = "CCN:QUERYBILL FOR HOUSE[".$house_id."] WAS SUCCESSFUL. YOUR TOTAL BILL IS: Ksh. " . 
					getHouseRate($house_id)." as at ".date("Y-m-d");
		$client = new SoapClient("http://192.168.100.13/bibi/soap/ccn_ebppp.wsdl");
			//echo "<hr>";
			$return_string = array('uspCode' => "CCN", 
								   'uspPassword' => "123456",
								   'uspTransCode' => "QUERYBILL",
									'ebpppRequestId' => $trans_id,
									'transStatus' => "SUCCESS",
									'uspReceipt' => "xxx",
									'uspTransId' => $reference_id, 
									'uspResponse' => $report);
			$client->uspReturn($return_string);
	}
	
	function returnBillForCar($trans_id,$trans_type,$reference_id,$car_no)
	{
		$report = "CCN:QUERYBILL FOR CAR[".$car_no."] WAS SUCCESSFUL. YOUR TOTAL BILL IS: Ksh. " . 
					getCarBill($car_no)." as at ".date("Y-m-d H:i:s");
		$client = new SoapClient("http://192.168.100.13/bibi/soap/ccn_ebppp.wsdl");
			//echo "<hr>";
			$return_string = array('uspCode' => "CCN", 
								   'uspPassword' => "123456",
								   'uspTransCode' => "QUERYBILL",
									'ebpppRequestId' => $trans_id,
									'transStatus' => "SUCCESS",
									'uspReceipt' => "xxx",
									'uspTransId' => $reference_id, 
									'uspResponse' => $report);
			$client->uspReturn($return_string);
	}
	
	function returnBillForLandRate($trans_id,$trans_type,$reference_id,$rate_id)
	{
		$report = "CCN:QUERYBILL FOR LANDRATE[".$rate_id."] WAS SUCCESSFUL. YOUR CURRENT BALANCE IS: Ksh. " .
		getLandRateBalance($rate_id)." as at ".date("Y-m-d")." AND YOUR ANNUAL RATE IS Ksh. ".getLandRate($rate_id);
		$client = new SoapClient("http://192.168.100.13/bibi/soap/ccn_ebppp.wsdl");
			//echo "<hr>";
			$return_string = array('uspCode' => "CCN", 
								   'uspPassword' => "123456",
								   'uspTransCode' => "QUERYBILL",
									'ebpppRequestId' => $trans_id,
									'transStatus' => "SUCCESS",
									'uspReceipt' => "xxx",
									'uspTransId' => $reference_id, 
									'uspResponse' => $report);
			$client->uspReturn($return_string);
	}
	
	function returnAccountNonExistent($trans_id,$trans_type,$reference_id,$rate_id)
	{
		$report = "CCN:This Account[".$rate_id."] Does Not Exist In Our Database... ";
		$client = new SoapClient("http://192.168.100.13/bibi/soap/ccn_ebppp.wsdl");
			//echo "<hr>";
			$return_string = array('uspCode' => "CCN", 
								   'uspPassword' => "123456",
								   'uspTransCode' => "QUERYBILL",
									'ebpppRequestId' => $trans_id,
									'transStatus' => "SUCCESS",
									'uspReceipt' => "xxx",
									'uspTransId' => $reference_id, 
									'uspResponse' => $report);
		$client->uspReturn($return_string);
	}
	function getBusinessRate($biz_id)
	{
		$query = "SELECT * FROM ".DATABASE.".business WHERE business_id = '$biz_id'";
		$data = run_query($query);
		$arr = get_row_data($data);
		$act = $arr['activity_code'];
		
		$query = "SELECT * FROM ".DATABASE.".business_activitycode_rates WHERE activity_code = '$act'";
		$data2 = run_query($query);
		$arr = get_row_data($data2);
		$rate = $arr['activity_rate'];
		return $rate;
	}
	
	function getHouseRate($house_id)
	{
		$query = "SELECT * FROM ".DATABASE.".house_rent WHERE house_number = '$house_id'";
		$data = run_query($query);
		$arr = get_row_data($data);
		$rate = $arr['house_rate'];

		return $rate;
	}	
	
	function getLandRate($rate_id)
	{
		$query = "SELECT * FROM ".DATABASE.".land_rates WHERE plot_number = '$rate_id'";
		$data = run_query($query);
		$arr = get_row_data($data);
		$rate = $arr['land_rates_annual'];
		return $rate;
	}
	
	function getLandRateBalance($rate_id)
	{
		$query = "SELECT * FROM ".DATABASE.".land_rates WHERE plot_number = '$rate_id'";
		$data = run_query($query);
		$arr = get_row_data($data);
		$rate = $arr['land_rates_currentbalance'];
		return $rate;
	}
	
	function getCarBill($car_no)
	{
		$total_bill = 0;
		$query = "SELECT * FROM ".DATABASE.".customer_bills WHERE service_account = '$car_no' and bill_status='0'";
		$data = run_query($query);
		while($arr = get_row_data($data))
		{
			$total_bill += $arr['bill_amt'];
		}
		return $total_bill;
	}
	
	function getCarSessionStatus($car_no)
	{
		$now = time();
		$query = "SELECT * FROM ".DATABASE.".parking_session WHERE time_out < $now and plate_number ='$plate_number'";
		$data = run_query($query);
		if(get_num_rows($data) > 0)
		{
			return true;
		}
		else
			return false;
	}
	
	function landRateExists($plotnum)
	{
		$query = "SELECT * FROM ".DATABASE.".land_rates WHERE plot_number ='$plotnum' OR upn_number ='$plotnum'";
		$data = run_query($query);
		if(get_num_rows($data) > 0)
		{
			return true;
		}
		else
			return false;
	}
	
	function houseExists($plotnum)
	{
		$query = "SELECT * FROM ".DATABASE.".house_rent WHERE house_number ='$plotnum'";
		$data = run_query($query);
		if(get_num_rows($data) > 0)
		{
			return true;
		}
		else
			return false;
	}
	
	function businessExists($plotnum)
	{
		$query = "SELECT * FROM ".DATABASE.".business WHERE business_id ='$plotnum'";
		$data = run_query($query);
		if(get_num_rows($data) > 0)
		{
			return true;
		}
		else
			return false;
	}
	
	function checkPendingBill($acc_no)
	{
		$total_bill = 0;
		$query = "SELECT * FROM ".DATABASE.".customer_bills WHERE service_account = '$acc_no' and bill_status='0'";
		$data = run_query($query);
		while($arr = get_row_data($data))
		{
			$total_bill += $arr['bill_amt'];
		}
		return $total_bill;
	}
	
	function checkReceiptCompliance($receipt,$trans_id,$reference_id)
	{
		$today = date("Y-m-d");
		$query = "SELECT * FROM ".DATABASE.".transactions WHERE receiptnumber = '$receipt'";
		$data = run_query($query);
		
		if(get_num_rows($data) > 0)
		{
			$rows = get_row_data($data);
			$report= "Receipt[".$receipt."] is valid for Transaction: ". $rows['transaction_id']. ", Date: ".$rows['normal_date'].
			" For Ksh. ".$rows['cash_paid'];						
		}
		else
		{			
			$report= "Receipt[".$receipt."] is not Valid";
		}	
		
		$client = new SoapClient("http://192.168.100.13/bibi/soap/ccn_ebppp.wsdl");
		//echo "<hr>";
		$return_string = array('uspCode' => "CCN", 
							   'uspPassword' => "123456",
							   'uspTransCode' => "COMPLIANCE",
								'ebpppRequestId' => $trans_id,
								'transStatus' => "SUCCESS",
								'uspReceipt' => "xxx",
								'uspTransId' => $reference_id, 
								'uspResponse' => $report);
		$client->uspReturn($return_string);			
	}
	
	function traceActivity($text)
	{
		$today = time();
		
		$myFile = "jairoposts.txt";
		$fh = fopen($myFile,'a');			
		
		fwrite($fh, $today."==".$text."\n");	   
		fclose($fh);
	}			
?>