<?php
$serverName = "localhost";
$userName = "admin";
$password = "12345";
$dbName = "govent";

$conn = new mysqli($serverName, $userName, $password, $dbName);

if ($conn->connect_error) {
    die("連線失敗" . $conn->connect_error);
} else {
}
