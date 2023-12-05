<?php 
	include '_layout.php'; 
?>

<div id="centered-div">
	<div class="text-box" id="report-container">   
			<!--This form generates different type of reports, depending on which button is selected-->
			<div id="report-buttons-div">
				<div>
				<label for="report1-button">September Customers: </label>
				<button class="hero-btn" id="report1-button" type="button" name="report1">Generate Report</button>
				</div>
				<div>
				<label for="report2-button">Highest Selling Authors: </label>
				<button class="hero-btn" id="report2-button" type="button" name="report2">Generate Report</button>
				</div>
				<div>
				<label for="report3-button">Highest Selling Bookstores: </label>
				<button class="hero-btn" id="report3-button" type="button" name="report3">Generate Report</button>
				</div>
				<div>
				<label for="report4-button">Biggest Nerds: </label>
				<button class="hero-btn" id="report4-button" type="button" name="report4">Generate Report</button>
				</div>
			</div>
			
			<div id="table-div">
				<!--<p id="table-description"></p>-->
				<table border='1' id="report-table">
				</table>
			</div>
		<script>
			document.getElementById("report1-button").addEventListener("click", generate_report1);
			document.getElementById("report2-button").addEventListener("click", generate_report2);
			document.getElementById("report3-button").addEventListener("click", generate_report3);
			document.getElementById("report4-button").addEventListener("click", generate_report4);
			function clearTable(tableId) {
				var table = document.getElementById(tableId);

				if (table) {
					// Remove all rows except the header row
					while (table.rows.length > 0) {
						table.deleteRow(0);
					}
				} else {
					console.error('Table with id ' + tableId + ' not found.');
				}
			}
			
			function generate_report1() {
				clearTable("report-table");
				// Make a Fetch request to generate_reports.php
				fetch('generate_reports.php', {
					method: 'POST',
					body: JSON.stringify({ action: 'report1' }), // Send a request identifier
					headers: {
						'Content-Type': 'application/json',
					},
				})
				.then(response => response.json())
				.then(data => {
					// Handle the response data and update the table
					var table = document.getElementById("report-table");
					//var tableDescription = document.getElementById("table-description");
					//tableDescription.innerHTML = "Generated a report for all Customers who ordered The Daughter of Time in the month of September 2023.";
					table.innerHTML = "<tr><th>Customer First Name</th><th>Customer Last Name</th><th>Postal Code</th></tr>";
					// Assuming the response data has a structure similar to your expected 'data' array
					data.forEach(item => {
						var newRow = table.insertRow(table.rows.length);
						var cell1 = newRow.insertCell(0);
						var cell2 = newRow.insertCell(1);
						var cell3 = newRow.insertCell(2);
						cell1.innerHTML = item.firstName;
						cell2.innerHTML = item.lastName;
						cell3.innerHTML = item.postalCode;
					});
				})
				.catch(error => console.error('Error:', error));
			}
			
			function generate_report2() {
				clearTable("report-table");
				// Make a Fetch request to generate_reports.php
				fetch('generate_reports.php', {
					method: 'POST',
					body: JSON.stringify({ action: 'report2' }), // Send a request identifier
					headers: {
						'Content-Type': 'application/json',
					},
				})
				.then(response => response.json())
				.then(data => {
					// Handle the response data and update the table
					var table = document.getElementById("report-table");
					//var tableDescription = document.getElementById("table-description");
					//tableDescription.innerHTML = "Generated a report for all Customers who ordered The Daughter of Time in the month of September 2023.";
					table.innerHTML = " <tr><th> Author Name </th><th> Total Revenue </th></tr>";
					// Assuming the response data has a structure similar to your expected 'data' array
					data.forEach(item => {
						var newRow = table.insertRow(table.rows.length);
						var cell1 = newRow.insertCell(0);
						var cell2 = newRow.insertCell(1);
						cell1.innerHTML = item.name;
						cell2.innerHTML = "$" + item.totalSales;
					});
				})
				.catch(error => console.error('Error:', error));
			}
			
			function generate_report3() {
				clearTable("report-table");
				// Make a Fetch request to generate_reports.php
				fetch('generate_reports.php', {
					method: 'POST',
					body: JSON.stringify({ action: 'report3' }), // Send a request identifier
					headers: {
						'Content-Type': 'application/json',
					},
				})
				.then(response => response.json())
				.then(data => {
					// Handle the response data and update the table
					var table = document.getElementById("report-table");
					table.innerHTML = "<tr><th> Store Name </th><th> Total Revenue </th></tr>";
					// Assuming the response data has a structure similar to your expected 'data' array
					data.forEach(item => {
						var newRow = table.insertRow(table.rows.length);
						var cell1 = newRow.insertCell(0);
						var cell2 = newRow.insertCell(1);
						cell1.innerHTML = item.storeName;
						cell2.innerHTML = "$" + item.totalSales;
					});
				})
				.catch(error => console.error('Error:', error));
			}
			
			function generate_report4() {
				clearTable("report-table");
				// Make a Fetch request to generate_reports.php
				fetch('generate_reports.php', {
					method: 'POST',
					body: JSON.stringify({ action: 'report4' }), // Send a request identifier
					headers: {
						'Content-Type': 'application/json',
					},
				})
				.then(response => response.json())
				.then(data => {
					// Handle the response data and update the table
					var table = document.getElementById("report-table");
					table.innerHTML = "<tr><th> Name </th><th> Total Spent </th></tr>";
					// Assuming the response data has a structure similar to your expected 'data' array
					data.forEach(item => {
						var newRow = table.insertRow(table.rows.length);
						var cell1 = newRow.insertCell(0);
						var cell2 = newRow.insertCell(1);
						cell1.innerHTML = item.name;
						cell2.innerHTML = "$" + item.totalSpent;
					});
				})
				.catch(error => console.error('Error:', error));
			}
		</script>
	</div>
</div>
