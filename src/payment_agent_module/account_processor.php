<?php
/**
 * Created by PhpStorm.
 * User: JOEL
 * Date: 7/14/2016
 * Time: 6:37 PM
 */

include_once ('src/models/Accounts.php');
$acc = new Account();

switch($_POST['action']) {
    case add_account:
        logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
        $acc->addBankAccount();
        break;

    case edit_account:
        logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
        $acc->editBankAccount();
        break;

    case Del575:
        logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
        $acc->deleteBankAccount();
        break;
}