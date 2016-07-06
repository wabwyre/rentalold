<?php
if (isset($_GET['customer'])){
   $customer=$_GET['customer'];
   //get the row
   $query="SELECT a.*, c.*, ct.*, ad.post_office_box, ad.postal_code, ad.premises, ad.street, ad.town, ad.county FROM afyapoa_agent a 
      LEFT JOIN customers c ON c.customer_id = a.customer_id
      LEFT JOIN ndovu_address ad ON ad.address_id = c.address_id
      LEFT JOIN customer_types ct ON ct.customer_type_id = c.customer_type_id
      WHERE c.customer_id = '".$customer."'
   ";
   $data=run_query($query);
   $row=get_row_data($data);
   $customer_name = $row['surname'].' '.$row['firstname'].' '.$row['middlename'];
}

set_layout("dt-layout.php", array(
	'pageSubTitle' => 'PROFILE',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'#', 'text'=>'Home' ),
		array ( 'text'=>'CRM' ),
		array ( 'url'=>'?num=815', 'text'=>'All Super Champions' ),
		array ( 'text'=>'Super Champion  Profile' )
	)
));


      //the values
      $customer_id=$row['customer_id'];
      $agent_id=$row['afyapoa_agent_id'];
		$surname=$row['surname'];
		$start_date=$row['start_date'];
		$active=$row['active'];
		$customer_type_id=$row['customer_type_id'];
		$firstname=$row['firstname'];
		$address_id=$row['address_id'];
		// if(isset($address_id))
		// {
		// $address_name=getAddressName($address_id);
		// }
		$middle_name=$row['middlename'];
		$regdate_stam=$row['regdate_stamp'];
		$regdate_stamp=date("d-M-Y", $regdate_stam);
		$national_id_number=$row['national_id_number'];
		$phone=$row['phone'];
		$passport=$row['passport'];
		$balance=$row['balance'];
		$username=$row['username'];
      $dob = $row['dob'];
      $customer_type_name = $row['customer_type_name'];
		$timedate=date("d-m-Y", strtotime($row['time_date']));
      $email=$row['email'];
      $customer_name = $row['surname'].' '.$row['firstname'].' '.$row['middlename'];
      $image_path = $row['images_path'];
      if($image_path == ''){
         $image_path = 'assets/img/profile/photo.jpg';
      }
      $status = $row['status'];
      if($status == 1){
         $status = 'Active';
      }else{
         $status = 'Inactive';
      }
      $address_item = 'P.O Box '.$row['post_office_box'].', '.$row['postal_code'].'. '.$row['county'];
