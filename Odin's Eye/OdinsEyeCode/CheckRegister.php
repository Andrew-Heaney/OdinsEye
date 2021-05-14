<?php
$email=$_POST["email"];
$password=$_POST["pass"];
$fname=$_POST["first"];
$lname=$_POST["last"];

$servername="localhost";
$dbusername="user";
$dbpassword="password";
$dbname="OdinsEye";

$connection= new mysqli($servername,$dbusername,$dbpassword,$dbname);
if ($connection->connect_error) {
	die("Failed to connect to database\n".$connection.connect_error);
}

$SQLString="insert into Users (email, password,fname,lname) values ('$email;','$password','$fname','$lname')";
$result=$connection->query($SQLString);

if (!$result){
	echo $connection->error."\n";
}else{
	header("Location: index.html");
}
?>