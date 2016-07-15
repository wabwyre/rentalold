<?php
require_once 'src/models/Quotes.php';
/**
 * Created by PhpStorm.
 * User: erick.murimi
 * Date: 7/15/2016
 * Time: 1:25 PM
 */
class ReceivedQuotes extends Quotes{
    public function getAllQuotesInJson($condition = null){
        $condition = (!is_null($condition)) ? $condition : '';

        $data = $this->selectQuery('contractors_quotes', '*', $condition);
        if(count($data)){
            foreach ($data as $row){
                $quote_id = $row['qoute_id'];
                $voucher_id = $row['maintainance_id'];

                $approve_btn = '';
                if(!$this->checkIfVoucherHasBeenWon($voucher_id)) {
                    $approve_btn = '<button class="btn btn-mini btn-success award-btn" quote-id="' . $quote_id . '"><i class="icon-paper-clip"></i> Award</button>';
                }
                $rows[] = array(
                    $row['qoute_id'],
                    $row['maintenance_name'],
                    $row['full_name'],
                    $row['bid_amount'],
                    $row['bid_date'],
                    ($row['bid_status'] == 't') ? '<span class="label label-success">Approved</span>': '<span class="label label-default">Pending</span>',
                    ($row['job_status'] == 't') ? '<span class="label label-success">Complete</span>' : '<span class="label label-default">Incomplete</span>',
                    $approve_btn
                );
                $return['data'] = $rows;
            }
        }else{
            $return['data'] = array();
        }
        echo json_encode($return);
    }

    public function getApprovedVouchers(){
        $data = $this->selectQuery('maintenance_vouchers', '*', "approved_status IS TRUE");
        return $data;
    }

    public function awardQuote($quote_id){
        $result = $this->updateQuery2('quotes',
            array(
                'bid_status' => '1'
            ),
            array(
                'qoute_id' => $quote_id
            )
        );
        if($result){
            $return = array(
                'success' => true
            );
        }else{
            $return = array(
                'success' => false
            );
        }
        echo json_encode($return);
    }

    public function checkIfVoucherHasBeenWon($voucher_id){
        $data = $this->selectQuery('quotes', '*', "maintainance_id   = '".sanitizeVariable($voucher_id)."' AND bid_status IS TRUE");
        if(count($data)){
            return true;
        }else{
            return false;
        }
    }
}