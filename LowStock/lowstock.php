<?php 
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "salesdb";
$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error) {
	die("Connection Failed: " . $conn->connect_error);
}

//$selectAll = "SELECT * FROM stockrecords;";
$findItemNo = "SELECT * FROM stockrecord WHERE ItemQuantity<5;";
$result1 = mysqli_query($conn, $findItemNo);
//$check = mysqli_query($conn, $selectAll);
//$count = mysqli_num_rows($check);
if ($result1) {
	echo "<table border='1'>";
	echo "<tr>";
	echo "<th>Item Number</th>";
	echo "<th>Item Name</th>";
	echo "<th>Item Quantity</th>";
	echo "</tr>";
	while ($row = mysqli_fetch_row($result1))
	{
		echo "<tr>";
		echo "<td>". $row[0] . "</td>";
		echo "<td>". $row[1] . "</td>";
		echo "<td>". $row[2] . "</td>";
		echo "</tr>";
	}
	echo "</table>";
	
}
	
