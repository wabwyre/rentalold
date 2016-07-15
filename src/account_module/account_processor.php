<?php
/**
 * Created by PhpStorm.
 * User: JOEL
 * Date: 7/15/2016
 * Time: 11:20 AM
 */
include_once ('src/models/Accounts.php');
$acc = new Accounts();

switch($_POST['action']) {
    case add_bank:
        var_dump($acc);
        logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
        $acc->addBank();
        break;

    case edit_bank:
        logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
        $acc->editBank();
        break;

    case Del575:
        logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
        $acc->deleteBank();
        break;
}