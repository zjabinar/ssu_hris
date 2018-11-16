<?php

$hostname = "localhost";
$username = "root";
$password = "secret";
$dbname = "excelexport_db";
$conn = mysqli_connect($hostname,$username,$password,$dbname);
if (mysqli_connect_errno()){
	printf("Connect failed: %s\n", mysqli_connect_error());
	exit();
}	
mysqli_set_charset($conn, "utf8");