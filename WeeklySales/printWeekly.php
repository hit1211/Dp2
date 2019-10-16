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

$dateRequired = $_POST["dateRequired"];
//echo "$dateRequired";


//echo "$Monthvar";
$findItems = "SELECT * FROM salesrecords WHERE Date BETWEEN '$dateRequired' AND DATE_ADD('$dateRequired', INTERVAL 1 WEEK);";
$result = mysqli_query($conn, $findItems);
//$count = mysqli_num_rows($test);
//if ($count > 0) {
	if ($result) {
		$fh = fopen('weekly.csv', 'w');
		echo "<p> <table border='1'>";
		echo "<tr>";
		echo "<th>Reciept Number</th>";
		echo "<th>Purchaser Name</th>";
		echo "<th>Item ID</th>";
		echo "<th>Item Name</th>";
		echo "<th>Item Price</th>";
		echo "<th>Quantity</th>";
		echo "<th>Date</th>";
		echo "</tr>";
		while ($row = mysqli_fetch_row($result))
		{
			$txt = $row[0].",". $row[1] .",". $row[2] .",". $row[3] .",". $row[4] .",". $row[5] .",". $row[6] . "\n";
			fwrite($fh, $txt);
			echo "<tr>";
			echo "<td>". $row[0] . "</td>";
			echo "<td>". $row[1] . "</td>";
			echo "<td>". $row[2] . "</td>";
			echo "<td>". $row[3] . "</td>";
			echo "<td>". $row[4] . "</td>";
			echo "<td>". $row[5] . "</td>";
			echo "<td>". $row[6] . "</td>";
			echo "</tr>";
		}
		fclose('monthly.csv');
		echo "</table> </p>";
		echo "<p> <form id='converttoCSV' action='weekly.csv' method='get'>
				<input type='submit' value='Convert to CSV'/>
				</form></p>";
	} else { 
		echo "<h2>No Records Within this week</h2>";
	}
//} else {
	//echo "<h2>No Records For this Month";
//}


?>