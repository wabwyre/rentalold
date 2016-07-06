<?php
include_once('src/models/SupportTickets.php');
$Support = new SupportTickets;

switch ($_POST['action']) {
	case assign_staff:
		logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
		$Support->assignStaff();
		break;

	case add_Respond:
		logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
		$Support->respondToSupportIssue();
		break;

	case add_support:
       	logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
		$Support->addSupport();
	    break;

	case reassign_staff:
		logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
		$Support->reassignStaff();
		break;

	case add_comment:
		logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
		$Support->addComment();
	break;
}
?>