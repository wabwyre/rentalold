<?php
//get the value
$attendant=$_GET['attendant'];

//get the row
$mako_val="SELECT * FROM ".DATABASE.".market_attendant WHERE attendant_id=$attendant";
$mako_v=run_query($mako_val);
$total_rows=get_num_rows($mako_v);


$con=1;
$total=0;

$row=get_row_data($mako_v);

        //the values
        $attendant_id=$row['attendant_id'];
		$market_id=$row['market_id'];
		$region_id=$row['region_id'];
		$is_active=$row['isactive'];
		$details=$row['details'];
?>
<fieldset>
<legend class="table_fields">EDIT MARKET ATTENDANT</legend>
<form action="?num=406" method="post" enctype="multipart/form-data">
<table>
<tr class="table_fields">
  <td>MARKET ID</td>
  <td>REGION ID</td>
  <td>IS ACTIVE</td>
  <td>DETAILS</td>
</tr>
<tr class="table_fields">
<td><input type="hidden" name="attendant_id" value="<?=$attendant_id; ?>"/> </td>
<td><input type="text" name="market_id" value="<?=$market_id;?>"/></td>
<td><input type="text" name="region_id" value="<?=$region_id; ?>"/></td>

<td><input type="text" name="isactive" value="<?=$is_active; ?>"/></td>
<td><input type="text" name="details" value="<?=$details; ?>"/></td>

<td><input type="hidden" name="action" value="edit_market_attendant"/></td>
<td><input type="submit" name="submit" value="SAVE"/></td>
</tr>
</table>
</form>
</fieldset>
