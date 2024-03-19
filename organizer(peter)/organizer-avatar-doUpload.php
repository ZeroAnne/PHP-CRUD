<?php
require_once("../connect_server.php");

session_start();

$id = $_POST["id"];

if ($_FILES["avatar"]["error"] > 0) { //大於0即為判定上傳成功
    // echo "Error: " . $_FILES["avatar"]["error"];
    $_SESSION['message'] = "更新圖片失敗";
    header("Location: organizer-profile.php?id=$id");
    exit();
} else {
    // echo "id: " . $id . "<br/>";
    // echo "檔案名稱: " . $_FILES["avatar"]["name"] . "<br/>";
    // echo "檔案類型: " . $_FILES["avatar"]["type"] . "<br/>";
    // echo "檔案大小: " . ($_FILES["avatar"]["size"] / 1024) . " Kb<br />";
    // echo "暫存名稱: " . $_FILES["avatar"]["tmp_name"] . "<br/>";

    //在無法判斷檔名是否有中文的情況下，建議使用此方法(iconv( 原來的編碼 , 轉換的編碼 , 轉換的字串 ))避免掉中文檔名無法上傳的問題
    $extension = explode('.', $_FILES["avatar"]["name"]); //分割
    $ext = end($extension); //抓取尾數副檔名

    $fileName = md5(uniqid(rand())) . "." . $ext; //產生亂數檔名
    $target_path = "organizer_avatar/"; //指定上傳資料夾
    $target_path .= $fileName; //合併 檔名 + 副檔名

    if (move_uploaded_file(
        $_FILES['avatar']['tmp_name'],
        iconv("UTF-8", "big5", $target_path)
    )) {
        // echo "檔案：" . $_FILES['organizerAvatar']['name'] . " 上傳成功!";
        // echo $fileName."<br>";
        // echo $target_path;
        $sql = "UPDATE organizer SET avatar = '$fileName' WHERE id = $id";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['message'] = "更新圖片成功";
            header("Location: organizer-profile.php?id=$id");
            exit();
        } else {
            $_SESSION['message'] = "更新圖片失敗";
            header("Location: organizer-profile.php?id=$id");
            exit();
        }
        $conn->close();
    } else {
        $_SESSION['message'] = "更新圖片失敗";
        header("Location: organizer-profile.php?id=$id");
        exit();
    }
}
