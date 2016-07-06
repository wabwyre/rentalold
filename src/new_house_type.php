<?
include("connection/config.php");
include("library.php");

//insert the value of the new house type
if (isset($_POST['action']) && $_POST['action']=="addnewhousetype"){
	$housetype = trim($_POST['house_type']); 
	$add_house_type = "insert into house_types(house_type_name) 			   
								   values('$housetype')";
	include ("rents_processor.php");
	if ($processed == 1){
	if(!run_query($add_house_type))
    	 echo "Could not process: <hr> " . mysql_error() . " <hr>" . $add_house_type;
	}
}
?>
<script type="text/javascript">
function ValidateForm()
	{
		//alert("hello");
		if((document.getElementById('house_type').value == ""))
		{
			 alert("Please enter house type");
		     return false;
		}

	}
</script>
<form name="form1" method="post" action="" onSubmit="return ValidateForm();">
  <table width="222" border="0">
    <tr>
      <td width="41">Name of House Type</td>
      <td width="211"><label>
        <input type="text" name="house_type" id="house_type">
      </label></td>
    </tr>
    <tr>
      <td><input type="hidden" name="action" id="action" value="addnewhousetype"></td>
      <td><label>
        <input type="submit" name="submit" id="submit" value="Submit">
      </label></td>
    </tr>
  </table>
</form>
