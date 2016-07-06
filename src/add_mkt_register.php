<fieldset>
<legend class="table_fields">ADD TO MARKET REGISTER </legend>
<form action="?num=38" method="post" name="add_markets" id="add_markets" enctype="multipart/form-data">
<table>
<tr class="table_fields">
<td>CUSTOMER ID:</td>
<td>
<?php
$get_customers="SELECT customer_id FROM customers";
$get_customer=run_query($get_customers);

echo "<select name=\"customer_id\">";
echo "<option selected>Select</option>";
if(get_num_rows($get_customer))
{
	while($row=get_row_data($get_customer))
	{
		echo " <option>$row[customer_id]</option> " ;
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
<td>ID NO:</td>
<td><input type="text" name="id_no"/>
</td>
</tr>
<tr class="table_fields">
<td>TELEPHONE:</td>
<td><input type="text" name="telephone"/>
</td>
</tr>
<tr class="table_fields">
<td>DATE TIME:</td>
<td><input type="text" name="date_time" value="<? echo  date("d-m-Y")?>"/></td>
</tr>
<tr class="table_fields">
<td>RECORD ID:</td>
<td><input type="text" name="record_id"/></td></tr>
<tr>
<td><input type="hidden" name="action" value="mkt_registration"/></td>
<td><input type="submit" name="submit" value="ADD"/></td>
</tr>
</table>
</form>
</fieldset>
