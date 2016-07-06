    <script type="text/javascript" src="ux/dd/src/jquery.ui.potato.menu.js"></script>
    <link rel=stylesheet href="ux/dd/src/jquery.ui.potato.menu.css">
    <style>
    #menu1 {}
    #menu2 { clear:both; width:auto;, margin-top:10px; }
	ul{ background:#000; background:rgba(0,0,0,0.9); }
    .potato-menu-item {
        width:auto;
        font-size:12px;
        background:#333;
        background:rgba(0,0,0,0.9);
    }
    .potato-menu-group {
        z-index:1000;
    }
    .potato-menu-item a {
        padding:5px 20px 5px 12px;
        color: #fff;
    }
    .potato-menu-hover {
        background-color: #666;
    }
    .potato-menu-has-vertical > a {
        /*background: transparent url(/images/icons/fammini/arrow_down.gif) right no-repeat;*/
        background: transparent url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAENSURBVDjLpZM/SwNREMTnxBRpFYmctaKCfwrBSCrRLuL3iEW6+EEUG8XvIVjYWNgJdhFjIXamv3s7u/ssrtO7hFy2fcOPmd03SYwR88xi1cPgpRdjjDB1mBquju+TMt1CFcDd0V7q4GilAwpnd2A0qCvcHRSdHUBqAYgOyaUGIBQAc4fkNSJIIGgGj4ZQx4EEAY3waPUiSC5FhLoOQkbQCJvioPQfnN2ctpuNJugKNUWYsMR/gO71yYPk8tRaboGmoCvS1RQ7/c1sq7f+OBUQcjkPGb9+xmOoF6ckCQb9pmj3rz6pKtPB5e5rmq7tmxk+hqO34e1or0yXTGrj9sXGs1Ib73efh1WaZN46/wI8JLfHaN24FwAAAABJRU5ErkJggg==) right no-repeat;
    }
    .potato-menu-has-horizontal > a {
        /*background: transparent url(/images/icons/fammini/arrow_right.gif) right no-repeat;*/
        background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAADvSURBVDjLY/z//z8DJYCJgUIwxAwImOWx22uSExvZBvz68cvm5/dfV5HFGEGxUHoiExwVf//8Zfjz+w/D719/GH79/A3UAMK/GH4CMYiWFJJk+PXrN8PN27cunWq/oA/SwwIzyUrYluHvP6AB//7A8e+/f4H4N8Pvf0D8Fyb2h+HLl696WllqJ69Nu2XOArMZpBCuGajoN1jxbwT9FyH36/dvkCt/w10Acvb+h3uxOhvoZzCbi4OLQVJSiuH1q9cMt2/cvXB7zj0beBgQAwwKtS2AFuwH2vwIqFmd5Fi40H/1BFDzQaBrdTFiYYTnBQAI58A33Wys0AAAAABJRU5ErkJggg==) right no-repeat;
    }
    .potato-menu-item ul {
        border-top:1px solid #444;
        border-left:1px solid #444;
    }
    </style>


