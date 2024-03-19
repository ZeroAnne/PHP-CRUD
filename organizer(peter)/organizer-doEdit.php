<?php
require_once("../connect_server.php");

session_start();

if (isset($_POST["updateType"])) {
    $updateType = $_POST["updateType"];
    // echo $updateType;
    // exit;
};
date_default_timezone_set("Asia/Taipei");

$id = $_POST["id"];
$organizerType = $_POST["organizerType"];
$name = $_POST["name"];
$businessName = $_POST["businessName"];
$businessInvoice = $_POST["businessInvoice"];
$bankName = $_POST["bankName"];
$bankCode = $_POST["bankCode"];
$bankBranch = $_POST["bankBranch"];
$amountNumber = $_POST["amountNumber"];

$currentDateTime = date("Y-m-d H:i:s");

// echo "updatetype: ".$updateType . "<br/>";
// echo "id: " . $id . "<br/>";
// echo "name: " . $name . "<br/>";
// echo "businessName: " . $businessName . "<br/>";
// echo "businessInvoice: " . $businessInvoice . "<br/>";
// echo "bankName: " . $bankName . "<br/>";
// echo "bankCode: " . $bankCode . "<br/>";
// echo "bankBranch: " . $bankBranch . "<br/>";
// echo "amountNumber: " . $amountNumber . "<br/>";
// echo $currentDateTime;
// exit;

if (!isset($_POST["id"])) {
    $conn->close();
    header("location: organizer-list.php?");
} elseif ($_POST["updateType"] == 1) {
    if (empty($_POST["name"]) || empty($_POST["businessName"]) || empty($_POST["businessInvoice"]) || empty($_POST["bankCode"]) || empty($_POST["bankName"]) || empty($_POST["bankBranch"]) || empty($_POST["amountNumber"])) {
        $_SESSION['message'] = "欄位不可為空";
        header("Location: organizer-edit.php?id=$id");
        exit();
    } else {
        // echo $updateType . "此為升級成功";
        // exit;
        $sql = "UPDATE organizer SET name = '$name', organizer_type = 1,  business_name = '$businessName', business_invoice = '$businessInvoice', bank_name = '$bankName', bank_code = '$bankCode', bank_branch = '$bankBranch', amount_number = '$amountNumber', update_at = '$currentDateTime' WHERE id = $id";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['message'] = "編輯資料成功";
        } else {
            $_SESSION['message'] = "編輯資料失敗";
        }
        header("Location: organizer-profile.php?id=$id");
        exit();
    }
} elseif ($_POST["organizerType"] == 0) {
    if (empty($_POST["name"]) || empty($_POST["bankCode"]) || empty($_POST["bankName"]) || empty($_POST["bankBranch"]) || empty($_POST["amountNumber"])) {
        $_SESSION['message'] = "欄位不可為空";
        header("Location: organizer-edit.php?id=$id");
        exit();
    } else {
        // echo $updateType . "此為個人編輯成功";
        // exit;
        $sql = "UPDATE organizer SET name = '$name', bank_name = '$bankName', bank_code = '$bankCode', bank_branch = '$bankBranch', amount_number = '$amountNumber', update_at = '$currentDateTime' WHERE id = $id";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['message'] = "編輯資料成功";
        } else {
            $_SESSION['message'] = "編輯資料失敗";
        }
        header("Location: organizer-profile.php?id=$id");
        exit();
    }
} elseif ($_POST["organizerType"] == 1) {
    if (empty($_POST["name"]) || empty($_POST["businessName"]) || empty($_POST["businessInvoice"]) || empty($_POST["bankCode"]) || empty($_POST["bankName"]) || empty($_POST["bankBranch"]) || empty($_POST["amountNumber"])) {
        $_SESSION['message'] = "欄位不可為空";
        header("Location: organizer-edit.php?id=$id");
        exit();
    } else {
        // echo $updateType . "此為企業升級成功";
        // exit;
        $sql = "UPDATE organizer SET name = '$name', business_name = '$businessName', business_invoice = '$businessInvoice', bank_name = '$bankName', bank_code = '$bankCode', bank_branch = '$bankBranch', amount_number = '$amountNumber', update_at = '$currentDateTime' WHERE id = $id";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['message'] = "編輯資料成功";
        } else {
            $_SESSION['message'] = "編輯資料失敗";
        }
        header("Location: organizer-profile.php?id=$id");
        exit();
    }
}
