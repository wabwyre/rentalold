<? //CCN MODULES
/************************************************************************************************/

$pages = Array();

/*CONTROL MODULE*/
$pages[0] = "home.php";
$pages[1] = "transactions.php";
$pages[2] = "buyservice_transactions.php";
$pages[3] = "paybill_transactions.php";
$pages[4] = "querybill_transactions.php";
$pages[5] = "compliance_transactions.php";

/*MARKETS MODULE*/
include("markets_module/market_settings.php");
//$pages[32] = "market_queries.php";
//$pages[33] = "market_bills.php";




/*SBP MODULE*/

/*SBP MODULE
>>>>>>> .r50
$pages[41] = "business_permits.php";
$pages[42] = "search_businesspermit.php";
$pages[43] = "businesspermit_bills.php";
$pages[46] = "view_business.php";
$pages[47] = "payments_businesspermit.php";

//$pages[51] = "rents.php";
/************************************************************************************************/
/*CONSTRUCTION PERMITS MODULE*/
$pages[601]="construction_permits/construction_permits.php";
$pages[602]="construction_permits/edit_cpermit.php";
$pages[603]="construction_permits/search_construction_permit.php";
$pages[604]="construction_permits/add_cpermit.php";
/*STAFF MODULE*/
$pages['701']="staff_module/staff.php";
$pages['702']="staff_module/edit_staff.php";
$pages['703']="staff_module/add_staff.php";
$pages['704']="staff_module/search_staff.php";
$pages['705']="staff_module/staff_profile.php";
/*CRM MODULE*/
$pages['801']="crm_module/crm.php";
$pages['802']="crm_module/edit_crm.php";
$pages['803']="crm_module/add_crm.php";
$pages['804']="crm_module/search_crm.php";
$pages['805']="crm_module/customer_profile.php";

/*LAND RATES*/
include "land_rates/land_settings.php";
/*USERLEVELS*/
include "userlevels/levelsettings.php";
?>


