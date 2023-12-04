<?php
//this report shows the customers who bought the book "The Daughter of Time" in September 2023.
function report1() {
    $conn = @mysqli_connect("localhost", "root", "default", "");
    mysqli_select_db($conn, 'BookNerds');
    $query = "select customer.firstName, customer.lastName, customer.postalCode 
              from customer, orders, orderdetails, book
              where(customer.customerID = orders.customerID and
              orders.orderID = orderdetails.orderID and
              book.bookID = orderdetails.bookID and
              book.title = 'The Daughter of Time' and
              orders.orderDate between '2023-09-01' and '2023-09-30')";
    $result= mysqli_query($conn, $query);
    echo "<html><body><h1>Report 1</h1></body></html>
    <table border='1'>
    <tr>
    <th> Customer First Name </th>
    <th> Customer Last Name </th>
    <th> Postal Code </th>
    </tr>";
    while($row = mysqli_fetch_array($result))
    {
    echo "<tr>";
    echo "<td>" . $row["firstName"] . "</td>";
    echo "<td>" . $row["lastName"] . "</td>";
    echo "<td>" . $row["postalCode"] . "</td>";
    echo "</tr>";
    }
    echo "</table>";
    echo "";
    echo "Generated a report for all Customers who ordered The Daughter of Time in the month of September 2023.";
    mysqli_close($conn);
}

//this report shows the highest selling authors in our database
function report2() {
    $conn = mysqli_connect("localhost", "root", "default", "");
    mysqli_select_db($conn, 'BookNerds');
    $query = "select CONCAT(author.firstName, ' ', author.lastName) as 'Name', SUM(book.price * orderDetails.quantity) as 'Total Sales'
    from orderDetails, author, book
    where(orderdetails.bookID = book.bookID and
    book.authorID = author.authorID)
    group by CONCAT(author.firstName, ' ', author.lastName)
    order by SUM(book.price) desc;";
    $result= mysqli_query($conn, $query);

    echo "<table border='1'>
    <tr>
    <th> Author Name </th>
    <th> Sales </th>
    </tr>";
    while($row = mysqli_fetch_array($result)){
        echo "<tr>";
        echo "<td>" . $row["Name"] . "</td>";
        echo "<td>" . $row["Total Sales"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    mysqli_close($conn);
}

// this report shows the highest selling bookstores in our database
function report3() {
    $conn = mysqli_connect("localhost", "root", "default", "");
    mysqli_select_db($conn, 'BookNerds');
    $query = "select bookstore.bookstoreName as 'Store Name', SUM(book.price * orderDetails.quantity) as 'Total Sales'
    from orderDetails, book, bookstore
    where(
    orderdetails.bookstoreID = bookstore.bookstoreID and
    orderdetails.bookID = book.bookID)
    group by bookstore.bookstoreName
    order by SUM(book.price * orderDetails.quantity) desc;";

    $result= mysqli_query($conn, $query);
    echo "<table border='1'>
    <tr>
    <th> Store Name </th>
    <th> Sales </th>
    </tr>";
    while($row = mysqli_fetch_array($result)){
        echo "<tr>";
        echo "<td>" . $row["Store Name"] . "</td>";
        echo "<td>" . $row["Total Sales"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    mysqli_close($conn);
}

// this report shows the total revenue of the company, as well as the largest contributors towards it.
function report4() {
    $conn = mysqli_connect("localhost", "root", "default", "");
    mysqli_select_db($conn, 'BookNerds');

    $total_revenue = "select SUM(totalPrice) as 'Total Revenue'
    from orders;";
    $result = mysqli_query($conn, $total_revenue);
    echo "<table border='1'>
    <tr>
    <th> Total Revenue </th>
    </tr>";
    while($row = mysqli_fetch_array($result)){
        echo "<tr>";
        echo "<td>" . $row['Total Revenue'] . "</td>";
    }
    echo "</table>";

    $biggest_nerds_query = "select CONCAT(customer.firstName,' ',customer.lastName) as 'Name', SUM(totalPrice) as 'Total Spent'
    from orders, customer
    where(orders.customerID = customer.customerID)
    group by (orders.customerID)
    order by SUM(totalPrice) desc;";
    $result = mysqli_query($conn, $biggest_nerds_query);
    echo "<table border='1'>
    <tr>
    <th> Name </th>
    <th> Total Spent </th>
    </tr>";
    while($row = mysqli_fetch_array($result)){
        echo "<tr>";
        echo "<td>" . $row['Name'] . "</td>";
        echo "<td>" . $row['Total Spent'] . "</td>";
    }
    echo "</table>";
    mysqli_close($conn);
}

if (isset($_POST['report1'])){report1();}
elseif (isset($_POST['report2'])) {report2();}
elseif (isset($_POST['report3'])) {report3();}
else {report4();}
?>
