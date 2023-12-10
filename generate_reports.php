<?php
//this report shows the customers who bought the book "The Daughter of Time" in September 2023.

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $requestData = json_decode(file_get_contents('php://input'), true);

    if (isset($requestData['action'])) {
        $action = $requestData['action'];

        switch ($action) {
            case 'report1':
                // Call the report1 function
                $data = report1();
                echo json_encode($data);
                exit(); // Ensure no additional content is sent
                break;
			case 'report2':
                // Call the report1 function
                $data = report2();
                echo json_encode($data);
                exit(); // Ensure no additional content is sent
                break;
			case 'report3':
                // Call the report1 function
                $data = report3();
                echo json_encode($data);
                exit(); // Ensure no additional content is sent
                break;
			case 'report4':
                // Call the report1 function
                $data = report4();
                echo json_encode($data);
                exit(); // Ensure no additional content is sent
                break;

            // Handle other actions as needed

            default:
                echo json_encode(['error' => 'Invalid action']);
                exit(); // Ensure no additional content is sent
        }
    } else {
        echo json_encode(['error' => 'Action not provided']);
        exit(); // Ensure no additional content is sent
    }
}

function report1() {
    $conn = @mysqli_connect("localhost",  "root", "default", "");
    mysqli_select_db($conn, 'BookNerds');
    $query = "select customer.firstName, customer.lastName, customer.postalCode 
              from customer, orders, orderDetails, book
              where(customer.customerID = orders.customerID and
              orders.orderID = orderDetails.orderID and
              book.bookID = orderDetails.bookID and
              book.title = 'The Daughter of Time' and
              orders.orderDate between '2023-09-01' and '2023-09-30')";
    $result = mysqli_query($conn, $query);

    $data = array();

    while ($row = mysqli_fetch_array($result)) {
        $data[] = array(
            'firstName' => $row["firstName"],
            'lastName' => $row["lastName"],
            'postalCode' => $row["postalCode"]
        );
    }

    mysqli_close($conn);

    return $data;
}

//this report shows the highest selling authors in our database
function report2() {
    $conn = mysqli_connect("localhost",  "root", "default", "");
    mysqli_select_db($conn, 'BookNerds');
    $query = "select CONCAT(author.firstName, ' ', author.lastName) as 'Name', SUM(book.price * orderDetails.quantity) as 'Total Sales'
    from orderDetails, author, book
    where(orderDetails.bookID = book.bookID and
    book.authorID = author.authorID)
    group by CONCAT(author.firstName, ' ', author.lastName)
    order by SUM(book.price) desc;";
    $result = mysqli_query($conn, $query);

    $data = array();

    while ($row = mysqli_fetch_array($result)) {
        $data[] = array(
            'name' => $row["Name"],
            'totalSales' => $row["Total Sales"]
        );
    }

    mysqli_close($conn);

    return $data;
}

// this report shows the highest selling bookstores in our database
function report3() {
    $conn = mysqli_connect("localhost",  "root", "default", "");
    mysqli_select_db($conn, 'BookNerds');
    $query = "select bookstore.bookstoreName as 'Store Name', SUM(book.price * orderDetails.quantity) as 'Total Sales'
    from orderDetails, book, bookstore
    where(
    orderDetails.bookstoreID = bookstore.bookstoreID and
    orderDetails.bookID = book.bookID)
    group by bookstore.bookstoreName
    order by SUM(book.price * orderDetails.quantity) desc;";

    $result = mysqli_query($conn, $query);

    $data = array();

    while ($row = mysqli_fetch_array($result)) {
        $data[] = array(
            'storeName' => $row["Store Name"],
            'totalSales' => $row["Total Sales"]
        );
    }

    mysqli_close($conn);

    return $data;
}

// this report shows the total revenue of the company, as well as the largest contributors towards it.
function report4() {
    $conn = mysqli_connect("localhost",  "root", "default", "");
    mysqli_select_db($conn, 'BookNerds');

	$biggest_nerds_query = "select CONCAT(customer.firstName,' ',customer.lastName) as 'Name', SUM(totalPrice) as 'Total Spent'
    from orders, customer
    where(orders.customerID = customer.customerID)
    group by (orders.customerID)
    order by SUM(totalPrice) desc;";
    $result2 = mysqli_query($conn, $biggest_nerds_query);
	
	$data = array();
	
    while ($row = mysqli_fetch_array($result2)) {
        $data[] = array(
            'name' => $row["Name"],
            'totalSpent' => $row["Total Spent"]
        );
    }
    
    mysqli_close($conn);

    return $data;
}
?>