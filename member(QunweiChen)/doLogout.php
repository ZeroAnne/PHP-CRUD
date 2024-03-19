<?php
session_start();

unset($_SESSION["member"]);

header("location: member_login.php");

?>

