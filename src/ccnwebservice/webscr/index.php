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
	//-$options_url,$inputs_url);
	
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
		$description = $_POST['DESCRIPTION']; //Transaction Customer Inputs
		$customer_email = $_POST['CUSTOMEREMAIL'];
		$customer_phone = $_POST['CUSTOMERPHONE'];
		$amount = $_POST['AMOUNT'];
		$date_logged = $_POST['DATELOGGED'];
		$swc_version = $_POST['swc_version'];
		traceActivity("...Agent[$agent_code]POST=$trans_code=$service_code=UA[$user_account]=DESCR[$description]=$amount=$date_logged=SWC[$swc_version]");		
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
	
	if($swc_version == "1.0")
	{
		include "swcversion1/functions.php";
		traceActivity("...SWC PICKED[".$swc_version."]...");	
	}
	elseif($swc_version == "1.1")
	{
		include "swcversion2/functions.php";
		traceActivity("...SWC PICKED[".$swc_version."]...");
	}
	else
	{
		traceActivity("ERROR: SWC INVALID[".$swc_version."]...");
	}
	
	$service_id = getServiceIDOfOptionCode($service_code);
	traceActivity("Service code is: ".$service_code." and Service_id is: ".$service_id);
	//echo "<hr>option details fetched...".$details['ServiceID']."<hr>";	
	$keyword = getKeyWordOfOptionCode($service_code);
	traceActivity("Keyword is: ".$keyword);
	$action = getServiceTypeOfServiceID($service_id);
	//echo "<hr>Service Type fetched..<hr>";
	traceActivity("Action is: ".$action);	
	$option_id = getOptionIDOfOptionCode($service_code);
		traceActivity("Option is: ".$option_id);
	$total_inputs = getNumberofInputsInOptionID($option_id);	
	traceActivity("Total Inputs is: ".$total_inputs);
	$descr = explode("*",$description); //transaction_code * option_code * inputs * agentcode * email * phone //echo "<hr>".$description;
	
	$agent_index = 1 + $total_inputs + 1;
	$email_index = 1 + $total_inputs + 2;
	$phone_index = 1 + $total_inputs + 3;
	
	//$agent_code = $descr[$agent_index];		//"CCNWEB";
	$phone = $customer_phone; //$descr[$phone_index];			//"0720810193";//$descr[2]; //customer phone number	
	$email = $customer_email; //$descr[$email_index];			//$descr[3]; //customer email address	
	
	$inputs = $description;
	
	traceActivity("...Inputs[".$total_inputs."--".$inputs."] == AgentIndex[".$agent_index."] == AgentCode[".$agent_code.
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
				updateRequestLog($reference_id,PARKING_SERVICE_ACCOUNT);
				traceActivity(".........PARKING INVOKED...");
				include "service_parking.php";
				break;
			}
			case MARKETS_TYPE:
			{
				updateRequestLog($reference_id,MARKETS_SERVICE_ACCOUNT);
				traceActivity(".........MARKETS INVOKED...");
				include "service_markets.php";
				break;
			}
			case PSV_TYPE:
			{
				updateRequestLog($reference_id,PARKING_SERVICE_ACCOUNT);
				traceActivity(".........PSV INVOKED...");
				include "service_psv.php";
				break;
			}
			default:
				traceActivity(".........NOTHING INVOKED...");
				$client = new SoapClient("http://192.168.100.13/bibi/soap/ccn_ebppp.wsdl");
				//echo "<hr>";
				$return_string = array('uspCode' => "CCN", 
									   'uspPassword' => "123456",
									   'uspTransCode' => "BUYSERVICE",
										'ebpppRequestId' => $trans_id,
										'transStatus' => "FAIL",
										'uspReceipt' => "NoReceipt",
										'uspTransId' => $reference_id, 
										'uspResponse' => "ERROR: Option Code could not be mapped to a specific service...");
				$client->uspReturn($return_string);
			break;
		}
	}
	elseif($trans_code == "QUERYBILL")
	{
		traceActivity("......QUERYBILL INVOKED[".$keyword."]...");
		if($keyword == "QB_HOUSE")
		{
			updateRequestLog($reference_id,RENTS_SERVICE_ACCOUNT);
			$house_id = strtoupper($inputs);
			if(houseExists($house_id))
				returnBillForHouse($trans_id,$trans_type,$reference_id,$house_id);
			else
				returnAccountNonExistent($trans_id,$trans_type,$reference_id,$house_id);
		}
		elseif($keyword == "QB_LANDRATE")
		{
			updateRequestLog($reference_id,RATES_SERVICE_ACCOUNT);
			$rate_id = strtoupper($inputs);
			if(landRateExists($rate_id))
				returnBillForLandRate($trans_id,$trans_type,$reference_id,$rate_id);
			else
				returnAccountNonExistent($trans_id,$trans_type,$reference_id,$rate_id);
		}
		elseif($keyword == "QB_BUSINESS")
		{
			updateRequestLog($reference_id,SBP_SERVICE_ACCOUNT);
			$biz_id = strtoupper($inputs);
			if(businessExists($biz_id))
				returnBillForBusiness($trans_id,$trans_type,$reference_id,$biz_id);
			else
				returnAccountNonExistent($trans_id,$trans_type,$reference_id,$biz_id);
		}
		elseif($keyword == "QB_CAR")
		{
			updateRequestLog($reference_id,PARKING_SERVICE_ACCOUNT);
			$car_no = strtoupper($inputs);
			if(checkPendingBill($car_no,'1') > 0)
				returnBillForCar($trans_id,$trans_type,$reference_id,$car_no);
			else
				returnComplianceStatus($trans_id,"VEHICLE",$reference_id,$car_no,"NOT BILLED IN THE SYSTEM FOR TODAY AS AT ".date("Y-m-d H:i:s"));
		}
		else
			returnDummyFor($trans_id,$trans_code,$reference_id);
	}
	elseif($trans_code == "COMPLIANCE")
	{
		traceActivity("......COMPLIANCE INVOKED[".$keyword."]...");
		
		if($keyword == "C_HSNUM")
		{
			updateRequestLog($reference_id,RENTS_SERVICE_ACCOUNT);
			$house_id = strtoupper($inputs);
			if(checkPendingBill($house_id,'5') > 0)
				returnComplianceStatus($trans_id,"HOUSE-RENT",$reference_id,$house_id,"NON-COMPLIANT");
			elseif(houseExists($house_id))
				returnComplianceStatus($trans_id,"HOUSE-RENT",$reference_id,$house_id,"COMPLIANT");
			else
				returnAccountNonExistent($trans_id,$trans_type,$reference_id,$house_id);
		}
		elseif($keyword == "C_LRNUM")
		{
			updateRequestLog($reference_id,RATES_SERVICE_ACCOUNT);
			$rate_id = strtoupper($inputs);
			$bill = checkPendingBill($rate_id,'4');
			$curr_balance = getLandRateBalance($rate_id);
			
			traceActivity("..RATES[".$rate_id."]...BILL:[".$bill."] ...CURRENT BALANCE[".$curr_balance."]");
			
			if($bill > 0 || $curr_balance > 0)
				returnComplianceStatus($trans_id,"PLOT-NUMBER",$reference_id,$rate_id,"NON-COMPLIANT");
			elseif(landRateExists($rate_id))
				returnComplianceStatus($trans_id,"PLOT-NUMBER",$reference_id,$rate_id,"COMPLIANT");
			else
				returnAccountNonExistent($trans_id,$trans_type,$reference_id,$rate_id);
		}
		elseif($keyword == "C_BIZID")
		{
			updateRequestLog($reference_id,SBP_SERVICE_ACCOUNT);
			$biz_id = strtoupper($inputs);
			traceActivity("......COMPLIANCE BIZ_ID[".$biz_id."]...");
			$bill = checkPendingBill($biz_id,'3');
			if( $bill> 0)
				returnComplianceStatus($trans_id,getBusinessName($biz_id)." BUSINESS-ID",$reference_id,$biz_id,"NON-COMPLIANT");
			elseif(businessExists($biz_id))
				returnComplianceStatus($trans_id,getBusinessName($biz_id)." BUSINESS-ID",$reference_id,$biz_id,"COMPLIANT");
			else
				returnAccountNonExistent($trans_id,$trans_type,$reference_id,$biz_id);
		}
		elseif($keyword == "C_CARNO")
		{
			updateRequestLog($reference_id,PARKING_SERVICE_ACCOUNT);
			$car_no = strtoupper($inputs);
			$bill = checkPendingBill($car_no,'1');
			$curr_status = getCarSessionStatus($car_no);
			
			traceActivity("..CAR[".$rate_id."]...BILL:[".$bill."] ...CURRENT BALANCE[".$curr_balance."]");
			
			if($bill > 0)
				returnComplianceStatus($trans_id,"VEHICLE",$reference_id,$car_no,"NON-COMPLIANT");
			elseif($curr_status)
				returnComplianceStatus($trans_id,"VEHICLE",$reference_id,$car_no,"COMPLIANT");
			else
			    returnComplianceStatus($trans_id,"VEHICLE",$reference_id,$car_no,"NOT CAPTURED IN THE SYSTEM FOR TODAY AS AT ".date("Y-m-d H:i:s"));
		}
		elseif($keyword == "C_MAKID")
		{
			updateRequestLog($reference_id,MARKETS_SERVICE_ACCOUNT);
			$mak_id = strtoupper($inputs);
			
			$curr_status = getMarketSessionStatus($mak_id);
			
			if(checkPendingBill($mak_id,'2') > 0)
				returnComplianceStatus($trans_id,"MARKET",$reference_id,$mak_id,"NON-COMPLIANT");
			elseif($curr_status)
				returnComplianceStatus($trans_id,"MARKET-ID",$reference_id,$car_no,"COMPLIANT");
			else
			    returnComplianceStatus($trans_id,"MARKET-ID",$reference_id,$car_no,"NOT CAPTURED IN THE SYSTEM FOR TODAY AS AT ".date("Y-m-d H:i:s"));
		}
		else
		{
			$receipt = strtoupper($inputs);
			checkReceiptCompliance($receipt,$trans_id,$reference_id);
		}
	}
	elseif($trans_code == "PAYBILL")
	{
		traceActivity("......PAYBILL INVOKED[".$keyword."]...");
		$values = explode("*",$inputs);
		$bill_id = $user_account;
		$paid_amt = $amount;
		if(billExists($bill_id))
		{
			traceActivity("Bill Exists(=$bill_id=)");
			$receipt = processBillPayment($bill_id,$paid_amt,$agent_id,$agent_trans_id,$service_id,$service_type,$description);
			traceActivity("Paybill Receipt(=$receipt=)");
			returnPayBillResult($trans_id,$trans_type,$reference_id,$bill_id,$receipt);
			traceActivity("Response Returned");
		}

		else
		{
			traceActivity("Bill Doesn't Exists(=$bill_id=)");	
			returnBillUnknown($trans_id,$trans_code,$reference_id,$bill_id);
		}
		//update bills table
		//returnDummyFor($trans_id,$trans_code,$reference_id);
	}
	elseif($trans_code == "VALIDATERECEIPT")
	{
		returnDummyFor($trans_id,$trans_code,$reference_id);
	}
	elseif($trans_code == "CHECKBILLAMOUNT")
	{
		$bill_id = $user_account;
		
		traceActivity("......CHECKBILLAMOUNT INVOKED[".$bill_id."]...");
		
		if(billExists($bill_id))
			returnBillAmount($trans_id,$trans_code,$reference_id,$bill_id);
		else
			returnBillUnknown($trans_id,$trans_code,$reference_id,$bill_id);
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
		$report = "CCN: DEFAULT REQUEST ".$trans_type." WAS NOT SUCCESSFUL";
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
		$report = $nature." ACCOUNT ".$acc_id." IS ".$status." Contact Customer Care on 020 344 194 for any further help.";
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
	
	function returnBillAmount($trans_id,$nature,$reference_id,$bill_id)
	{
		
		traceActivity("......in REturn Bill Amount of Bill [".$bill_id."]...");
		$total = getBillBalance($bill_id);
		$report = $total;
		//$report = "CCN:Bill-".$bill_id."- Current Balance is Ksh. ".$total.":".$total;
		$client = new SoapClient("http://192.168.100.13/bibi/soap/ccn_ebppp.wsdl");
			//echo "<hr>";
			$return_string = array('uspCode' => "CCN", 
								   'uspPassword' => "123456",
								   'uspTransCode' => "PAYBILL",
									'ebpppRequestId' => $trans_id,
									'transStatus' => "SUCCESS",
									'uspReceipt' => "xxx",
									'uspTransId' => $reference_id, 
									'uspResponse' => $report);
			$client->uspReturn($return_string);
	}
	function returnBillUnknown($trans_id,$nature,$reference_id,$bill_id,$status)
	{
		$report = "CCN:Bill - ".$bill_id." - Doesnt exist in our system...";
		$client = new SoapClient("http://192.168.100.13/bibi/soap/ccn_ebppp.wsdl");
			//echo "<hr>";
			$return_string = array('uspCode' => "CCN", 
								   'uspPassword' => "123456",
								   'uspTransCode' => "PAYBILL",
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
		$report = "CCN:BUSINESS- ".$biz_id." - ".getBusinessName($biz_id).". YOUR TOTAL BILL IS: Ksh. " .checkPendingBill($biz_id,'3');
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
		$report = "CCN:QUERYBILL FOR HOUSE/MARKET-STALL ".$house_id.", ".getHouseEstate($house_id).". YOUR TOTAL BILL IS: Ksh. " . 
					checkPendingBill($house_id,'5')." as at ".date("Y-m-d");
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
		$report = "CCN:QUERYBILL FOR CAR-".$car_no." WAS SUCCESSFUL. YOUR TOTAL BILL IS: Ksh. " . 
					checkPendingBill($car_no,'1')." as at ".date("Y-m-d H:i:s");
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
		$report = "LANDRATE ".$rate_id." ".getLandRateContact($rate_id).". CURRENT BALANCE: Ksh. " .
		formatMoney(checkPendingBill($rate_id,'4'),2)." as at ".date("Y-m-d H:i").". ANNUAL RATE: Ksh. ".formatMoney(getLandRate($rate_id),2);
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
		$report = "CCN:This Account-".$rate_id."- Does Not Exist In Our Database... ";
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
	
	function returnPayBillResult($trans_id,$trans_type,$reference_id,$bill_id,$receipt)
	{
		$report = "CCN:Bill-".$bill_id." Was Successfully Credited. Receipt: ".$receipt;
		$client = new SoapClient("http://192.168.100.13/bibi/soap/ccn_ebppp.wsdl");
			//echo "<hr>";
			$return_string = array('uspCode' => "CCN", 
								   'uspPassword' => "123456",
								   'uspTransCode' => "PAYBILL",
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
	
	function getBusinessName($biz_id)
	{
		$query = "SELECT * FROM ".DATABASE.".business WHERE business_id = '$biz_id'";
		$data = run_query($query);
		$arr = get_row_data($data);
		$act = $arr['business_name'];
		return $act;
	}
	
	function getHouseRate($house_id)
	{
		$query = "SELECT * FROM ".DATABASE.".house_rent WHERE house_number = '$house_id'";
		$data = run_query($query);
		$arr = get_row_data($data);
		$rate = $arr['house_rate'];

		return $rate;
	}	
	
	function getHouseEstate($house_id)
	{
		$query = "SELECT * FROM ".DATABASE.".house_rent WHERE house_number = '$house_id'";
		$data = run_query($query);
		$arr = get_row_data($data);
		$rate = $arr['house_estate'];

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
		$query = $query = "SELECT * FROM ".DATABASE.".land_rates WHERE plot_number = '$rate_id'";
		$data = run_query($query);
		$arr = get_row_data($data);
		$rate = $arr['balance'];
		return $rate;
	}
	
	function getLandRateContact($rate_id)
	{
		$query = "SELECT * FROM ".DATABASE.".land_rates WHERE plot_number = '$rate_id'";
		$data = run_query($query);
		$arr = get_row_data($data);
		$rate = $arr['contact_name'];
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
		$query = "SELECT * FROM ".DATABASE.".parking_session WHERE time_out > $now and plate_number ='$plate_number'";
		$data = run_query($query);
		if(get_num_rows($data) > 0)
		{
			return true;
		}
		else
			return false;
	}
	
	function getMarketSessionStatus($mak_id)
	{
		$now = time();
		$query = "SELECT * FROM ".DATABASE.".markets_session WHERE time_out > $now and customer_marketid ='$mak_id'";
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
	
	function billExists($bill_id)
	{
		$query = "SELECT * FROM ".DATABASE.".customer_bills WHERE bill_id ='$bill_id'";
		$data = run_query($query);
		if(get_num_rows($data) > 0)
		{
			return true;
		}
		else
			return false;
	}
	
	function checkPendingBill($acc_no,$acc_type)
	{
		$total_bill = 0;
		$query = "SELECT * FROM ".DATABASE.".customer_bills WHERE service_account = '$acc_no' and bill_status='0' AND service_account_type = '$acc_type'";
		$data = run_query($query);
		while($arr = get_row_data($data))
		{
			$total_bill += $arr['bill_balance'];
		}
		return $total_bill;
	}
	
	function getBillAmount($bill_id)
	{
		$total_bill = 0;
		$query = "SELECT * FROM ".DATABASE.".customer_bills WHERE bill_id = '$bill_id'";
		$data = run_query($query);
		while($arr = get_row_data($data))
		{
			$total_bill += $arr['bill_amt'];
		}
		return $total_bill;
	}
	
	function getBillBalance($bill_id)
	{
		$total_bill = 0;
		$query = "SELECT * FROM ".DATABASE.".customer_bills WHERE bill_id = '$bill_id'";
		$data = run_query($query);
		while($arr = get_row_data($data))
		{
			$total_bill += $arr['bill_balance'];
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
	
	function processBillPayment($bill_id,$paid_amt,$agent_id,$agent_trans_id,$service_id,$service_type,$user_account)
	{
		
		traceActivity("In ProcessBillPayment");
		$today = date("Y-m-d");
		$trans_id = getnextID(DATABASE.".transactions", "transaction_id",1);

		$service_id = 6;
		$service_type = 6;
		
		$transaction_id = $trans_id;
		
		$receipt = "CCNBL" .$bill_id."T".$trans_id;			
		
		$ins_sql = "INSERT INTO ".DATABASE.".transactions(transaction_id, receiptnumber, agent_id, agent_trans_id, service_id,service_type_id, cash_paid,
														  transaction_date,completed,service_account,bill_id)
					   VALUES ('$trans_id','$receipt','$agent_id','$agent_trans_id','$service_id','$service_type','$paid_amt','$today','FALSE','$user_account','$bill_id')";
		traceActivity($ins_sql);			
		run_query($ins_sql);
		
		
		$update_sql = "UPDATE ".DATABASE.".customer_bills set 
						   bill_balance=bill_balance - $paid_amt where 
						   bill_id='".$bill_id."'";
				
		//traceActivity("<hr>".$insert_sql."<br>");	
		$result = run_query($update_sql);
		
		
		if(isBillCleared($bill_id))
		{
			$update_sql = "UPDATE ".DATABASE.".customer_bills set 
							   bill_status=1 where 
							   bill_id='".$bill_id."'";
		
			traceActivity($update_sql);
			run_query($update_sql);
			
			traceActivity("Bill has been cleared!");
		}
		return $receipt;
	}
	
	function isBillCleared($bill_id)
	{
		if(totalPaidForBill($bill_id) >= getBillBalance($bill_id))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function totalPaidForBill($bill_id)
	{
		$total_paid = 0;
		$query = "SELECT * FROM ".DATABASE.".transactions WHERE bill_id = '$bill_id'";
		$data = run_query($query);
		while($arr = get_row_data($data))
		{
			$total_paid += $arr['cash_paid'];
		}
		return $total_paid;
	}
	
	function traceActivity($text)
	{
		$today = time();
		$today = $today . " | ". date("Y-m-d H:i:s");
		
		$myFile = "jairoposts.txt";
		$fh = fopen($myFile,'a');			
		
		fwrite($fh, $today."==".$text."\n");	   
		fclose($fh);
	}
	
	function updateRequestLog($biz_id,$sa)
	{
		$query = "UPDATE ".DATABASE.".log_req SET service_account_type='$sa' WHERE header_id = '$biz_id'";
		$data = run_query($query);
	}			
?>