<?php
require_once("../connect_server.php");

session_start();

if (!isset($_GET["id"])) {
    echo "請循正常管道進入此頁";
    exit;
}


$id = $_GET["id"];

$sql = "UPDATE event SET valid='0' WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    $_SESSION['message'] = "刪除成功";
} else {
    $_SESSION['message'] = "刪除失敗";
}

$conn->close();

header("location:event.php");
