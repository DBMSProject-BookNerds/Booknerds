<?php include '../_layout.php' ?>

<div class="text-box">
    <h2>SEARCH PAGE</h2>  
    <!--This form queries the database, specifically the book table-->
    <form id= "search-form" action='Search.php' method="post">
        Title:<input type="text" name="title">
        Author First Name:<input type="text" name="fname" />
        Author Last Name:<input type="text" name="lname" />
        Genre:<input type="text" name="genre" />
        ISBN:<input type="text" name="isbn" />
        <input type='submit' value='Search' />
    </form>
</div>
