<fieldset>
<legend class="table_fields">ADD A MARKET </legend>
<form action="?num=412" method="post" name="add_market" id="add_market" enctype="multipart/form-data">
<table>
<tr class="table_fields">
<td>ADDRESS ID:</td>
<td>
<?php
$get_address="SELECT address_id FROM address";
$get_add=run_query($get_address);

echo "<select name=\"address_id\">";
echo "<option selected>Select</option>";
if(get_num_rows($get_add))
{
	while($row=get_row_data($get_add))
	{
		echo " <option>$row[address_id]</option> " ;
	}
}
else {
	echo"<option>Nothing to list</option>";
	echo "</select>";
}
?>
</td>
</tr>
<tr class="table_fields">
<td>MARKET RATE ID:</td>
<td><input type="text" name="market_rate_id"/>
</td>
</tr>
<tr class="table_fields">
<td>MARKET NAME:</td>
<td><input type="text" name="market_name"/>
</td>
</tr>
<tr class="table_fields">
<td>MARKET DESCRIPTION:</td>
<td><input type="text" name="market_description"/></td>
</tr>
<tr class="table_fields">
<td>DETAILS:</td>
<td><input type="text" name="details"/></td></tr>
<tr class="table_fields">
<td>MARKET TYPE ID:</td>
<td><input type="text" name="market_type_id"></td>

</tr>
<tr>
<td><input type="hidden" name="action" value="add_market"/></td>
<td><input type="submit" name="submit" value="ADD"/></td>
</tr>
</table>
</form>
</fieldset>
