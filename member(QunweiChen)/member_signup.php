<?php

session_start();
session_destroy();
if (isset($_SESSION["member"])) {
    // header("location: member_dashboard.php");
    //若已登入 導入至dashboard
}

// 拉取地址資歷庫
require_once("../connect_server.php");
$sql = "SELECT * FROM city";
$result = $conn->query($sql);
// var_dump($result);

if ($result->num_rows > 0) {
    $addresses = $result->fetch_all(MYSQLI_ASSOC);
    // echo "成功";
}
$conn->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title> Sign Up</title>

    <?php include('../public_head.php') ?>

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5 animate__animated animate__fadeIn animate__faster">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4 font-weight-bolder">註冊新帳號</h1>
                            </div>
                            <form action="doSignup.php" method="post" class="user">
                                <!-- name -->
                                <!-- <label>姓名</label> -->
                                <div class="form-group">
                                    <!-- <div class="col-sm-6 mb-3 mb-sm-0"> -->
                                    <input type="text" name="name" class="form-control form-control-user" id="exampleName" placeholder="姓名" maxlength="50" value="<?= isset($_SESSION['error']['filledData']['name']) ? $_SESSION['error']['filledData']['name'] : '' ?>">
                                    <!-- </div> -->
                                    <!-- <div class="col-sm-6">
                                        <input type="text" class="form-control form-control-user" id="exampleLastName"
                                            placeholder="Last Name">
                                    </div> -->
                                </div>
                                <!-- email -->
                                <!-- <label>Email</label> -->
                                <div class="form-group">
                                    <input name="email" type="email" class="form-control form-control-user" id="exampleInputEmail" placeholder="Email" maxlength="50" value="<?= isset($_SESSION['error']['filledData']['email']) ? $_SESSION['error']['filledData']['email'] : '' ?>">
                                </div>
                                <!-- phone -->
                                <!-- <label>phone</label> -->
                                <div class="form-group">
                                    <input name="phone" type="text" class="form-control form-control-user" id="exampleInputPhone" placeholder="電話" maxlength="10" value="<?= isset($_SESSION['error']['filledData']['phone']) ? $_SESSION['error']['filledData']['phone'] : '' ?>">
                                </div>

                                <!-- password -->
                                <!-- <label>密碼</label> -->
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input name="password" type="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="密碼" maxlength="50" value="<?= isset($_SESSION['error']['filledData']['password']) ? $_SESSION['error']['filledData']['password'] : '' ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input name="repassword" type="password" class="form-control form-control-user" id="exampleRepeatPassword" placeholder="密碼確認" maxlength="50" value="<?= isset($_SESSION['error']['filledData']['repassword']) ? $_SESSION['error']['filledData']['repassword'] : '' ?>">
                                    </div>
                                </div>

                                <!-- national ID -->
                                <!-- <label>身分證</label> -->
                                <div class="form-group row px-2">
                                    <input name="national_id" type="text" class="form-control form-control-user col-7" id="exampleInputId" placeholder="身分證" maxlength="10" value="<?= isset($_SESSION['error']['filledData']['national_id']) ? $_SESSION['error']['filledData']['national_id'] : '' ?>">
                                    <!-- gender -->
                                    <div class="col p-0 me-1 ms-4">
                                        <div class="border rounded-pill">
                                            <div class="d-flex align-items-center" style="padding-block: 12px;">
                                                <div class="ps-5">
                                                    <input name="gender" type="radio" class="form-check-input text-gray-700 border-secondary" id="exampleInputGender" value="2" checked>
                                                    <label class="text-gray-700 m-0 small">女性</label>
                                                </div>
                                                <div class="ps-5">
                                                    <input name="gender" type="radio" class="form-check-input text-gray-700 border-secondary" id="exampleInputGender" value="1">
                                                    <label class="text-gray-700 m-0 small">男性</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- address -->
                                <!-- <label class="col">居住地</label> -->
                                <div class="form-group">
                                    <!-- <label class="col-3">居住地</label> -->
                                    <select type="text" name="address" class="input-group-text form-control-user col bg-white small text-start" style="padding: 14px; appearance: none" id="address" placeholder="居住地">
                                        <?php foreach ($addresses as $address) : ?>
                                            <option value="<?= $address["city_id"]; ?>">
                                                <?= $address["city_name"]; ?>／<?= $address["dist_name"]; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>

                                </div>

                                <!-- born date -->
                                <!-- <label>出生日期</label> -->
                                <div class="form-group">
                                    <input name="born_date" type="date" class="form-control form-control-user" id="exampleInputEmail" placeholder="出生日期" value="<?= isset($_SESSION['error']['filledData']['born_date']) ? $_SESSION['error']['filledData']['born_date'] : '' ?>">
                                </div>
                                <!-- invoice -->
                                <!-- <label>電子發票</label> -->
                                <div class="form-group">
                                    <input name="invoice" type="text" class="form-control form-control-user" id="exampleInputEmail" placeholder="電子發票" maxlength="8" value="<?= isset($_SESSION['error']['filledData']['invoice']) ? $_SESSION['error']['filledData']['invoice'] : '' ?>">
                                </div>
                                <?php if (isset($_SESSION["error"]["message"])) : ?>
                                    <div class="mt-2 text-danger">
                                        <?= $_SESSION["error"]["message"] ?>
                                    </div>
                                <?php endif; ?>
                                <button type="submit" href="#" class="btn btn-primary btn-user btn-block">
                                    註冊新帳號
                                </button>
                                <!-- <hr>
                                <a href="index.html" class="btn btn-google btn-user btn-block">
                                    <i class="fab fa-google fa-fw"></i> 透過 google 註冊
                                </a>
                                <a href="index.html" class="btn btn-facebook btn-user btn-block">
                                    <i class="fab fa-facebook-f fa-fw"></i> 透過 Facebook 註冊
                                </a> -->
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="member_login.php">已經有帳號？登入！</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <?php include('../public-js.php') ?>

</body>

</html>