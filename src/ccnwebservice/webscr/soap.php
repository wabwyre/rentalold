<?
    /*
     *CCN MODULES WEB-SERVICE TO RECEIVE REQUESTS FROM EBPPP, INSPECTOR JAVA AND CUSTOMER JAVA
    *AUTHOR: JAIRUS OBUHATSA
    *DATE: 14/07/2011
    */
    traceActivity("\nNew Hit..");
    include "../connection/config.php";
    //echo "<hr>DATA CONNECTION DONE...1<hr>";
    include "../library.php";
    //echo "<hr>Library Loaded...1<hr>";
    //include "../agent_functions.php";
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


class ccnWebservice{

	function RequestCCN($symbol)
	{
		$timestamp = time();

		$trans_id = $symbol->TRANSACTIONID;  //transaction id from sender
		$trans_code = $symbol->TRANSACTIONCODE; //Paybill,QueryBill,Compliance
		$service_code = $symbol->SERVICECODE;  //Parking/Markets/SBP etc
		$user_account = $symbol->USERACCOUNT; //Service Anchor like plate_number
		$agent_code = $symbol->AGENTCODE; //keyword code of third party agent
		$description = $symbol->DESCRIPTION; //Transaction Customer Inputs
		$customer_email = $symbol->CUSTOMEREMAIL;
		$customer_phone = $symbol->CUSTOMERPHONE;
		$amount = $symbol->AMOUNT;
		$date_logged = $symbol->DATELOGGED;
		$swc_version = $symbol->SWCVERSION;
		traceActivity("...Agent[$agent_code]POST=$trans_code=$service_code=UA[$user_account]=DESCR[$description]=
		$amount=$date_logged=SWC[$swc_version]");

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
				if(checkPendingBill($car_no) > 0)
					returnBillForCar($trans_id,$trans_type,$reference_id,$car_no);
				else
					returnComplianceStatus($trans_id,"VEHICLE",$reference_id,$car_no,"NOT BILLED IN THE SYSTEM
					 FOR TODAY AS AT ".date("Y-m-d H:i:s"));
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
				if(checkPendingBill($house_id) > 0)
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
				$bill = checkPendingBill($rate_id);
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
				$bill = checkPendingBill($biz_id);
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
				$bill = checkPendingBill($car_no);
				$curr_status = getCarSessionStatus($car_no);

				traceActivity("..CAR[".$rate_id."]...BILL:[".$bill."] ...CURRENT BALANCE[".$curr_balance."]");

				if($bill > 0)
					returnComplianceStatus($trans_id,"VEHICLE",$reference_id,$car_no,"NON-COMPLIANT");
				elseif($curr_status)
					returnComplianceStatus($trans_id,"VEHICLE",$reference_id,$car_no,"COMPLIANT");
				else
					returnComplianceStatus($trans_id,"VEHICLE",$reference_id,$car_no,"NOT CAPTURED IN THE SYSTEM FOR
					TODAY AS AT ".date("Y-m-d H:i:s"));
			}
			elseif($keyword == "C_MAKID")
			{
				updateRequestLog($reference_id,MARKETS_SERVICE_ACCOUNT);
				$mak_id = strtoupper($inputs);

				$curr_status = getMarketSessionStatus($mak_id);

				if(checkPendingBill($mak_id) > 0)
					returnComplianceStatus($trans_id,"MARKET",$reference_id,$mak_id,"NON-COMPLIANT");
				elseif($curr_status)
					returnComplianceStatus($trans_id,"MARKET-ID",$reference_id,$car_no,"COMPLIANT");
				else
					returnComplianceStatus($trans_id,"MARKET-ID",$reference_id,$car_no,"NOT CAPTURED IN THE SYSTEM FOR
					TODAY AS AT ".date("Y-m-d H:i:s"));
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
			$bill_id = $user_account;//the bill number
			$paid_amt = $amount; //the amount
			if(billExists($bill_id)) //if bill is found
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

		$response['REQUESTSTATUS'] = "REQSUCCESS";
		$response['TRANSACTIONID'] = $trans_id;
		$response['CCNTRANSID'] = $reference_id;
		$response['CCNRESPONSE'] = "REQUEST_QUEUED";

		return $response;

    }//end of RequestCCN


    /*CONSTRUCTION PERMITS BEGIN*/
    function registerConstructionPermit($symbol) //For EAP_SAP to register a SBP User
    {
        $agent = $symbol->AGENTCODE;
        $agent_pwd = $symbol->AGENTPASSWORD;
        $agent_trans_id = $symbol->AGENTTRANSID;
        $cust_option = 	$symbol->CUSTOMEROPTION;
        $cust_id =	$symbol->CUSTOMERID;
        $CPermit_id =	$symbol->CPERMITID;
        $swc_version = $symbol->SWCVERSION;

        //$service_account_type = 7;
        //check if sof code and password correct
        //check if ebppp transid exists



        if($CPermit_id == "" || $cust_id == "")
        {
            $response['REQUESTSTATUS'] = "REQFAIL";
            $response['CCNRESPONSE'] = "ERROR in Request: Invalid CPermit ID or Customer ID...";
            return $response;
        }

        $query = "SELECT architect_name,architect_number FROM ".DATABASE.".construction_permits WHERE construction_permits_id =   '$CPermit_id'";
        $data = run_query($query);
        $rows = get_row_data($data);

        if(get_num_rows($data)>0)
        {
            $name = trim($rows['architect_name']);

            $customer = $rows['architect_number'];

                if($customer < 1)
                {
                        $record_sql = "UPDATE ".DATABASE.".construction_permits set
                                                           architect_number='$cust_id' where

                                                           costruction_permits_id='$CPermit_id'";
                        $result = run_query($record_sql);


                        $bills_sql = "UPDATE ".DATABASE.".customer_bills set
                                                           customer_id='$cust_id' where
                                                           service_account='$CPermit_id'";

                        $result = run_query($bills_sql);


                        $response['REQUESTSTATUS'] = "REQSUCCESS";
                        $response['CCNRESPONSE'] = $CPermit_id.":".$name;
                }
                else
                {
                        $response['REQUESTSTATUS'] = "REQFAIL";
                        $response['CCNRESPONSE'] = $CPermit_id.":CPERMIT-ID ALREADY ASSIGNED TO ANOTHER CUSTOMER PROFILE, CONTACT CUSTOMER CARE 					FOR HELP...";
                }


            }
            else
            {
                    $response['REQUESTSTATUS'] = "REQFAIL";
                    $response['CCNRESPONSE'] = $CPermit_id.":NO SUCH PERMIT-ID EXISTING IN OUR DATABASE...";
            }

        $response['CPERMITID']=$CPermit_id;
        return $response;
    }


    /*CONSTRUCTION PERMIT ENDS*/
    /*SUBSCRIBE CONTACT BEGINS */
    function subscribeContact($symbol)
    {
            $agent_code = $symbol->AGENTCODE;
            $service = $symbol->SERVICE;
            $account = $symbol->ACCOUNT;
            $email = $symbol->EMAIL;
            $phone = $symbol->PHONE;

            $serv['PARKING'] = 1;
            $serv['MARKETS'] = 2;
            $serv['SBP'] = 3;
            $serv['RATES'] = 4;
            $serv['RENTS'] = 5;

            traceActivity("AGENTCODE=$agent_code=SERVICE=$service=ACCOUNT=$account=EMAIL=$email=PHONE=$phone");
            //check if already subscribed to the book
            $query = "SELECT * FROM ccn_subscriptions WHERE service_account_type='$service',service_account='$account',email='$email',phone='$phone'";
            $data = run_query($query);
            $rows = get_row_data($data);

            if (get_num_rows($data)>1)
            {
                $response['REQUESTSTATUS']="DUPLICATE";
                $response['CCNRESPONSE']="Error in Request:You already subscribed to that service";
            }
            //subscribe to the service request
            $query="INSERT  INTO ".DATABASE.".ccn_subscriptions (service_account_type,service_account,phone,email)
                                                     VALUES($serv[$service],'$account','$phone','$email')";

            traceActivity($query);
            $sub=run_query($query);

                //get the subscription id
               /* $query="SELECT sub_id FROM ccn_subscriptions WHERE service=$service_account_type,service_account='$service_account',email='$email',phone='$phone'";
                $data=run_query($query);
                $sub_id=get_row_data($data);*/
                //response to send
                $response['REQUESTSTATUS']="SUCCESSFUL";
                $response['CCNRESPONSE']="Confirmed:You are subscribed";
                $response['SUBSCRIPTIONID']=$sub_id;

            //}

                return $response;
                traceActivity("Response sent: ");
    }


    /*SUBSCRIBE CONTACT ENDS*/
    /*unsubscribe*/
    function unsubscribeContact($symbol)
    {
        $agentcode=$symbol->AGENTCODE;
        $email=$symbol->EMAIL;
        $phone=$symbol->PHONE;
    }

    function validateItem($symbol)
    {

        traceActivity("Call to validate item successful");

        $agentcode = $symbol->AGENTCODE;
        $itemtype = strtoupper($symbol->ITEMTYPE);
        $itemid = strtoupper($symbol->ITEMID);
        $market_type_id = strtoupper($symbol->MARKETTYPE);
        $inspector = strtoupper($symbol->INSPECTOR);
        $customer_account = strtoupper(trim($symbol->CUSTOMERACCOUNT));
        $swc_version  = strtoupper($symbol->SWCVERSION);

        traceActivity("AGENTCODE=$agentcode=ITEMTYPE=$itemtype=CUSTOMERACCOUNT=$customer_account=ITEMID=$itemid");

        switch ($itemtype)
        {
            case STAFF:
                $update_sql = "SELECT * FROM staff s, departments d where  s.staff_id='".$itemid."' and s.department_id = d.department_id";
                $p = 0;
                $result_set = run_query($update_sql);

                if($result = get_row_data($result_set))
                {
                    traceActivity("STAFF WAS FOUND...");
                    $p=1;
                    $resp = "CCN STAFF NO: ".$itemid.", ID NUMBER:".$result['id_passport'].
                                ", NAMES: ". $result['surname'] . " " .$result['first_name']." ".
                                $result['last_name']." and DEPARTMENT: ".$result['department_name'];
                }

                if($p == 0)
                {
                   traceActivity("STAFF WAS NOT FOUND...");
                   $resp = "CCN:INVALID! This person -$itemid- is NOT an employee of CCN...";
                }

                traceActivity("RESPONSE IS: ".$resp);
                break;


            case BUSINESSID:

                break;

            case MEDICALCERT:

                $update_sql = "SELECT * FROM medical_certs where cert_no='".$itemid."'";
                $p = 0;
                $result_set = run_query($update_sql);

                if($array = get_row_data($result_set))
                {
                    $resp = $today . " CCN CERTIFICATE: ".$itemid.", Food Handler Name: ".$array['food_handler_name'].
                                                    ", Business Names: ".$array['business_name'] . " Lab Reference No:" .$array['lab_ref_no'].". Contact Customer Care for any help";
                }
                else
                {
                    $resp = "CCN:INVALID! This Certificate number -$itemid- does not exist in our database...";
                }
                traceActivity("RESPONSE IS: ".$resp);
                break;


            case RECEIPT:
                $update_sql = "SELECT * FROM laifoms_receipt where bill_no='".$itemid."' OR receipt_no='".$itemid."'";
                $p = 0;
                $result_set = run_query($update_sql);

                if($array = get_row_data($result_set))
                {
                   $resp = "CCN BILL/RECEIPT: ".$receipt. ", NAMES: ".$array['customer_name'] .
                           ", Receipt No: " . $array['receipt_no'] . ", Date: ".$array['receipt_date'] . " is Verified.";
                }
                else
                {
                   $resp = "CCN Receipt/Bill ".$receipt." information not available.
                            Contact Customer care for help.";
                }
                break;



           case MARKETCOMPLIANCE:
                if(marketSessionActive($itemid))
                {
                    traceActivity("MARKETCOMPLIANCE-$itemid- POSITIVE: ");
                    $compliance_status=1;
                }
                else
                {
                    traceActivity("MARKETCOMPLIANCE-$itemid- NEGATIVE: ");
                    $compliance_status=0;
                }

                $querytime = time();
                $time_out = date("H:i:s");
                $compliance_id = getnextID("public.market_compliance", "market_compliance_id",1);//echo "hello...3";
                $query = "INSERT INTO public.market_compliance (market_compliance_id,market_number,market_type_id,market_id,
                                                        market_date,market_attendant_id,status,query_timestamp,agent_id)
                                     VALUES ('$compliance_id','$itemid','5','$market_type_id','".date("Y-m-d").
                                                        "','$inspector','$compliance_status','$querytime','3')";
                traceActivity($query);
                run_query($query);
                if($compliance_status==1)
                    $resp="COMPLIANT MARKETID: QUERY WAS SUCCESSFUL: REFERENCE-".$compliance_id;
                else
                    $resp="NON-COMPLIANT MARKETID: QUERY WAS SUCCESSFUL: REFERENCE-".$compliance_id;

                break;



            case OPTIONAVAILABLE:
            {//start of case block

                 traceActivity("...entered -- to check option available for account. ".$customer_account ." ...swc picked: ".$swc_version);
                if($swc_version == "1.0")
                {
                    include "swcversion1/functions.php";
                    traceActivity("...SWC PICKED[".$swc_version."]...");
                }
                elseif($swc_version == "1.1")
                {
                   traceActivity("...SWC PICKED[".$swc_version."]... before");
                    include "swcversion2/functions.php";
                    traceActivity("...SWC PICKED[".$swc_version."]...after");
                }
                else
                {
                    traceActivity("ERROR: SWC INVALID[".$swc_version."]...");
                }

                $service_code = $itemid;
                traceActivity("...service code is ...".$service_code);
                $service_id = getServiceIDOfOptionCode($service_code);
                traceActivity("Service code is: ".$service_code." and Service_id is: ".$service_id);
                //echo "<hr>option details fetched...".$details['ServiceID']."<hr>";
                $keyword = getKeyWordOfOptionCode($service_code);
                traceActivity("Keyword is: ".$keyword);
                $action = getServiceTypeOfServiceID($service_id);

                switch($action)//start of inner switch
                {
                    case PARKING_TYPE:
                            //check parking_hours...
                            traceActivity("Check Parking Availability");
                            $parking_start = 7;
                            $parking_end = 16;

                            $sat_parking_start = 7;
                            $sat_parking_end = 12;

                            if((date("N") == 6) && ((date("H") < $sat_parking_start) || (date("H") > $sat_parking_end)) && ($keyword == 'DOLOR' || $keyword == 'DASAON' || $keyword == 'DASAOFF' || $keyword == 'DASAOC' || $keyword == 'DASACM')) //DAY IS SATURDAY
                            {
                                $resp = "Parking not available after 12 noon (12hrs) on Saturdays.";
                                $code = "900";
                            }
                            elseif((date("N") == 7) && ($keyword == 'DOLOR' || $keyword == 'DASAON' || $keyword == 'DASAOFF' || $keyword == 'DASAOC' || $keyword == 'DASACM')) //DAY IS SUNDAY
                            {
                                $resp = "Parking not available on Sundays.";
                                $code = "900";
                            }
                            elseif(((date("H") < $parking_start) || (date("H") > $parking_end)) && ($keyword == 'DOLOR' || $keyword == 'DASAON' || $keyword == 'DASAOFF' || $keyword == 'DASAOC' || $keyword == 'DASACM'))//DAY IS WEEKDAY
                            {
                                $resp = "Parking not available after 5pm (16hrs) on Weekdays.";
                                $code = "900";
                            }
                            elseif(parkingActive($customer_account))
                            {
                                //check if parking exists...
                                $resp = "Parking for $customer_account Already Exists";
                                $code = "900";
                            }else
                            {
                                $resp = "Parking for $customer_account is Available as at: ".date("Y-m-d");
                                $code = "100";
                            }
                        break;
                   default:
                                $resp = "Purchase is Available as at: ".date("Y-m-d");
                                $code = "100";
                       break;
                }//end of inner switch
            }//end of case block

                break;
		case CONFIRMPARKINGBYPLATE:
				if(parkingActive($customer_account))
				{
					//check if parking exists...
					$resp = "Parking for $customer_account is Valid";
					$code = "100";
				}else
				{
					$resp = "Parking for $customer_account is not yet Active as at: ".date("Y-m-d H:i:s");
					$code = "900";
				}
				break;
            default:
                break;
        }
        traceActivity("FINISHED:    Code: ".$code);

        $response['REQUESTSTATUS'] = "SUCCESSFUL";
        $response['CCNRESPONSE'] = $resp;
        $response['RESPONSECODE'] = $code;
        return $response;
    }


    function parkingCompliance($symbol)
    {
        $agentcode = $symbol->AGENTCODE;
        $compliance = strtoupper($symbol->COMPLIANCETYPE);
        $cartype = strtoupper($symbol->CARTYPE);
        $street = $symbol->STREET;
        $numberplate = strtoupper(trim($symbol->NUMBERPLATE));
        $inspector = $symbol->INSPECTOR;
        $lock = $symbol->LOCK;

        traceActivity("AGENTCODE=$agentcode=COMPLIANCETYPE=$compliance=NUMBERPLATE=$numberplate");

        switch ($compliance)
        {
            case CHECKTICKET:
                $query = "SELECT * FROM public.parking_session WHERE plate_number='$numberplate' and status='1'";
                $result = run_query($query);

                if(get_num_rows($result) > 0)
                {
                    traceActivity("CHECKTICKET-$numberplate- POSITIVE: ");
                    $compliance_status=1;
                }
                else
                {
                    traceActivity("CHECKTICKET-$numberplate- NEGATIVE: ");
                    $compliance_status=0;
                }

                $querytime = time();
                $time_out = date("H:i:s");
                $compliance_id = getnextID("public.parking_compliance", "parking_compliance_id",1);//echo "hello...3";
                $query = "INSERT INTO public.parking_compliance (parking_compliance_id,plate_number,parking_type_id,
                                                        parking_date,time_out,parking_attendant_id,street_id,status,query_timestamp,agent_id)
                                     VALUES ('$compliance_id','$numberplate','1','".date("Y-m-d").
                                                        "','$time_out','$inspector','$street','$compliance_status','$querytime','3')";
                run_query($query);
                $resp="QUERY WAS SUCCESSFUL: REFERENCE-".$compliance_id;

                break;



           case DOUBLEPARKING: //parkin compliance type 2

                $compliance_status=0;

                $querytime = time();
                $time_out = date("H:i:s");
                $compliance_id = getnextID("public.parking_compliance", "parking_compliance_id",1);//echo "hello...3";
                $query = "INSERT INTO public.parking_compliance (parking_compliance_id,plate_number,parking_type_id,
                                                        parking_date,time_out,parking_attendant_id,street_id,status,query_timestamp,agent_id)
                                     VALUES ('$compliance_id','$numberplate','2','".date("Y-m-d").
                                                        "','$time_out','$inspector','$street','$compliance_status','$querytime','3')";
                run_query($query);
                $resp="QUERY WAS SUCCESSFUL: REFERENCE-".$compliance_id;

                break;



            case YELLOWLINE: //parkin compliance type 3
                $compliance_status=0;

                $querytime = time();
                $time_out = date("H:i:s");
                $compliance_id = getnextID("public.parking_compliance", "parking_compliance_id",1);//echo "hello...3";
                $query = "INSERT INTO public.parking_compliance (parking_compliance_id,plate_number,parking_type_id,
                                                        parking_date,time_out,parking_attendant_id,street_id,status,query_timestamp,agent_id)
                                     VALUES ('$compliance_id','$numberplate','3','".date("Y-m-d").
                                                        "','$time_out','$inspector','$street','$compliance_status','$querytime','3')";
                run_query($query);
                $resp="QUERY WAS SUCCESSFUL: REFERENCE-".$compliance_id;
                break;

            case CLAMPING: //clamping entry

                $daystart = strtotime("Y-m-d 00:00:00");
                $dayend = strtotime("Y-m-d 23:59:59");

                $query = "update clamping_transactions set isactive=1, clamper_id='".$inspector."',
                          padlock_id = '".$lock."' where plate_number='".$numberplate."' and
                          clamping_time > '".$daystart."' and allocation_date < '".$dayend."'";
                          run_query($query);
                $resp = "CLAMPING WAS SUCCESSFUL:";
                break;

            case TOWING: //towing entry
                $daystart = strtotime("Y-m-d 00:00:00");
                $dayend = strtotime("Y-m-d 23:59:59");

                $query = "update towing_transactions set isactive=1, clamper_id='".$inspector."',
                          padlock_id = '".$lock."' where plate_number='".$numberplate."' and
                          clamping_time > '".$daystart."' and allocation_date < '".$dayend."'";
                          run_query($query);
                $resp = "CLAMPING WAS SUCCESSFUL:";
                break;

            case PSVCOMPLIANCE: //psv entry
                $route = $street;

                if(!checkPSVCompliance($numberplate,$route,$cartype,$inspector))
                {
                    $resp = "INVALID PSV:WEKA TAYA!";
                }
                else
                {
                    $resp = "VALID PSV:QUERY WAS SUCCESSFUL!";
                }

                break;

            default:
                break;
        }
        traceActivity("FINISHED: ");

        $response['REQUESTSTATUS'] = "SUCCESSFUL";
        $response['CCNRESPONSE'] = $resp;
        $response['RESPONSECODE'] = $response;
        return $response;
    }


    function loginUser($symbol)
    {
        $agent = $symbol->AgentCode;
        $agent_pwd = $symbol->AgentPassword;
        $username = $symbol->StaffUsername;
        $password = $symbol->StaffPassword;

        //authenticateAgent($agent,$agent_pwd);

        traceActivity($username."|||".$password);

        if(!($staff_id = checkLogin($username,$password)))
        {
                $response['request_status'] = "FAIL";
                $response['ccn_response'] = "Username or Password was not Found";
        }
        else
        {
                $staff_data = getStaffDetails($staff_id);

                $staff_info['StaffInfo'] = $staff_data;

                $json_staff = json_encode($staff_info);
                $response['request_status'] = "SUCCESS";
                $response['staff_id'] = $staff_id;
                $response['staff_info'] = $json_staff;
        }

        return $response;
    }

    function getInspectorDetails($symbol)
    {
        $agent = $symbol->AgentCode;
        $agent_pwd = $symbol->AgentPassword;
        $inspector = $symbol->InspectorId;
        $userlevelid = $symbol->UserlevelId;

        //authenticateAgent($agent,$agent_pwd);

        traceActivity($inspector."|||".$userlevelid);

        switch($userlevelid)
        {
            case 20://parking inspector
                //get streets assigned for day
                traceActivity("In Parking inspector");
                $response['Streets']=getStreetAllocations($inspector);
                $response['TotalQueries']=getTotalInspectorQuerysToday($inspector);
                //
                break;

            case 21://parking clamper
                $thedata = getClamperDetails($inspector);
                $response['Regions'] = $thedata['region'];
                $response['ClampList'] = json_encode($thedata['clamps']);
                break;

            case 22://parking tower
                $thedata = getTowerDetails($inspector);
                $response['Regions'] = $thedata['region'];
                $response['TowList'] = json_encode($thedata['tows']);
                break;

            case 19://Markets Inspector
                $thedata = getMarketInspectorDetails($inspector);
                $response['Markets'] = json_encode($thedata['Markets']);
                $response['TotalQueries'] = getTotalMarketInspectorQuerysToday($inspector);
                break;

            case 17://PSV Inspector
               /* $thedata = getMarketInspectorDetails($inspector);
                $response['Markets'] = $thedata['Markets'];
                $response['TotalQueries'] = getTotalMarketInspectorQuerysToday($inspector);*/
                break;
        }
         $response['request_status'] = "Success";
        return $response;
    }//end of get InspectorDetails

}//end of ccnWebservice Class


function checkPSVCompliance($plate_number,$route,$cartype,$inspector)
{
    traceActivity("PlateNumber=$plate_number ||| Route=$route ||| Cartype=$cartype ||| Inspector=$inspector");


    $status = 0;
    $query3 = "SELECT * FROM public.psv_vehicles WHERE psv_reg_no='$plate_number' and  psv_current_route ='$route'";
    //traceActivity($query3);
    $result = run_query($query3);

    if(get_num_rows($result) <= 0)
    {
        $status = 1;
    }

    $time = time();

    $query = "SELECT * FROM public.psv_parking WHERE car_reg='$plate_number' and
             (start_date <= '$time' and end_date >= '$time') and psv_parking_route='".$route."'";
    //traceActivity($query);
    $result2 = run_query($query);
    if(get_num_rows($result2) <= 0){
        $status = 1;
    }

    $query2 = "INSERT INTO public.psv_compliance (plate_number, psv_route,status,psv_cartype,psv_inspector_id,querytime,query_date)
             values ('$plate_number','$route','$status','$cartype','$inspector','".time()."','".date("Y-m-d")."') ";

    //traceActivity($query2);

    run_query($query2);

    //traceActivity($query2);

    if($status == 0)
        return true;
    else
        return false;

}

function parkingActive($plate_number)
{
    $parking_time = time();

    $ins_sql = "SELECT * FROM ".DATABASE.".parking_session where plate_number ='".$plate_number."'  AND time_in < ".$parking_time." and time_out > ".$parking_time;
    traceActivity("<hr>".$ins_sql."<br>");
    $result = run_query($ins_sql);

    if(get_num_rows($result) > 0)
            return true;
    else
            return false;
}

function marketSessionActive($market_id)
{
    $market_time = time();

    $ins_sql = "SELECT * FROM ".DATABASE.".markets_session where customer_marketid ='".$market_id."'
                            AND time_in < ".$market_time." and time_out > ".$market_time;
    traceActivity("<hr>".$ins_sql."<br>");
    $result = run_query($ins_sql);

    if(get_num_rows($result) > 0)
        return true;
    else
        return false;
}

function getStreetAllocations($staff_id)
{
    $job_query = "SELECT * FROM public.inspectors_allocation WHERE staff_id='".$staff_id."' and timestamp='".date("Y-m-d")."'";
    traceActivity($job_query);
    $result2 = run_query ($job_query);

    $streets = Array();
    $count = 1;
    while($arr= get_row_data($result2))
    {
        traceActivity("In loop");
         $dat['street_id']=$arr['street_id'];
         $dat['street_name']=getStreetName($arr['street_id']);
        $streets[$count] = $dat;
        $count++;
    }
    $stjs = json_encode($streets);
    return $stjs;
}

function getTotalInspectorQuerysToday($inspector)
{
    $sql = "select count(parking_compliance_id) as total from public.parking_compliance
                    where parking_attendant_id = '$inspector'
                    and parking_date = '".date("Y-m-d")."'";
    $result = run_query($sql);
    $arr = get_row_data($result);
    return $arr['total'];
}

function getTotalMarketInspectorQuerysToday($inspector)
{
    $sql = "select count(market_compliance_id) as total from public.market_compliance
                    where market_attendant_id = '$inspector'
                    and market_date = '".date("Y-m-d")."'";
    $result = run_query($sql);
    $arr = get_row_data($result);
    return $arr['total'];
}

function getClamperDetails($staff_id)
{
    $query = "SELECT * FROM public.clampers_allocation WHERE staff_id='".$staff_id."' and timestamp like '".date("Y-m-d")."'";
    $result = run_query($query);
    $array = get_row_data($result);
    $region = $array['region_id'];
    $arr['region'] = $region;

    $job_query = "SELECT * FROM public.clamping_transactions where region_id='$region' and isactive='0'";
    $result = run_query($job_query);

    $clamps = Array();
    $count = 1;
    while($arr2 = get_row_data($result))
    {
        $dat['clamp_id'] = $arr2['clamping_transaction_id'];
        $dat['plate_number'] = $arr2['plate_number'];
        $dat['street_id'] = $arr2['street_id'];
        $dat['street_name'] = getStreetName($arr2['street_id']);
        $clamps[$count] = $dat;

        $count++;
    }

    $ress['region'] = $region;
    $ress['clamps'] = $clamps;

    return $ress;
}

function getTowerDetails($staff_id)
{
    $query = "SELECT * FROM public.towers_allocation WHERE staff_id='".$staff_id."' and timestamp like '".date("Y-m-d")."'";
    $result = run_query($query);
    $array = get_row_data($result);
    $region = $array['region_id'];
    $arr['region'] = $region;

    $job_query = "SELECT * FROM public.towing_transactions where WHERE towing_agent_id=".$staff_id  ."and completed='f'";
    $result = run_query($job_query);

    $clamps = Array();
    $count = 1;
    while($arr2 = get_row_data($result))
    {
        $dat['tow_id'] = $arr2['towing_transaction_id'];
        $dat['plate_number'] = $arr2['plate_number'];
        $dat['street_id'] = $arr2['street_id'];
        $dat['street_name'] = getStreetName($arr2['street_id']);
        $clamps[$count] = $dat;

        $count++;
    }

    $ress['region'] = $region;
    $ress['tows'] = $clamps;

    return $ress;
}


function getMarketInspectorDetails($inspector)
{
    $daystart = strtotime(date("Y-m-d 00:00:00"));
    $dayend = strtotime(date("Y-m-d 23:59:59"));

    $job_query = "SELECT * FROM public.markets_allocation where inspector_id='$inspector' AND
                  (allocated_date >= '".$daystart."' and allocated_date <= '".$dayend."')";
    traceActivity($job_query);
    $result = run_query($job_query);

    $markets = Array();
    $count = 1;
    while($arr2 = get_row_data($result))
    {
        $dat['market_id'] = $arr2['market_id'];
        $dat['market_name'] = getMarketName($arr2['market_id']);
        $markets[$count] = $dat;
        traceActivity("Market allocated - ".$dat['market_id']." and Name is ".$dat['market_name']."---");
        $count++;
    }

    $ress['Markets'] = $markets;

    return $ress;
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
		$report = getBillBalance($bill_id);
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
		$report = "CCN:BUSINESS- ".$biz_id." - ".getBusinessName($biz_id).". YOUR TOTAL BILL IS: Ksh. " .checkPendingBill($biz_id);
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
					checkPendingBill($house_id)." as at ".date("Y-m-d");
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
					checkPendingBill($car_no)." as at ".date("Y-m-d H:i:s");
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
		formatMoney(checkPendingBill($rate_id),2)." as at ".date("Y-m-d H:i").". ANNUAL RATE: Ksh. ".formatMoney(getLandRate($rate_id),2);
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
		$query = "SELECT * FROM ".DATABASE.".land_rates WHERE plot_number = '$rate_id'";
		$data = run_query($query);
		$arr = get_row_data($data);
		$rate = $arr['land_rates_currentbalance'];
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

	function checkPendingBill($acc_no)
	{
		$total_bill = 0;
		$query = "SELECT * FROM ".DATABASE.".customer_bills WHERE service_account = '$acc_no' and bill_status='0'";
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
		$today = time().":".date("Y-m-d H:i:s");
		$myFile = date("Y-m-d")."_jairowsposts.txt";
		$fh = fopen($myFile,'a');
		fwrite($fh, $today."==".$text."\n");
		fclose($fh);
	}

	function updateRequestLog($biz_id,$sa)
	{
		$query = "UPDATE ".DATABASE.".log_req SET service_account_type='$sa' WHERE header_id = '$biz_id'";
		$data = run_query($query);
	}


        function checkLogin($username,$password)
        {
		$tablename="staff";

		$query = "SELECT * FROM ".DATABASE.".".$tablename."
							  WHERE (username='".$username."' OR phone_number='".$username."')
							  AND password='".$password."'";

		$result = run_query($query);
		traceActivity($query);

		$num =get_num_rows($result);
		$array = get_row_data($result);

		if($num > 0)
		{
			//$session_token = createStaffUserSession($array['number']);
			return $array['staff_id'];
		}
		else
		{
			return false;
		}
        }

        function getStaffDetails($one) //surname,firstname,lastname,phone,email,national_id,passport
        {
            $staff_data;
            $query = "SELECT * FROM ".DATABASE.".staff WHERE staff_id = '$one'";
            traceActivity($query);
            $data = run_query($query);
            $rows = get_row_data($data);
            $staff_data['surname'] = trim($rows['surname']);
            $staff_data['lastname'] = trim($rows['last_name']);
            $staff_data['firstname'] = trim($rows['first_name']);
            $staff_data['username'] = trim($rows['username']);
            $staff_data['phone'] = trim($rows['phone_number']);
            $staff_data['email'] = trim($rows['email']);
            $staff_data['department'] = trim($rows['department']);
            $staff_data['job_id'] = trim($rows['job_id']);
            $staff_data['userlevelid'] = trim($rows['userlevelid']);
            return $staff_data;
        }

	ini_set("soap.wsdl_cache_enabled", "0"); // disabling WSDL cache
	$server = new SoapServer("ccnWebservice.wsdl");
	$server->setClass("ccnWebservice");
	$server->handle();
?>
