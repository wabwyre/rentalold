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
	}
?>