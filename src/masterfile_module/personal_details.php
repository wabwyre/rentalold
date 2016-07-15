<div class="row-fluid">
    <div class="span6">
        <div class="control-group">
            <label for="b_role" class="control-label">Business Role<span>*</span></label>
            <div class="controls">
              <select name="b_role" class="span12" id="b_role">
                  <option value="">--Choose Business Role--</option>
                  <option value="tenant" <?php if(isset($_POST['b_role']) && $_POST['b_role'] == 'tenant') echo 'selected'; ?>>Tenant</option>
                  <option value="land_lord" <?php if(isset($_POST['b_role']) && $_POST['b_role'] == 'land-lord') echo 'selected'; ?>>Land Lord</option>
                  <option value="contractor" <?php if(isset($_POST['b_role']) && $_POST['b_role'] == 'contractor') echo 'selected'; ?>>Contractor</option>
                  <option value="property_manager" <?php if(isset($_POST['b_role']) && $_POST['b_role'] == 'property-manager') echo 'selected'; ?>>Property Manager</option>
              </select>
            </div>
        </div>
    </div>
    <div class="span6">
        <div class="control-group">
            <label for="regdate_stamp" class="control-label">Start Date<span>*</span></label>
            <div class="controls">
                <input type="text" class="date-picker span12" name="regdate_stamp" value="<?php
                if(isset($_POST['regdate_stamp'])){
                    echo $_POST['regdate_stamp'];
                }else{
                    echo date('m/d/Y');
                }
                ?>" />
            </div>
        </div>
    </div>
</div>
<div class="row-fluid">
    <div class="span6">
        <div class="control-group">
            <label for="surname" class="control-label" id="variation">Surname</label>
            <div class="controls  input-icon">
                <input type="text" name="surname" class="span12" value="<?php $mf->get('surname'); ?>" id="surname"/>
            </div>				
        </div>
    </div>
    <div class="span6">
        <div class="control-group">
            <label class="control-label" for="id_passport" id="id_pass">ID # or Passport<span>*</span></label>
            <div class="controls">
                <input type="text" name="id_passport" value="<?php $mf->get('id_passport'); ?>" class="span12" />
            </div>
        </div>
    </div>
</div>
	
<div class="row-fluid">
    <div class="span6">
        <div class="control-group">
            <label for="firstname" class="control-label">First Name</label>
            <div class="controls">
                    <input type="text" name="firstname" class="span12" id="firstname" value="<?php echo $mf->get('firstname'); ?>" placeholder="First Name"/>
            </div>
        </div>
    </div>
    <div class="span6">
        <div class="control-group">
            <label for="gender" class="control-label">Gender</label>
            <div class="controls">
                <select name="gender" class="span12" id="gender">
                    <option value="">--Choose Gender--</option>
                    <option value="Male" <?php echo ($mf->get('gender') == 'Male') ? 'selected': ''; ?>>Male</option>
                    <option value="Female" <?php echo ($mf->get('gender') == 'Female') ? 'selected': ''; ?>>Female</option>
                </select>
            </div>
        </div>
    </div>
</div>
		
<div class="row-fluid">
    <div class="span6">
        <div class="control-group">
            <label for="middlename" class="control-label">Middle Name</label>
            <div class="controls">
                    <input type="text" name="middlename" class="span12" id="middlename" value="<?php echo $mf->get('middlename'); ?>" placeholder="Middle Name" />
            </div>
        </div>
    </div>
    <div class="span6">
        <div class="control-group">
            <label class="control-label" for="plot">Plot:</label>
            <div class="controls">
                <select name="plot" id="plot" class="span12 live_search">
                    <option value="">--Choose Plot--</option>
                    <?php
                        $plots = $mf->getAllPlots();
                        if(count($plots)){
                            foreach ($plots as $plot){
                    ?>
                        <option value="<?php echo $plot['plot_id']; ?>" <?php ($plot['plot_id'] == $mf->get('plot')) ? 'selected': ''; ?>><?php echo $plot['plot_name']; ?></option>
                    <?php }} ?>
                </select>
            </div>
        </div>
    </div>
