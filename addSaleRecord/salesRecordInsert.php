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
//Setting variables from form

if (isset ($_POST["pName"]) && isset ($_POST["item_id"]) && isset ($_POST["item_quantity"]) && isset ($_POST["item_price"]) && isSet($_POST["date_purchased"])) {
	$pName = $_POST["pName"];
	$itemID = $_POST["item_id"];
	$itemQuantity = $_POST["item_quantity"];
	$itemPrice= $_POST["item_price"];
	$datePurchased = $_POST["date_purchased"];
	$errMsg = "";
  
	//item id validation
	
	if ($itemID=="") {
		$errMsg .= "<h2>You must enter the item ID.</h2>";
	}
	else if (!preg_match("/^[0-9]*$/", $itemID)) {
		$errMsg .= "<h2>Only numbers can be contained in item ID.</h2>";
	}

	//item quantity validation
	
	if ($itemQuantity=="") {
		$errMsg .= "<h2>You must enter the item Quantity.</h2>";
	}
	else if (!preg_match("/^[0-9]*$/", $itemQuantity)) {
		$errMsg .= "<h2>Only numbers can be contained in item Quantity.</h2>";
	}

	//purchaser name validation
	
	if ($pName=="") {
		$errMsg .= "<h2>You must enter the purchaser name.</h2>";
	}
	else if (!preg_match("/^[a-zA-Z]*$/", $pName)) {
		$errMsg .= "<h2>Only alpha letters allowed in purchaser name.</h2>";
	}
	
	if ($errMsg == "") {
		$errMsg2 = "";
		$selectAll = "SELECT * FROM stockrecord;";
		$findItemNo = "SELECT * FROM stockrecord WHERE ItemNo='$itemID';";
		$result1 = mysqli_query($conn, $findItemNo);
		$check = mysqli_query($conn, $selectAll);
		$count = mysqli_num_rows($check);
		
		//echo "$count and $itemID";
		
		if ($result1 && ($itemID <= $count)) {
			$row = mysqli_fetch_row($result1);
			$itemName = $row[1];
			$currentQuant = $row[2];
		} else {
			$errMsg2 .= "<h2>Please Select a Valid ItemNo</h2>";
		}
		
		//echo "$errMsg2";
		
	} else {
		echo "$errMsg";
	}
	
	if ($errMsg2 == "") {
		$totErr = "";
		$newquant = $currentQuant - $itemQuantity;
		
		if ($newquant < 0) {
			$totErr .= "<h2> Not Enough Stock</h2>";
		}
		
		if ($totErr == "") {
			$updatequery = "UPDATE stockrecord SET ItemQuantity='$newquant' WHERE ItemNo='$itemID';";
			$result2 = mysqli_query($conn, $updatequery);
		
			$addquery = "INSERT INTO `salesrecords`(`recieptNum`, `PName`, `ItemID`, `ItemName`, `ItemPrice`, `ItemQuantity`, `Date`) VALUES (NULL,'$pName','$itemID','$itemName','$itemPrice','$itemQuantity','$datePurchased');";
			$addsale = mysqli_query($conn, $addquery);
			
		if (($result2 == true) && ($addsale == true)) {
			echo "Update succsessful";
		} else {
			echo "Update Unsuccsessful";
		}
		
	} else {
		echo "$totErr";
	}
	} else {
		echo "$errMsg2";
	}

  
}