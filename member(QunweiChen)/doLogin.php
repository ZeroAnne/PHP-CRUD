<?php
require_once("../connect_server.php");
session_start();


if(!isset($_POST["email"])){
    // echo "請循正常管道進入此頁";
    // header("location: member_login.php");//引導至login
    exit;
}

$_SESSION["error"]["filledData"] = $_POST;

$email=$_POST["email"];
$password=$_POST["password"];

// $password=md5($password);//
// var_dump($email, $password);

if(empty($email)){
    $message="請輸入email";
    $_SESSION["error"]["message"]=$message;
    header("location: member_login.php");
    exit;
}
if(empty($password)){
    $message="請輸入密碼";
    $_SESSION["error"]["message"]=$message;
    header("location: member_login.php");
    exit;
}


$sql="SELECT * FROM member_list WHERE valid=1 AND email='$email' AND password = '$password' ";

// $sql="SELECT * FROM member_list WHERE valid=1 AND email='$email'";

// var_dump($sql);

$result=$conn->query($sql);
// $rows=$result->fetch_all(MYSQLI_ASSOC);

var_dump($rows);

if($result->num_rows==0){
    if(isset($_SESSION["error"]["times"])){
        $_SESSION["error"]["times"]++;
    }else{
        $_SESSION["error"]["times"]=1;
    }
    $message="帳號密碼錯誤";
    $_SESSION["error"]["message"]=$message;
    // echo "登錄失敗";
    header("location: member_login.php");
    exit;
}else{
    // echo "登入成功";
    // header("location: member_dashboard.php");
};

$rows=$result->fetch_all(MYSQLI_ASSOC);
$_SESSION["member"]=$rows;
unset($_SESSION["error"]);
header("location: member_list.php");


?>

