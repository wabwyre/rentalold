<?php
//get the value
$maket_item=$_GET['mark'];

//get the row
$mako_val="SELECT * FROM ".DATABASE.".market_items WHERE market_item_id='$maket_item'";
$mako_v=run_query($mako_val);
$total_rows=get_num_rows($mako_v);


$con=1;
$total=0;

$row=get_row_data($mako_v);

//the values
$maket_item_id=$row['market_item_id'];
$maket_item_name=$row['market_item_name'];
$maket_item_description=$row['market_item_description'];


?>
<fieldset>
<legend class="table_fields">EDIT MARKET MARKET ITEM</legend>
<form action="?num=39" method="post" enctype="multipart/form-data">
<table>
<tr class="table_fields">
<td>MARKET ITEM NAME</td>
<td>MARKET ITEM DESCRIPTION</td>
</tr>
<tr class="table_fields">
<td><input type="hidden" name="maket_item_id" value="<?=$maket_item_id; ?>"/> </td>
<td><input type="text" name="maket_item_name" value="<?=$maket_item_name;?>"/></td>
<td><input type="text" name="maket_item_description" value="<?=$maket_item_description; ?>"/></td>

<td><input type="hidden" name="action" value="edit_market_item"/></td>
<td><input type="submit" name="submit" value="SAVE"/></td>
</tr>
</table>
</form>
</fieldset>
