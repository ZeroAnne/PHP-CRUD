<?php
require_once("../connect_server.php");


$sql = "SELECT event.*, organizer.*
FROM event
JOIN organizer ON event.merchant_id = organizer.id; ";
  
$result = $conn ->query($sql);
$rows =$result -> fetch_all(MYSQLI_ASSOC);
var_dump($rows);
?>