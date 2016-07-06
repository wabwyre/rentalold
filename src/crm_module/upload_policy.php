
<div class="widget">
  <div class="widget-title">
    <h4><i class="icon-file"></i> Add Insurance Policy From a CSV file</h4>
    <div class="actions">
      <a href="http://oriems.com/gtel-mobile/assets/csv/insurance_policy.csv" class="btn btn-small btn-info">Download Template <i class="icon-download"></i></a>
    </div>
  </div>
  <div class="widget-body form">
    <form action="" method="post" class="form-horizontal" enctype="multipart/form-data">
      <div class="row-fluid">  
        <div class="control-group">
          <label class="control-label">Upload a CSV file: </label>
          <div class="controls">
            <div class="fileupload fileupload-new" data-provides="fileupload">
              <div class="input-append">
                <div class="uneditable-input">
                   <i class="icon-file fileupload-exists"></i> 
                   <span class="fileupload-preview"></span>
                </div>
                <span class="btn btn-file">
                <span class="fileupload-new">Select file</span>
                <span class="fileupload-exists">Change</span>
                <input type="file" class="default" name="upload_insurance" accept=".csv" />
                </span>
                <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- hidden fields -->
      <input type="hidden" name="action" value="upload_insurance"/>

      <div class="form-actions">
        <?php viewActions($_GET['num'], $_SESSION['role_id']); ?>
      </div>
    </form>
  </div>
</div>

<div class="widget">
  <div class="widget-title">
    <h4><i class="icon-reorder"></i> Upload History</h4>
  </div>
  <div class="widget-body form">  
    <?php
      if (isset($_SESSION['upload_csv'])) {
        echo $_SESSION['upload_csv'];
        unset($_SESSION['upload_csv']);
      }
    ?>  
    <table class="table table-bordered live_table">
      <thead>
      <tr>
        <th>Upload#</th>
        <th>Upload Date</th>
        <th>Total Count</th>
        <th>Report</th>
        <th>Uploader</th>
        </tr>
      </thead>
      <tbody>
        <?
          $distinctQuery = "SELECT lrp.*, CONCAT(m.surname,' ',m.firstname,' ',m.middlename) AS full_name FROM insurance_uploads lrp 
          LEFT JOIN masterfile m ON m.mf_id = lrp.uploader_mf_id";
          $resultId = run_query($distinctQuery);
          while($row = get_row_data($resultId)){
        ?>
        <tr>
         <td><?=$row['insurance_upload_id']; ?></td>
         <td><?=$row['upload_date']; ?></td>
         <td><?=$row['record_count']; ?></td>
         <td><?=$row['error_report']; ?></td>
         <td><?=$row['full_name']; ?></td>                                
        </tr>
        <? } ?>
      </tbody>
    </table>
    <div class="clearfix"></div>
  </div>
</div>