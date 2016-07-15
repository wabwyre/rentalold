<?php
include_once('src/models/Library.php');
/**
 * Created by PhpStorm.
 * User: JOEL
 * Date: 7/8/2016
 * Time: 4:19 PM
 */
class House extends Library
{
    public function getAllHouses($condition = null){
        $condition = (!is_null($condition)) ? $condition : '';
        $rows = $this->selectQuery('houses_and_plots', '*', $condition);
        return array(
            'all' => $rows,
            'specific' => $rows[0]
        );
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

    public function attachPlotToLandlord($landlord_mf_id, $plot_id){
        $result = $this->updateQuery(
            'plots',
            "landlord_mf_id = '".sanitizeVariable($landlord_mf_id)."'",
            "plot_id = '".sanitizeVariable($plot_id)."'"
        );
        if($result)
            return true;
        else
            return false;
    }

    public function attachPlotToPmManager($pm_mf_id, $plot_id){
        $result = $this->updateQuery(
            'plots',
            "landlord_mf_id = '".sanitizeVariable($landlord_mf_id)."'",
            "plot_id = '".sanitizeVariable($plot_id)."'"
        );
        if($result)
            return true;
        else
            return false;
    }

    public function getAllPlots(){
        $rows = $this->selectQuery('plots', '*');
        return $rows;
    }
    public function getAllAttributes(){
        $rows = $this-> selectQuery('house_attributes', '*');
        return $rows;
    }
}