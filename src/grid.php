<?php 
	ini_set("session.gc_maxlifetime","14400");
	session_start(); 
	include "connection/config.php";
	include "library.php";
?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head><title>:: Admin Home ::</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link href="style_admin_t.css" rel="stylesheet" type="text/css" />
	<link href="css/topic1.css" rel="stylesheet" type="text/css" />
	<link href="css/tables.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="css/ingrid.css" type="text/css" media="screen" />
	<?
		include "js_scripts.php";
	?>
    <script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
	 <script type="text/javascript" src="js/jquery.ingrid.js"></script>	
	<style type="text/css">
	<!--
	.header{font-family: "Trebuchet MS";font-weight: bold;color: #FFFFFF;}
	body{
		margin-top: 0px;
		background:#F3F3F3;
		margin-left: 0px;
		margin-right: 0px;
	}
	.header2{color: #FFFFFF;font-family: "Trebuchet MS";font-size: 12px;}
	a.headerlinks{color:#FFFFFF;font-family: "Trebuchet MS"; font-size: 12px; font-weight: bold; text-decoration:none;}  
	.progi{font-size: 24px; color: #FFFFFF; font-family: "Trebuchet MS"; font-weight: bold;}
	.style55 {font-family: "Trebuchet MS"; font-weight: bold; color: #FFFFFF; font-size: 12px; }
	.style56 {font-size: 12px; color:#FF0000; font-family: "Trebuchet MS"; font-weight: bold; }
	.style57 {
		font-size: 16px;
		color:#000;
		font-family: "Trebuchet MS";
		font-weight: bold;
	}
	.topcell { background-image: url(TReyebrow.gif);}
	-->
	</style>
    <script type="text/javascript">
		$(document).ready(
			function() {
				$("#table1").ingrid({ 
					url: 'remote.php',
					height: 350
				});
			}
		); 
	</script>
	</head>
    <body>
    <div id="main" name="main" style="visibility:hidden">
    <div style="height:30px; background-image:url(TopBar.png); background-repeat:no-repeat;"></div>
    <table width="100%" id="shelltable" border="0" align="center" bgcolor="#F3F3F3" cellpadding="0" cellspacing="0" >
	<tr class="topcell" height="20"> <td width="39%" height="10" valign="top" class="style57"> <strong>Welcome, <?php echo $_SESSION['name']; ?> </strong></td>
	  <td width="37%" valign="middle" class="header2" style="padding:2px"><span class="style56">
      <div id="loading_div" style="display:none;"><img src="loading.gif" width="280" height="13" /></div>
      
       </span></td>
	  <td width="15%" valign="top" class="header2" style="padding:2px">&nbsp;</td>
	  <td width="9%" valign="top" style="padding:2px"><div align="right"><a href="signout.php" class="style56">sign-out</a> </div> </td> </tr>
	  
	<tr> <td colspan="4" valign="top"><div align="left">
	<?
		$num = $_GET["num"];
		
		$_SESSION['num'] = $num;
		
		/*	
			if($_SESSION['type'] == 1)
			{
			   include "system_admin.php";  // System Admin Panel 
			}
			else if($_SESSION['type'] == 2)
			{
			   include "academics_admin.php"; 
			}
			else if($_SESSION['type'] == 3)
			{
			   include "accounts_admin.php"; 
			}
			else if($_SESSION['type'] == 4)
			{
			   include "admissions_admin.php"; 
			}	
		*/
		
		include "system_admin.php"; 
		include "settings.php";	
	
	
	
	//include "processor.php";
	?>
		
	</div> </td> </tr>
	
	<?
			if($processed == 1)
			{
			?>
				<tr> 
					<td colspan="4" valign="top">
						<div id="message_box" style="width:100%;">
							<?
								show_action_message($message);
							?> 					
						</div>
					</td>
				</tr>
			<?
			}
	?>
	<tr> 
		<td height="495px" colspan="4" valign="top">
        
 <!------------------------------------------------------------------------------->       
    <table id="table1">
 <thead>
  <tr>
   <th>CCNTrans#</th>
   <th>EBPPPTrans#</th>
   <th>DateTime</th>
   <th>TransType</th>
   <th>ServiceCode</th>
   <th>UserAccount</th>
   <th>TransType</th>
   <th>TransType</th>
  </tr>
 </thead>
 <tbody>
 
 <?
   $distinctQuery = "select * from ".DATABASE.".log_req Order by header_id DESC Limit 10";
   $resultId = run_query($distinctQuery);	
   $total_rows = get_num_rows($resultId);
	
   
	$con = 1;
	$total = 0;
	while($row = get_row_data($resultId))
	{
		$trans_id = trim($row['transaction_id']);
		$ref_id = trim($row['reference_id']);
		$head_id = trim($row['header_id']);
		
		$trans_type = $row['transaction_code'];
		
		$service_code = $row['service_code'];
		$user_account = $row['user_account'];
		$trx_date = $row['date_logged']; 
		 ?>
		  <tr>
		   <td><?=$ref_id; ?></td>
		   <td><?=$trans_id; ?></td>
		   <td><?=$trx_date; ?></td>
		   <td><?=$trans_type; ?></td>
           <td><?=$service_code; ?></td>
           <td><?=$user_account; ?></td>
           <td><?=$trans_type; ?></td>
           <td><?=$trans_type; ?></td>
		  </tr>
		 <?
 
	}
	
	?>
  </tbody>
</table>
</td>
	</tr>
	
	<tr> 
		<td height="39" colspan="4" valign="top">
			<div align="center" class="style56">
					Copyright &copy; <? echo date("Y"); ?> HAUSRAUM. All Rights Reserved.
			</div> 
		</td>  
	</tr>
	</table>
</div>	

	
	</body>
	</html>
<script type='text/javascript'>
		document.getElementById('main').style.visibility = "visible";
	</script> 
	<?
//}
?>