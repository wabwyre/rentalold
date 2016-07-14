<?php
include_once 'src/models/Plots.php';
$prop = new Plots();
switch($_POST['action'])
{
case add_property:
    var_dump($_POST);exit;
    $prop->addPlot($_POST);
    $_SESSION['warnings'] = $prop->getWarnings();
    break;
}
?>
