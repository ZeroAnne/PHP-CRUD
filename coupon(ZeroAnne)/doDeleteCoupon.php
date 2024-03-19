<?php
require_once("../connect_server.php");
session_start();

if (!isset($_GET["id"])) {
    echo "請循正常管道進入此頁";
    die;
}
$id = $_GET["id"];
$search = $_GET["search"];

$sql = "UPDATE coupon SET coupon_valid='-1' WHERE id=$id";
// echo $sql;
// exit;
if(isset($_GET["search"])){
    $search=$_GET["search"];
    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "刪除成功";
        header("Location: coupon-list.php?search=$search");
        exit();
    } else {
        $_SESSION['message'] = "刪除失敗";
        header("Location: coupon-list.php?search=$search");
        exit();
    }
}elseif(isset($_GET["page"]) && isset($_GET["order"])){
    $page=$_GET["page"];
    $order=$_GET["order"];
    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "刪除成功";
        header("Location: coupon-list.php?page=$page&order=$order");
        exit();
    } else {
        $_SESSION['message'] = "刪除失敗";
        header("Location: coupon-list.php?page=1&order=1");
        exit();
    }
}elseif(isset($_GET["page"]) && isset($_GET["order"]) && isset($_GET["use"])){
    if ($conn->query($sql) === TRUE) {
        $page=$_GET["page"];
        $use=$_GET["use"];
        $order=$_GET["order"];
        
        $_SESSION['message'] = "刪除成功";
        header("Location: coupon-list.php?page=$page&use=$use&order=$order");
        exit();
    } else {
        $_SESSION['message'] = "刪除失敗";
        header("Location: coupon-list.php?page=1&order=1");
        exit();
    }
}
else{
    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "刪除成功";
        header("Location: coupon-list.php?page=1&order=1");
        exit();
    } else {
        $_SESSION['message'] = "刪除失敗";
        header("Location: coupon-list.php?page=1&order=1");
        exit();
    }
}


$conn->close();

// if (isset($_GET["use"])) {
//     $use = $_GET["use"];
//     header("location:coupon-list.php?page=$page&order=$order&use=$use");
// } elseif(isset($_GET["page"]) && $_GET["order"] ) {
//     $page = $_GET["page"];
//     $order = $_GET["order"];
//     header("location:coupon-list.php?page=$page&order=$order");
// }else{
//         $search = $_GET["search"];
//         var_dump($search);
//         header("location:coupon-list.php?page=1&order=1");
// }
