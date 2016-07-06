<?
	session_start();
	include_once "library.php";
	include_once "rate_card.php";
	
	$_sender = $_SESSION['user_id'];

	
	if($_GET['a'] == "c")
	{
		setComplete($_GET['i'], $_GET['c']);
		$owner = $_POST['sender'];
		
		$card_value =  $_POST['callcard_amt'];
		
		$card_allocated_pin  = $_POST['approved_pin'];
		$card_allocated_access  = $_POST['approved_accessnumber'];
		
		
		$owner_email = getUserEmail($owner);
		//$owner_email = "tintalle.istari@gmail.com";
		$owner_name = getUserName($owner);
		//$owner_email = "jairus@obulex.co.uk";
		//$owner_name = getUserName($owner);
		
		
		$thecard = "<font size='-2'  face='Trebuchet MS'>
					<table width='730' border='0'  cellpadding='0' cellspacing='0' align='center' bgcolor='#0B2A3E'>
					  <tr>
						<td colspan='3'><img src='{$source_url}card_banner.jpg' width='644' height='131' /></td>
					  </tr>
					  					  <tr>
                        <td colspan='3' cell='cell'>
                        <div align='center'><font color='#FFFFFF' size='+2'>SUCCESS!</font> <strong> <font color='#FFFFFF' size='2' face='Trebuchet MS'> Your transaction has been approved for the amount of US$ {$card_value} </font> </strong> </div></td>
				      </tr>
					  <tr>
					    <td colspan='3' cell='cell'><div align='center'></div></td>
				      </tr>
					
					  <tr>
                        <td colspan='3' cell='cell'>
                          <div align='center'><strong><font color='#FFFFFF' size='2' face='Trebuchet MS'>Find your local access number below  or <br />
                            Dial 1-877-531-9879 (Add 3.9cents/min when using this toll free number) <br />
                          </font></strong></div></td>
				      </tr>
					  
					    <tr>
					    <td colspan='3' cell='cell'><table width='82%' border='0' align='center'>
                          <tr>
                            <td width='14%' bgcolor='#333333'>&nbsp;</td>
                            <td width='21%' bgcolor='#333333'><font color='#FFFFFF' size='-2' >ACCESS NUMBER </font></td>
                            <td width='17%' bgcolor='#333333'>&nbsp;</td>
                            <td width='21%' bgcolor='#333333'><font color='#FFFFFF' size='-2' >ACCESS NUMBER </font></td>
                            <td width='12%' bgcolor='#333333'>&nbsp;</td>
                            <td width='15%' bgcolor='#333333'><font color='#FFFFFF' size='-2' >ACCESS NUMBER </font></td>
                          </tr>
                          <tr>
                            <td><font color='#FFFFFF' size='-2' >WASHINGTON</font></td>
                            <td><font color='#FFFFFF' size='-2' >1-202-730-9023</font></td>
                            <td><font color='#FFFFFF' size='-2' >LOS ANGELES </font></td>
                            <td><font color='#FFFFFF' size='-2' >1-323-474-0044</font></td>
                            <td><font color='#FFFFFF' size='-2' >ST. LOUIS </font></td>
                            <td><font color='#FFFFFF' size='-2' >1-618-433-3002</font></td>
                          </tr>
                          <tr>
                            <td><font color='#FFFFFF' size='-2' >PHILADELPHIA</font></td>
                            <td><font color='#FFFFFF' size='-2' >1-215-618-3321</font></td>
                            <td><font color='#FFFFFF' size='-2' >SPRINGFIELD LUDLOW </font></td>
                            <td><font color='#FFFFFF' size='-2' >1-413-308-3016</font></td>
                            <td><font color='#FFFFFF' size='-2' face='Trebuchet MS'>GAINSVILLE</font></td>
                            <td><font color='#FFFFFF' size='-2' >1-678-928-3395</font></td>
                          </tr>
                          <tr>
                            <td><font color='#FFFFFF' size='-2' >MIAMI</font></td>
                            <td><font color='#FFFFFF' size='-2' >1-305-351-9500</font></td>
                            <td><font color='#FFFFFF' size='-2' >ROCHESTER</font></td>
                            <td><font color='#FFFFFF' size='-2' >1-507-226-9993</font></td>
                            <td><font color='#FFFFFF' size='-2' >ARLINGTON</font></td>
                            <td><font color='#FFFFFF' size='-2' >1-682-227-6162</font></td>
                          </tr>

                        </table></td>
				      </tr>
					  <tr>
					    <td height='0' colspan='3' cell></td>
				      </tr>
					  <tr>
					  
					  
					  
					  
					  
					  
					  
						<td width='242' height='174' valign='top' bgcolor='#FFFFFF'>
						
						  <div align='center'>
						    <table width='195' height='500' border='0' cellpadding='0' cellspacing='0'>
						      <tr>
						        <td><img src='{$source_url}images/{$card_value}card.jpg' width='240' height='150' alt='' /></td>
                              </tr>
						      <tr>
						        <td><table width='100%' height='380' border='0' cellpadding='0' cellspacing='10' bgcolor='#113C71'>
						          
						          <tr>
						            <td height='321' valign='top' class='white-text'>
									<div align='center'>
						              <table width='100%' height='335' border='0'>
						                <tr>
						                  <td colspan='2' valign='top' class='style6'>
										  <strong><font size='-2' color='#FFFFFF' face='Trebuchet MS'>TO CALL FROM USA/CANADA </font></strong></td>
					                    </tr>
						                <tr>
						                  <td width='18' valign='top' class='style6'><font size='-2'  color='#FFFFFF'>1.</font></td>
                                          <td width='179' valign='top' class='style6'><font size='-2' color='#FFFFFF'  face='Trebuchet MS'>When prompted enter your PIN</font></td>
                                        </tr>
						                <tr>
						                  <td valign='top' class='style6'><font  size='-2'  color='#FFFFFF'>2.</font></td>
                                          <td class='style6'><font color='#FFFFFF' size='-2' face='Trebuchet MS'>For calls within US, Canada or the <br />
                                            Caribbean;</font></td>
                                        </tr>
						                <tr>
						                  <td height='92' class='style6'><font color='#FFFFFF'>&nbsp;</font></td>
                                          <td valign='top' class='style6'><p><font color='#FFFFFF' size='-2' face='Trebuchet MS'>Dial 1 + area code and telephone number;</font><font color='#FFFFFF'><br />
                                          <font size='-2' face='Trebuchet MS'>For calls to other countries;<br />
                                            Dial 011 + country code + city code and<br />
                                            telephone number;</font></font> <font color='#FFFFFF'><br />
                                                  <font size='-2' face='Trebuchet MS'>To make another call, don't hang up. <br />
                                              Press  *  for two seconds.</font></font> </p>
                                              <p><font size='-2' color='#FFFFFF'>OR</font></p></td>
                                        </tr>
						                <tr>
						                  <td valign='top' class='style6'><font color='#FFFFFF'>&nbsp;</font></td>
                                          <td valign='top' class='style6'><font color='#FFFFFF' size='-2'  face='Trebuchet MS'>Access our website www.sovaya.com to download our free web-based SoftPhone (SIP) Phone and then follow instructions of how to use the SoftPhone and also how to obtain your own local phone number. Charges can also be viewed on our website </font></td>
                                        </tr>
						                <tr>
						                  <td height='22' valign='top' class='style6'>.</td>
                                          <td valign='top' height='30' background='{$source_url}images/pinnumber.png' class='style6'>
											  <div align='center'>
											  <font size='-2' color='#FFFFFF'>PIN: </font><font size='-2' face='Trebuchet MS'> </font>
											  <font color='#FFFFFF'>{$card_allocated_pin}</font>
											  </div>
										  </td>
                                        </tr>
					                  </table>
                                    </div>                                                                          </td>
                                    </tr>
						          
					            </table></td>
                              </tr>
						      <tr>
						        <td>&nbsp;</td>
                              </tr>
					        </table>
					      </div>						  <p align='center'></p>						</td>
						  
						  
						  
						  
						  
						  
						  
						  
						  
						  
						<td width='243' valign='top' bgcolor='#FFFFFF'>
						
					      <div align='center'>
					        <table width='195' height='500' border='0' cellspacing='0' cellpadding='0'>
					          <tr>
					            <td><img src='{$source_url}images/{$card_value}card.jpg' width='240' height='150' alt='' /></td>
                              </tr>
					          <tr>
					            <td><table width='100%' height='380' border='0' cellpadding='0' cellspacing='10' bgcolor='#113C71'>
						            
					              <tr>
					                <td class='white-text' valign='top'>
									<div align='center'>
					                  <table width='100%' height='335' border='0'>
					                    <tr>
                                          <td colspan='2' valign='top' class='style6'><strong><font size='-2' color='#FFFFFF' face='Trebuchet MS'>TO CALL FROM >KENYA</font> </font></strong></td>
				                        </tr>
					                    <tr>
					                      <td width='8' height='107' valign='top' class='style6'><font size='-2' color='#FFFFFF'>1.</font></td>
                                          <td width='192' class='style6' valign='top'><font size='-2' color='#FFFFFF'>Have a VOIP Handset or Buy a VOIP Phone from our Customaer Care Shop by calling: <br />
                                          0713 078 405, <br />
                                          020 236 5283,<br />
                                          020 336 0000, <br />
                                          0736 512 164, </font></td>
                                        </tr>
					                    <tr>
					                      <td height='71' valign='top' class='style6'><font size='-2' color='#FFFFFF'>2.</font></td>
                                          <td valign='top' class='style6'><font size='-2' color='#FFFFFF'>Call our field service engineers to help you set your VOIP perimeters within your phone</font>
                                              
                                            <p><font size='-2' color='#FFFFFF'>OR</font>                                            </p>
                                            </td>
                                        </tr>
					                    <tr>
					                      <td height='92' valign='top' class='style6'><font color='#FFFFFF'>&nbsp;</font></td>
                                          <td valign='top' class='style6'><font color='#FFFFFF' size='-2'  face='Trebuchet MS'>Access our website www.sovaya.com to download our free web-based SoftPhone (SIP) Phone and then follow instructions of how to use the SoftPhone and also how to obtain your own local phone number. Charges can also be viewed on our website </font></td>
                                        </tr>
					                    <tr>
					                      <td height='22' valign='top' class='style6'><font color='#FFFFFF'>.</font></td>
                                                                                   <td valign='top' height='30' background='{$source_url}images/pinnumber.png' class='style6'>
											  <div align='center'>
											  <font size='-2' color='#FFFFFF'>PIN: </font><font size='-2' face='Trebuchet MS'> </font>
											  <font color='#FFFFFF'>{$card_allocated_pin}</font>
											  </div>
										  </td>
                                        </tr>
				                      </table>
                                    </div></td>
                                    </tr>
						            
				                </table></td>
                              </tr>
					          <tr>
					            <td>&nbsp;</td>
                              </tr>
				            </table>
				        </div>					      <p align='center'></p>						</td>
						
						
						
						
						
						
						
						
						
						<td width='245' height='174' valign='top' bgcolor='#FFFFFF'>
                            
                            <div align='center'>
                              <table width='195' height='500' border='0' cellpadding='0' cellspacing='0'>
                                <tr>
                                  <td><img src='{$source_url}images/{$card_value}card.jpg' width='240' height='150' alt='' /></td>
                                </tr>
                                <tr>
                                  <td><table width='100%' height='380' border='0' cellpadding='0' cellspacing='10' bgcolor='#113C71'>
                                    <tr>
                                      <td height='322' valign='top' class='white-text'>
									 
									  <div align='center'>
                                        <table width='100%' border='0' height='335'>
                                          <tr>
                                            <td colspan='2' valign='top' class='style6'><strong><font size='-2' color='#FFFFFF'>TO CALL FROM <font size='-2' face='Trebuchet MS'>THE REST OF THE WORLD </font> </font></strong></td>
                                          </tr>
                                          <tr>
                                            <td valign='top' class='style6'><font size='-2' color='#FFFFFF'>1.</font></td>
                                            <td valign='top' class='style6'><font color='#FFFFFF' size='-2'  face='Trebuchet MS'>Access our website www.sovaya.com to download our free web-based SoftPhone (SIP) Phone and then follow instructions of how to use the SoftPhone and also how to obtain your own local phone number. Charges can also be viewed on our website </font></td>
                                          </tr>
                                          <tr>
                                            <td valign='top' class='style6'>&nbsp;</td>
                                            <td class='style6'>&nbsp;</td>
                                          </tr>
                                          <tr>
                                            <td width='8' valign='top' class='style6'>&nbsp;</td>
                                            <td width='180' class='style6'>&nbsp;</td>
                                          </tr>
                                          <tr>
                                            <td height='92' class='style6'><font color='#FFFFFF'>&nbsp;</font></td>
                                            <td valign='top' class='style6'><p>&nbsp;</p>
                                              <p>&nbsp;</p>
                                              <p>&nbsp;</p>
                                              </td>
                                          </tr>
                                          <tr>
                                            <td valign='top' class='style6'>&nbsp;</td>
                                            <td valign='top' class='style6'>&nbsp;</td>
                                          </tr>
                                          <tr>
                                            <td height='29' valign='top' class='style6'><font color='#FFFFFF'>&nbsp;</font></td>
                                            <td valign='top' class='style6'>&nbsp;</td>
                                          </tr>
                                          <tr>
                                            <td height='22' valign='top' class='style6'>.</td>
                                                                                     <td valign='top' height='30' background='{$source_url}images/pinnumber.png' class='style6'>
											  <div align='center'>
											  <font size='-2' color='#FFFFFF'>PIN: </font><font size='-2' face='Trebuchet MS'> </font>
											  <font color='#FFFFFF'>{$card_allocated_pin}</font>
											  </div>
										  </td>
                                          </tr>
                                        </table>
                                      </div></td>
                                    </tr>
                                  </table></td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                </tr>
                                </table>
                        </div>                          <p align='center'></p>					    </td>
					  </tr>
					  
					  
					  
					  
					  
					  
					  <tr>
					    <td height='76' colspan='3' bgcolor='#0B2A3E'>
						
								<table width='28%' border='0' align='center'>
									  <tr>
										<td width='50%' bgcolor='#333333'><font color='#FFFFFF' size='-2' >CITY</font></td>
										<td width='50%' bgcolor='#333333'><font color='#FFFFFF' size='-2' >ACCESS NUMBER </font></td>
									  </tr>
									  <tr>
										<td><font color='#FFFFFF' size='-2' >WASHINGTON</font></td>
										<td><font color='#FFFFFF' size='-2' >1-202-730-9023</font></td>
									  </tr>
									  <tr>
										<td><font color='#FFFFFF' size='-2' >PHILADELPHIA</font></td>
										<td><font color='#FFFFFF' size='-2' >1-215-618-3321</font></td>
									  </tr>
									  <tr>
										<td><font color='#FFFFFF' size='-2' >MIAMI</font></td>
										<td><font color='#FFFFFF' size='-2' >1-305-351-9500</font></td>
									  </tr>
									  <tr>
										<td><font color='#FFFFFF' size='-2' >LOS ANGELES </font></td>
										<td><font color='#FFFFFF' size='-2' >1-323-474-0044</font></td>
									  </tr>
									  <tr>
										<td><font color='#FFFFFF' size='-2' >SPRINGFIELD LUDLOW </font></td>
										<td><font color='#FFFFFF' size='-2' >1-413-308-3016</font></td>
									  </tr>
									  <tr>
										<td><font color='#FFFFFF' size='-2' >ROCHESTER</font></td>
										<td><font color='#FFFFFF' size='-2' >1-507-226-9993</font></td>
									  </tr>
									  <tr>
										<td><font color='#FFFFFF' size='-2' >ST. LOUIS </font></td>
										<td><font color='#FFFFFF' size='-2' >1-618-433-3002</font></td>
									  </tr>
									  <tr>
										<td><font color='#FFFFFF' size='-2' face='Trebuchet MS'>GAINSVILLE</font></td>
										<td><font color='#FFFFFF' size='-2' >1-678-928-3395</font></td>
									  </tr>
									  <tr>
										<td><font color='#FFFFFF' size='-2' >ARLINGTON</font></td>
										<td><font color='#FFFFFF' size='-2' >1-682-227-6162</font></td>
									  </tr>
									</table>
					  </td>
				      </tr>
					  
					  
					  
					  
					  
					  
					  
					  <tr>
						<td colspan='3' bgcolor='#0B2A3E' align='center'><a href='{$source_url}'>
						<img src='{$source_url}card_footer.png' width='640' height='9' border='0' /></a></td>
					  </tr>
</table>
</font>
					";
		
		
		/*Email Username and password to new member*/
			$title = "Magolink Admin: Order Confirmation";
			$content = "<table width='408' border='0'>
						  <tr>
							<td colspan='2'>Dear ".$owner_name.",</td>
						  </tr>
						  <tr>
							<td colspan='2'>This is to confirm that you have successfully purchased a call card....</td>
						  </tr>
						   <tr>
						    <td height='127' colspan='2'>
														
							   ".$thecard."
							
							</td>
  </tr>
						 <tr>
							<td colspan='2'>Kindly spare a few minutes to comment/give a testimonial 
							on our services! Click the link below to comment on our service: <br>
							<p>
								If you cannot click on the link below, please copy and paste it onto your browser's 
								address bar and go to the page.
							</p>
									
									
							<hr>
							<a href='{$source_url}comment.php' >{$source_url}comment.php</a>
							<hr> </td>
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

	$callcard_payments = getAllCallcardPayments(STATUS_DONE);
	
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
.style5 {color: #003366}
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
            <td height="31" bgcolor="#CCCCCC"><? include "top_right.php"; ?></td>
          </tr>
          <tr>
            <td height="18"  bgcolor="#FFFFFF"><? include "callcard_menu_admin2.php"; ?></td>
          </tr>
          
          <tr>
            <td width="574">
			
			
			<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
			  
			  

			  <tr>
                <td height="60" valign="bottom"><span class="style4">CALLING CARD  Log:  (complete transactions)</span></td>
			    </tr>
			  
			   <tr>
                <td height="90"><img src="images/spacer.gif" width="1" height="5"><img src="images/spacer.gif" width="1" height="1" border="0">
                  <fieldset>
                  <legend>CALLING CARD Payments Log </legend>
				  
				  <table width="744" border="0">
                    <tr>
                      <th width="22" bgcolor="#F3EACB" scope="col"><div align="center">ID</div></th>
                      <th width="115" bgcolor="#F3EACB" scope="col"><div align="left"><span class="style29">Date &amp; Time </span></div></th>
                      <th width="196" bgcolor="#F3EACB" scope="col"><div align="left">Time Lapse </div></th>
					  <th bgcolor="#F3EACB" scope="col"><div align="left">Sender </div></th>
                      <th width="117" bgcolor="#F3EACB" scope="col"><div align="left"><span class="style29">Amt</span></div></th>
                      <th width="40" bgcolor="#F3EACB" scope="col">&nbsp;</th>
                      <th width="73" bgcolor="#F3EACB" scope="col"><span class="style29">Status</span></th>
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
						
						$owner_email = getUserEmail($owner);
						$owner_name = getUserName($owner);
						
						 ?>
                    <tr>
                      <td valign="top"><strong><? echo $number; ?></strong></td>
                      <td height="21" valign="top"><? echo $date . " | " . $clocktime; ?> </td>
                      <td  valign="top"><div align="left">
                          <? if($timethen != 0)
										  echo ShortenText(time_duration($timenow - $timethen),20) . "ago.";
									?>
                      </div></td>
					  <td valign="top"><?=$owner_name; ?>                            </td>
                      <td valign="top"><div align="left"> US$
                        <?=$amt_usd; ?>
                      </div></td>
                      <td valign="top"><div align="right"> <a onClick="show_CallcardTransactionForm(<?=$number; ?>);" class="hintanchor" style='color:#000000; cursor:pointer;' onmouseover="showhint('SEND TO:<hr>Name: <?=$name; ?><hr>MPESA Number: <?=$phone; ?><hr><?=$message; ?><hr>', this, event, '200px')">[?]</a></div></td>
                      <td valign="top"><div align="left"><?=$status; ?></div></td>
                    </tr>
                    <tr>
                      <td colspan="7" valign="top" bgcolor="#CCCCCC" class="marginbottom" style="padding-right:10px;"><div id="more_info_<?=$number; ?>"> </div>
                          <div align="left" id="loading_div"></div></td>
                    </tr>
                    <?
						} 
				  
				  ?>
                    <tr>
                      <td>&nbsp;</td>
                      <td colspan="2"><a href="excel_complete.php" class="style5">Export To Excel</a></td>
                      <td width="151">&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                  </table>
                  </fieldset>
				  
				  
				  
				  
				  
				  
				  
				  
						  </td>
              </tr>
              <tr>
                <td background="images/gr2.gif" height="52"><img src="images/spacer.gif" width="1" height="52"><img src="images/spacer.gif" width="1" height="1" border="0"></td>
              </tr>
			  <tr>
                <td><a href="#"></a></td>
              </tr>
			  <tr>
                <td><img src="images/spacer.gif" width="1" height="15"><img src="images/spacer.gif" width="1" height="1" border="0"></td>
              </tr>
			  <tr>
                <td>&nbsp;</td>
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
