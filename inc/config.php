<?php

$host = "localhost";
$user = "root";
$pass = "";
$db   = "bookeeper";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$base_url = "http://localhost/bookkeeper/";  

?>
