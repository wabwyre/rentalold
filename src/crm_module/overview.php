<!--begin form-->
<form action="" enctype="multipart/form-data" class="form-horizontal">
	<div class="row-fluid">
	    <div class="span2">
	        <div class="control-group">
				<img src="assets/crm_images/PP_<?=$ccn_customer_id; ?>.jpg" alt="" />
			</div>
		</div>
		<div class="span10">
      <div class="row-fluid">
          <div class="control-group">
              <h1><?=$surname; ?> <?=$firstname; ?></h1>
              <h4>Policy# <?=$customer; ?> MCARE# <?=$mcare_id; ?> DUNAMIS# <?=$dunamiss_id; ?></h4>
          </div>
      </div>
      <div class="tabbable tabbable-custom tabbable-custom-profile">
        <ul class="nav nav-tabs">
           <li class="active"><a href="#tab_1_11" data-toggle="tab"><i class="icon-briefcase"></i> OVERVIEW</a></li>
           <li class=""><a href="#tab_1_22" data-toggle="tab"><i class="icon-picture"></i>CHANGE AVATAR</a></li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="tab_1_11">
            <?php include "contacts_info.php"; ?>
          </div>
          <div class="tab-pane" id="tab_1_22">
            <form action="#">
                <div class="controls">
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                        <div class="fileupload-new thumbnail" style="width: 100px; height: 100px;">
                          <img src="assets/img/profile/photo.jpg" />
                        </div>
                        <div class="fileupload-preview fileupload-exists thumbnail" 
                            style="max-width: 100px; max-height: 100px; line-height: 20px;"></div>
                            <div>
                                <span class="btn btn-file">
                                  <span class="fileupload-new">Select image</span>
                                  <span class="fileupload-exists">Change</span>
                                  <input type="file" name="profile-pic" />
                                </span>
                                <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>                
                            </div>
                    </div> 
                </div>
                <div class="submit-btn">
                  <a href="#" class="btn green">Submit</a>
                  <a href="#" class="btn">Cancel</a>
                </div>
            </form>
		      </div>
	      </div>
      </div>
    </div>
  </div>  
</form>