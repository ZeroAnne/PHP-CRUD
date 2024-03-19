<?php
require_once("../connect_server.php");
session_start();
if(!isset($_POST["name"])){
    echo "請循正常管道進入此頁";
    exit;
}

$id=$_POST["id"];
$name=$_POST["name"];
$email=$_POST["email"];
$phone=$_POST["phone"];
$password=$_POST["password"];
$born_date=$_POST["born_date"];
$invoice=$_POST["invoice"];


// var_dump($name, $email, $phone);

$sql="UPDATE member_list SET name='$name', email='$email', phone='$phone', password='$password', born_date='$born_date', invoice='$invoice' WHERE id=$id";
var_dump($sql);


if($conn->query($sql)===TRUE){
    $_SESSION['message'] = '編輯資料成功';
}else{
    echo "更新資料錯誤: ". $conn->error;
}

$conn->close();

header("location: member_data.php?id=$id");