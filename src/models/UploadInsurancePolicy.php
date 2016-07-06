<?php
require_once 'src/models/Masterfile.php';

class UploadInsurancePolicy extends Masterfile
{
    public function uploadInsurance(){
        $allowedExts = array("csv");
        $temp = explode(".", $_FILES["upload_insurance"]["name"]);
        $extension = end($temp);
        $timestamp = date('Y_m_d_H_i_s_');
        // var_dump($_POST);exit;

        // var_dump($extension);exit;
        if (in_array($extension, $allowedExts)) {
            if ($_FILES["upload_insurance"]["error"] > 0) {
                "Return Code: " . $_FILES["upload_insurance"]["error"] . "<br>";
            } else {
                $target_path = "assets/csv/" . $timestamp . "" . $_FILES["upload_insurance"]["name"];
                if (move_uploaded_file($_FILES["upload_insurance"]["tmp_name"], $target_path)) {
                    // get the contents of the csv file
                    $myFile = $target_path;
                    // var_dump($myFile);exit;
                    // echo "got file...";

                    if (file_exists($myFile)) {
                        // var_dump('file exists');exit;
                        $fh = fopen($myFile, 'r');
                        $toread = filesize($myFile);
                        $allfile = fread($fh, $toread);
                        $wordChunks = explode("\n", $allfile);
                    }

                    $count = 0;
                    $counter = '';
                    while ($wordChunks[$count]) {
                        $data = $wordChunks[$count];
                        $dataline = explode(",", $data);

                        if(is_numeric($dataline[0])){
                            $imei = $dataline[0];
                            $raw_date = explode('/', $dataline[1]);
                            $month = $raw_date[0];
                            $day = $raw_date[1];
                            $yr = $raw_date[2];
                            $start_date = date($yr.'-'.$month.'-'.$day);
                            $policy_type = $dataline[2];

                            if(!empty($imei) && !empty($start_date) && !empty($policy_type)) {
                                if ($policy_type == gold) {
                                    $bill_data = $this->getBillAmtFromServiceCode(gold);
                                } elseif ($policy_type == platinum) {
                                    $bill_data = $this->getBillAmtFromServiceCode(platinum);
                                }
                                // var_dump($dataline);exit;
                                $customer_data = $this->getCustomerDataFromImei($imei);
                                if(count($customer_data)) {
                                    //var_dump($customer_data);exit;
                                    $bill_id = $this->createCustomerBill(
                                        $bill_data['price'],
                                        date('Y-m-d'),
                                        0, 0,
                                        $bill_data['price'],
                                        $customer_data['mf_id'],
                                        $bill_data['service_channel_id'],
                                        $customer_data['customer_code']);

                                    if ($bill_id >= 1) {
                                        // create debit journal
                                        $this->createJournal(
                                            $bill_id,
                                            $bill_data['price'],
                                            'DR', 1,
                                            $customer_data['customer_code'], '',
                                            time(), $customer_data['mf_id']);
                                    } else {
                                        $counter .= $count . ', ';
                                    }

                                    // update the bill
                                    if ($this->updateBillBalance($bill_id, $bill_data['price'], 0, 1)) {
                                        // credit journal
                                        if ($this->createJournal($bill_id, $bill_data['price'],
                                            'DR', 1, $customer_data['customer_code'],
                                            'For Insurance Policy',
                                            time(), $customer_data['mf_id'])
                                        ) {
                                            // create transaction
                                            $result = $this->addPayment(
                                                $bill_data['price'],
                                                date('Y-m-d H:i:s'),
                                                $customer_data['customer_code'],
                                                $customer_data['mf_id'], $bill_id,
                                                $bill_data['service_channel_id'], '');
                                            if ($result) {
                                                $rows = get_row_data($result);
                                                $transaction_id = $rows['transaction_id'];

                                                // finally create the insurance policy for the phone
                                                if (!empty($customer_data['customer_account_id'])) {
                                                    if (is_numeric($transaction_id) && $transaction_id >= 1) {
                                                        $result = $this->createInsurancePolicy(
                                                            $bill_data['service_channel_id'],
                                                            1,
                                                            $start_date,
                                                            $customer_data['customer_account_id'],
                                                            $transaction_id,
                                                            1);
                                                        if ($result) {
                                                            $_SESSION['done-deal'] = '<div class="alert alert-success">
                                                                <button class="close" data-dismiss="alert">×</button>
                                                                <strong>Success!</strong> New GTEL Insurance Policy was Added successfully.
                                                            </div>';
                                                        }
                                                    }
                                                } else {
                                                    $counter .= $count . ', ';
                                                }
                                            } else {
                                                $counter .= $count . ', ';
                                            }
                                        } else {
                                            $counter .= $count . ', ';
                                        }
                                    } else {
                                        $counter .= $count . ', ';
                                    }
                                }else{
                                    $counter .= $count.', ';
                                }
                            }
                        }
                        $count++;
                    }
                    $counter = rtrim($counter, ', ');
                    $count = $count - 1;
                    $this->addInsuranceUploadHistory($count, $counter);
                }
            }
        }
    }

    public function getCustomerDataFromImei($imei){
        $query = "SELECT customer_code, mf_id, customer_account_id FROM customer_account ca
        LEFT JOIN gtel_device gd ON gd.device_id = ca.device_id
        WHERE gd.imei = '".$imei."'";
        if($result = run_query($query)){
            if(get_num_rows($result)){
                return get_row_data($result);
            }
        }
    }

    public function addInsuranceUploadHistory($rec_count, $error_report){
        $query = "INSERT INTO insurance_uploads(
            uploader_mf_id, 
            upload_date, 
            record_count, 
            error_report)
        VALUES ('".sanitizeVariable($_SESSION['mf_id'])."', '".date('Y-m-d')."', $rec_count, '".sanitizeVariable($error_report)."');";
        if($result = run_query($query)){
            return true;
        }else{
            return false;
        }
    }
}