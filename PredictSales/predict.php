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

$Selection = $_POST["Selection"];
$dataArray = array();
$graph = array();
$increment = 1;
$index = 1;
//$checkVal = 0;

if ($Selection == 1) {
	$findItems = "SELECT ItemID, ItemName, SUM(ItemQuantity) as UnitsSold FROM salesrecords WHERE YEAR(Date)=YEAR(CURDATE()) and MONTH(Date)= MONTH(CURDATE()) GROUP BY ItemID ORDER BY UnitsSold;";
	$result = mysqli_query($conn, $findItems);
	if ($result) {
		while ($row = mysqli_fetch_row($result))
		{
			$dataArray[] = $row;
		}
		//print_r($dataArray);
		
		foreach ($dataArray as $arr) {
			if ($increment == 1) {
				$lowestPrice = $arr[2];
				$HighestAmount = $arr[2];
			} else { 
				if ($lowestPrice > $arr[2]) {
					$lowestPrice = $arr[2];
				}
				if ($HighestAmount < $arr[2]) {
					$HighestAmount = $arr[2];
				}
			} 
			$increment++;
			//echo "$arr[2] \n";
			//$check = $arr[2];
			//$predictedAmount = rand(0, $check+5); 
			//$arr[3] = $predictedAmount;
		}
		//echo"$HighestAmount";
		//echo"$lowestPrice";
		//echo "$increment";
		//FIND Linear Function
		$gradient = ($HighestAmount-$lowestPrice)/$increment;
		//echo "$gradient \n";
		//$checkVal = $index*$gradient;
		//echo "$checkVal \n";
		foreach($dataArray as &$comp) {
			if (($index*$gradient) > $comp[2]) {
				$prediction = ($index*$gradient)-$comp[2];
				$comp[2] = $prediction;
			} else if (($index*$gradient) == $comp[2]) {
				$prediction = $comp[2];
				$comp[2] = $prediction;
			} else if (($index*$gradient) < $comp[2]) {
				$offset = $comp[2]-($index*$gradient);
				$prediction = rand($index*$gradient, $comp[2]+$offset);
				$comp[2] = $prediction;
			}
			$index++;
		}
		
		echo "<h2> Prediction </h2>";
		echo "<table border='1'>";
		echo "<tr>";
		echo "<th>Item ID</th>";
		echo "<th>Item Name</th>";
		echo "<th>Predicted Quantity</th>";
		echo "</tr>";
		foreach($dataArray as $printPred) {
			echo "<tr>";
			echo "<td>". $printPred[0] . "</td>";
			echo "<td>". $printPred[1] . "</td>";
			echo "<td>". $printPred[2] . "</td>";
			echo "</tr>";
		}
	} else { 
		echo "<h2> Not Enough Data for Prediction</h2>";
	}
}


if ($Selection == 2) {
	$findItems = "SELECT ItemID, ItemName, SUM(ItemQuantity) as UnitsSold FROM salesrecords WHERE Date BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 WEEK) AND CURDATE() GROUP BY ItemID ORDER BY UnitsSold;";
	$result = mysqli_query($conn, $findItems);
	if ($result) {
		while ($row = mysqli_fetch_row($result))
		{
			$dataArray[] = $row;
		}
		//print_r($dataArray);
		
		foreach ($dataArray as $arr) {
			if ($increment == 1) {
				$lowestPrice = $arr[2];
				$HighestAmount = $arr[2];
			} else { 
				if ($lowestPrice > $arr[2]) {
					$lowestPrice = $arr[2];
				}
				if ($HighestAmount < $arr[2]) {
					$HighestAmount = $arr[2];
				}
			} 
			$increment++;
		}
		//echo"$HighestAmount";
		//echo"$lowestPrice";
		//echo "$increment";
		//FIND Linear Function
		$gradient = ($HighestAmount-$lowestPrice)/$increment;
		//echo "$gradient \n";
		//$checkVal = $index*$gradient;
		//echo "$checkVal \n";
		foreach($dataArray as &$comp) {
			if (($index*$gradient) > $comp[2]) {
				$prediction = ($index*$gradient)-$comp[2];
				$comp[2] = $prediction;
			} else if (($index*$gradient) == $comp[2]) {
				$prediction = $comp[2];
				$comp[2] = $prediction;
			} else if (($index*$gradient) < $comp[2]) {
				$offset = $comp[2]-($index*$gradient);
				$prediction = rand($index*$gradient, $comp[2]+$offset);
				$comp[2] = $prediction;
			}
			$index++;
		}
		
		echo "<h2> Prediction </h2>";
		echo "<table border='1'>";
		echo "<tr>";
		echo "<th>Item ID</th>";
		echo "<th>Item Name</th>";
		echo "<th>Predicted Quantity</th>";
		echo "</tr>";
		foreach($dataArray as $printPred) {
			echo "<tr>";
			echo "<td>". $printPred[0] . "</td>";
			echo "<td>". $printPred[1] . "</td>";
			echo "<td>". $printPred[2] . "</td>";
			echo "</tr>";
		}
	} else { 
		echo "<h2> Not Enough Data for Prediction</h2>";
	}

}
