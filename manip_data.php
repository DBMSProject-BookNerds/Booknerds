<?php
    foreach ($_POST as $key => $value) {
        $output = preg_split("/[\s,]+/", $key);
        //$output[0] is query type, $output[1] is table
        if(count($output) > 1){
            echo $output[0] . ' ';
            echo $output[1];
        }

    }
    
    if ($output[0] == 'insert') {insert_data($output[count($output)-1]);}
        elseif ($output[0] == 'delete') {delete_data($output[count($output)-1]);}
        else {modify_data($output[count($output)-1]);}

    function insert_data($table_name){
        echo 'Inserting data on table ' . $table_name .'.';
    }

    function delete_data($table_name){
        echo 'Deleting data from table ' . $table_name .'.';
    }

    function modify_data($table_name){
        echo 'Modifying data of table ' . $table_name .'.';
    }
?>