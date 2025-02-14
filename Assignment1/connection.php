<?php

$servername = "localhost";
$username = "root";
$password = "J03L";
$dbname = "students";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("". $conn->connect_error);
}

?>