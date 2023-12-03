<?php include '../_layout.php' ?>

<div class="text-box">
    <h2>REPORTS PAGE</h2>    
<!--This form queries the database, specifically the book table-->
    <form action='generate_reports.php' method="post">
        <div>September Customers: <input class="hero-btn" id="search-button" type="submit" value="Generate Report" name="report1"/></div>
        <div>Highest Selling Authors: <input class="hero-btn" id="search-button" type="submit" value="Generate Report" name="report2"/></div>
        <div>Highest Selling Bookstores: <input class="hero-btn" id="search-button" type="submit" value="Generate Report" name="report3"/></div>
        <div>Total Revenue: <input class="hero-btn" id="search-button" type="submit" value="Generate Report" name="report4"/></div>
    </form>
</div>
