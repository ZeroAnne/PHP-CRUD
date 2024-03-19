<?php

session_start();

require_once("../connect_server.php");

if(!isset($_POST["ticketName"])){
    header("location: 404.php");
    die;
}

$ticket_type_id=$_POST["seat"];
$category_id=$_POST["ticketType"];
$name=$_POST["ticketName"];
$price=$_POST["ticketPrice"];
$max_quantity=$_POST["ticketTotal"];
$remaining_quantity=$_POST["ticketTotal"];
$time=date("Y-m-d H:i:s");

$sql="SELECT event_id FROM ticket_type 
WHERE category_id=$category_id ORDER BY event_id DESC LIMIT 1";
$result=$conn->query($sql);

$lastEvent = $result->fetch_assoc();

// echo $lastEvent;
// echo $category_id;
// var_dump($lastEvent);

if($lastEvent==null){
    $lastEvent=$category_id*100;
    $eventId = $lastEvent + 1;
}else{
    $eventId = $lastEvent['event_id'] + 1;
}

// echo $eventId;

// var_dump($ventId);
echo "$ticket_type_id, $category_id, $name, $price, $max_quantity, $remaining_quantity, $eventId";

$insertSql ="INSERT INTO ticket_type (ticket_type_id, category_id, event_id, name, price, max_quantity, remaining_quantity, created_at, valid)
VALUES ('$ticket_type_id', '$category_id', '$eventId','$name', '$price', '$max_quantity', '$remaining_quantity', '$time', 2)";

echo $sql;

if ($conn->query($insertSql) === TRUE) {
    $_SESSION['message'] = "新增票卷資料成功";
    $last_id = $conn->insert_id;
    $_SESSION['addId'] = $last_id;
    // echo "最新一筆為序號".$last_id;

} else {
    $_SESSION['message'] = "新增資料錯誤" . $conn->error;
}

$sqlTotal = "SELECT * from ticket_type WHERE valid = '2'";
$resultPage = $conn->query($sqlTotal);
$pageTotalCount = $resultPage->num_rows;

$perPage = 8;
$pageCount = ceil($pageTotalCount / $perPage);

$conn->close();

header("location:ticket-list.php?page=$pageCount");

?>