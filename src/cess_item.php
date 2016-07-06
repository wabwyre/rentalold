<fieldset>
<legend class="table_fields">CESS ITEMS</legend>
<!-- first table with adding a package-->


<table border="0"  bgcolor="#F2F2F2" cellspacing="2" cellpadding="3">

<form action="?num=315" method="post" name="cess_item">
 <thead>
<tr class="table_fields" bgcolor="#002E5B">
<td  colspan="2"align="left" bgcolor="#A5C432"> <font color="#FFFFFF">NEW CESS ITEM</font></td>
</tr>
<tr class="table_fields" bgcolor="#C7C7C7"> 
<td align="left" valign="top" width=""><input type="text" name="cess_item_name"/></td> 
<input type="hidden" name="action" value="add_cess_item"/>
<td align="left" valign="top" width=""><input type="submit" name="submit" value="ADD"/></td>

</tr>
</thead>
</form>
</table>



<!--second table with creating a cess item package-->



<table width="" border="0" 	 bgcolor="#F2F2F2" cellspacing="2" cellpadding="3"> 
<thead>
<tr class="table_fields" bgcolor="#002E5B">
<td colspan="5" align="left" bgcolor="#A5C432"> <font color="#FFFFFF">ADD A CESS ITEM PACKAGE</font></td></tr>
<tr class="table_fields" bgcolor="#C7C7C7"> 
<td align="left" valign="top" width="113" >CESS ITEM NAME</td> 
<td width="" align="left" valign="top">CESS ITEM PACKAGE</td>
<td width=""align="left" valign="top">COST</td>
<td width="" align="left" valign="top">QUANTITY</td> 
<td></td>
</tr>
</thead>

<form name="add_package" action="?num=315" method="post" enctype="multipart/form-data"/>
<tr class="table_fields">
<td>
<?php
$find_cess="SELECT cess_item_name FROM ".DATABASE.".cess_items";
$find_ces=run_query($find_cess);

echo "<select name=\"cess_item_name\">";
echo "<option selected>Select</option>";
if (get_num_rows($find_ces))
while($row=get_row_data($find_ces)){
	
	echo "<option>$row[cess_item_name]</option>";
	}
	else
	{
		echo "<option>Nothing to list</option>";
		}

?>
</td>
<td><input type="text" name="cess_item_package_name"/></td>
<td><input type="text" name="cost"/></td>
<td><input type="text" name="quantity"/></td>
<input type="hidden" name="action" value="add_cess_package"/>
<td><input type="submit" name="submit" value="ADD PACKAGE"/></td>
</form>
</tr>
</table>

<!--third table with a list of table packages-->
<?php
$packages="SELECT count(cess_package_id)  as total_packages FROM cess_item_packages";
$package=run_query($packages);
$packag=get_row_data($package);
$pack=$packag['total_packages'];

?>
<script type="text/javascript">
		$(document).ready(
			function() {
				$("#table1").ingrid({ 
					url: 'remote_package.php',
					height: 150,
					totalRecords: <?=$pack;?>,
					pageNumber: 1,
					recordsPerPage: 0,
					colWidths: [150,150,150,150,100,100]
				});
			}
		); 
	</script>  
 
   <table id="table1" align="right">
 <thead>
  <tr>
   <th>CESS PACKAGE ID</th>
   <th>CESS ITEM NAME</th>
   <th>CESS PACKAGE NAME</th>
   <th>QUANTITY</th>
   <th>COST</th>
   <th>INVOICE</th>
 
  </tr>
 </thead>
 <tbody>
 
 <?
   $distinctQuery = "SELECT * FROM ".DATABASE.".cess_item_packages Order by cess_package_id DESC Limit 10";
   $resultId = run_query($distinctQuery);	
   $total_rows = get_num_rows($resultId);
	
   
	$con = 1;
	$total = 0;
	while($row = get_row_data($resultId))
	{
		$cess_package_id=$row['cess_package_id'];
		$cess_item_name=$row['cess_item_name'];
		$cess_package_name=$row['cess_package_name'];
		$quantity=$row['quantity'];
		$cost=$row['cost'];
		
 ?>
		 <tr>
		  <td><?=$cess_package_id; ?></td>
          <td><?=$cess_item_name; ?></td>
          <td><?=$cess_package_name; ?></td>
          <td><?=$quantity; ?></td>
          <td><?=$cost; ?></td>
	     <td><a href="index.php?num=315&cess=<?=$cess_package_id; ?>">INVOICE</a></td>
      
       </tr>
		 <?
 
	}
	   
	?>
  </tbody>
