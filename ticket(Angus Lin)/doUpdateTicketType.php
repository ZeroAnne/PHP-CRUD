<?php

require_once("../connect_server.php");

session_start();

if(!isset($_POST["id"])){
    header("location:404.php");
    exit;
}

$id=$_POST["id"];
$name=$_POST["name"];
$category_id=$_POST["category_id"];
$ticket_type_id=$_POST["ticket_type_id"];
$price=$_POST["price"];
$max_quantity=$_POST["max_quantity"];
$remaining_quantity=$_POST["remaining_quantity"];
// var_dump($id, $name, $category_id, $ticket_type_id, $price, $max_quantity, $remaining_quantity);

$sql= "UPDATE ticket_type SET name='$name',category_id='$category_id', ticket_type_id='$ticket_type_id', price='$price', max_quantity='$max_quantity', remaining_quantity='$remaining_quantity' WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    $_SESSION['message'] = "編輯資料成功";
    // echo "修改序號".$id;
} else {
    $_SESSION['message'] = "編輯資料失敗".$conn->error;
}

header("location:ticket-type.php?id=$id")

?>