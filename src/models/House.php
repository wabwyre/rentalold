<?php
include_once('src/models/Library.php');
/**
 * Created by PhpStorm.
 * User: SATELLITE
 * Date: 7/8/2016
 * Time: 4:19 PM
 */
class House extends Library
{
    public function getAllHouses(){
        $rows = $this->selectQuery('houses_and_plots', '*');
        return $rows;
    }

    public function attachHouseToTenant($tenant_mf_id, $house_id){
        $result = $this->updateQuery(
            'houses',
            "tenant_mf_id = '".sanitizeVariable($tenant_mf_id)."'",
            "house_id = '".sanitizeVariable($house_id)."'"
        );
        if($result)
            return true;
        else
            return false;
    }
}