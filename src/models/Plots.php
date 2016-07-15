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
            'lr_no' => array(
                'name' => 'Land Reg. No',
                'required' => true,
                'unique' => 'plots'
            ),
            'payment_code' => array(
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
                    'landlord_mfid' => $post['landlord'],
                    'lr_no' => $post['lr_no']
                )
            );
            if($result){
                $this->flashMessage('plots', 'success', 'A new Plot has been added!');
            }else{
                $this->flashMessage('plots', 'error', 'Encountered an error!');
            }
        }
    }

    public function editPlot($post){
//        var_dump($post);exit;
        $this->validate($post, array(
            'ed_plot_name' => array(
                'name' => 'Name',
                'required' => true,
                'unique2' => array(
                    'table' => 'plots',
                    'skip_column' => 'plot_id',
                    'skip_value' => $post['edit_id'],
                )
            ),
            'payment_code' => array(
                'name' => 'Payment Code',
                'unique2' => array(
                    'table' => 'plots',
                    'skip_column' => 'plot_id',
                    'skip_value' => $post['edit_id']
                )
            ),
            'lr_no' => array(
                'name' => 'Land Reg. No',
                'required' => true,
                'unique2' => array(
                    'table' => 'plots',
                    'skip_column' => 'plot_id',
                    'skip_value' => $post['edit_id']
                )
            ),
            'ed_units' => array(
                'name' => 'Units',
                'required' => true
            ),
        ));

        if($this->getValidationStatus()) {
            $result = $this->updateQuery2('plots',
                array(
                    'plot_name' => $post['ed_plot_name'],
                    'payment_code' => $post['payment_code'],
                    'pm_mfid' => $post['ed_property_manager'],
                    'paybill_number' => $post['ed_paybill_number'],
                    'units' => $post['ed_units'],
                    'landlord_mfid' => $post['ed_landlord']
                ),
                array(
                    'plot_id' => $post['edit_id']
                )
            );
            
            if($result){
                $this->flashMessage('plots', 'success', 'A new Plot has been added!');
            }else{
                $this->flashMessage('plots', 'error', 'Encountered an error!');
            }
        }
    }

    public function deletePlot($id){
        if($this->deleteQuery2('plots', array(
            'plot_id' => $id
        ))){
            $this->flashMessage('plots', 'success', 'Plot has been deleted');
        }else{
            $this->flashMessage('plots', 'warning', 'The Plot is being used somewhere else in the system!');
        }
    }

    public function getPlotByPlotId($id){
        $data = $this->selectQuery('plots', '*', "plot_id = '".sanitizeVariable($id)."' ");
        echo json_encode($data[0]);
    }
}