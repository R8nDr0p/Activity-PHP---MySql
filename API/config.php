<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kodego_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error Connecting to " . $conn->connect_error);
}
