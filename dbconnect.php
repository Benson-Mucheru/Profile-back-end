<?php
$servername = "localhost";
$username = "ben";
$password = 12345;
$dbname = "try";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//echo "Connected successfully";
