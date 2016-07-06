<?
include("connection/config.php");
include("library.php");

if (isset($_POST['action']) && $_POST['action']=="addhouserent"){
	$housenumber = trim($_POST['house_number']); 
	$housetype = trim($_POST['housetypes']); 
	$houseestates = trim($_POST['houseestates']); 
	$customer = trim($_POST['Customer']); 
	$houserate = trim($_POST['house_rate']);
	$totalarrears = trim($_POST['total_arrears']);
	$currentbalance = trim($_POST['current_balance']); 
	$contactname =  trim($_POST['contact_name']);
//Insert data to databaase
	$add_new_house = "insert into house_rent(house_number, house_type, house_estate, contact_name, house_rate, customer_id, total_arrears, current_balance) values('$housenumber', '$housetype', '$houseestates','$contactname', $houserate, $customer, $totalarrears, $currentbalance)";
	if(!run_query($add_new_house))
    	 echo "Could not process: <hr> " . mysql_error() . " <hr>" . $add_new_house;				
}
?>
<script type="text/javascript">
function ValidateForm()
	{
		//alert("hello");
		if((document.getElementById('house_number').value == ""))
		{
			 alert("Please enter House Number");
		     return false;
		}
		if((document.getElementById('total_arrears').value == ""))
		{
			 alert("Please enter Total Arrears");
		     return false;
		}
		if((document.getElementById('contact_name').value == ""))
		{
			 alert("Please enter Contact Name");
		     return false;
		}

	}
</script>
<form id="new_house" name="new_house" method="post" action="" onSubmit="return ValidateForm();" ><table width="583" border="1">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>House Number</td>
    <td><label>
      <input type="text" name="house_number" id="house_number">
    </label></td>
    <td>House Type</td>
    <td><label>
    <? selectDistinct("house_types","house_type_id","housetypes","","house_type_name"); ?>
    </label></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>House Estate</td>
    <td><label><? selectDistinct("house_estates","house_estate_id","houseestates","","house_estate_name"); ?></label></td>
    <td>Customer</td>
    <td><? selectDistinct("ccn_customers","ccn_customer_id","Customer","","firstname"); ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>House Rate</td>
    <td><label>
      <input type="text" name="house_rate1" id="house_rate1" disabled="disabled" value="0">
      <input type="hidden" name="house_rate" id="house_rate" value="0" />
    </label></td>
    <td>Total Arrears</td>
    <td><label>
      <input type="text" name="total_arrears" id="total_arrears">
    </label></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Current Balance</td>
    <td><label>
      <input type="text" name="current_balance1" id="current_balance1" disabled="disabled" value="0" >
      <input type="hidden" name="current_balance" id="current_balance" value="0" />
    </label></td>
    <td><input type="hidden" name="action" id="action"  value="addhouserent"/>
      Contact Name</td>
    <td><label>
      <input type="text" name="contact_name" id="contact_name" />
    </label></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><input type="submit" name="button" id="button" value="Submit" /></td>
  </tr>
</table>
</form>
