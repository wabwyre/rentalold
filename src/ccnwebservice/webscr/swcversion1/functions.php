<?
define("PARKING_TYPE","1");
define("MARKETS_TYPE","5");
define("PSV_TYPE","3");
define("BILLS_TYPE","2");


traceActivity("...SWC1 Functions.....");

/*include_once "../../library.php";
include_once "../../connection/config.php";

$service_code = "40002";
	$service_id = getServiceIDOfOptionCode($service_code);
	echo "Option code is: ".$service_code." and Service_id is: ".$service_id."<br>";
	
	$keyword = getKeyWordOfOptionCode($service_code);
	echo "Keyword is: ".$keyword."<br>";
	$action = getServiceTypeOfServiceID($service_id);
	//echo "<hr>Service Type fetched..<hr>";
	echo "Action is[ServiceTypeID]: ".$action."<br>";	
	$option_id = getOptionIDOfOptionCode($service_code);
	echo "Option is: ".$option_id."<br>";
	$total_inputs = getNumberofInputsInOptionID($option_id);	
	echo "Total Inputs is: ".$total_inputs."<br>";*/

function getServiceTypeOfServiceID($service_id)
{	
		$query = "select * from public.services where service_id ='$service_id'";
		$result = run_query($query);
		$arr = get_row_data($result);
		$rate = $arr["service_type_id"];
		return $rate;
}

function getServiceTypeNameOfServiceTypeID($service_type_id)
{	
		$query = "select * from public.service_types where service_type_id = '$service_type_id'";
		$result = run_query($query);
		$arr = get_row_data($result);
		$rate = $arr["service_type_name"];
		return $rate;
}

function getServiceIDOfOptionCode($option_code)
{
		$query = "select * from public.options where option_code ='$option_code'";
		$result = run_query($query);
		$arr = get_row_data($result);
		$rate = $arr["service_id"];
		return $rate;
}

function getOptionIDOfOptionCode($option_code)
{
		$query = "select * from public.options where option_code ='$option_code'";
		$result = run_query($query);
		$arr = get_row_data($result);
		$rate = $arr["option_id"];
		return $rate;
}

function getKeyWordOfOptionCode($option_code)
{
		$query = "select * from public.options where option_code ='$option_code'";
		$result = run_query($query);
		$arr = get_row_data($result);
		$rate = $arr["keyword"];
		return $rate;
}

function getNumberofInputsInOptionID($option_id)
{
		$query = "select Count(option_inputid) as total from public.option_inputs where option_id ='$option_id'";
		$result = run_query($query);
		$arr = get_row_data($result);
		$rate = $arr["total"];
		return $rate;
}

?>