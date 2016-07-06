<?php
set_layout("form-layout.php", array(
	'pageSubTitle' => 'POLICY PROFILE',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'#', 'text'=>'Home' ),
		array ( 'text'=>'CRM' ),
		array ( 'text'=>'All Customers' ),
		array ( 'text'=>'Profile' )
	),
	'pageWidgetTitle'=>'<i class="icon-reorder"></i>Policy Profile'
));

set_css(array(
	'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.css'
));

set_js(array(
	'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.js',
)); 

//get the value
$customer=$_GET['afyapoa_id'];
if (isset($customer))
{
    //get the row
    $query="SELECT af.*, c.*, ad.* FROM ".DATABASE.".afyapoa_file af "
            . " left join customers c"
            . " on af.customer_id = c.customer_id"
            . " left join ndovu_address ad on ad.customer_id = c.customer_id"
            . " WHERE afyapoa_id ='$customer'";
    $data=run_query($query);
    $total_rows=get_num_rows($data);
}

$con=1;
$total=0;

$row=get_row_data($data);

        //the values
                $ccn_customer_id=$row['customer_id'];
		$surname=$row['surname'];
		$start_date=$row['start_date'];
		$active=$row['active'];
                
                $total_premium = $row['total_premium'];
                $loan_amount = $row['loan_amount'];
                $amount_paid = $row['paid_premium'];
                
		$customer_type_id=$row['customer_type_id'];
                if(isset($customer_type_id))
                    // {
                    // $customer_type_name=getCustomerTypeName($customer_type_id);
                    // }
		$firstname=$row['firstname'];
		$address_id=$row['address_id'];
		if(isset($address_id))
		{
		$address_name=getAddressName($address_id);
		}
		$middlename=$row['middlename'];
		$regdate_stam=$row['regdate_stamp'];
		$regdate_stamp=date("d-m-Y",$regdate_stam);
		$national_id_number=$row['national_id_number'];
		$phone=$row['phone'];
		$passport=$row['passport'];
		$mcare_id = $row['mcare_id'];
		$dunamiss_id = $row['dunamiss_id'];
		$balance=$row['balance'];
		$username=$row['username'];

		$timedate=date("d-m-Y",$row['time_date']);
                $email=$row['email'];
?>

<!-- BEGIN INLINE TABS PORTLET-->
<form enctype="multipart/form-data" class="form-horizontal" method="post" id= "" class="widget">
<div class="row-fluid">
    <div class="span12">
        <!--BEGIN TABS-->
        <div class="tabbable tabbable-custom">
           <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1_1" data-toggle="tab">OVERVIEW</a></li>
              <li><a href="#tab_1_2" data-toggle="tab">PRINCIPAL INFO</a></li>
              <li><a href="#tab_1_3" data-toggle="tab">DEPENDANTS</a></li>
              <li><a href="#tab_1_4" data-toggle="tab">SAVINGS</a></li>
              <li><a href="#tab_1_5" data-toggle="tab">RE-PAYMENTS</a></li>
              <li><a href="#tab_1_5" data-toggle="tab">HOSP. BILLING</a></li>
           </ul>
                                 
        <div class="tab-content">
           <div class="tab-pane row-fluid active" id="tab_1_1">
               <?php include "overview.php"; ?>
       </div>   
            
           <div class="tab-pane" id="tab_1_2">   
                <?php include "profile_info.php"; ?>
           </div>

           <div class="tab-pane" id="tab_1_3">
                <?php include "dependants.php"; ?>
           </div>
		
           <div class="tab-pane" id="tab_1_4">
                <?php //include "bills_info.php"; ?>
           </div>					

           <div class="tab-pane" id="tab_1_5">
                <?php //include "transfer_request.php"; ?>
           </div>
           <div class="tab-pane" id="tab_1_5">
                <?php //include "transfer_request.php"; ?>
           </div>
          
        </div>
        																
        </div>
        <!--END TABS-->
        <!-- END PAGE --> 
    </div>
</div>
</form>

                                 



