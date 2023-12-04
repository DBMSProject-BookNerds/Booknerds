<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookNerds</title>
    <script src="https://kit.fontawesome.com/9a04c14e05.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div id="header">
        <nav>
            <a href="index.php"><img id="nav-icon" src="../images/Nerd.png"></a>
            <div class="nav-links" id="navLinks">
                <i class="fa fa-times" onclick="hideMenu()"></i>
                <ul>
                    <li><a href="../index.php">HOME</a></li>
                    <li><a href="../pages/search.php">SEARCH</a></li>
                    <li><a href="../pages/checkout.php">CHECKOUT</a></li>
                    <li><a href="../pages/reports.php">REPORTS</a></li>
                </ul>
            </div>
            <i class="fa fa-bars" onclick="showMenu()"></i>
        </nav>
    </div>
    <script>
        var navLinks = document.getElementById("navLinks")
        function showMenu() {
            navLinks.style.right = "0";
        }
        function hideMenu() {
            navLinks.style.right = "-200px";
        }
    </script>
</body>

</html>
