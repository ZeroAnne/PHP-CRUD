<?php

require_once("../connect_server.php");

session_start();

if(!isset($_GET["id"])){
    header("Location:404.php");
    exit;
}

$id=$_GET["id"];
$category=$_GET["category"];
$page=$_GET["page"];

// var_dump($id);

$sql="UPDATE ticket_type SET valid='1' WHERE id=$id";

if ($conn->query($sql) === TRUE){
    $_SESSION['message'] = "刪除成功";
}else{
    $_SESSION['message'] = "刪除失敗". $conn->error;
}

$conn->close();

if (isset($_GET["page"]) && isset($_GET["category"])) {
    header("Location: ticket-list.php?page=$page&category=$category");
} elseif (isset($_GET["page"])) {
    header("Location: ticket-list.php?page=$page");
} elseif (isset($_GET["category"])) {
    header("Location: ticket-list.php?category=$category");
} else {
    header("Location: ticket-list.php");
}

?>