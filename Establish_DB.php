<?php
    include 'Form.php';
    
    // establish the database
    // change permissions as needed
    $conn=mysqli_connect("localhost", "root", "default","");

    $drop_db = "DROP DATABASE BookNerds"; /////// delete these after
    mysqli_query($conn, $drop_db); /////     delete these after*/
    if (!$conn)
	{	
		echo " Cannot connect" . mysqli_error();
	}
	else
	{
		echo "Connection created\n";
	}

	$sql="CREATE DATABASE BookNerds";
	try 
	{
		if (mysqli_query($conn, $sql))
		{
		echo "Database created\n";
		}
	}
	catch (exception $e)
	{
		echo $e->getmessage();
	}

    mysqli_select_db($conn, 'BookNerds');
    // create the tables
    $table = array("CREATE TABLE Bookstore
                    (bookstoreID int PRIMARY KEY,
                    bookstoreName varchar(50),
                    city varchar(50),
                    stateName varchar(50),
                    postalCode int,
                    addressName varchar(50),
                    phone varchar(20))",

                    "CREATE TABLE Customer
                    (customerID int PRIMARY KEY,
                    firstName varchar(20),
                    lastName varchar(20),
                    email varchar(50),
                    phone varchar(20),
                    addressName varchar(50),
                    city varchar(50),
                    stateName varchar(50),
                    postalCode int)",
                    
                    "CREATE TABLE Orders
                    (orderID int PRIMARY KEY,
                    customerID int,
                    FOREIGN KEY (customerID) REFERENCES Customer(customerID),
                    orderDate date,
                    totalPrice decimal(10, 2))",

                    "CREATE TABLE Author
                    (authorID int PRIMARY KEY,
                    firstName varchar(50),
                    lastName varchar(50),
                    descr varchar(50))",

                    "CREATE TABLE Genre
	                (genreID int PRIMARY KEY,
	                genreName varchar(20))",

                    "CREATE TABLE Book
                    (bookID int PRIMARY KEY,
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
                    stock int)",

                    "CREATE TABLE OrderDetails
                    (orderDetailsID int PRIMARY KEY,
                    orderID int,
                    FOREIGN KEY (orderID) REFERENCES Orders(orderID),
                    bookstoreID int,
                    FOREIGN KEY (bookstoreID) REFERENCES Bookstore(bookstoreID),
                    quantity int,
                    orderType varchar(30),
                    bookID int,
                    FOREIGN KEY (bookID) REFERENCES Book(bookID))"
                    );
    
    foreach ($table as &$value){
        try{
            if (mysqli_query($conn, $value))
                {
                echo "Table created\n";
                }
        }
        catch (exception $e){
            echo $e->getmessage();
        }
    }

    create_form($conn);
?>