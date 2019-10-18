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

if (isSet($_POST['recieptNum'])) {
	$id=$_POST['recieptNum'];
	
	$errMsg = "";

	//item id validation
	if ($id=="") {
		$errMsg .= "<h2>You must enter the item ID.</h2>";
	}
	else if (!preg_match("/^[0-9]*$/", $id)) {
		$errMsg .= "<h2>Only numbers can be contained in item ID.</h2>";
	}
	
	if ($errMsg == "") {
		//$errMsg2 = "";
		$selectAll = "SELECT * FROM salesrecords;";
		$findItemNo = "SELECT * FROM salesrecords WHERE recieptNum='$id';";
		$result1 = mysqli_query($conn, $findItemNo);
		$check = mysqli_query($conn, $selectAll);
		$count = mysqli_num_rows($check);
		if ($result1 && ($id = $count)) {
			echo "<table border='1'>";
			echo "<tr>";
			echo "<th>Reciept Number</th>";
			echo "<th>Client Name</th>";
			echo "<th>Item ID</th>";
			echo "<th>Item Name</th>";
			echo "<th>Item Price</th>";
			echo "<th>Purchase Quantity</th>";
			echo "<th>Date</h>";
			echo "</tr>";
			echo "<tr>";
			$row = mysqli_fetch_row($result1);
			echo "<td>". $row[0] . "</td>";
			echo "<td>". $row[1] . "</td>";
			echo "<td>". $row[2] . "</td>";
			echo "<td>". $row[3] . "</td>";
			echo "<td>". $row[4] . "</td>";
			echo "<td>". $row[5] . "</td>";
			echo "<td>". $row[6] . "</td>";
			echo "</tr>";
			echo "</table>";
		}
	} else {
		echo "<h2>Please Fill in ALL FIELDS</h2>";
	}
}