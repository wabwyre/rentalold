<?php
	include_once('src/models/Import.php');	
	$import = new Import();

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
	}
?>