<?php
require_once("../connect_server.php");

session_start();

$name = $_POST["name"];
$userid = $_POST["ID"];
//user資料庫
$userSql = "SELECT member_list.id,member_list.name FROM member_list";
$userResult = $conn->query($userSql);
$userRows = $userResult->fetch_all(MYSQLI_ASSOC);
//user_order資料庫
$userOrderSql = "SELECT user_order.user_id FROM user_order";
$userOrderResult = $conn->query($userOrderSql);
$userOrderRows = $userOrderResult->fetch_all(MYSQLI_ASSOC);

$changeUserID = '';
foreach ($userRows as $row) {
    if ($row['name'] == $name) {
        $userExists = true;
        $changeUserID = $row["id"];
        break;
    } else {
        $userExists = false;
    }
};

if ($userExists) {
    $sql = "UPDATE user_order SET user_id ='$changeUserID' WHERE id =$userid ";
} else {
    $_SESSION['message'] = "使用者不存在";
    header("location:change-order.php?id=$userid");
    exit;
}


if ($conn->query($sql) === TRUE) {
    $_SESSION['message'] = "編輯資料成功";
    header("location:change-order.php?id=$userid");
    exit;
} else {
    $_SESSION['message'] = "編輯資料失敗";
    header("location:change-order.php?id=$userid");
    exit;
}
$conn->close();
header("location:change-order.php?id=$userid");
