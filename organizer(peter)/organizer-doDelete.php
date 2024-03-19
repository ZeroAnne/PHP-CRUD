<?php
require_once("../connect_server.php");

session_start();

$id = $_GET["id"];

$sql = "UPDATE organizer SET valid = 0 WHERE id = $id";


if ($conn->query($sql) === TRUE) {
    $_SESSION['message'] = "刪除成功";
    header("Location: organizer-list.php");
    exit();
} else {
    $_SESSION['message'] = "刪除失敗";
    header("Location: organizer-list.php");
    exit();
}
