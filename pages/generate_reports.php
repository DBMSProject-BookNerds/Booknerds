<?php
function report1() {
    $conn = mysqli_connect("localhost", "test", "test", "");
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

function report2() {

}

function report3() {

}

function report4() {

}

if (isset($_POST['report1'])) {report1();}
elseif (isset($_POST['report2'])) {report2();}
elseif (isset($_POST['report3'])) {report3();}
else {report4();}
?>