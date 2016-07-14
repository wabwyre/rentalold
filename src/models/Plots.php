<?php
require_once 'src/models/Masterfile.php';
/**
 * Created by PhpStorm.
 * User: erick.murimi
 * Date: 7/14/2016
 * Time: 11:45 AM
 */
class Plots extends Masterfile{
    public function getAllPlots(){
        $data = $this->selectQuery('plots', '*');
        return $data;
    }
}