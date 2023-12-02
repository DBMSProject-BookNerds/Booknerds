<?php include '../_layout.php' ?>
<div id="centered-div">
	<div class="text-box"> 
		<!--This form queries the database, specifically the book table-->
		<form id= "search-form" action='Search.php' method="post">
			<div id="label-input">
			<label for="title-input">Title:</label>
			<input id= "title-input" type="text" name="title">
			</div>
			<div id="label-input">
			<label for="Author-fname-input">Author's First Name:</label>
			<input id="Author-fname-input" type="text" name="fname" />
			</div>
			<div id="label-input">
			<label for="Author-lname-input">Author's Last Name:</label>
			<input id="Author-lname-input" type="text" name="lname" />
			</div>
			<div id="label-input"> 
			<label for="genre-select">Genre:</label>
			<select id="genre-select" name="genre"/>
				<option value="Mystery">Mystery</option>
				<option value="Comedy">Comedy</option>
				<option value="Horror">Horror</option>
				<option value="Romance">Romance</option>
				<option value="Science Fiction">Science Fiction</option>
			</select>
			</div>
			<div id="label-input"> 
			<label for="isbn-input">ISBN:</label>
			<input id="isbn-input" type="text" name="isbn"/>
			</div>
		</form>
		<input class="hero-btn" id="search-button" type="submit" value="Search"/>
	</div>
</div>
