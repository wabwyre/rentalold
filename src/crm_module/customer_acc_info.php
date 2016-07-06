<?php
	include_once "src/models/Masterfile.php";
	$masterfile = new Masterfile();

	//get the value
	if (isset($_GET['acc_id'])){
		$acc_id=$_GET['acc_id'];

    $acc_details = $masterfile->getAccountDetails($acc_id); // this is an array containing all the details for a customer_account and device

		set_layout("dt-layout.php", array(
			'pageSubTitle' => 'Customer Acc Details',
			'pageSubTitleText' => '',
			'pageBreadcrumbs' => array (
				array ( 'url'=>'#', 'text'=>'Home' ),
				array ( 'text'=>'CRM' ),
				array ( 'url'=>'?num=801', 'text'=>'All Masterfile' ),
				array ( 'url'=>'?num=810&mf_id='.$acc_details['mf_id'], 'text'=>'Masterfile Profile' ),
				array ( 'text'=>'Phones' ),
				array ( 'text'=>'View Bills' )
				)
		));

	}

?>

<div class="widget">
  <div class="widget-title"><h4><i class="icon-reorder"></i> Customer Name: <span style="color: green;"><?=$acc_details['customer_name']; ?> </span>Customer Account Code: <span style="color: green;"><?php echo $acc_details['customer_code']; ?></span></h4></div>
  <div class="widget-body form">
  <!-- BEGIN INLINE TABS PORTLET-->
  <form enctype="multipart/form-data" class="form-horizontal" method="post" id= "" class="widget">
  <div class="row-fluid">
      <div class="span12">
          <!--BEGIN TABS-->
          <div class="tabbable tabbable-custom">
              <ul class="nav nav-tabs">
                <?php
                  $tab1 = '';
                  $tab2 = '';
                  $tab5 = '';
                  if(isset($_SESSION['done-deal'])){
                    $tab2 = 'active';
                  }else if(isset($_POST['month'])){
                    $tab5 = 'active';
                  }
                  else{
                    $tab1 = 'active';
                  }
                ?>
                <li class="<?=$tab1; ?>"><a href="#tab_1_1" data-toggle="tab"><i class="icon-user"></i> Customer Details</a></li>
                <li class="<?=$tab2; ?>"><a href="#tab_1_2" data-toggle="tab"><i class="icon-book"></i> Bills</a></li>                
                <li class=""><a href="#tab_1_3" data-toggle="tab"><i class="icon-money"></i> Payments</a></li>               
                <li class=""><a href="#tab_1_4" data-toggle="tab"><i class="icon-money"></i> Loan Repayments</a></li>  
                <li class="<?=$tab5; ?>"><a href="#tab_1_5" data-toggle="tab"><i class="icon-file"></i> Statement</a></li>
             </ul>
                                   
          <div class="tab-content">
              <div class="tab-pane <?=$tab1; ?> profile-classic row-fluid"  id="tab_1_1">
                 <?php include "customer_details.php"; ?>
              </div> 

              <div class="tab-pane <?=$tab2; ?> profile-classic row-fluid" id="tab_1_2">
                 <?php include "customer_phone_bills.php"; ?>
              </div>
              
              <div class="tab-pane profile-classic row-fluid" id="tab_1_3">
                 <?php include "phone_payments.php"; ?>
              </div>

              <div class="tab-pane profile-classic row-fluid" id="tab_1_4">
                 <?php include "phone_loan_repayments.php"; ?>
              </div>             

              <div class="tab-pane <?=$tab5; ?>  profile-classic row-fluid" id="tab_1_5">
                 <?php 	include "service_acc_statement.php"; ?>
              </div>
          </div>
                                          
          </div>
          <!--END TABS-->
          <!-- END PAGE --> 
      </div>
  </div>
  </form>
  </div>
</div>