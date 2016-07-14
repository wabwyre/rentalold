<?php
include_once('src/models/SupportTickets.php');
include_once('src/models/Quotes.php');
$Support = new SupportTickets;
$Quotes = new Quotes();

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

	case add_category:
		logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
		$Support->addCategory();
		$_SESSION['support_error'] = $Support->getWarnings();
		break;

	case edit_category:
		logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
		$Support->editCategory();
		$_SESSION['support_error'] = $Support->getWarnings();
		break;

	case delete_category:
		logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
		$Support->deleteCategory();
		break;

	case add_quotation:
		logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
		$Quotes->addQuataion();
	break;
}
?>