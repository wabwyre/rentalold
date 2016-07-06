<?php
	require('Connection/pg_connection.php');

	define("PARKING_TYPE","1");
	define("MARKETS_TYPE","2");
	define("PSV_TYPE","3");
	define("BILLS_TYPE","4");

	define("PARKING_TYPE","1");
	define("MARKETS_TYPE","2");
	define("PSV_TYPE","3");
	define("BILLS_TYPE","4");

	//traceActivity("...SWC2 Functions.....");

	//test code
	///////////////////////////////////////////////////////////////////////////////////
	$optionCode = "341";
	$service_id = getServiceIDOfOptionCode($optionCode);
	echo "Option code is: ".$optionCode." and Service_id is: ".$service_id."<br>";
	//traceActivity("...SWC2-A.....");


	$keyword = getKeyWordOfOptionCode($optionCode);
	echo "Keyword is: ".$keyword."<br>";
	//traceActivity("...SWC2-B.....");


	$action = getServiceTypeOfServiceID($service_id);
	//echo "<hr>Service Type fetched..<hr>";
	echo "Action is[ServiceTypeID]: ".$action."<br>";
	//traceActivity("...SWC2-C.....");


	$option_id = getOptionIDOfOptionCode($optionCode);
	echo "Option is: ".$option_id."<br>";
	$total_inputs = getNumberofInputsInOptionID($option_id);
	echo "Total Inputs is: ".$total_inputs."<br>";
	//traceActivity("...SWC2-D.....");



	////////////////////////////////////////////////////////////////////////////////////


	function getServiceTypeOfServiceId($serviceId)
	{

		global $dbcon3;
		$query_string="SELECT service_types.service_type_id
						FROM service_types
						JOIN services ON
						service_types.service_type_id=services.service_type_id
						WHERE services.service_id=$serviceId";
		//echo $query_string;
		$query_result=pg_query($dbcon3, $query_string);
		$row=pg_fetch_array($query_result);
		$result=$row['service_type_id'];
		return $result;



	}


	function getServiceIDOfOptionCode($optionCode)
	{
		global $dbcon3;

		$query_string="SELECT service_id
						FROM services
						WHERE option_code=$optionCode";
             // traceActivity($query_string);
		$query_result=pg_query($dbcon3, $query_string);
		$row=pg_fetch_array($query_result);
		$rows_no=pg_num_rows($query_result);
		$result=$row['service_id'];

		if($rows_no==0){
		$query_string="SELECT service_id
						FROM options
						WHERE option_code=$optionCode";
		$query_result=pg_query($dbcon3, $query_string);
		$row=pg_fetch_array($query_result);
		$rows_no=pg_num_rows($query_result);
		$result=$row['service_id'];
		}

		if($rows_no==0){
		$query_string="SELECT options.service_id
						FROM options
						JOIN sub_options
						ON options.option_id=sub_options.option_id
						WHERE
						sub_options.option_code=$optionCode";
		$query_result=pg_query($dbcon3, $query_string);
		$row=pg_fetch_array($query_result);
		$rows_no=pg_num_rows($query_result);
		$result=$row['service_id'];
		}

                 //traceActivity("Service Id from SWC Vertion 2 is ".$result);
		return $result;
	}

	function getOptionIDOfOptionCode($optionCode)
	{
		global $dbcon3;

		$query_string="SELECT services.option_id
						FROM services
						WHERE services.option_code=$optionCode";
		$query_result=pg_query($dbcon3, $query_string);
		$row=pg_fetch_array($query_result);
		$rows_no=pg_num_rows($query_result);
		$result=$row['option_id'];

		if($rows_no==0){

		$query_string="SELECT options.option_id
						FROM options
						WHERE options.option_code=$optionCode";
		$query_result=pg_query($dbcon3, $query_string);
		$row=pg_fetch_array($query_result);
		$rows_no=pg_num_rows($query_result);
		$result=$row['option_id'];

		}

		if($rows_no==0)	{
		$query_string="SELECT sub_options.option_id
						FROM sub_options
						WHERE sub_options.option_code=$optionCode";
		$query_result=pg_query($dbcon3, $query_string);
		$row=pg_fetch_array($query_result);
		$rows_no=pg_num_rows($query_result);
		$result=$row['option_id'];


		}
		if($rows_no==0)	{
		$query_string="SELECT sub_sub_options.option_id
						FROM sub_sub_options
						WHERE sub_sub_options.option_code=$optionCode";
		$query_result=pg_query($dbcon3, $query_string);
		$row=pg_fetch_array($query_result);
		$rows_no=pg_num_rows($query_result);
		$result=$row['option_id'];


		}
		return $result;
	}

	function getNumberOfInputsInOptionId($optionId)
	{
		global $dbcon3;
		$query_string="SELECT option_inputs.origin_id
						FROM option_inputs
						JOIN
						services
						ON services.input_id=option_inputs.origin_id
						WHERE services.option_id = $optionId";
		$query_result=pg_query($dbcon3, $query_string);
		$result=pg_num_rows($query_result);

		if($result == 0){
		$query_string="SELECT option_inputs.origin_id
						FROM option_inputs
						JOIN
						options
						ON options.input_id=option_inputs.origin_id
						WHERE options.option_id = $optionId";
		$query_result=pg_query($dbcon3, $query_string);
		$result=pg_num_rows($query_result);

		}

		if($result == 0){
		$query_string="SELECT option_inputs.origin_id
						FROM option_inputs
						JOIN
						sub_options
						ON sub_options.input_id=option_inputs.origin_id
						WHERE sub_options.option_id = $optionId";
		$query_result=pg_query($dbcon3, $query_string);
		$result=pg_num_rows($query_result);

		}

		if($result == 0){
		$query_string="SELECT option_inputs.origin_id
						FROM option_inputs
						JOIN
						sub_sub_options
						ON sub_sub_options.input_id=option_inputs.origin_id
						WHERE sub_sub_options.option_id = $optionId";
		$query_result=pg_query($dbcon3, $query_string);
		$result=pg_num_rows($query_result);

		}

		return $result;

	}
	function getKeyWordOfOptionCode($optionCode)
	{
		global $dbcon;
		$query_string="SELECT keyword
						FROM options_junction
						WHERE
						option_code=$optionCode";
		$query_result=pg_query($dbcon, $query_string);
		$result=pg_fetch_array($query_result);

		return $result['keyword'];

	}
?>