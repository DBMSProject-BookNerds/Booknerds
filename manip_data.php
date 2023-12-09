<?php
    $conn = @mysqli_connect("localhost", "root", "default","");
    mysqli_select_db($conn, 'BookNerds');

    foreach ($_POST as $key => $value) {
        $output = preg_split("/[\s,]+/", $key);
        //$output[0] is query type, $output[1] is table
        /*
        if(count($output) > 1){
            echo $output[0] . ' ';
            echo $output[1];
        }
        */

    }

    if ($output[0] == 'insert') {insert_data($output[count($output)-1], $conn);}
        elseif ($output[0] == 'delete') {delete_data($output[count($output)-1], $conn);}
        else {modify_data($output[count($output)-1], $conn);}

    function insert_data($table_name, $conn){
        echo 'Inserting data on table ' . $table_name .'.';
        $query = 'insert into ' . $table_name . ' (';
        $non_null_key= array();
        $non_null_values = array();
        foreach($_POST as $key => $value){
            if($value != null && ($key!='insert,' . $table_name)){
                array_push($non_null_key, $key);
                array_push($non_null_values, $value);
            }
        }
        for($x = 0; $x < count($non_null_key); $x++){
            $query = $query . $non_null_key[$x];
            if($x != count($non_null_key) - 1){
                $query = $query . ', ';
            }
            
        }
        $query = $query . ') VALUES (';
        for($x = 0; $x < count($non_null_values); $x++){
            //need to account for ->' in sql syntax
            //first, query DB to check what datatype the column is
            //if column is either date or varchar, add ->' to either side
            $column_type_query = 'SELECT DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS 
            WHERE table_name = "'. $table_name . '" AND COLUMN_NAME = "'. $non_null_key[$x] .'";';
            $column_type = mysqli_query($conn, $column_type_query);
            $column_type = mysqli_fetch_array($column_type)['DATA_TYPE'];

            if($column_type == 'varchar'){
                $query = $query  . '"' . $non_null_values[$x] . '"';
            }          

            if($x != count($non_null_values) - 1){
                $query = $query . ', ';
            }
            
        }
        $query = $query . ');';
        try{
            mysqli_query($conn, $query);
        }
        catch (exception $e){
            echo $e->getmessage();
        }

    }

    function delete_data($table_name, $conn){
        //allow deletion of foreign key rows.
        $set_fk = 'set foreign_key_checks = 0;';
        try{
            mysqli_query($conn, $set_fk);
        }
        catch (exception $e){
            echo $e->getmessage();
        }

        echo 'Deleting data from table ' . $table_name .'.';
        $query = 'delete from ' . $table_name . ' WHERE(';
        $non_null_key= array();
        $non_null_values = array();
        foreach($_POST as $key => $value){
            if($value != null && ($key!='delete,' . $table_name)){
                array_push($non_null_key, $key);
                array_push($non_null_values, $value);
            }
        }
        for($x = 0; $x < count($non_null_values); $x++){
            //need to account for ->' in sql syntax
            //first, query DB to check what datatype the column is
            //if column is either date or varchar, add ->' to either side
            $column_type_query = 'SELECT DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS 
            WHERE table_name = "'. $table_name . '" AND COLUMN_NAME = "'. $non_null_key[$x] .'";';
            $column_type = mysqli_query($conn, $column_type_query);
            $column_type = mysqli_fetch_array($column_type)['DATA_TYPE'];

            $query = $query . $non_null_key[$x] . '=';
            if($column_type == 'varchar' || $column_type == 'date'){
                $query = $query  . '"' . $non_null_values[$x] . '"';
            }
            
            if($x != count($non_null_values) - 1){
                $query = $query . 'and ';
            }
            
        }
        $query = $query . ');';
        echo $query;
        
        //delete the data with the $query
        try{
            mysqli_query($conn, $query);
        }
        catch (exception $e){
            echo $e->getmessage();
        }

        //reset foreign key constraint
        $set_fk = 'set foreign_key_checks = 1;';
        try{
            mysqli_query($conn, $set_fk);
        }
        catch (exception $e){
            echo $e->getmessage();
        }
        
    }

    function modify_data($table_name, $conn){
        echo 'Modifying data of table ' . $table_name .'.';
        $query = '';
    }
?>