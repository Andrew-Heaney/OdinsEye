<?php
$email=$_POST["email"];
$password=$_POST["pass"]; 

$servername="localhost";
$dbusername="user";
$dbpassword="password";
$dbname="OdinsEye";

if (!filter_var($email, FILTER_SANITIZE_STRING) === false || !filter_var($password, FILTER_SANITIZE_STRING) === false){
	header("Location: index.html");
	echo "Enter a valid user information";
}

session_start();

$_SESSION["authorised"] = 0;

$connection= new mysqli($servername,$dbusername,$dbpassword,$dbname); 

if ($connection->connect_error) {
	die("Failed to connect to database\n".$connection.connect_error);
}

$SQLString="SELECT password from Users where email='".$email."'";

$result=$connection->query($SQLString);
if (!$result){
	echo $connection->error."\n";
}else{
	while($row=$result->fetch_assoc()){
		if ($password==$row["password"]){
			$_SESSION["authorised"] = 1;
		}else{
			$_SESSION["authorised"] = 0;
		}
	}
}

if ($_SESSION["authorised"] == 1){
	header("Location: PickVideo.php");
}else{
	header("Location: index.html");
}
?>