?>
<!--begin form-->
   <div class="widget">
      <div class="widget-title"><h4><i class="icon-reorder"></i> Super Champion Name { <span style="color: green;"><?=strtoupper($customer_name); ?></span> }</h4></div>
		<div class="widget-body form">
                           <div class="tabbable tabbable-custom">
                              <ul class="nav nav-tabs">
                                 <li class="active"><a href="#tab_1_1" data-toggle="tab">Overview</a></li>
                                 <!-- <li><a href="#tab_1_2" data-toggle="tab">Principle Info</a></li> -->
                                 <!-- <li><a href="#tab_1_3" data-toggle="tab">Dependants</a></li>
                                 <li><a href="#tab_1_4" data-toggle="tab">Savings</a></li>
                                 <li><a href="#tab_1_6" data-toggle="tab">Repayments</a></li> -->
                              </ul>
                              <div class="tab-content">
                                 <div class="tab-pane row-fluid active" id="tab_1_1">
                                    <ul class="unstyled profile-nav span3">
                                       <li><img src="<?=$image_path; ?>" alt="" /></li>
                                       <!-- <li><a href="#">Projects</a></li>
                                       <li><a href="#">Messages <span>3</span></a></li>
                                       <li><a href="#">Friends</a></li>
                                       <li><a href="#">Settings</a></li> -->
                                    </ul>
                                    <div class="span9">
                                       <div class="row-fluid">
                                          <div class="span12 profile-info">
                                             <h1><?=$customer_name; ?></h1>
                                             
                                             <p><?=$address_item; ?></p>
                                             <ul class="unstyled inline">
                                                <!-- <li><i class="icon-map-marker"></i> Spain</li>
                                                <li><i class="icon-calendar"></i> <?=$dob; ?></li>
                                                <li><i class="icon-briefcase"></i> Design</li>
                                                <li><i class="icon-star"></i> Top Seller</li>
                                                <li><i class="icon-heart"></i> BASE Jumping</li> -->
                                             </ul>
                                          </div>
                                          <!--end span8-->
                                          <!--end span4-->
                                       </div>
                                       <!--end row-fluid-->
                                       <div class="tabbable tabbable-custom tabbable-custom-profile">
                                          <ul class="nav nav-tabs">
                                             <li class="active"><a href="#tab_1_11" data-toggle="tab">Agents List</a></li>
                                             <!-- <li class=""><a href="#tab_1_22" data-toggle="tab">Registrations</a></li>
                                             <li class=""><a href="#tab_1_23" data-toggle="tab">Commissions</a></li> -->
                                          </ul>
                                          <div class="tab-content">
                                             <div class="tab-pane active" id="tab_1_11">
                                                <div class="portlet-body" style="display: block;">
                                                   <? include 'super_champ_agents_list.php'; ?>
                                                </div>
                                             </div>
                                             <!--tab-pane-->
                                             <div class="tab-pane" id="tab_1_22">
                                                <? include 'agent_registrations.php'; ?>
                                             </div>
                                             <!--tab-pane-->
                                              <div class="tab-pane" id="tab_1_23">
                                                <? include 'agent_commissions.php'; ?>
                                             </div>
                                             <!--tab-pane-->
                                          </div>
                                       </div>
                                    </div>
                                    <!--end span9-->
                                 </div>
                                 <!--end tab-pane-->
                                 <div class="tab-pane profile-classic row-fluid" id="tab_1_2">
                                    <? //include 'principle_info.php'; ?>
                                 </div>
                                 <!--tab_1_2-->
                                 <div class="tab-pane row-fluid profile-account" id="tab_1_3">
                                    <?php
                                       //dependants
                                      // include 'dependants.php'; 
                                    ?>
                                 </div>
                                 <!--end tab-pane-->
                                 <div class="tab-pane" id="tab_1_4">
                                    <?php
                                       //savings
                                       //include 'savings.php'; 
                                    ?>
                                 </div>
                                 <!--end tab-pane-->
                                 <div class="tab-pane row-fluid" id="tab_1_6">
                                    <div class="row-fluid">
                                       <div class="span12">
                                          <div class="span3">
                                             <ul class="ver-inline-menu tabbable margin-bottom-10">
                                                <li class="active">
                                                   <a data-toggle="tab" href="#tab_1">
                                                   <i class="icon-briefcase"></i> 
                                                   General Questions
                                                   </a> 
                                                   <span class="after"></span>                                    
                                                </li>
                                                <li><a data-toggle="tab" href="#tab_2"><i class="icon-group"></i> Membership</a></li>
                                                <li><a data-toggle="tab" href="#tab_3"><i class="icon-leaf"></i> Terms Of Service</a></li>
                                                <li><a data-toggle="tab" href="#tab_1"><i class="icon-info-sign"></i> License Terms</a></li>
                                                <li><a data-toggle="tab" href="#tab_2"><i class="icon-tint"></i> Payment Rules</a></li>
                                                <li><a data-toggle="tab" href="#tab_3"><i class="icon-plus"></i> Other Questions</a></li>
                                             </ul>
                                          </div>
                                          <div class="span9">
                                             <div class="tab-content">
                                                <div id="tab_1" class="tab-pane active">
                                                   <div style="height: auto;" id="accordion1" class="accordion collapse">
                                                      <div class="accordion-group">
                                                         <div class="accordion-heading">
                                                            <a href="#collapse_1" data-parent="#accordion1" data-toggle="collapse" class="accordion-toggle collapsed">
                                                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry ?
                                                            </a>
                                                         </div>
                                                         <div class="accordion-body collapse in" id="collapse_1">
                                                            <div class="accordion-inner">
                                                               Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod.
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <div class="accordion-group">
                                                         <div class="accordion-heading">
                                                            <a href="#collapse_2" data-parent="#accordion1" data-toggle="collapse" class="accordion-toggle collapsed">
                                                            Pariatur cliche reprehenderit enim eiusmod highr brunch ?
                                                            </a>
                                                         </div>
                                                         <div class="accordion-body collapse" id="collapse_2">
                                                            <div class="accordion-inner">
                                                               Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor.
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <div class="accordion-group">
                                                         <div class="accordion-heading">
                                                            <a href="#collapse_3" data-parent="#accordion1" data-toggle="collapse" class="accordion-toggle collapsed">
                                                            Food truck quinoa nesciunt laborum eiusmod nim eiusmod high life accusamus  ?
                                                            </a>
                                                         </div>
                                                         <div class="accordion-body collapse" id="collapse_3">
                                                            <div class="accordion-inner">
                                                               Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor.
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <div class="accordion-group">
                                                         <div class="accordion-heading">
                                                            <a href="#collapse_4" data-parent="#accordion1" data-toggle="collapse" class="accordion-toggle collapsed">
                                                            High life accusamus terry richardson ad ?
                                                            </a>
                                                         </div>
                                                         <div class="accordion-body collapse" id="collapse_4">
                                                            <div class="accordion-inner">
                                                               Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor.
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <div class="accordion-group">
                                                         <div class="accordion-heading">
                                                            <a href="#collapse_5" data-parent="#accordion1" data-toggle="collapse" class="accordion-toggle collapsed">
                                                            Reprehenderit enim eiusmod high life accusamus terry quinoa nesciunt laborum eiusmod ?
                                                            </a>
                                                         </div>
                                                         <div class="accordion-body collapse" id="collapse_5">
                                                            <div class="accordion-inner">
                                                               Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor.
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <div class="accordion-group">
                                                         <div class="accordion-heading">
                                                            <a href="#collapse_6" data-parent="#accordion1" data-toggle="collapse" class="accordion-toggle collapsed">
                                                            Wolf moon officia aute non cupidatat skateboard dolor brunch ?
                                                            </a>
                                                         </div>
                                                         <div class="accordion-body collapse" id="collapse_6">
                                                            <div class="accordion-inner">
                                                               Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor.
                                                            </div>
                                                         </div>
                                                      </div>
                                                   </div>
                                                </div>
                                                <div id="tab_2" class="tab-pane">
                                                   <div style="height: auto;" id="accordion2" class="accordion collapse">
                                                      <div class="accordion-group">
                                                         <div class="accordion-heading">
                                                            <a href="#collapse_2_1" data-parent="#accordion2" data-toggle="collapse" class="accordion-toggle collapsed">
                                                            Cliche reprehenderit, enim eiusmod high life accusamus enim eiusmod ?
                                                            </a>
                                                         </div>
                                                         <div class="accordion-body collapse in" id="collapse_2_1">
                                                            <div class="accordion-inner">
                                                               Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod.
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <div class="accordion-group">
                                                         <div class="accordion-heading">
                                                            <a href="#collapse_2_2" data-parent="#accordion2" data-toggle="collapse" class="accordion-toggle collapsed">
                                                            Pariatur cliche reprehenderit enim eiusmod high life non cupidatat skateboard dolor brunch ?
                                                            </a>
                                                         </div>
                                                         <div class="accordion-body collapse" id="collapse_2_2">
                                                            <div class="accordion-inner">
                                                               Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor.
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <div class="accordion-group">
                                                         <div class="accordion-heading">
                                                            <a href="#collapse_2_3" data-parent="#accordion2" data-toggle="collapse" class="accordion-toggle collapsed">
                                                            Food truck quinoa nesciunt laborum eiusmod ?
                                                            </a>
                                                         </div>
                                                         <div class="accordion-body collapse" id="collapse_2_3">
                                                            <div class="accordion-inner">
                                                               Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor.
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <div class="accordion-group">
                                                         <div class="accordion-heading">
                                                            <a href="#collapse_2_4" data-parent="#accordion2" data-toggle="collapse" class="accordion-toggle collapsed">
                                                            High life accusamus terry richardson ad squid enim eiusmod high ?
                                                            </a>
                                                         </div>
                                                         <div class="accordion-body collapse" id="collapse_2_4">
                                                            <div class="accordion-inner">
                                                               Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor.
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <div class="accordion-group">
                                                         <div class="accordion-heading">
                                                            <a href="#collapse_2_5" data-parent="#accordion2" data-toggle="collapse" class="accordion-toggle collapsed">
                                                            Reprehenderit enim eiusmod high life accusamus terry quinoa nesciunt laborum eiusmod ?
                                                            </a>
                                                         </div>
                                                         <div class="accordion-body collapse" id="collapse_2_5">
                                                            <div class="accordion-inner">
                                                               <p>
                                                                  Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor.
                                                               </p>
                                                               <p> 
                                                                  moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmodBrunch 3 wolf moon tempor
                                                               </p>
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <div class="accordion-group">
                                                         <div class="accordion-heading">
                                                            <a href="#collapse_2_6" data-parent="#accordion2" data-toggle="collapse" class="accordion-toggle collapsed">
                                                            Wolf moon officia aute non cupidatat skateboard dolor brunch ?
                                                            </a>
                                                         </div>
                                                         <div class="accordion-body collapse" id="collapse_2_6">
                                                            <div class="accordion-inner">
                                                               Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor.
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <div class="accordion-group">
                                                         <div class="accordion-heading">
                                                            <a href="#collapse_2_7" data-parent="#accordion2" data-toggle="collapse" class="accordion-toggle collapsed">
                                                            Reprehenderit enim eiusmod high life accusamus terry quinoa nesciunt laborum eiusmod ?
                                                            </a>
                                                         </div>
                                                         <div class="accordion-body collapse" id="collapse_2_7">
                                                            <div class="accordion-inner">
                                                               <p>
                                                                  Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor.
                                                               </p>
                                                               <p> 
                                                                  moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmodBrunch 3 wolf moon tempor
                                                               </p>
                                                            </div>
                                                         </div>
                                                      </div>
                                                   </div>
                                                </div>
                                                <div id="tab_3" class="tab-pane">
                                                   <div style="height: auto;" id="accordion3" class="accordion collapse">
                                                      <div class="accordion-group">
                                                         <div class="accordion-heading">
                                                            <a href="#collapse_3_1" data-parent="#accordion3" data-toggle="collapse" class="accordion-toggle collapsed">
                                                            Cliche reprehenderit, enim eiusmod ?
                                                            </a>
                                                         </div>
                                                         <div class="accordion-body collapse in" id="collapse_3_1">
                                                            <div class="accordion-inner">
                                                               Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod.
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <div class="accordion-group">
                                                         <div class="accordion-heading">
                                                            <a href="#collapse_3_2" data-parent="#accordion3" data-toggle="collapse" class="accordion-toggle collapsed">
                                                            Pariatur skateboard dolor brunch ?
                                                            </a>
                                                         </div>
                                                         <div class="accordion-body collapse" id="collapse_3_2">
                                                            <div class="accordion-inner">
                                                               Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor.
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <div class="accordion-group">
                                                         <div class="accordion-heading">
                                                            <a href="#collapse_3_3" data-parent="#accordion3" data-toggle="collapse" class="accordion-toggle collapsed">
                                                            Food truck quinoa nesciunt laborum eiusmod ?
                                                            </a>
                                                         </div>
                                                         <div class="accordion-body collapse" id="collapse_3_3">
                                                            <div class="accordion-inner">
                                                               Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor.
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <div class="accordion-group">
                                                         <div class="accordion-heading">
                                                            <a href="#collapse_3_4" data-parent="#accordion3" data-toggle="collapse" class="accordion-toggle collapsed">
                                                            High life accusamus terry richardson ad squid enim eiusmod high ?
                                                            </a>
                                                         </div>
                                                         <div class="accordion-body collapse" id="collapse_3_4">
                                                            <div class="accordion-inner">
                                                               Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor.
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <div class="accordion-group">
                                                         <div class="accordion-heading">
                                                            <a href="#collapse_3_5" data-parent="#accordion3" data-toggle="collapse" class="accordion-toggle collapsed">
                                                            Reprehenderit enim eiusmod high  eiusmod ?
                                                            </a>
                                                         </div>
                                                         <div class="accordion-body collapse" id="collapse_3_5">
                                                            <div class="accordion-inner">
                                                               <p>
                                                                  Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor.
                                                               </p>
                                                               <p> 
                                                                  moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmodBrunch 3 wolf moon tempor
                                                               </p>
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <div class="accordion-group">
                                                         <div class="accordion-heading">
                                                            <a href="#collapse_3_6" data-parent="#accordion3" data-toggle="collapse" class="accordion-toggle collapsed">
                                                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry ?
                                                            </a>
                                                         </div>
                                                         <div class="accordion-body collapse" id="collapse_3_6">
                                                            <div class="accordion-inner">
                                                               Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor.
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <div class="accordion-group">
                                                         <div class="accordion-heading">
                                                            <a href="#collapse_3_7" data-parent="#accordion3" data-toggle="collapse" class="accordion-toggle collapsed">
                                                            Reprehenderit enim eiusmod high life accusamus aborum eiusmod ?
                                                            </a>
                                                         </div>
                                                         <div class="accordion-body collapse" id="collapse_3_7">
                                                            <div class="accordion-inner">
                                                               <p>
                                                                  Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor.
                                                               </p>
                                                               <p> 
                                                                  moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmodBrunch 3 wolf moon tempor
                                                               </p>
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <div class="accordion-group">
                                                         <div class="accordion-heading">
                                                            <a href="#collapse_3_8" data-parent="#accordion3" data-toggle="collapse" class="accordion-toggle collapsed">
                                                            Reprehenderit enim eiusmod high life accusamus terry quinoa nesciunt laborum eiusmod ?
                                                            </a>
                                                         </div>
                                                         <div class="accordion-body collapse" id="collapse_3_8">
                                                            <div class="accordion-inner">
                                                               <p>
                                                                  Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor.
                                                               </p>
                                                               <p> 
                                                                  moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmodBrunch 3 wolf moon tempor
                                                               </p>
                                                            </div>
                                                         </div>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <!--end span9-->                                   
                                       </div>
                                    </div>
                                 </div>
                                 <!--end tab-pane-->
                              </div>
                           </div>
                           <!--END TABS-->
      </div>
   </div>
    <!-- END FORM -->