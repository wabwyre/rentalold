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

    public function addPlot($post){
        $this->validate($post, array(
            'plot_name' => array(
                'name' => 'Name',
                'required' => true,
                'unique' => 'plots'
            ),
            'units' => array(
                'name' => 'Units',
                'required' => true
            ),
        ));

        if($this->getValidationStatus()) {
            $result = $this->insertQuery('plots',
                array(
                    'plot_name' => $post['plot_name'],
                    'payment_code' => $post['payment_code'],
                    'pm_mfid' => $post['property_manager'],
                    'date_created' => date('Y-m-d'),
                    'paybill_number' => $post['paybill_number'],
                    'units' => $post['units'],
                    'landlord_mfid' => $post['landlord']
                )
            );
            if($result){
                $this->flashMessage('plots', 'success', 'A new Plot has been added!');
            }else{
                $this->flashMessage('plots', 'error', 'Encountered an error!');
            }
        }
    }
}