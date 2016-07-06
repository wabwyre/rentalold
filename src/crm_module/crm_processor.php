<?php
include_once('src/models/Masterfile.php');
include_once('src/models/Staff.php');
//include_once('src/models/AfyapoaMsps.php');

$masterfile = new Masterfile();
$staff = new Staff();
//$afyapoa_msp = new AfyapoaMsps();//esentially creates the client users/staff

switch($_POST['action']){

//    case add_masterfile:
//    logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
//        extract($_POST);
//        $target_path = '';
//        $allowedExts = array("gif", "jpeg", "jpg", "png");
//        $temp = explode(".", $_FILES["profile-pic"]["name"]);
//        $extension = end($temp);
//
//        if ((($_FILES["profile-pic"]["type"] == "image/gif")
//        || ($_FILES["profile-pic"]["type"] == "image/jpeg")
//        || ($_FILES["profile-pic"]["type"] == "image/jpg")
//        || ($_FILES["profile-pic"]["type"] == "image/pjpeg")
//        || ($_FILES["profile-pic"]["type"] == "image/x-png")
//        || ($_FILES["profile-pic"]["type"] == "image/png"))
//        && ($_FILES["profile-pic"]["size"] < 5000000)
//        && in_array($extension, $allowedExts)) {
//            if ($_FILES["profile-pic"]["error"] > 0) {
//              "Return Code: " . $_FILES["profile-pic"]["error"] . "<br>";
//            } else {
//                if (file_exists("profile/" . $_FILES["profile-pic"]["name"])) {
//                    $_FILES["profile-pic"]["name"] . " already exists. ";
//                } else {
//                    $target_path = "crm_images/".$_FILES["profile-pic"]["name"];
//                    move_uploaded_file($_FILES["profile-pic"]["tmp_name"], $target_path);
//                }
//            }
//        } else {
//            "Invalid file";
//        }
//
//        if(empty($surname) || empty($national_id_number) || empty($email) || empty($b_role) || empty($regdate_stamp)){
//                    
//            $_SESSION['done-deal']='<div class="alert alert-warning">
//                <button class="close" data-dismiss="alert">&times;</button>
//                <strong>Warning!</strong> Please ensure you fill in the fields marked with an asteric(*);
//            </div>';
//            $_SESSION['tab1'] = 'active';
//
//        }elseif(empty($county) || empty($town) || empty($phone_number) || empty($postal_address) ||empty($address_type_id)){
//
//            $_SESSION['done-deal']='<div class="alert alert-warning">
//                <button class="close" data-dismiss="alert">&times;</button>
//                <strong>Warning!</strong> Please ensure you fill in the fields marked with an asteric(*);
//            </div>';
//            $_SESSION['tab2'] = 'active';
//
//        }else{
//            if($b_role == 'staff'){
//                //add to masterfile
//                $mf_id = $masterfile->addToMasterfile($target_path);
//                if(!empty($mf_id)){
//                    if($masterfile->addAddress($mf_id)){
//                        $user_id = $staff->addLoginAccount($mf_id);
//                        if(!empty($user_id)){
//                            $_SESSION['done-deal']='<div class="alert alert-success">
//                                <button class="close" data-dismiss="alert">&times;</button>
//                                <strong>Success!</strong> You successfully added a new Staff.
//                            </div>';
//                            App::redirectTo('?num=803');
//                        }
//                    }else{
//                        // var_dump(get_last_error());exit;
//                    }
//                }
//            }elseif($b_role == 'client'){
//                // var_dump('Client...');exit;
//                //add to masterfile
//                $mf_id = $masterfile->addToMasterfile($target_path);
//                if(!empty($mf_id)){
//                    if($masterfile->addAddress($mf_id)){
//                        //insert customer file
//                        if ($masterfile->addCustomerFile($mf_id)) {
//                        $_SESSION['done-deal']='<div class="alert alert-success">
//                            <button class="close" data-dismiss="alert">&times;</button>
//                            <strong>Success!</strong> You successfully added a new Client.
//                        </div>';
//                        App::redirectTo('?num=803');
//                        }
//                    }else{
//                        // var_dump(get_last_error());exit;
//                    }
//                }
//            }elseif($b_role == 'client group'){
//                // var_dump('Client...');exit;
//                //add to masterfile
//                $mf_id = $masterfile->addToMasterfile($target_path);            
//                if(!empty($mf_id)){
//                    if($masterfile->addAddress($mf_id)){
//                        $_SESSION['done-deal']='<div class="alert alert-success">
//                            <button class="close" data-dismiss="alert">&times;</button>
//                            <strong>Success!</strong> You successfully added a new Client Group.
//                        </div>';
//                        App::redirectTo('?num=803');
//                    }else{
//                        // var_dump(get_last_error());exit;
//                    }
//                }
//            }
//        }
//    break;
    
//    case edit_crm:
//    logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
//        extract($_POST);
//        // var_dump($_POST);exit;
//        if(!onEditcheckForExistingEntry('masterfile', 'id_passport', $id_passport, 'mf_id', $mf_id)){
//        //image validation
//        $allowedExts = array("gif", "jpeg", "jpg", "png");
//        $temp = explode(".", $_FILES["images_path"]["name"]);
//        $extension = end($temp);
//
//        $target_path = "";
//        if($_FILES['images_path']['name'] != ''){
//            if ((($_FILES["images_path"]["type"] == "image/gif")
//           || ($_FILES["images_path"]["type"] == "image/jpeg")
//           || ($_FILES["images_path"]["type"] == "image/jpg")
//           || ($_FILES["images_path"]["type"] == "image/pjpeg")
//           || ($_FILES["images_path"]["type"] == "image/x-png")
//           || ($_FILES["images_path"]["type"] == "image/png"))
//           && ($_FILES["images_path"]["size"] < 5000000)
//           && in_array($extension, $allowedExts)) {
//           if ($_FILES["images_path"]["error"] > 0) {
//              "Return Code: " . $_FILES["images_path"]["error"] . "<br>";
//           } else {
//                "Upload: " . $_FILES["images_path"]["name"] . "<br>";
//                "Type: " . $_FILES["images_path"]["type"] . "<br>";
//                "Size: " . ($_FILES["images_path"]["size"] / 1024) . " kB<br>";
//                "Temp file: " . $_FILES["images_path"]["tmp_name"] . "<br>";
//
//                $target_path = "crm_images/".$_FILES["images_path"]["name"];
//                move_uploaded_file($_FILES["images_path"]["tmp_name"], $target_path);
//                }
//            } else {
//                $_SESSION['done-deal']='<div class="alert alert-warning">
//                    <button class="close" data-dismiss="alert">&times;</button>
//                    <strong>Warning!</strong> The image file is Invalid!
//                </div>';
//           }
//        }
//
//        if(empty($id_passport) || empty($regdate_stamp) || empty($b_role) && empty($mf_id)){          
//            $_SESSION['done-deal'] = '<div class="alert alert-warning">
//                <button class="close" data-dismiss="alert">&times;</button>
//                <strong>Warning!</strong> Some Mandatory fields(*) have not yet  been filled!
//            </div>';
//        }else{
//            $customer_type_id = (isset($customer_type_id)) ? $customer_type_id : 'NULL';
//            if(!empty($_FILES['images_path']['name'])){
//                $upate_image = "images_path = '".sanitizeVariable($target_path)."',";
//            }else{
//                $upate_image = '';
//            }
//            if(isset($company_name)){ 
//                if(!empty($company_name)){
//                    $update_company = "company_name = ".sanitizeVariable($company_name).","; 
//                }else{
//                    $update_company = "company_name = NULL,";
//                }
//            }else{
//                $update_company = "company_name = NULL,";
//            }
//            $gender = (isset($gender)) ? $gender : '';
//
//            //update the masterfile
//            $query="UPDATE masterfile SET
//            firstname='".sanitizeVariable($firstname)."',
//            middlename = '".sanitizeVariable($middlename)."', 
//            surname = '".sanitizeVariable($surname)."',
//            id_passport = '".sanitizeVariable($id_passport)."',
//            gender = '".sanitizeVariable($gender)."',
//            b_role = '".sanitizeVariable($b_role)."',
//            regdate_stamp = '".sanitizeVariable($regdate_stamp)."',
//            email = '".sanitizeVariable($email)."',
//            $upate_image
//            $update_company
//            customer_type_id = ".sanitizeVariable($customer_type_id)."
//            WHERE mf_id = ".sanitizeVariable($mf_id)."";
//
//            // var_dump($query);exit;
//            $data=run_query($query);            
//            if ($data){ 
//                // var_dump($masterfile->editBussrole($_POST['mf_id']));exit;
//                if ($masterfile->editBussrole($_POST['mf_id'])) {
//                    $_SESSION['done-deal']='<div class="alert alert-success">
//                        <button class="close" data-dismiss="alert">&times;</button>
//                        <strong>Success!</strong> CRM details have been successfully updated.
//                    </div>';
//                }
//            }
//        }
//    }else{
//        $_SESSION['done-deal'] = '<div class="alert alert-warning">
//            <button class="close" data-dismiss="alert">&times;</button>
//            <strong>Warning!</strong> The Id No. ('.$_POST["id_passport"].') already exists.
//        </div>';
//    }
//    break; 

    case Del265:r
        logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
        extract($_POST);
        // var_dump($masterfile->getAllCustomerAccCodesAndIds($mf_id));exit;

        $query1 = "UPDATE masterfile SET active = '0' WHERE mf_id = '".$mf_id."'";
        if(run_query($query1)){
            if(!checkForExistingEntry('user_login2', 'mf_id', $mf_id)){
                $masterfile->disableCustomerAccountRecords();
            }else{
                if($masterfile->blockUser($mf_id)){
                    $masterfile->disableCustomerAccountRecords();
                }
            }
        }else{       
            $_SESSION['done-deal'] = '<div class="alert alert-warning">
                <button class="close" data-dismiss="alert">×</button>
                <strong>Warning!</strong> Encoutered an error when deleting the masterfile. '.get_last_error().'
            </div>';
            // var_dump(pg_last_error());exit;
        }     
    break;

    case Del436:
        extract($_POST);

        $delete = "DELETE FROM afyapoa_agent WHERE customer_id = '".$afyapoa_customer_id."'";
        $result = run_query($delete);
        if($result){
            $_SESSION['edit_agent']='<div class="alert alert-success">
                        <button class="close" data-dismiss="alert">×</button>
                        <strong>Success!</strong> Agent details have been successfully deleted.
                    </div>';
        }
    break;

    case edit_agent:
        extract($_POST);        
        //validate the image
        $allowedExts = array("jpg");
        $temp = explode(".", $_FILES["profile-pic"]["name"]);
        $extension = end($temp);
        // $user_role = $_POST['user_role'];

        //upload the profile pic if available
        if($_FILES["profile-pic"]["name"] != ''){
            // var_dump($_FILES["profile-pic"]["error"]);exit;
            if ((($_FILES["profile-pic"]["type"] == "image/jpeg"))
            && ($_FILES["profile-pic"]["size"] < 5000000)
            && in_array($extension, $allowedExts)) {
                if ($_FILES["profile-pic"]["error"] > 0) {
                  "Return Code: " . $_FILES["profile-pic"]["error"] . "<br>";
                } else {
                  "Upload: " . $_FILES["profile-pic"]["name"] . "<br>";
                  "Type: " . $_FILES["profile-pic"]["type"] . "<br>";
                  "Size: " . ($_FILES["profile-pic"]["size"] / 1024) . " kB<br>";
                  "Temp file: " . $_FILES["profile-pic"]["tmp_name"] . "<br>";

                    $target_path = 'crm_images/'.$_FILES['profile-pic']['name'];
                    move_uploaded_file($_FILES["profile-pic"]["tmp_name"], $target_path);
                }
            } else {
             "Invalid file";
            }
        }

        if($_FILES['profile-pic']['name'] == ''){
            $query = "UPDATE afyapoa_agent SET ro_customer_id = '".$attached_ro."', 
            champ_customer_id = '".$attached_champion."', 
            super_champ_customer_id = '".$attached_superchampion."' WHERE customer_id = '".$afyapoa_customer_id."'";
            $result = run_query($query);
            if($result){
                $_SESSION['edit_agent']='<div class="alert alert-success">
                            <button class="close" data-dismiss="alert">×</button>
                            <strong>Success!</strong> Agent details have been successfully updated.
                        </div>';
            }else{
                $_SESSION['edit_agent'] = pg_last_error();
            }
        }else{
            $query1 = "UPDATE afyapoa_agent SET ro_customer_id = '".$attached_ro."', 
            champ_customer_id = '".$attached_champion."', 
            super_champ_customer_id = '".$attached_superchampion."' WHERE customer_id = '".$afyapoa_customer_id."'";
            if(run_query($query1)){
                $query2 = "UPDATE customers SET images_path = '".$target_path."' WHERE customer_id = '".$afyapoa_customer_id."'";
                if(run_query($query2)){
                    $_SESSION['edit_agent']='<div class="alert alert-success">
                        <button class="close" data-dismiss="alert">&times;</button>
                        <strong>Success!</strong> Agent details have been successfully updated.
                    </div>';
                }
            }
        }
        
    break;

    case add_dependant:
        extract($_POST);
        $mf_id = $masterfile->addDependantToMasterfile();

        $query = "INSERT INTO afyapoa_dependants(
            afyapoa_id, 
            dependant_names, 
            dependant_dob, 
            dependant_gender,
            status, 
            mcare_id,
            mf_id)
            VALUES (
                '".$afyapoa_id."', 
                '".$dependant_name."', 
                '".$dob."', 
                '".$gender."', 
                '".$status."', 
                '".$mcare_id."',
                '".$mf_id."')";
        // var_dump($query);exit;
        if(run_query($query)){
            $_SESSION['dependant']='<div class="alert alert-success">
                        <button class="close" data-dismiss="alert">×</button>
                        <strong>Success!</strong> A new dependant has been successfully added.
                    </div>';
        }
    break;

    case edit_dependant:
        extract($_POST);

        $query = "UPDATE afyapoa_dependants
        SET 
        afyapoa_id='".$afyapoa_id."', 
        dependant_names='".$dependant_name."', dependant_dob='".$dob."', 
        dependant_gender='".$gender."', status='".$status."', 
        mcare_id='".$mcare_id."'
        WHERE dependant_id = '".$dept_id."'";
        if(run_query($query)){
            $_SESSION['dependant']='<div class="alert alert-success">
                        <button class="close" data-dismiss="alert">×</button>
                        <strong>Success!</strong> Dependant details were updated successfully.
                    </div>';
        }
    break;

    case delete_dependant:
        extract($_POST);

        $delete = "DELETE FROM afyapoa_dependants WHERE dependant_id = '".$dependant_id."'";
        if(run_query($delete)){
            $_SESSION['dependant']='<div class="alert alert-success">
                        <button class="close" data-dismiss="alert">×</button>
                        <strong>Success!</strong> Dependant details were deleted successfully.
                    </div>';
        }
    break;

    case resend_sms:
        extract($_POST);
        $date_created = strtotime(date('Y-m-d H:i:s'));
        $query = "INSERT INTO ndovu_sms(target, message, date_created, status) VALUES('".$target."', '".trim($sms)."', '".$date_created."', 0)";
        if (run_query($query)) {
            $_SESSION['manage_policy']='<div class="alert alert-success">
                        <button class="close" data-dismiss="alert">×</button>
                        <strong>Success!</strong>SMS has been sent.
                    </div>';
        }else{
            $_SESSION['manage_policy']=pg_last_error();
        }
    break;

    case send_to_mcare:
        extract($_POST);

        //get policy holder details
        $query="SELECT a.*, c.*, ct.*, ad.post_office_box, ad.postal_code, ad.premises, ad.street, ad.town, ad.county, na.agent_number FROM afyapoa_file a 
          LEFT JOIN customers c ON c.customer_id = a.customer_id
          LEFT JOIN ndovu_address ad ON ad.address_id = c.customer_id
          LEFT JOIN ndovu_agents na ON na.customer_id = a.agent_customer_id
          LEFT JOIN customer_types ct ON ct.customer_type_id = c.customer_type_id
          WHERE c.customer_id = '".$customer_id."'
        ";

        $result = run_query($query);
        $customer_data = get_row_data($result);

        $customer_data['parent_id'] = 12428;
        $member_id = registerProviderToMcare($customer_data);

        if(is_numeric($member_id) && !empty($member_id)){
            //update mcare id to policy file
            $update_mcare_id = "update afyapoa_file set mcare_id = '".$member_id."' 
                                 where afyapoa_id = '".$customer_data['afyapoa_id']."'";
        

            if(run_query($update_mcare_id)){
        
                //get all dependants
                $query = "SELECT * FROM afyapoa_dependants WHERE afyapoa_id = '".$customer_data['afyapoa_id']."' Order by dependant_id DESC";
                // var_dump($query);exit;
                $result = run_query($query);
                $num_rows = get_num_rows($result);
                if($num_rows){
                    while($dependant = get_row_data($result)){

                        //prepare dependants data                    }

                        $names = explode(" ",$dependant['names']);

                        $customer_data['firstname'] = $names[0];
                        $customer_data['lastname'] = $names[1];
                        $customer_data['middlename'] = $names[2];;
                        $customer_data['dob'] = $dependant['dob'];
                        $customer_data['email'] = $dep_id."_dep@afyapoa.com";
                        
                        $customer_data['phone'] = $customer_data['phone'];
                        $customer_data['parent_id'] = $member_id;
                        $customer_data['policy_number'] = $customer_data['afyapoa_id'];    

                        //submit dependant to mcare
                        $dep_member_id = registerToMcare($customer_data);
                            //gt mcare id

                        //udpate dpendant data with mcare id
                        //query to update dependat record with member id
                        $query = "UPDATE afyapoa_dependants SET mcare_id = '".$dep_member_id."'";
                        if(run_query($query)){
                            $_SESSION['manage_policy']='<div class="alert alert-success">
                                <button class="close" data-dismiss="alert">×</button>
                                <strong>Success!</strong> Policy data has been successfully sent.
                            </div>';
                        }
                    }
                }else{
                    $_SESSION['manage_policy']='<div class="alert alert-success">
                                <button class="close" data-dismiss="alert">×</button>
                                <strong>Success!</strong> Policy holder details have been successfully sent.
                            </div>';
                }
            }else{
                $_SESSION['manage_policy'] = pg_last_error();
            }
        }
    break;

    case add_address_type:
      logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
       $masterfile->addAddressType();
    break;

    case edit_address_type:
      logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
       $staff->editAddressType();
    break;

    case Del575:
      logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
       $staff->deleteAddressType();
    break;

    case add_address:
      logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
       $masterfile->addCustomerAddress();
    break;

    case edit_address:
      logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
       $masterfile->editAddress();
    break;

    case delete_address:
      logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
       $masterfile->deleteAddress();
    break;

    case add_mps_user:
        extract($_POST);

        //image validation
        $allowedExts = array("jpg");
        $temp = explode(".", $_FILES["profile-pic"]["name"]);
        $extension = end($temp);
        // $user_role = $_POST['user_role'];

        $target_path = '';
        //upload the profile pic if available
        if($_FILES["profile-pic"]["name"] != ''){
            // var_dump($_FILES["profile-pic"]["error"]);exit;
            if ((($_FILES["profile-pic"]["type"] == "image/jpeg"))
            && ($_FILES["profile-pic"]["size"] < 5000000)
            && in_array($extension, $allowedExts)) {
                if ($_FILES["profile-pic"]["error"] > 0) {
                  "Return Code: " . $_FILES["profile-pic"]["error"] . "<br>";
                } else {
                  "Upload: " . $_FILES["profile-pic"]["name"] . "<br>";
                  "Type: " . $_FILES["profile-pic"]["type"] . "<br>";
                  "Size: " . ($_FILES["profile-pic"]["size"] / 1024) . " kB<br>";
                  "Temp file: " . $_FILES["profile-pic"]["tmp_name"] . "<br>";

                    $target_path = "crm_images/".$_FILES["profile-pic"]["name"];
                    move_uploaded_file($_FILES["profile-pic"]["tmp_name"], $target_path);
                }
            } else {
             "Invalid file";
            }
        }

        $result = $afyapoa_msp->createMspUser($target_path);

        if($result){ 
            $_SESSION['add_crm']='<div class="alert alert-success">
                <button class="close" data-dismiss="alert">×</button>
                <strong>Success!</strong> Masterfile has been successfully created.
            </div>';
        }else{
            $_SESSION['add_crm']='<div class="alert alert-warning">
                <button class="close" data-dismiss="alert">×</button>
                <strong>Warning!</strong>'.pg_last_error().'
            </div>';
        }
    break;

    case add_insurance_policy:
        logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
        $masterfile->addPolicy();
        break;

        case insurance_claim:
        logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
        $masterfile->addInsuranceClaim($_POST['mf_id']);
        break;

        case edit_insurance_claim:
        logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
        $masterfile->editInsuranceClaim();
        break;

        case delete_insurance_claim:
        logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
        $masterfile->deleteInsuranceClaim();
        break;

        case process_insurance:
        logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
        $masterfile->processInsuranceClaim();
        break;

        case delete_masterfile:
            logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
            $masterfile->deleteMasterfile();
            break;
}

?>
