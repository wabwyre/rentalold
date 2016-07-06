<?php
//get the value
$allocation=$_GET['m_allocation'];

//get the row
$mako_val="SELECT * FROM ".DATABASE.".markets_allocation WHERE allocation_id=$allocation";
$mako_v=run_query($mako_val);
$total_rows=get_num_rows($mako_v);


$con=1;
$total=0;

$row=get_row_data($mako_v);

        //the values
        $allocation_id=$row['allocation_id'];
		$inspector_id=$row['inspector_id'];
		$market_id=$row['market_id'];
		$allocation_date=$row['allocation_date'];
		$allocated_date=$row['allocated_date'];
	   
?>
<fieldset>
<legend class="table_fields">EDIT MARKET ALLOCATION:</legend>
<form action="?num=409" method="post" enctype="multipart/form-data">
<table>
<tr class="table_fields">
<input type="hidden" name="allocation_id" value="<?=$allocation_id; ?>"/>
 <td>INSPECTOR ID:</td>
<td><input type="text" name="inspector_id" value="<?=$inspector_id; ?>"/> </td>
</tr>
<tr class="table_fields">
 <td>MARKET ID:</td>
<td><input type="text" name="market_id" value="<?=$market_id;?>"/></td>
</tr>
<tr class="table_fields">
 <td>ALLOCATION DATE:</td>
<td><input type="text" name="allocation_date" value="<?=$allocation_date; ?>"/></td>
</tr>
<tr class="table_fields">
 <td>ALLOCATED DATE:</td>
<td><input type="text" name="allocated_date" value="<?=$allocated_date; ?>"/></td>
</tr>

<td><input type="hidden" name="action" value="edit_market_allocation"/></td>
<td><input type="submit" name="submit" value="SAVE"/></td>
</tr>
</table>
</form>
</fieldset>
