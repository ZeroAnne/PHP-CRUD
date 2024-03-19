<?php
$servername = "localhost";
$username = "admin";
$password = "12345";
$dbname = "govent";
    
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// 檢查連線
if ($conn->connect_error) { //物件取得資訊-> 在Js中是用.
  	die("連線失敗: " . $conn->connect_error);
}else{
     //echo "資料庫連線成功";
}

