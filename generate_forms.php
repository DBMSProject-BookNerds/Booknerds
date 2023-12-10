<?php
    if (isset($_POST['customer'])) {create_data_form('customer');}
    elseif (isset($_POST['bookstore'])) {create_data_form('bookstore');}
    elseif (isset($_POST['book'])) {create_data_form('book');}
    elseif (isset($_POST['author'])) {create_data_form('author');}
    elseif (isset($_POST['genre'])) {create_data_form('genre');}
    else {create_data_form('orders');}

    function create_data_form($value){
        //TODO: Pass $value to the button, so that we know which table we are manipulating with the form.
        //This needs to be done because we are passing the data along.

        //get a connection
        $conn = @mysqli_connect("localhost", "root", "default","");
        mysqli_select_db($conn, 'BookNerds');

        $get_columns = ("show columns in " . $value . ";");
        $result= mysqli_query($conn, $get_columns);

        //form for inserting data
        echo '<h3> Insert Data </h3>';
        echo '<form action="manip_data.php" method="post">';
        while($row = mysqli_fetch_array($result)){
            echo '<div> ' . $row['Field'] . ': <input type="text" name="' . $row['Field'].'"/></div>'; 
        }
        echo '<input type="submit" name="insert,' . $value .'"/>';
        // insert,table_name
        echo '</form>';

        //form for deleting data
        $result = mysqli_query($conn, $get_columns);
        echo '<h3> Delete Data </h3>';
        echo '<form action="manip_data.php" method="post">';
        while($row = mysqli_fetch_array($result)){
            echo '<div> ' . $row['Field'] . ': <input type="text" name="' . $row['Field'].'"/></div>'; 
        }
        echo '<input type="submit" name="delete,' . $value . '"/>';
        echo '</form>';

        //form for modifying data
        $result = mysqli_query($conn, $get_columns);
        echo '<h3> Modify Data </h3>';
        echo '<h4> Change </h4>';
        echo '<form action="manip_data.php" method="post">';
        //skip the first row, so the user can't modify the id
        $row = mysqli_fetch_array($result);
        while($row = mysqli_fetch_array($result)){
            echo '<div> ' . $row['Field'] . ': <input type="text" name="' . $row['Field'].'"/></div>'; 
        }
        echo '<h4> Where </h4>';
        $result = mysqli_query($conn, $get_columns);
        while($row = mysqli_fetch_array($result)){
            echo '<div> ' . $row['Field'] . ': <input type="text" name="' . $row['Field'].'where"/></div>'; 
        }
        echo '<input type="submit" name="modify,' . $value . '"/>';
        echo '</form>';
    }
?>