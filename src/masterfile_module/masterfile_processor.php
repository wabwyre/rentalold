<?php
	include_once('src/models/Import.php');	
	$import = new Import();
        
        include_once('src/models/Masterfile.php');	
	$masterfile = new Masterfile();        
        
        include_once('src/models/Staff.php');
        $staff = new Staff();

	switch ($_POST['action']) {
		case import_masterfile:
			logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
			$import->importData();
			$_SESSION['errors'] = $import->getErrors();
		break;

		case import_client_groups:
			logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
			$import->importClientGroups();
			$_SESSION['errors'] = $import->getClientGroupErrors();
		break;
                    
                case add_masterfile:
			logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
			$masterfile->addMasterfile();
			$_SESSION['errors'] = $masterfile->getErrors();
		break;
                    
                case edit_masterfile:
			logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
			$masterfile->editMasterfile();
			$_SESSION['errors'] = $masterfile->getErrors();
		break;
	}
?>