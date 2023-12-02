<?php
    function create_database(){
        //boolean for whether or not to create data.
        $create_data = false;
        
        // establish the database
        // change permissions as needed
        $conn=mysqli_connect("localhost", "root", "default","");

        //$drop_db = "DROP DATABASE BookNerds"; /////// delete these after
        //mysqli_query($conn, $drop_db); /////     delete these after*/
        if (!$conn)
        {	
            echo " Cannot connect" . mysqli_error();
        }
        else
        {
            echo "Connection created\n";
        }

        $sql="CREATE DATABASE if not exists BookNerds";
        try 
        {
            //create the database if it does not exist
            if (mysqli_query($conn, $sql))
            {
            echo "Database created\n";
            mysqli_select_db($conn, 'BookNerds');

            // create the tables
            $table = array("CREATE TABLE Bookstore
                            (bookstoreID int NOT NULL AUTO_INCREMENT,
                            bookstoreName varchar(50),
                            city varchar(50),
                            stateName varchar(50),
                            postalCode int,
                            addressName varchar(50),
                            phone varchar(20),
                            PRIMARY KEY(bookstoreID))",

                            "CREATE TABLE Customer
                            (customerID int NOT NULL AUTO_INCREMENT,
                            firstName varchar(20),
                            lastName varchar(20),
                            email varchar(50),
                            phone varchar(20),
                            addressName varchar(50),
                            city varchar(50),
                            stateName varchar(50),
                            postalCode int,
                            PRIMARY KEY (customerID))",
                            
                            "CREATE TABLE Orders
                            (orderID int NOT NULL AUTO_INCREMENT,
                            customerID int,
                            FOREIGN KEY (customerID) REFERENCES Customer(customerID),
                            orderDate date,
                            totalPrice decimal(10, 2),
                            PRIMARY KEY(orderID))",

                            "CREATE TABLE Author
                            (authorID int NOT NULL AUTO_INCREMENT,
                            firstName varchar(50),
                            lastName varchar(50),
                            descr varchar(50),
                            PRIMARY KEY (authorID))",

                            "CREATE TABLE Genre
                            (genreID int NOT NULL AUTO_INCREMENT,
                            genreName varchar(20),
                            PRIMARY KEY (genreID))",

                            "CREATE TABLE Book
                            (bookID int NOT NULL AUTO_INCREMENT,
                            title varchar(250),
                            descr varchar(250),
                            price decimal(10, 2),
                            authorID int,
                            FOREIGN KEY (authorID) REFERENCES Author(authorID),
                            bookstoreID int,
                            FOREIGN KEY (bookstoreID) REFERENCES Bookstore(bookstoreID),
                            publicationDate date,
                            genreID int,
                            FOREIGN KEY (genreID) REFERENCES Genre(genreID),
                            isbn varchar(30),
                            stock int,
                            PRIMARY KEY (bookID))",

                            "CREATE TABLE OrderDetails
                            (orderDetailsID int NOT NULL AUTO_INCREMENT,
                            orderID int,
                            FOREIGN KEY (orderID) REFERENCES Orders(orderID),
                            bookstoreID int,
                            FOREIGN KEY (bookstoreID) REFERENCES Bookstore(bookstoreID),
                            quantity int,
                            orderType varchar(30),
                            bookID int,
                            FOREIGN KEY (bookID) REFERENCES Book(bookID),
                            PRIMARY KEY (orderDetailsID))"
                            );
            
                foreach ($table as &$value){
                    try{
                        if (mysqli_query($conn, $value))
                            {
                            echo "Table created\n";
                            $create_data = true;
                            }
                    }
                    //catch the exception of creating a table
                    catch (exception $e){
                        echo $e->getmessage();
                    }
                }
            }
        }
        //catch the exception of creating the database
        catch (exception $e)
        {
            echo $e->getmessage();
        }

        //create test data as needed.
        if($create_data)
            insert_dummy_data($conn);
        
    }

    function insert_dummy_data($conn){
        //echo "insert_dummy_data called";
        //$sql_insert_customer = "insert into Customer";

    }
?>
