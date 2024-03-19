<?php
require_once("./db_conntect_govent.php");
session_start();
if (!isset($_POST["name"])) {
    echo "請循正常管道進入此頁";
    exit;
}

$page=$_POST["page"];
$id = $_POST["id"];
if($_POST["startAt"] > $_POST["expiresAt"]){
    $message="請輸入正確日期";
    $_SESSION["error"]["message"]=$message;
    header("location: coupon-edit.php?id=$id");
    exit;
}
$name = $_POST["name"];
$couponValid = $_POST["couponValid"];
$discountType = $_POST["discountType"];
$discountValid = $_POST["discountValid"];
$startAt = $_POST["startAt"];
$expiresAt = $_POST["expiresAt"];
$priceMin = $_POST["priceMin"];
$maxUsage = $_POST["maxUsage"];
$activityNum = $_POST["activityNum"];

if(empty($_POST["name"] && $_POST["couponValid"] && $_POST["discountType"] && $_POST["discountValid"] && $_POST["startAt"] && $_POST["expiresAt"] && $_POST["priceMin"] && $_POST["maxUsage"] && $_POST["activityNum"] )){
    $message="請輸入所有欄位資料";
    $_SESSION["error"]["message"]=$message;
    $_SESSION["error"]["filledData"] = $_POST;
    header("location: coupon-edit.php?id=$id");
    exit;
}

$sql = "UPDATE coupon SET coupon_name='$name', coupon_valid='$couponValid', discount_type='$discountType', 
discount_valid='$discountValid', start_at='$startAt', expires_at='$expiresAt', price_min='$priceMin',  max_usage='$maxUsage', activity_num='$activityNum' 
WHERE id='$id'";

if ($conn->query($sql) === TRUE) {
    $_SESSION['message'] = "編輯資料成功";
} else {
    $_SESSION['message'] = "編輯資料失敗";
}
header("Location: coupon.php?id=$id");
exit();
$conn->close();

// header("location:coupon.php?id=$id");
