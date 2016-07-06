<?php

function get_multi_rows($table, $where_column=null, $where=null) {
    $results = null;
    $sql = "";
    if (is_null($where_column)) {
        "SELECT * FROM " . $table;
    } else {
        $sql = "SELECT * FROM " . $table . " WHERE " . $where_column . " = " . "'$where'";
    }
    $eval = run_query($sql);
    if (get_num_rows($eval) > 0) {
        $results = $eval;
    }
    return $results;
}

function get_custom($sql) {
    $results = null;
    $eval = run_query($sql);
    if (get_num_rows($eval) > 0) {
        $results = $eval;
    }
    return $results;
}

?>
