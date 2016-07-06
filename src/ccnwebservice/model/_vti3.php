<?
	session_start();
	include_once "library.php";
	include_once "rate_card.php";
	
	$_sender = $_SESSION['user_id'];
	
	if($_GET['a'] == "c")
	{
		setComplete($_GET['i'], $_GET['c']);
		$owner = getTransactionSender($_GET['i'], $_GET['c']);
		
		$owner_email = getUserEmail($owner);
		$owner_name = getUserName($owner);
		
		
		/*Email Username and password to new member*/
			$title = "Magolink Admin: Order Confirmation";
			$content = "<table width='408' border='0'>
						  <tr>
							<td colspan='2'>Dear ".$owner_name.",</td>
						  </tr>
						  <tr>
							<td colspan='2'>This is to confirm that your bill has been successfully sent to the Recipient</td>
						  </tr>
						  <tr>
							<td width='123'><div align='right'>Order ID:</div></td>
							<td width='275'>".$_GET['i']."</td>
						  </tr>
						  <tr>
							<td colspan='2'><p>Regards,</p>
							<p>Administrator,<br />Magolink Support Team </p>
							</td>
						  </tr>
						</table>";
			$target = $owner_email;
			//$target = "tintalle.istari@gmail.com";
			//$date = date("Y-m-d");
			
			//$num = get_next_number("emails","num",$dbh);
			
			
			$emailheaders = "From: Magolink Admin<admin@pesasend.com>\r\nReply-To: Magolink Admin <admin@pesasend.com>\r\nContent-Type: text/html";
			$emailsubject = $title;
			
			$mail_sent = @mail($target, $emailsubject, $content, $emailheaders);
				
			
			//$mailsent = true;
			if($mailsent)
			{
			  print "An Email has been sent to the Sender to confirm completion of Transaction. <br><table bgcolor='white' width='400'><tr><td><hr/>";
			  echo $content;
			  print"<hr /></td></tr></table>";
			}
			else
			{
			  //print "There was a problem with your email address";
			}
		
		
	}
	
	$callcard_payments = getAllCallcardPayments(STATUS_COMPLETE);
	
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Magolink</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <script language="JavaScript" type="text/javascript"  src="xmlhttprequest.js"></script>
  <script language="JavaScript" type="text/javascript" src="ajax2.js"></script>
<? include "setup.html"; ?>
<style type="text/css">
<!--
.marginbottom {
	border-top-width: thin;
	border-right-width: thin;
	border-bottom-width: thin;
	border-left-width: thin;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: dotted;
	border-left-style: none;
	border-top-color: #4D626C;
	border-right-color: #4D626C;
	border-bottom-color:#000000;
	border-left-color: #4D626C;
}