<ul id="menu1">
<? 
if ($_SESSION['usertype'] ==29 || $_SESSION['usertype'] ==33  || $_SESSION['usertype'] ==30)
{
?>
<li><a class="qmparent" href="index.php?num=1">INBOX</a>
	<ul>
    	<li><a href="index.php?num=1">ALL Requests</a></li>
		<li><a href="index.php?num=2">BuyService (Pay2Consume)</a></li>
		<li><a href="index.php?num=3">PayBill (PayAsYouConsume)</a></li>
		<li><a href="index.php?num=4">QueryBill (Queries)</a></li>
        <li><a href="index.php?num=5">CheckCompliance (Validation)</a></li>

	</ul>
</li>
<li><span class="qmdivider qmdividery" ></span></li>
<? } ?>
<? 
if ($_SESSION['usertype'] ==29 || $_SESSION['usertype'] ==34 || $_SESSION['usertype'] ==30)
{
?>
<li><a href="#">PAYMENT & BILLS</a>
    <ul>
    	<li><a href="index.php?num=139">Pay Bill</a></li>
                
        <li><a href="index.php?num=145">Payments</a></li>
        <li><a href="#">Bills</a>
            <ul>
                <li><a href="index.php?num=146">Bills</a></li>
                <li><a href="index.php?num=147">Search Bill</a></li>
            </ul>
        </li>
        <li><span class="qmdivider qmdividerx" ></span></li>
        <li><a href="index.php?num=152">Manage Services</a></li>
        <li><span class="qmdivider qmdividerx" ></span></li>
        <li><a href="index.php?num=149">Manage Service Bills</a></li>
	</ul>
</li>

<li><span class="qmdivider qmdividery" ></span></li>
<?
}
if ($_SESSION['usertype'] ==29 || $_SESSION['usertype'] ==30)
{
?>
<li><a class="qmparent" href="index.php?num=101">PARKING</a>
	<ul>
    	<li>
            <a href="index.php?num=101">Parking Tickets</a>
            <ul>
                <li><a href="index.php?num=1142">Search Parking </a></li>
            </ul>
        </li>
        <li><span class="qmdivider qmdividerx" ></span></li>
        </li>
        <li><span class="qmdivider qmdividerx" ></span></li>
        <li><a href="index.php?num=105">Parking Bills</a></li>
        <li><span class="qmdivider qmdividerx" ></span></li>
        <li>
            <a href="index.php?num=106">Parking Options</a>
            <ul>
                <li><a href="index.php?num=1145">Search Parking Options</a></li>
            </ul>
        </li>
        <li><span class="qmdivider qmdividerx" ></span></li>
        
        <li><a href="index.php?num=108">Manage Streets And Regions</a>
        <ul>
             <li><a href="index.php?num=124">Manage Streets</a></li>
             <li><a href="index.php?num=127">Manage Regions</a></li>
             <li><a href="index.php?num=108">Manage Streets And Regions Allocation</a></li>
        </ul></li>
        <li>
            <a href="index.php?num=132">Manage Vehicles</a>
            <ul>
                <li><a href="index.php?num=132">Manage Vehicles</a></li>
                <li><a href="index.php?num=136">Manage Vehicle Types</a></li>
                <li><a href="index.php?num=1140">Search Customers' Vehicles</a></li>
            </ul>
        </li>
<li><a href="index.php?num=1147">Manage Declampers</a></li>
</li>

<?
}
?>
<? if ($_SESSION['usertype'] ==29 || $_SESSION['usertype'] ==30)
{ ?>
<li>
  <a href="index.php?num=102">Parking Queries</a>
                     <ul>
                        <li><a href="index.php?num=1146">Search Parking Queries </a></li>
                    </ul>

                </li>
                
<li><a href="index.php?num=107">Manage Inspectors</a>
        <ul>
            <li><a href="index.php?num=107">Manage Inspectors</a></li>
            <li><a href="index.php?num=123">View Inspectors</a></li>
        </ul></li>
<?
}
?>
<? if ($_SESSION['usertype'] ==29 || $_SESSION['usertype'] ==31  || $_SESSION['usertype'] ==30)
{ ?>
<li>
                    <a href="index.php?num=103">Clamped Vehicles</a>
                    <ul>
                        <li><a href="index.php?num=1143">Uncleared vehicle</a></li>
                    </ul>
                </li>
                  <li><a href="index.php?num=109">Manage Clampers</a>
        <ul>
            <li><a href="index.php?num=109">Manage Clampers</a></li>
             <li><a href="index.php?num=130">View Clampers</a></li>
        </ul> </li>
        <? 
        } ?>
        <? if ($_SESSION['usertype'] ==29 || $_SESSION['usertype'] ==32  || $_SESSION['usertype'] ==30)
{ ?>
         <li>
            <a href="index.php?num=104">Towed Vehicles</a>
            <ul>
                <li><a href="index.php?num=1144">Uncleared towed vehicle</a></li>
            </ul>
            </li>
              <li><a href="index.php?num=110">Manage Towers</a>
            <ul>
                  <li><a href="index.php?num=110">Manage Towers</a></li>
                  <li><a href="index.php?num=131">View Towers</a></li>
            </ul>
	</ul>
        </li>
<? } ?>
<li><span class="qmdivider qmdividery" ></span></li>
<?
if ($_SESSION['usertype'] ==29 || $_SESSION['usertype'] ==35) 
{
?>
<li><a class="qmparent" href="index.php?num=301">MARKETS</a>
	<ul>

<?php
include("markets_module/market_system_admin.php");
?>
	</ul>
</li>

<li><span class="qmdivider qmdividery" ></span></li>
<?
}
if ($_SESSION['usertype'] ==29 || $_SESSION['usertype'] ==36) 
{
?>

    <?php
    include("rate_module/rates_system_admin.php");
    ?>


<li><span class="qmdivider qmdividery" ></span></li>
<? 
}
if ($_SESSION['usertype'] ==29 || $_SESSION['usertype'] ==37  || $_SESSION['usertype'] ==30)
{
?>
<li><a class="qmparent" href="index.php?num=41">BUSINESS PERMITS</a>
	<ul>
    	<li><a href="index.php?num=41">ALL SBPs</a></li>
		<li><a href="index.php?num=42">Search SBP</a></li>
		<li><a href="index.php?num=43">Bills</a></li>
        <li><a href="index.php?num=44">Activity Codes/Rates</a></li>

	</ul>
</li>

<li><span class="qmdivider qmdividery" ></span></li>
<?
}
if ($_SESSION['usertype'] ==29 || $_SESSION['usertype'] ==38  || $_SESSION['usertype'] ==30)
{
?>
<li><a class="qmparent" href="index.php?num=51">RENTS(HOUSE/STALLS)</a>
	<ul>
    	<li><a href="index.php?num=51">ALL RENTs</a></li>
		<li><a href="index.php?num=52">Search HOUSE/STALL</a></li>
		<li><a href="index.php?num=510">RENT Bills</a></li>
        <li><a href="index.php?num=55">New House</a></li>
        <li><a href="index.php?num=54">Manage >></a>
        <ul>
    		<li><a href="index.php?num=57">House Types</a></li>
            <li><a href="index.php?num=58">House Estates</a></li>
			<li><a href="index.php?num=514">Deleted Rent Accounts</a></li>
        </ul>
        </li>
        <li><a>Filters >></a>
		<ul>
    		<li><a href="index.php?num=501">Paid Bills</a></li>
            <li><a href="index.php?num=502">Pending Bills</a></li>
			<li><a href="index.php?num=503">Payments</a></li>
            <li><a href="index.php?num=504">Accounts</a></li>
			<li><a href="index.php?num=59">Estates</a></li>
        </ul>
		</li>
		<li><a href="index.php?num=508">Create rent bills</a></li>
        <li><a href="index.php?num=509">Create rent interest bills</a>
	</ul>
</li>
<li><span class="qmdivider qmdividery" ></span></li>
<?
}
if ($_SESSION['usertype'] ==29 || $_SESSION['usertype'] ==39  || $_SESSION['usertype'] ==30)
{
?>
<li><a class="qmparent" href="admin.php">MESSAGING SYSTEM</a>
	<ul>
    	<li><a href="index.php?num=99">Test SMS</a></li>
		<li><a href="admin.php?num=1">Sent SMS</a></li>
		<li><a href="admin.php?num=12">Sent Email</a></li>
		<li><span class="qmdivider qmdividerx" ></span></li>
        <li><a href="index.php?num=10">All Response Messages</a></li>
	</ul>
</li>
<li><span class="qmdivider qmdividery" ></span></li>
<?
}
if ($_SESSION['usertype'] ==29 || $_SESSION['usertype'] ==40  || $_SESSION['usertype'] ==30)
{
?>
<li><a class="qmparent" href="index.php?num=601">CONSTRUCTION PERMITS</a>
<ul>
		<li><a href="index.php?num=603">Search Construction Permit</a></li>
                <li><a href="index.php?num=604">Add Construction Permit</a></li>
	</ul>


</li>
<li><span class="qmdivider qmdividery" ></span> </li>
<?
}
if ($_SESSION['usertype'] ==29 || $_SESSION['usertype'] ==41 || $_SESSION['usertype'] ==1  || $_SESSION['usertype'] ==30)
{
	?>
	<li>
				<a class="qmparent" href="index.php?num=701">STAFF</a>
				<ul>
				<?php
				include ("staff_module/staff_system_admin.php");
				?>
				</ul>
				<? 
				include ("userlevels/leveladmin.php"); 
				 ?>
              </li>

	<li><span class="qmdivider qmdividery" ></span> </li>
	<?
	}
if ($_SESSION['usertype'] ==29 || $_SESSION['usertype'] ==42  || $_SESSION['usertype'] ==30)
{
	?>
	<li>
				<a class="qmparent" href="index.php?num=801">CRM</a>
				<ul>
				<li><a href="index.php?num=801">CRM</a></li>
				<li><a href="index.php?num=804">Search CRM</a></li>
                                <li><a href="index.php?num=803">Add CRM</a></li>
				</ul>
              </li>

<li class="qmclear">&nbsp;</li> 
<? } ?></ul>



<?
// <li><a href="admin.php?num=22">Fees Distribution</a></li>
?>





<script type="text/javascript">
(function($) {
    $(document).ready(function(){
        $('#menu1').ptMenu();
        $('#menu2').ptMenu({vertical:true});
    });
})(jQuery);
</script>
