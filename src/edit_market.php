<?php
//get the value
$market=$_GET['market'];

//get the row
$mako_val="SELECT * FROM ".DATABASE.".markets WHERE market_id=$market";
$mako_v=run_query($mako_val);
$total_rows=get_num_rows($mako_v);


$con=1;
$total=0;

$row=get_row_data($mako_v);

        //the values
        $market_id=$row['market_id'];
		$address_id=$row['address_id'];
		$market_rate_id['market_rate_id'];
		$market_name=$row['market_name'];
		$market_description=$row['market_description'];
		$details=$row['details'];
		$market_type_id=$row['market_type_id'];
	   
?>
<fieldset>
<legend class="table_fields">EDIT MARKET:</legend>
<form action="?num=412" method="post" enctype="multipart/form-data">
<table>
<tr class="table_fields">
<input type="hidden" name="market_id" value="<?=$market_id; ?>"/>
 <td>ADDRESS ID:</td>
<td><input type="text" name="address_id" value="<?=$address_id; ?>"/> </td>
</tr>
<tr class="table_fields">
 <td>MARKET RATE ID:</td>
<td><input type="text" name="market_rate_id" value="<?=$market_rate_id;?>"/></td>
</tr>
<tr class="table_fields">
 <td>MARKET NAME:</td>
<td><input type="text" name="market_name" value="<?=$market_name; ?>"/></td>
</tr>
<tr class="table_fields">
 <td>MARKET DESCRIPTION:</td>
<td><input type="text" name="market_description" value="<?=$market_description; ?>"/></td>
</tr>
<tr class="table_fields">
<td> DETAILS:</td>
<td><input type="text" name="details" value="<?=$details; ?>"/></td>
</tr>
<tr class="table_fields">
 <td>MARKET TYPE ID</td>
<td><input type="text" name="market_type_id" value="<?=$market_type_id; ?>"/></td>
</tr>
<td><input type="hidden" name="action" value="edit_market"/></td>
<td><input type="submit" name="submit" value="SAVE"/></td>
</tr>
</table>
</form>
</fieldset>
