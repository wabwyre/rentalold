<?php

/**
 * Created by PhpStorm.
 * User: JOEL
 * Date: 7/14/2016
 * Time: 3:01 PM
 */
class Accounts extends Library{
    public function getAllAccDetails($condition = null){
        $condition = (!is_null($condition)) ? $condition : '';
        $data = $this->selectQuery('account_details', '*', $condition);
        return array(
            'all' => $data,
            'specific' => $data[0]
        );
    }
}