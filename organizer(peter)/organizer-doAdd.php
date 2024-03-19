<?php
require_once("../connect_server.php");

session_start();

date_default_timezone_set("Asia/Taipei");

$userId = $_POST["userId"];
$organizerType = $_POST["organizerType"];
$name = $_POST["name"];
$businessName = $_POST["businessName"];
$businessInvoice = $_POST["businessInvoice"];
$bankName = $_POST["bankName"];
$bankCode = $_POST["bankCode"];
$bankBranch = $_POST["bankBranch"];
$amountNumber = $_POST["amountNumber"];

$currentDateTime = date("Y-m-d H:i:s");

// echo "organizerType: " . $organizerType . "<br/>";
// echo "name: " . $name . "<br/>";
// echo "businessName: " . $businessName . "<br/>";
// echo "businessInvoice: " . $businessInvoice . "<br/>";
// echo "bankName: " . $bankName . "<br/>";
// echo "bankCode: " . $bankCode . "<br/>";
// echo "bankBranch: " . $bankBranch . "<br/>";
// echo "amountNumber: " . $amountNumber . "<br/>";
// echo $currentDateTime;
// echo "檔案名稱: " . $_FILES["avatar"]["name"] . "<br/>";
// echo "檔案類型: " . $_FILES["avatar"]["type"] . "<br/>";
// echo "檔案大小: " . ($_FILES["avatar"]["size"] / 1024) . " Kb<br />";
// echo "暫存名稱: " . $_FILES["avatar"]["tmp_name"] . "<br/>";
// exit;

// $sqlMemberId = "SELECT user_id FROM organizer";
// $resulitMemberId = $conn -> query($sqlMemberId);
// $rowsMemberId = $resulitMemberId -> fetch_all(MYSQLI_ASSOC);

// 使用預備語句來防止SQL注入攻擊

$sql = "SELECT user_id FROM organizer WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId); // 'i' 表示參數是整數型態

// 執行查詢
$stmt->execute();

// 獲取結果集
$result = $stmt->get_result();

// 判斷是否存在該ID的記錄
// if ($result->num_rows > 0) {
//     echo "ID存在於資料庫中";
// } else {
//     echo "ID不存在於資料庫中";
// }
if ($result->num_rows > 0) {
    $_SESSION['message'] = "資料已存在";
    header("Location: organizer-add.php");
    exit();
} elseif ($_FILES["avatar"]["error"] > 0) { //大於0即為判定上傳成功
    $_SESSION['message'] = "圖片上傳檔案錯誤";
    header("Location: organizer-add.php");
    exit();
}

$extension = explode('.', $_FILES["avatar"]["name"]); //分割
$ext = end($extension); //抓取尾數副檔名

$fileName = md5(uniqid(rand())) . "." . $ext; //產生亂數檔名
$target_path = "organizer_avatar/"; //指定上傳資料夾
$target_path .= $fileName; //合併 檔名 + 副檔名

if (move_uploaded_file(
    $_FILES['avatar']['tmp_name'],
    iconv("UTF-8", "big5", $target_path)
)) {
    if ($_POST["organizerType"] == 0) {
        if (empty($_POST["name"]) || empty($_POST["bankCode"]) || empty($_POST["bankName"]) || empty($_POST["bankBranch"]) || empty($_POST["amountNumber"])) {
            $_SESSION['message'] = "欄位不可為空";
            header("Location: organizer-add.php");
            exit();
        } else {

            // echo $updateType . "個人更新成功";
            $sql = "INSERT INTO organizer (name, user_id, organizer_type, bank_code, bank_name, bank_branch, amount_number, avatar, created_at, update_at, valid)
            VALUES ('$name', '$userId', 0, '$bankCode', '$bankName', '$bankBranch', '$amountNumber', '$fileName', '$currentDateTime', '$currentDateTime', 1)";

            if ($conn->query($sql) === TRUE) {
                $_SESSION['message'] = "新增資料成功";
                $last_id = $conn->insert_id;
                $_SESSION['addId'] = "$last_id";
                header("Location: organizer-profile.php?id=$last_id");
                exit();
            } else {
                $_SESSION['message'] = "新增資料錯誤";
                header("Location: organizer-add.php");
                exit();
            }
            // header("location: organizer-profile.php?id=$id");
            // $conn->close();
        }
    }
    if ($_POST["organizerType"] == 1) {
        if (empty($_POST["name"]) || empty($_POST["bankCode"]) || empty($_POST["bankName"]) || empty($_POST["bankBranch"]) || empty($_POST["amountNumber"])) {
            $_SESSION['message'] = "欄位不可為空";
            header("Location: organizer-add.php");
            exit();
        } else {
            // echo $updateType . "個人更新成功";
            $sql = "INSERT INTO organizer (name, user_id, organizer_type, bank_code, bank_name, bank_branch, amount_number, avatar, business_name, business_invoice, created_at, update_at, valid)
            VALUES ('$name', '$userId', 1, '$bankCode', '$bankName', '$bankBranch', '$amountNumber', '$fileName', '$businessName', '$businessInvoice', '$currentDateTime', '$currentDateTime', 1)";

            if ($conn->query($sql) === TRUE) {
                $_SESSION['message'] = "新增資料成功";
                $last_id = $conn->insert_id;
                $_SESSION['addId'] = "$last_id";
                header("Location: organizer-profile.php?id=$last_id");
                exit();
            } else {
                $_SESSION['message'] = "新增資料錯誤";
                header("Location: organizer-add.php");
                exit();
            }
            // header("location: organizer-profile.php?id=$id");
            // $conn->close();
        }
    }
} else {
    $_SESSION['message'] = "新增資料錯誤";
    header("Location: organizer-add.php");
    exit();
}
