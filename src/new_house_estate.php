<?
include("connection/config.php");
include("library.php");

//insert the value of the new house estate
if (isset($_POST['action']) && $_POST['action']=="addnewhouseestate"){
	$houseestate = trim($_POST['house_estate']); 
	$add_house_estate = "insert into house_estates(house_estate_name) 			   
								   values('$houseestate')";
	include ("rents_processor.php");
	if ($processed == 1){
	if(!run_query($add_house_estate))
    	 echo "Could not process: <hr> " . mysql_error() . " <hr>" . $add_house_estate;
	}
}
?>
<script type="text/javascript">
function ValidateForm()
	{
		//alert("hello");
		if((document.getElementById('house_estate').value == ""))
		{
			 alert("Please enter house type");
		     return false;
		}

	}
</script>
<form id="form1" name="form1" method="post" action="" onSubmit="return ValidateForm();" >
  <table width="200" border="0">
    <tr>
      <td>Name of house Estate</td>
      <td><label>
        <input type="text" name="house_estate" id="house_estate" />
      </label></td>
    </tr>
    <tr>
      <td><input type="hidden" name="action" id="action" value="addnewhouseestate" /></td>
      <td><label>
        <input type="submit" name="button" id="button" value="Submit" />
      </label></td>
    </tr>
  </table>
</form>

