<?php
include_once 'src/models/Plots.php';
$prop = new Plots();
switch($_POST['action'])
{
    case add_property:
        logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
        $prop->addPlot($_POST);
        $_SESSION['warnings'] = $prop->getWarnings();
        break;

    case edit_property:
        logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
        $prop->editPlot($_POST);
        $_SESSION['warnings'] = $prop->getWarnings();
        break;

    case edit_property:
        logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
        $prop->deletePlot($_POST);
        break;
}
?>
