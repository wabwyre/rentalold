<?
	include("connection/config.php");
	include("library.php");
?><style type="text/css">
<!--
.text1 {font-family: "Trebuchet MS"}
.text2 {font-family: "Trebuchet MS"; font-weight: bold; }
-->
</style>
<link href="style.css" rel="stylesheet" type="text/css" />
<table align="left" width="100%"> 
  <tr> <td> <form id="house_rent_search" name="house_rent_search" method="post" action="">
<fieldset> <legend class="table_fields"><strong>RENTS->Search HOUSE/STALL...</strong></legend>

<table width="100%" border="0" align="center" cellspacing="4"> <tr class="table_fields"> <th align="left">Enter Contact Name, House Number or House Estate: 

      <input name="search_item" type="text" id="search_item" size="50" />

 <input name="fetch" type="submit" class="submit_button" id="fetch" value="Search" />
<input name="action" type="hidden" class="header_del_sub" id="action" value="showhouses"/>
 </th></tr> </table> 

</fieldset> </form> </td> </tr> 

<tr> <td height="121" align="center" valign="top">
<?
if ((isset($_POST['action']))&&($_POST['action'] == "showhouses")){
	$search = $_POST['search_item']; 
	//$house_estate_search = (string)$_POST['search_item'];
	
	$distinctQuery = "SELECT * FROM ".DATABASE.".house_rent 
   					 WHERE house_number LIKE '%$search%'
					 ORDER BY house_number ASC
					";
				 
	 $resultId = run_query($distinctQuery);
	 $total_rows = get_num_rows($resultId);
	  echo $total_rows;
}
?>
<table width="881" border="0" align="left" bgcolor="#F2F2F2" cellspacing="2" cellpadding="3"> 
    <thead>
	<tr class="table_fields" bgcolor="#002E5B"> <td colspan="6" align="left" bgcolor="#A5C432"> <font color="#FFFFFF">Search Result: House Rents</font></td>
	  </tr>
	<tr class="table_fields" bgcolor="#C7C7C7"> <td align="left" valign="top" width="113">House No.</td> 
	  <td align="left" valign="top">Contact Name</td>
      <td width="165" align="left" valign="top">Rate</td>
      <td width="165" align="left" valign="top">Arrears</td>
      <td width="165" align="left" valign="top">Current Balance</td>
	  <td width="68" align="left" valign="top">Edit </td> 	</tr>
    </thead>
    <tbody id="all_data" <? if($total_rows > 20) echo "style='overflow-y:scroll; height:350px; overflow-x:hidden;'"; ?> >  
    <?
	$con = 1;
	while($row = get_row_data($resultId))
	{
		$house_id = trim($row['house_id ']);
		$house_number = $row['house_number'];
		$house_type = trim($row['house_type']);
		$house_estate = trim($row['house_estate']);
		$contact_name = trim($row['contact_name']);
		$house_rate= trim($row['house_rate']);
		$customer_id = trim($row['customer_id']);
		$total_arrears = trim($row['total_arrears']);
		$current_balance = trim($row['current_balance']);
		//$course = getCourseName($core);
		?>
		<form name="view_profile" method="post" action="admin.php?num=3">
		<tr bgcolor="#FFFFFF" class="label"> 
          <td class="table_fields" align="left" valign="top"><?=$house_number; ?></td> 
          <td class="table_fields" align="left" valign="top"><?=$contact_name; ?></td>
		  <td align="left" valign="top" class="table_fields"><?=$house_rate; ?></td>
          <td class="table_fields" align="left" valign="top"><?=$total_arrears; ?></td> 
          <td class="table_fields" align="left" valign="top"><?=$current_balance; ?></td> 
		  <td align="left" valign="top"><a href="index.php">Manage</a></td> </tr>	
		</form>
		<?	 
		$con++;
	} // end of loop ....
	?>
	</tbody>
	</table>