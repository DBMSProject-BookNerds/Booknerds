<?php include '_layout.php';
if (!empty($_POST)) {
    $conn = mysqli_connect("localhost",  "root", "default", "");
    mysqli_select_db($conn, 'BookNerds');
    $query = search();
    $result= mysqli_query($conn, $query);
    echo "<div id=\"centered-div\"><h1>Results</h1></div>
    <div id=\"centered-div\">
        <table border='1'>
        <tr>
            <th> BookID </th>
            <th> Title </th>
            <th> Author First Name </th>
            <th> Author Last Name </th>
            <th> Genre </th>
            <th> ISBN </th>
        </tr>";
    while($row = mysqli_fetch_array($result))
    {
    echo "<tr>";
    echo "<td>" . $row["bookID"] . "</td>";
    echo "<td>" . $row["title"] . "</td>";
    echo "<td>" . $row["FirstName"] . "</td>";
    echo "<td>" . $row["LastName"] . "</td>";
    echo "<td>" . $row["Genre"] . "</td>";
    echo "<td>" . $row["ISBN"] . "</td>";
    echo "</tr>";
    }
    echo "</table></div>";
    mysqli_close($conn);
}
else {
}

function search(){
    $value = 'select bookID, title, firstName as FirstName, lastName as LastName, genreName as Genre, ISBN from book
              inner join author
              on book.authorID = author.authorID
              inner join genre
              on book.genreID = genre.genreID
              where(';

    $keys = array_keys(array_filter($_POST));
    for($x = 0; $x < count($keys); $x++){
        if (!empty($_POST[$keys[$x]])) {
            $value = $value . $keys[$x] . ' = ' . '\'' . $_POST[$keys[$x]] . '\'';
            if ($x != count($keys)-1) {
                $value = $value . ' and ';
            }
        }
        
    }
    $value = $value . ');';
    return $value;
}
?>
<div id="centered-div">
	<div class="text-box"> 
		<!--This form queries the database, specifically the book table-->
		<form id= "search-form" action='search.php' method="post">
			<div id="label-input">
			<label for="title-input">Title:</label>
			<input id= "title-input" type="text" name="title">
			</div>
			<div id="label-input">
			<label for="Author-fname-input">Author's First Name:</label>
			<input id="Author-fname-input" type="text" name="firstName" />
			</div>
			<div id="label-input">
			<label for="Author-lname-input">Author's Last Name:</label>
			<input id="Author-lname-input" type="text" name="lastName" />
			</div>
			<div id="label-input"> 
			<label for="genre-select">Genre:</label>
			<select id="genre-select" name="genreName"/>
				<option value="Mystery">Mystery</option>
				<option value="Comedy">Comedy</option>
				<option value="Horror">Horror</option>
				<option value="Romance">Romance</option>
				<option value="Science Fiction">Science Fiction</option>
			</select>
			</div>
			<div id="label-input"> 
			<label for="isbn-input">ISBN:</label>
			<input id="isbn-input" type="text" name="ISBN"/>
            <input class="hero-btn" id="search-button" type="submit" value="Search"/>
			</div>
		</form>
		<!--<input class="hero-btn" id="search-button" type="submit" value="Search"/>-->
	</div>
</div>