</div>

<div class="row-fluid">
    <div class="span6">
        <div class="control-group">
            <label for="email" class="control-label">Email <span>*</span></label>
            <div class="controls">
                <input type="email" name="email" class="span12" value="<?php echo $mf->get('email'); ?>" placeholder="email" />
            </div>
        </div>        
    </div>
    <div class="span6">
        <div class="control-group">
            <label class="control-label" for="house">House:</label>
            <div class="controls">
                <select name="house" id="house" class="span12 live_search">
                    <option value="">--Choose House--</option>
                    <?php
                        $houses = $mf->getAllHouses();
                        $houses = $houses['all'];
                        if(count($houses)){
                            foreach ($houses as $house){
                    ?>
                    <option value="<?php echo $house['house_id']; ?>" <?php echo ($mf->get('house') == $house['house_id']) ? 'selected' : ''; ?>><?php echo $house['house_number'].' ('.$house['plot_name'].')'; ?></option>
                    <?php }} ?>
                </select>
            </div>
        </div>
    </div>
</div>

<div class="row-fluid">
    <div class="span6">
	<label for="user_role" class="control-label">User Role</label>
        <div class="controls">
            <select name="user_role" class="span12 live_search" id="user_role">
                <option value="">--choose role--</option>
                <?php
                $us_roles = $mf->getAllUserRoles();
                if(count($us_roles)){
                    foreach ($us_roles as $us_role){
                        ?>
                        <option value="<?php echo $us_role['role_id']; ?>" <?php echo ($mf->get('user_role') == $us_role['role_id']) ? 'selected': ''; ?>><?php echo $us_role['role_name']; ?></option>
                    <?php }} ?>
            </select>
        </div>      
    </div>
    <div class="span6">
        <div class="control-group">
            <label for="occupation" class="control-label">Occupation</label>
            <div class="controls">
                <input type="text" name="occupation" id="occupation" class="span12" value="<?php echo $mf->get('occupation'); ?>" placeholder="Occupation" />
            </div>
        </div>
    </div>
</div>

<div class="row-fluid">
    <div class="span6">
        <div class="control-group">
            <label for="customer_type_id" class="control-label">Masterfile Type</label>
            <div class="controls">
                <select name="customer_type_id" class="span12 live_search" id="customer_type_id">
                    <option value="">--choose masterfile type--</option>
                    <?php
                    $mf_types = $mf->getAllMasterfileType();
                    if(count($mf_types)){
                        foreach ($mf_types as $mf_type){
                            ?>
                            <option value="<?php echo $mf_type['customer_type_id']; ?>" <?php echo ($mf->get('customer_type_id') == $mf_type['customer_type_id']) ? 'selected': ''; ?>><?php echo $mf_type['customer_type_name']; ?></option>
                        <?php }} ?>
                </select>
            </div>
        </div>
    </div>
    <div class="span6">
        <div class="control-group">
            <label for="pin" class="control-label">Pin No.</label>
            <div class="controls">
                <input type="text" name="pin" class="span12" value="<?php echo $mf->get('pin'); ?>" placeholder="Pin Number" />
            </div>
        </div>
    </div>
</div>

<div class="row-fluid">
    <div class="span6">
        <label class="control-label">Profile Pic</label>
        <div class="controls">
            <div class="fileupload fileupload-new" data-provides="fileupload">
                <div class="fileupload-new thumbnail" style="width: 100px; height: 100px;"><img src="assets/img/profile/photo.jpg" /></div>
                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 100px; max-height: 100px; line-height: 20px;"></div>
                <div>
                    <span class="btn btn-file"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span><input class="span12" type="file" name="profile-pic"/></span>
                    <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                </div>
            </div> 
        </div>
    </div>
    <div class="span6">
        <div class="control-group">
            <label for="lr_no" class="control-label">L.R No. / Name Property.</label>
            <div class="controls">
                <input type="text" name="lr_no" class="span12" id="lr_no" value="<?php echo $mf->get('lr_no'); ?>" placeholder="Land Rate Number or Property Name" />
            </div>
        </div>
    </div>
</div>

