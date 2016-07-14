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

<<<<<<< HEAD
	case add_voucher:
		logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
		$Support->addVoucher();
		$_SESSION['support_error'] = $Support->getWarnings();
		break;

	case edit_voucher:
		logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
		$Support->editVoucher();
		$_SESSION['support_error'] = $Support->getWarnings();
		break;

	case delete_voucher:
		logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
		$Support->deleteVoucher();
		break;
=======
	case edit_quotation:
		logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
		$Quotes->editQuote();
	break;
	case delete_quotation:
		logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
		$Quotes->deleteQuote($_POST['delete_id']);
	break;

>>>>>>> 35229d69a91d2b9c82fe716c0f2bb28226e3b12a
}


?>