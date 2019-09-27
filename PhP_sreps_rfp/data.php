<?php
//setting header to json_decode
header('Content-Type: application/json');

//database
define('DB_HOST', 'localhost:8080');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'usbw');
define('DB_NAME', 'mydb');

//get connection 
$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

if(!$mysqli){
	die("Connection failed: " . $mysqli->error);
}

//query to get data from the table
$query = sprintf("SELECT playerID, score FROM scoredata ORDER BY playerID");

//execute query
$result = $mysqli->query($query);

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