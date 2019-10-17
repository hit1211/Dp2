<?php 
//setting header to json_decode
header('Content-Type: application/json');

//database
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'mydb');

//get connection 
$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

if(!$mysqli){
	die("Connection failed: " . $mysqli->error);
}

//query to get data from the table
$query = "SELECT playerID, score FROM scoredata ORDER BY playerID";

//execute query
$result = mysqli_query($mysqli,$query);

//loop through th returned data
$data = array();
foreach ($result as $row) {
	$data[] = $row;
}

// memory associated with result
$result->close();

//close connection
$mysqli->close();

//now print the data
print json_encode($data);
?>