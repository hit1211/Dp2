<?php 
session_start();
//Connection Established to Database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "phpdb";
$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error) {
	die("Connection Failed: " . $conn->connect_error);
}

if (isSet($_POST['usern']) && isSet($_POST['pass'])) {
	$user=$_POST['usern'];
	$pass=$_POST['pass'];
	
$query = "SELECT * FROM login WHERE username='$user' and Password='$pass'";
$result = mysqli_query($conn, $query);
$count = mysqli_num_rows($result);
$row = mysqli_fetch_array($result);

$employeename= $row['FirstName'] . " " . $row['LastName'];
#$_SESSION["Employee"] = $employeename;

#$test = $_SESSION["Employee"];

if ($count == 1) {
	$_SESSION["Employee"] = $employeename;
	header('location:app.php');
} else {
	header('location: index.html');
}
#echo "$test";
} else {
	header('location: index.html');
}


mysqli_close($conn);
?>