body,td,th {
	font-family: tahoma;
	font-size: 11px;
	color: #414141;
}
body {
	background-color: #414141;
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
a {
	font-size: 11px;
	color: #ffffff;
}
a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
}
a:hover {
	text-decoration: underline;
}
a:active {
	text-decoration: none;
}
.transaction_category{
color:#003366;
text-decoration:underline;
}
.style4 {
	color: #C86C23;
	font-weight: bold;
	font-family: "Trebuchet MS";
	font-size: 24px;
}
.style5 {color: #000000}
-->
</style></head>
<body>

<!-- Start editing template here -->
<table width="765" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><img src="images/spacer.gif" width="1" height="1" border="0">
	
	<table width="765" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
      <tr>
        <td valign="top">
		
		</td>
        <td valign="top">
		
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="656" height="31" bgcolor="#CCCCCC"><? include "top_right.php"; ?></td>
          </tr>
          <tr>
            <td height="18"  bgcolor="#FFFFFF"><? include "callcard_menu_admin2.php"; ?></td>
          </tr>
          <tr>
            <td>
			
			
			<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
			  <tr>
                <td height="60" valign="bottom"><span class="style4">Current Transactions Log:  </span></td>
			    </tr>
			  
			   <tr>
                <td height="90"><img src="images/spacer.gif" width="1" height="5"><img src="images/spacer.gif" width="1" height="1" border="0">
                  <fieldset>
                  <legend>CALLING CARD Payments Log </legend>
				  
				  <table width="100%" border="0">
				  <tr>
				    <th width="26" bgcolor="#F0E6BF" scope="col"><div align="center">ID</div></th>
					<th width="120" bgcolor="#F0E6BF" scope="col"><div align="left"><span class="style29">Date &amp; Time </span></div></th>
					<th colspan="2" bgcolor="#F0E6BF" scope="col"><div align="left">Time Lapse </div></th>
					<th width="129" bgcolor="#F0E6BF" scope="col"><div align="left">Sender</div></th>
					<th width="88" bgcolor="#F0E6BF" scope="col"><div align="left">Sender Status </div></th>
					<th width="67" bgcolor="#F0E6BF" scope="col"><div align="left"><span class="style29">Amt</span></div></th>
					<th width="19" bgcolor="#F0E6BF" scope="col">&nbsp;</th>
					<th width="124" bgcolor="#F0E6BF" scope="col"><span class="style29">Paypal Status</span></th>
				  </tr>
				  
				  <?
				  
						while($array = mysql_fetch_array($callcard_payments))
						{
					
						$name = $array['name'];
						$number = $array['number'];
						$phone = $array['phone'];
						$amt_usd = $array['amt_usd'];
						$message = $array['message'];
						$date = $array['date'];
						$owner = $array['user'];
						$category = $array['category'];
						$status = wordStatus($array['status']);
						$timestamp = $array['time'];
						$timeframe = explode("*",$timestamp);
						
						$timethen = $timeframe[0];
						$clocktime = $timeframe[1];
						$timenow = time();
						
						$elapsed_time = $timenow - $timethen;
						$gone_hours = $elapsed_time/3600;
						
						if($gone_hours > 24)
						   if(getUserStatus($owner) != 6)
						   		removeProbation($owner);
						
						
						$owner_email = getUserEmail($owner);
						$owner_name = getUserName($owner);
						
						$sender_status = wordUserStatus(getUserStatus($owner));
						
						 ?>
						  <tr>
						    <td valign="top" class="marginbottom"><strong><? echo $number; ?></strong></td>
							<td height="21" valign="top" class="marginbottom"><? echo $date . " | " . $clocktime; ?> </td>
							<td colspan="2" valign="top" class="marginbottom">
							  <div align="left">
									<? if($timethen != 0)
										  echo ShortenText(time_duration($timenow - $timethen),20) . "ago.";
									?>
							  </div>							  				    </td>
							<td valign="top" class="marginbottom"><?=$owner_name; ?>                            </td>
							<td valign="top" class="marginbottom">-<?=$sender_status; ?>- </td>
							<td valign="top" class="marginbottom"><div align="left">
                               US$  <?=$amt_usd; ?>
                            </div></td>
							<td valign="top" class="marginbottom">
							  <div align="right">
							  <a onClick="show_CallcardTransactionForm(<?=$number; ?>);" class="hintanchor" style='color:#000000; cursor:pointer;' onmouseover="showhint('SEND TO:<hr>Name: <?=$name; ?><hr>MPESA Number: <?=$phone; ?><hr><?=$message; ?><hr>', this, event, '200px')">[?]</a></div></td>
							<td valign="top" class="marginbottom"><div align="right">
							<? 
								if(getUserStatus($owner) == 6)
								{
									?>
								<a href="callcard_transactions_complete.php?a=c&i=<?=$number; ?>&c=callcard">
									<img border="0" src="icons/Configure.png" width="19" height="19" align="right">								</a>
									<?
								}
							?>
							  <?=$status; ?>
							  </div></td>
						  </tr>
						  
						  <tr>
							<td colspan="9" valign="top" bgcolor="#CCCCCC" class="marginbottom" style="padding-right:10px;"><div id="more_info_<?=$number; ?>">					      	  </div>							  <div align="left" id="loading_div"></div></td>
						  </tr>
						  <?
						} 
				  
				  ?>
				  <tr>
				    <td>&nbsp;</td>
					<td>&nbsp;</td>
					<td width="57">&nbsp;</td>
					<td width="85">&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				  </tr>
				</table>				  
				  </fieldset>
				  
				  
				  
				  
				  
		  </td>
              </tr>
              <tr>
                <td background="images/gr2.gif"><img src="images/spacer.gif" width="1" height="52"><img src="images/spacer.gif" width="1" height="1" border="0"><a href="#"></a><img src="images/spacer.gif" width="1" height="15"><img src="images/spacer.gif" width="1" height="1" border="0"></td>
              </tr>
			  
            </table></td>
          </tr>
		  </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><a href="#"><img src="images/footer.gif" width="765" height="22" border="0"></a></td>
  </tr>
  <tr>
    <td>
      <? include "footer.php"; ?>
	  <img src="images/spacer.gif" width="1" height="1" border="0"></td>
  </tr>
</table>
<img src="images/spacer.gif" width="1" height="1" border="0">


<!-- End template editing here -->
</body>
</html>
