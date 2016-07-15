<?php
include_once('src/models/LeaseAgreement.php');

$less = new LeaseAgreement;

switch($_POST['action']){

    case add_lease_agreement:
        logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
        $less->addLeaseAgreement();
        break;
    
}

?>
