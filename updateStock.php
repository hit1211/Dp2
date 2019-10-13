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

if (isSet($_POST['item_id']) && isSet($_POST['item_quantity'])) {
	$id=$_POST['item_id'];
	$quan=$_POST['item_quantity'];
	
	$errMsg = "";

	//item id validation
	if ($id=="") {
		$errMsg .= "<h2>You must enter the item ID.</h2>";
	}
	else if (!preg_match("/^[0-9]*$/", $id)) {
		$errMsg .= "<h2>Only numbers can be contained in item ID.</h2>";
	}
	
	if ($quan=="") {
		$errMsg .= "<h2>You must enter the item Quantity.</h2>";
	}
	else if (!preg_match("/^[0-9]*$/", $quan)) {
		$errMsg .= "<h2>Only numbers can be contained in item Quantity.</h2>";
	}
	
	if ($errMsg == "") {
		$errMsg2 = "";
		$selectAll = "SELECT * FROM stockrecord;";
		$findItemNo = "SELECT * FROM stockrecord WHERE ItemNo='$id';";
		$result1 = mysqli_query($conn, $findItemNo);
		$check = mysqli_query($conn, $selectAll);
		$count = mysqli_num_rows($check);
		if ($result1 && ($id <= $count)) {
			$row = mysqli_fetch_row($result1);
			$currentQuant = $row[2];
		} else {
			$errMsg2 .= "<h2>Please Select a Valid ItemNo</h2>";
		}
	} else {
		echo "$errMsg";
	}		
		
	if ($errMsg == "" && $errMsg2 =="") {
		$newquant = $currentQuant + $quan;
		
		$query = "UPDATE stockrecord SET ItemQuantity='$newquant' WHERE ItemNo='$id';";
		$result2 = $result = mysqli_query($conn, $query);
		
		if ($result2) {
			echo "Update Successful";
		} else {
			echo "Unable to Update";
		}
	} else {
		echo "$errMsg2";
	}
}