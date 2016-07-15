<?php
require_once 'src/models/Quotes.php';
/**
 * Created by PhpStorm.
 * User: erick.murimi
 * Date: 7/15/2016
 * Time: 1:25 PM
 */
class ReceivedQuotes extends Quotes{
    public function getAllQuotesInJson(){
        $data = $this->selectQuery('quotes', '*');
        echo json_encode($data);
    }
}