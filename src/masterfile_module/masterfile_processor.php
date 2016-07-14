<?php
	include_once('src/models/Masterfile.php');
	$mf = new Masterfile();

	switch ($_POST['action']) {

		case add_masterfile:
			logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
            $mf->addMf();
			$_SESSION['mf_warnings'] = $mf->getWarnings();
		break;

		case edit_masterfile:
			logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
			$mf->editMf($_POST);
			$_SESSION['mf_warnings'] = $mf->getWarnings();
			break;

		case Del265:
			logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
			extract($_POST);

			$query1 = "UPDATE masterfile SET active = '0' WHERE mf_id = '".$mf_id."'";
			if(run_query($query1)){
				if(!checkForExistingEntry('user_login2', 'mf_id', $mf_id)){
					$mf->blockUser($mf_id);
				}
			}else{
				$_SESSION['done-deal'] = '<div class="alert alert-warning">
                <button class="close" data-dismiss="alert">×</button>
                <strong>Warning!</strong> Encoutered an error when deleting the masterfile. '.get_last_error().'
            </div>';
				// var_dump(pg_last_error());exit;
			}
			break;
		
		case delete_masterfile:
			logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
			$mf->deleteMasterfile();
			break;
	}
?>