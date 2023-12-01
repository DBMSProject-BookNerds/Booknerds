<?php
    function create_form($conn){
        print <<<_HTML_
        <h1 align="center">Welcome to BookNerds 🤓 </h1>
        <FORM action="Reports.php"/>
        <input type='submit' name='Reports' value='Reports'/>
        </FORM>

        <FORM action="Search.php" method="post">
        Title:<input type="text" name="title">
        Author First Name:<input type="text" name="fname"/>
        Author Last Name:<input type="text" name="lname"/>
        Genre:<input type="text" name="genre"/>
        ISBN:<input type="text" name="isbn"/>
        <input type='submit' value='Search'/>
        </FORM>
        _HTML_;
        /*
        if (isset($_POST['action'])) {
            switch ($_POST['action']) {
                case 'Reports':
                    reports();

                case 'Search':
                    search();
            }
        }
        */
    }
?>