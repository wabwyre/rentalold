<?php
ini_set("session.gc_maxlifetime", "14400");
session_start();
include "connection/config.php";
include "library.php";
include "parking_module/library.php";
include "payment_agent_module/library.php";
include "reports_library.php";



if ($_POST['entry_point'] == "valid" && $_SESSION['logged'] == false) {
    if (!checkLogin($_POST['username'], $_POST['password']))
        echo "Login was un-successful. Please try again!";
}
elseif ($_GET['signout'] == "t") {
    session_destroy();
}
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
        <link rel="stylesheet" type="text/css" href="css/datepicker.css" />
        <script type="text/javascript" src="js/datepicker.js"></script>
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
            .table_fields {font-family:"Trebuchet MS"; font-size:12px;}
            .style57 {
                font-size: 16px;
                color:#000;
                font-family: "Trebuchet MS";
                font-weight: bold;
            }
            .topcell { background-image: url(TReyebrow.gif);}
            -->
        </style>
        <!--Server side validation markets/cpermits/crm module/staff module-->
        <style type="text/css" xml:space="preserve">
            BODY, P,TD{ font-family: Arial,Verdana,Helvetica, sans-serif; font-size: 10pt }
            A{font-family: Arial,Verdana,Helvetica, sans-serif;}
            B {	font-family : Arial, Helvetica, sans-serif;	font-size : 12px;	font-weight : bold;}
            .error_strings{ font-family:Verdana; font-size:10px; color:#660000;}
        </style><script language="JavaScript" src="js/gen_validatorv4.js"
        type="text/javascript" xml:space="preserve"></script>

        <!--Server side validation-->
        <!--design of the links-->
        <style type="text/css">
            #edit_link {
                background:url(linker1.jpg);
                color: green;
                text-decoration: none;
                font-weight: bold;
            }
            #delete_link
            {
                background:url(linker1.jpg);
                color: red;
                text-decoration: none;
                font-weight: bold;
            }
            #profile_link
            {
                background:url(linker1.jpg);
                color:orange;
                text-decoration: none;
                font-weight: bold;
            }

        </style>

    </head>
    <body>
<?
if ($_SESSION['logged']) {
    ?>
            <div id="main" name="main" style="visibility:hidden">
                <div style="height:0px; background-image:url(TopBar.png); background-repeat:no-repeat;"></div>
                <table width="100%" id="shelltable" border="0" align="center" bgcolor="#F3F3F3" cellpadding="0" cellspacing="0" >
                    <tr class="topcell" height="20"> <td width="39%" height="10" valign="top" class="style57">
                    <br><strong>Welcome, <?php echo $_SESSION['sys_name']; ?> </strong><br><br></td>
                        <td width="37%" valign="middle" class="header2" style="padding:2px"><span class="style56">
                                <div id="loading_div" style="display:none;"><img src="loading.gif" width="280" height="13" /></div>

                            </span></td>
                        <td width="15%" valign="top" class="header2" style="padding:2px">&nbsp;</td>
                        <td width="9%" valign="top" style="padding:2px"><div align="right"><a href="index.php?signout=t" class="style56">sign-out</a> </div> </td> </tr>

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
    include "parking_module/settings.php";
    include "payment_agent_module/settings.php";
    include "rate_module/settings.php";
    include "sbp_module/sbp_settings.php";
    include "markets_module/market_settings.php";
    include "rents_module/rents_settings.php";

    $processed = 0;

    if ($_POST['action']) {
        include "rate_module/rates_processor.php";
        include "markets_module/markets_processor.php";
        include "construction_permits/construction_permits_processor.php";
        include "staff_module/staff_processor.php";
        include "crm_module/crm_processor.php";
        include "rents_module/rents_processor.php";
        include "sbp_module/sbp_processor.php";
        include "land_rates/land_processor.php";
		include "parking_module/parking_processor.php";
		include "userlevels/level_processor.php";
    }
    ?>

                            </div> </td> </tr>

                                <?
                                if ($processed == 1) {
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
                        <td height="495px" colspan="4" valign="top" style="padding:5px;">

                            <!------------------------------------------------------------------------------->

    <?
    //echo "Processor = ---".$processed."---";

    if ($_GET["num"]) {
        if ($pages[$_GET["num"]] == "")
            echo "<div class='table_fields' style='margin-top:200px;' align='center'>AFYAPOA Modules<hr>Page Currently UnAvailable</div>";
        else
            include ($pages[$_GET["num"]]);
    }
    else
        include ($pages[1]);
    ?>


                            <!------------------------------------------------------------------------------->
                        </td>
                    </tr>

                    <tr>
                        <td height="39" colspan="4" valign="top">
                            <div align="center" class="style56">
                                Copyright &copy; <? echo date("Y"); ?> Obulex Business Solutions
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
}
else {
    include "login.php";
}
?>
