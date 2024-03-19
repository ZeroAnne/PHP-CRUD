<?php
require_once("../connect_server.php");

session_start();

if (isset($_POST["add"])) {
    $event_name = mysqli_real_escape_string($conn, $_POST["event_name"]);
    $event_type_id = mysqli_real_escape_string($conn, $_POST["event_type_id"]);
    $start_date = mysqli_real_escape_string($conn, $_POST["start_date"]);
    $end_date = mysqli_real_escape_string($conn, $_POST["end_date"]);
    $address = mysqli_real_escape_string($conn, $_POST["address"]);
    $merchant_id = mysqli_real_escape_string($conn, $_POST["merchant_id"]);

    $images = mysqli_real_escape_string($conn, $_FILES["images"]["name"]);
    //echo $images;
    $temp_image = $_FILES["images"]["tmp_name"];
    //echo $temp_image;
    $image_path = "image/" . $images;
    //echo $image_path;

    if (move_uploaded_file($_FILES["images"]["tmp_name"], $image_path)) {
        echo "檔案 上傳成功!";
    } else {
        echo "檔案上傳失敗，請檢查權限或其他問題。";
    }


    $event_price = mysqli_real_escape_string($conn, $_POST["event_price"]);

    $sql = "INSERT INTO event(event_name,event_type_id, start_date, end_date, address, merchant_id,images,event_price,valid) VALUES('$event_name','$event_type_id','$start_date','$end_date','$address','$merchant_id','$images','$event_price',1)";

    //var_dump($images);
    if (mysqli_query($conn, $sql)) {
        $_SESSION['message'] = "新增資料成功";
        $last_id = $conn->insert_id;
        $_SESSION['addId'] = "$last_id";
    } else {
        $_SESSION['message'] = "新增資料錯誤";
    }
}

$conn->close();

header("location: event.php");