</table>
<!--THE INVOICE TABLE THEN FOLLOWS-->

	<table width="" border="0" align="left" bgcolor="#F2F2F2" cellspacing="2" cellpadding="3"> 
    <thead>
	<tr class="table_fields" bgcolor="#002E5B"> <td colspan="5" align="left" bgcolor="#A5C432"> <font color="#FFFFFF">CESS INVOICE</font></td>
	  </tr>
<tr class="table_fields" bgcolor="#C7C7C7"> 
    <!--  <td align="left" valign="top" width="113" >INVOICE ID</td> -->
       <td width="120">CUSTOMER ID</td>
      <td width="120">TOTAL AMOUNT</td>
	 <td width="165" align="left" valign="top">DATE CREATED</td>
	  <td width="68" align="left" valign="top">STATUS</td> 
      <td></td>
    
 </tr>
    </thead>
    <?php
	//getting the cess_item_package_id from the url
     $ces_package_id=$_GET['cess'];
	 if(isset($ces_package_id))
{
	$invoice="SELECT * FROM ".DATABASE.".cess_item_packages WHERE cess_package_id=$ces_package_id ";
	$invois=run_query($invoice);
	$invo=get_num_rows($invois);
	
	
	
	$row=get_row_data($invois);
}
		$cess_package_id=$row['cess_package_id'];
		$cess_item_name=$row['cess_item_name'];
		$cess_package_name=$row['cess_package_name'];
		$cost=$row['cost'];
		$quantity=$row['quantity'];
		$total_amount=$cost*$quantity;
		
		?>
        <form action="?num=315" method="post" name="invoice">
      
        <tr class="table_fields">
        <td><input type="text" name="customer_id"  /></td>
        <td><input type="text" name="total_amount" value="<?=$total_amount; ?>"/></td>
        <td><input type="text" name="dateCreated" value="<?=date("d-m-Y"); ?>"/></td>
              <td><input type="text" name="status" value="0"/></td>
              <input type="hidden" name="action" value="create_invoice"/>
              <td><input type="submit" name="submit" value="CREATE INVOICE"/></td>
        </tr>
       </form>
     </table>
   <br />
<br />
<br />
<br />
<br />
<br />

  <!--invoice items will then follow-->
  
  <?php
$packages="SELECT count(invoice_id)  as total_invoice_items FROM cess_item_packages NATURAL JOIN cess_invoice";
$package=run_query($packages);
$packag=get_row_data($package);
$pack=$packag['total_invoice_items'];

?>
<script type="text/javascript">
		$(document).ready(
			function() {
				$("#table1").ingrid({ 
					url: 'remote_invoice.php',
					height: 250,
					totalRecords: <?=$pack;?>,
					pageNumber: 1,
					recordsPerPage: 0,
					colWidths: [150,150,150,150]
				});
			}
		); 
	</script>  
 
   <table id="table1" align="left">
 <thead>
  <tr class="table_fields">
   <th>INVOICE ID</th>
   <th>CESS ITEM NAME</th>
   <th>CESS PACKAGE NAME</th>
   <th>QUANTITY</th>
   </tr>
 </thead>
 <tbody>
 
 <?
   $distinctQuery = "SELECT cess_invoice.invoice_id,cess_invoice.customer_id,
   cess_item_packages.quantity,cess_invoice.total_amount FROM cess_invoice 
   NATURAL JOIN cess_item_packages order by invoice_id DESC Limit 5";
   $resultId = run_query($distinctQuery);	
   $total_rows = get_num_rows($resultId);
	
   
	$con = 1;
	$total = 0;
	while($row = get_row_data($resultId))
	{
		$invoice_id=$row['invoice_id'];
		$customer_id=$row['customer_id'];
		$quantity=$row['quantity'];
		$total_amount=$row['total_amount'];
	
 ?>
		 <tr class="table_fields">
		  <td><?=$invoice_id; ?></td>
          <td><?=$customer_id; ?></td>
          <td><?=$quantity; ?></td>
          <td><?=$total_amount; ?></td>
       </tr>
		 <?
 
	}
	   
	?>
  </tbody>
</table>
</fieldset>