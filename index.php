<?php
    // include the layout
    include '_layout.php'; 
    // CALL ESTABLISH_DB HERE
    include 'Establish_DB.php';
?>	
	<div id="centered-div">
		<p>
			<?php 
				echo create_database();
			?>
		</p>
	</div>
	
    <div id="centered-div">
		<div class="text-box">
			<h1>Welcome to BookNerds!</h1>
			<p>
				We understand the unique and profound relationship that book lovers share 
				with the written word. Whether you're an avid reader on the hunt for your 
				next literary adventure or someone seeking expert recommendations, our online 
				bookstore is designed with you in mind. Our mission at BookNerds is simple 
				yet profound: to provide a comprehensive and user-friendly database that stores 
				relevant information about books, making it easier than ever for customers to 
				discover their next favorite read. We recognize that in today's fast-paced world, 
				time is of the essence, and finding the perfect book should be a swift and enjoyable process.
			</p>
		</div>
    </div>
    
    <div id="centered-div">
		<div class="text-box">
			<h1> Get Started</h1>
			<div id="button-div">
				<a href="search.php" class="hero-btn">Find Books</a>
				<a href="forms.php" class="hero-btn">Data Forms</a>
				<a href="reports.php" class="hero-btn">View Reports</a>
			</div>
		</div>
    </div>
