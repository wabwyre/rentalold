<fieldset>
<legend class="table_fields">ADD A MARKET ALLOCATION </legend>
<form action="?num=409" method="post" name="add_market_allocation"  enctype="multipart/form-data">
<table>
<tr class="table_fields">
<td>INSPECTOR ID:</td>
<td>
<input type="text" name="inspector_id" />
</td>
</tr>
<tr class="table_fields">
<td>MARKET ID:</td>
<td><input type="text" name="market_id"/>
</td>
</tr>
<tr class="table_fields">
<td>ALLOCATION DATE:</td>
<td><input type="text" name="allocation_date" value="<? echo date("d-m-Y") ?>"/>
</td>
</tr>
<tr class="table_fields">
<td>ALLOCATED DATE:</td>
<td><input type="text" name="allocated_date" value="<? echo  date("d-m-Y")?>"/></td>
</tr>

<tr>
<td><input type="hidden" name="action" value="add_market_allocation"/></td>
<td><input type="submit" name="submit" value="ADD"/></td>
</tr>
</table>
</form>
</fieldset>
