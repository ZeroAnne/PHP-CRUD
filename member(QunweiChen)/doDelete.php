<?php
require_once("../connect_server.php");

session_start();

if(!isset($_GET["id"])){
    echo "請循正常管道進入此頁";
    exit;
}

$id=$_GET["id"];
// $id="512";


// var_dump($name, $email, $phone);

$sql="UPDATE member_list SET valid='0' WHERE id=$id";
// var_dump($sql);


if($conn->query($sql)===TRUE){
    $_SESSION['message'] = '刪除成功';
}else{
    $_SESSION['message'] = '刪除失敗';
}

$conn->close();

header("location: member_list.php");