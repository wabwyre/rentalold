<?php
include ("connection/config.php");
	include ("library.php");
	
	$page = $_GET['page'];
	
	if($page == 1)
	    $offset = 0;
	else
		$offset = $page * 20;

?>
 <table id="table1">
 <tbody>
 
 <?
  $penbills="SELECT * FROM customer_bills WHERE bill_status='0' Order by bill_id DESC Limit 20 OFFSET $offset";
$pendbill=run_query($pendbills);
$total_pending_bill=get_num_rows($pendbill);
	
   
	$con = 1;
	$total = 0;
	while($row = get_row_data($pendbill))
	{
		$due_date = date("d-m-Y H:i:s",$row['bill_due_date']);
		$customer_id = trim($row['customer_id']);
		$bill_date = date("d-m-Y H:i:s",$row['bill_date']);
		$service_bill_id = trim($row['service_bill_id']);
		$bill_amount = trim($row['bill_amt']);
	    $bill_status=$row['bill_status'];
	    $bill_id=$row['bill_id'];
	    $service_account=$row['service_account'];
	    $bill_balance=$row['bill_balance'];
	    $service_account_type=$row['service_account_type'];
	   $billing_year=$row['billing_year'];
	   $billing_month=$row['billing_month'];
	  $billing_day=$row['billing_day'];
	   $sms_notification=$row['sms_notification'];
	  $email_notification=$row['email_notification'];
		 ?>
		  <tr>
		     <td><?=$due_date; ?></td>
		   <td><?=$customer_id; ?></td>
		   <td><?=$bill_date; ?></td>
           <td><?=getServiceBillName($service_bill_id); ?></td>
           <td>Ksh. <?=number_format($bill_amount,2); ?></td>
		   <td><? echo ($status==0)?"PENDING":"PAID"; ?></td>
           <td><?=$bill_id; ?></td>
           <td><?=$service_account; ?></td>
           <td><?=$bill_balance; ?></td>
           <td><?=$service_account_type; ?></td>
           <td><?=$billing_year; ?></td>
           <td><?=$billing_month; ?></td>
           <td><?=$billing_day; ?> </td>
           <td><?=$sms_notication ?></td>
           <td><?=$email_notification; ?></td>
		  </tr>
		 <?
 
	}
	
	?>
  </tbody>
</table>
