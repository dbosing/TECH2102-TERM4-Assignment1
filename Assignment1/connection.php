<?php

$servername = "localhost";
$username = "root";
$password = your_mysql_password;
$dbname = "students";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>