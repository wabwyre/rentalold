<?

	$business_id = $_GET['biz'];

	$distinctQuery = "select * from ".DATABASE.".business where business_id ='$business_id'";
	$resultId = run_query($distinctQuery);	
	$total_rows = get_num_rows($resultId);
	
	
	$con = 1;
	$total = 0;
	$row = get_row_data($resultId);
	
	$trans_id = trim($row['business_id']);
	$business_name = trim($row['business_name']);
	$head_id = trim($row['activity_code']);
	
	$trans_type = $row['transaction_code'];
	
	$contact_name = $row['contact_person'];
	$pin_number = $row['pin_number'];
	$customer_id = $row['customer_id'];
	$lr_penalty = $row['land_rates_accpenalty'];
	$lr_balance = $row['land_rates_currentbalance'];

?>
<link href="style.css" rel="stylesheet" type="text/css" />

<form id="application" name="application" method="post" action="?num=11">
<table width="775" border="0" cellpadding="2" cellspacing="2" align="left">

<tr class="table_fields">
  <td height="23" colspan="4" align="left" valign="top" bgcolor="#FFFF99">Business Details:</td>
  </tr>
  
<tr class="table_fields"> <td height="23" align="right" valign="top">Name::</td> <td valign="top" align="left"> 
<font size="2" color="#0000FF"><?=$business_name; ?> </font> </td>
  <td valign="top" align="right">Operator:</td>
  <td valign="top" align="left"><?=$array['OPERATOR']; ?></td>
</tr> 

<tr class="table_fields"> 
    <td width="18%" align="right" valign="top">BID:</td> 
	<td width="32%" align="left" valign="top"><?=$trans_id; ?></td>
    <td width="13%" align="right" valign="top">Date:</td>
   <td width="37%" align="left" valign="top"><?=$array['TRX_DATE']; ?></td>
</tr>

<tr class="table_fields">
  <td valign="top" align="right">Act.Code::</td>
  <td colspan="3" align="left" valign="top"><?=$head_id; ?></td>
</tr>

<tr class="table_fields">
  <td valign="top" align="right">&nbsp;</td>
  <td colspan="3" align="left" valign="top">&nbsp;</td>
</tr>

<tr class="table_fields">
  <td height="24" colspan="4" align="right" valign="middle"><hr/></td>
</tr>
  
<tr class="table_fields">
  <td height="22" colspan="4" align="left" valign="middle" bgcolor="#FFFF99">Bills:</td>
  </tr>
  
		  <fieldset><legend class="table_fields">BUSINESS PERMIT-BILLS</legend> 
   <table id="table1">
 <thead>
  <tr>
   <th class="table_fields">BIZ#</th>
   <th class="table_fields">Bill.ID#</th>
   <th class="table_fields">B.Date</th>
   <th class="table_fields">Bill Name</th>
   <th class="table_fields">Bill Amount</th>
   <th class="table_fields">STATUS</th>
   <th class="table_fields">Due.Date</th>
   <th class="table_fields">Customer</th>
   
  </tr>
 </thead>
 <tbody>
 
 <?
   $distinctQuery = "select * from ".DATABASE.".customer_bills where service_account_type='3' AND service_account ='$business_id'";
   $resultId = run_query($distinctQuery);	
   $total_rows = get_num_rows($resultId);
	
   
	$con = 1;
	$total = 0;
	while($row = get_row_data($resultId))
	{
		$trans_id = trim($row['bill_id']);
		$ref_id = trim($row['service_account']);
		$service_bill_id = trim($row['service_bill_id']);
		
		$bill_date = date("d-m-Y H:i:s",$row['bill_date']);
		$due_date = date("d-m-Y H:i:s",$row['bill_due_date']);
		$end_date = date("d-m-Y H:i:s",$row['time_out']);
		
		$parking_type = $row['parking_type_id'];
		$status = $row['bill_status'];
		$agent_id = $row['agent_id'];
		$bill_amount = $row['bill_amt'];
		$clamping_flag = $row['clamping_flag'];
		 ?>
		  <tr>
		   <td class="table_fields"><?=$ref_id; ?></td>
		   <td class="table_fields"><?=$trans_id; ?></td>
		   <td class="table_fields"><?=$bill_date; ?></td>
           <td class="table_fields"><?=getServiceBillName($service_bill_id); ?></td>
           <td class="table_fields">Ksh. <?=number_format($bill_amount,2); ?></td>
		   <td class="table_fields"><? echo ($status==0)?"PENDING":"PAID"; ?></td>
           <td class="table_fields"><?=$due_date; ?></td>
           <td class="table_fields"><?=$customer_id; ?></td>
           

		  </tr>
		 <?
 
	}
	
	?>
  </tbody>
</table>



      <tr class="table_fields">
           <td height="24" colspan="4" align="right" valign="middle">
           
           
           
           
           
           </td>
      </tr>
      <tr class="table_fields">
  <td height="24" colspan="4" align="right" valign="middle">&nbsp;</td>
</tr> 

<tr class="table_fields">
  <td height="23" colspan="4" align="center" valign="middle"><hr/></td>
</tr>
<tr class="table_fields"> 

  <td colspan="4" align="center" valign="top">&nbsp;</td> 
  </tr> 

</table></form> 
 
 </fieldset>

<?


?>