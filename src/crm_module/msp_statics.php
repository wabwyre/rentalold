<!--end tab-pane-->
      <div class="tab-pane" id="tab_1_4">
         <div class="row-fluid portfolio-block">
            <div class="span5 portfolio-text">
               <img src="assets/img/profile/portfolio/logo_metronic.jpg" alt="" />
               <div class="portfolio-text-info">
                  <h4>Visit's for : <b><?php echo date('l jS \of F Y') ?></b></h4>
                  <p>MSP Visits for the Current Day.</p>
               </div>
            </div>
            <div class="span5" style="overflow:hidden;">
               <div class="portfolio-info">
                  unique visits
                  <span>
                      <?php
                      $today = date('Y-m-d');
                     $distinctQuery2 = "SELECT count(DISTINCT customer_id) as total_unique_visits from  msp_visits WHERE msp_id = '$msp' AND  visit_date ='$today'";
                        //var_dump($distinctQuery2);exit;
                     $resultId2 = run_query($distinctQuery2);  
                     $arraa = get_row_data($resultId2);
                     $total_rows2 = $arraa['total_unique_visits'];
                      echo $total_rows2;
                     ?>
                  </span>
               </div>
               <div class="portfolio-info">
                  Total Visits
                  <span>
                     <?php
                     $today = date('Y-m-d');
                     $distinctQuery2 = "SELECT count(visit_id) as total_visits from  msp_visits WHERE msp_id = '$msp' AND  visit_date ='$today'";
                     $resultId2 = run_query($distinctQuery2);  
                     $arraa = get_row_data($resultId2);
                     $total_rows2 = $arraa['total_visits'];
                      echo $total_rows2;
                     ?>
                  </span>
               </div>
               <div class="portfolio-info">
                  Total Amount
                  <span>
                     <?php
                     $today = date('Y-m-d');
                     $distinctQuery2 = "SELECT count(bill_amount) as total_amount from  msp_visits WHERE msp_id = '$msp' AND  visit_date ='$today'";
                     $resultId2 = run_query($distinctQuery2);  
                     $arraa = get_row_data($resultId2);
                     $total_rows2 = $arraa['total_amount'];
                      echo $total_rows2;
                     ?>
                  </span>
               </div>
            </div>
         </div>
         <!--end row-fluid-->
         <div class="row-fluid portfolio-block">
            <div class="span5 portfolio-text">
               <img src="assets/img/profile/portfolio/logo_azteca.jpg" alt="" />
               <div class="portfolio-text-info">
                  <h4>Visit's for the Month  of : <b><?php echo date('F Y') ?></b></h4>
                  <h5></h5>
                  <p>MSP Visits for the Current Month.</p>
               </div>
            </div>
             <div class="span5" style="overflow:hidden;">
               <div class="portfolio-info">
                  unique visits
                  <span>
                      <?
                     $beginmonth = date('Y-m-01');
                     $endmonth = date("Y-m-t");
                     $distinctQuery2 = "SELECT count(DISTINCT customer_id) as total_unique_visits from  msp_visits WHERE msp_id = '".$msp."' AND (visit_date >= '".$beginmonth."' AND visit_date <= '".$endmonth."')";
                     $resultId2 = run_query($distinctQuery2);  
                     $arraa = get_row_data($resultId2);
                     $total_rows2 = $arraa['total_unique_visits'];
                      echo $total_rows2;
                     ?>
                  </span>
               </div>
               <div class="portfolio-info">
                  Total Visits
                  <span>
                     <?php
                     $beginmonth = date('Y-m-01');
                     $endmonth = date("Y-m-t");
                     $distinctQuery2 = "SELECT count(visit_id) as total_visits from  msp_visits WHERE msp_id = '".$msp."' AND (visit_date >= '".$beginmonth."' AND visit_date <= '".$endmonth."')";
                     $resultId2 = run_query($distinctQuery2);  
                     $arraa = get_row_data($resultId2);
                     $total_rows2 = $arraa['total_visits'];
                      echo $total_rows2;
                     ?>
                  </span>
               </div>
               <div class="portfolio-info">
                  Total Amount
                  <span>
                     <?php
                     $beginmonth = date('Y-m-01');
                     $endmonth = date("Y-m-t");
                     $distinctQuery2 = "SELECT count(bill_amount) as total_amount from  msp_visits WHERE msp_id = '".$msp."' AND (visit_date >= '".$beginmonth."' AND visit_date <= '".$endmonth."')";
                     $resultId2 = run_query($distinctQuery2);  
                     $arraa = get_row_data($resultId2);
                     $total_rows2 = $arraa['total_amount'];
                      echo $total_rows2;
                     ?>
                  </span>
               </div>
            </div>
         </div>
         <!--end row-fluid-->
         <div class="row-fluid portfolio-block">
            <div class="span5 portfolio-text">
               <img src="assets/img/profile/portfolio/logo_conquer.jpg" alt="" />
               <div class="portfolio-text-info">
                  <h4>Totals</h4>
                  <p>Total MSP Visits.</p>
               </div>
            </div>
             <div class="span5" style="overflow:hidden;">
               <div class="portfolio-info">
                  unique visits
                  <span>
                      <?php
                     $distinctQuery2 = "SELECT count(DISTINCT customer_id) as total_unique_visits from  msp_visits WHERE msp_id = '".$msp."'";
                     $resultId2 = run_query($distinctQuery2);  
                     $arraa = get_row_data($resultId2);
                     $total_rows2 = $arraa['total_unique_visits'];
                      echo $total_rows2;
                     ?>
                  </span>
               </div>
               <div class="portfolio-info">
                  Total Visits
                  <span>
                     <?php
                     $distinctQuery2 = "SELECT count(visit_id) as total_visits from  msp_visits WHERE msp_id = '".$msp."'";
                     $resultId2 = run_query($distinctQuery2);  
                     $arraa = get_row_data($resultId2);
                     $total_rows2 = $arraa['total_visits'];
                      echo $total_rows2;
                     ?>
                  </span>
               </div>
               <div class="portfolio-info">
                  Total Amount
                  <span>
                     <?php
                     $distinctQuery2 = "SELECT count(bill_amount) as total_amount from  msp_visits WHERE msp_id = '".$msp."'";
                     $resultId2 = run_query($distinctQuery2);  
                     $arraa = get_row_data($resultId2);
                     $total_rows2 = $arraa['total_amount'];
                      echo $total_rows2;
                     ?>
                  </span>
               </div>
            </div>
         </div>
         <!--end row-fluid-->
      </div>