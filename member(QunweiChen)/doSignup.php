<?php
require_once("../connect_server.php");
session_start();

// // 檢查是否有 POST 資料
// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     // 檢查是否存在名為 "address" 的 POST 變數
//     if (isset($_POST["address"])) {
//         // 獲取選擇的地址的 ID
//         $selectedAddressId = $_POST["address"];
        
//         // 在這裡進行相應的處理，比如查詢資料庫或其他操作
//         echo "選擇的地址 ID 是：" . $selectedAddressId;
//     } else {
//         echo "未找到名為 'address' 的 POST 變數。";
//     }
// }

$_SESSION["error"]["filledData"] = $_POST;

$name=$_POST["name"];
$email=$_POST["email"];
$password=$_POST["password"];
$repassword=$_POST["repassword"];
$phone=$_POST["phone"];
$national_id=$_POST["national_id"];
$address=$_POST["address"];
$gender=$_POST["gender"];
$born_date=$_POST["born_date"];
$invoice=$_POST["invoice"];
$valid="1";

// var_dump($name, $email, $password, $repassword, $address, $gender );

if(empty($name)||empty($email)||empty($password)||empty($repassword)||empty($phone)||empty($national_id)||empty($born_date)||empty($invoice)){
    // echo "請輸入必填欄位";
    $message="請輸入所有欄位";
    $_SESSION["error"]["message"]=$message;
    header("location: member_signup.php");
    exit;
}

if($address<=0){
    $message="請選擇居住地";
    $_SESSION["error"]["message"]=$message;
    header("location: member_signup.php");
    exit;
}

if($password!=$repassword){
    // echo "前後密碼不一致";
    $message="前後密碼不一致";
    $_SESSION["error"]["message"]=$message;
    header("location: member_signup.php");
    exit;
}

$sql="SELECT * FROM member_list WHERE email='$email'";
$result=$conn->query($sql);
$rowCount=$result->num_rows;
if($rowCount>0){
    // die("此email已被註冊");
    $message="此email已被註冊";
    $_SESSION["error"]["message"]=$message;
    header("location: member_signup.php");
    exit;
}

$time=date('Y-m-d H-i-s');
$sqlUser="INSERT INTO member_list (name, email, password, phone, national_id, address, gender, born_date, invoice, created_at, member_leval, valid)
VALUES ('$name', '$email', '$password', '$phone', '$national_id', '$address', '$gender', '$born_date', '$invoice', '$time', 1, 1)";
// var_dump($sqlUser);
// $resultUser=$conn->query($sqlUser);//造成重複寫入

if($conn->query($sqlUser) === TRUE){
    // echo "註冊完成 ";
    // $last_id=$conn -> insert_id;
    // echo "id序號為".$last_id;

    // 註冊完成後引導的登入畫面
    // $resultMessage= "註冊完成, id序號為" . $conn->insert_id;
    $resultMessage= "註冊完成";
    header("location: member_login.php?messageSuccess=" . urldecode($resultMessage));
    exit;
}else{
    echo "註冊失敗 錯誤碼：". $conn->error;
}
// var_dump($messageA);

