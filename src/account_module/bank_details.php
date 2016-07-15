<?php
/**
 * Created by PhpStorm.
 * User: SATELLITE
 * Date: 7/15/2016
 * Time: 12:57 PM
 */

include '../connection/config.php';

$query = "SELECT * FROM banks WHERE bank_id = '".$_POST['edit_id']."'";
$result = pg_query($query);
$rows = pg_fetch_assoc($result);
echo json_encode($rows);
?>