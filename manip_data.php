<?php
    $conn = @mysqli_connect("localhost", "test", "test","");
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
        $query = 'update ' . $table_name . ' set ';

        //need to get the number of columns, for the change part of the form.
        $num_cols_query = 'SELECT count(*) AS anyName FROM information_schema.columns
        WHERE table_name = "' . $table_name . '";';
        $num_cols = mysqli_query($conn, $num_cols_query);
        $num_cols= mysqli_fetch_array($num_cols)['anyName'];
        //echo $num_cols;

        //get values of form
        $all_keys= array();
        $all_values = array();
        foreach($_POST as $key => $value){
            if($key!='modify,' . $table_name){
                array_push($all_keys, $key);
                array_push($all_values, $value);
            }
        }

        $non_null_change_keys = array();
        $non_null_change_values = array(); 
        $non_null_change_types = array();
        
        //loop for establishing change fields
        for($x = 0; $x < (count($all_keys) - $num_cols); $x++){
            $column_type_query = 'SELECT DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS 
            WHERE table_name = "'. $table_name . '" AND COLUMN_NAME = "'. $all_keys[$x] .'";';
            $column_type = mysqli_query($conn, $column_type_query);
            $column_type = mysqli_fetch_array($column_type)['DATA_TYPE'];

            if($all_values[$x] != null){
                array_push($non_null_change_keys, $all_keys[$x]);
                array_push($non_null_change_values, $all_values[$x]);
                array_push($non_null_change_types, $column_type);      
            }
        }

        //loop for change section
        for($x = 0; $x < count($non_null_change_keys); $x++){
            if($non_null_change_values[$x] != null){
                
                $query = $query . $non_null_change_keys[$x] . '=';
                if($non_null_change_types[$x] == 'varchar'){
                    $query = $query . '"' . $non_null_change_values[$x] . '"';
                }
                else{
                    $query = $query . $non_null_change_values[$x];
                }
    
                if($x != count($non_null_change_keys) - 1){
                    $query = $query . ', ';
                }
            }

        }
        $query = $query . 'where(';

        $non_null_where_keys = array();
        $non_null_where_values = array(); 
        $non_null_where_types = array();    

        //loop for establishing where fields
        for($x = (count($all_keys) - $num_cols); $x < count($all_keys); $x++){
            $all_keys[$x] = preg_replace("/where/", "", $all_keys[$x]);
            $column_type_query = 'SELECT DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS 
            WHERE table_name = "'. $table_name . '" AND COLUMN_NAME = "'. $all_keys[$x] .'";';
            $column_type = mysqli_query($conn, $column_type_query);
            $column_type = mysqli_fetch_array($column_type)['DATA_TYPE'];

            if($all_values[$x] != null){
                array_push($non_null_where_keys, $all_keys[$x]);
                array_push($non_null_where_values, $all_values[$x]);
                array_push($non_null_where_types, $column_type);      
            }
        }

        //loop for concatenating where clauses
        for($x = 0; $x < count($non_null_where_keys); $x++){
            $query = $query . $non_null_where_keys[$x] . '=';
            if($non_null_where_types[$x] == 'varchar'){
                $query = $query . '"' . $non_null_where_values[$x] . '"';
            }
            else{
                $query = $query . $non_null_where_values[$x];
            }

            if($x != (count($non_null_where_keys) - 1)){
                $query = $query . ' and ';
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
?>