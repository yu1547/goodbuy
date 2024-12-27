<?php
$servername = "localhost";
$username = "root";
$password = "penny01157120";
$dbname = "product2";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
