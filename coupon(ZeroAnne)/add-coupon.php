<?php
session_start();
session_destroy();
require_once("../connect_server.php");
$sqlActivity = "SELECT * FROM activity_category ";
$resultActivity = $conn->query($sqlActivity);
$rowsActivity = $resultActivity->fetch_all(MYSQLI_ASSOC);
// var_dump($rows)
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>新增優惠券</title>

    <!-- 公用head -->
    <?php include('../public_head.php') ?>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include('../sidebar.php'); ?>
        
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include('../topbar.php'); ?>

                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between pt-3 mb-4 mx-4">
                        <div class="d-flex align-items-end">
                            <h1 class="h3 mb-0 text-gray-800 font-weight-bolder">新增優惠券</h1>
                            <!-- session -->
                            <?php if (isset($_SESSION["error"]["message"])) : ?>
                                <div class="ms-3 px-2 alert-danger text-danger" role="alert"><?= $_SESSION["error"]["message"] ?></div>
                            <?php endif; ?>
                            <!-- session -->
                        </div>
                        <a href="coupon-list.php?page=1&order=1" class="text-primary d-flex align-items-center">
                            <div>
                                回優惠券列表
                            </div>
                            <i class="bi bi-box-arrow-right fs-4 ms-3"></i>
                        </a>
                    </div>
                    <div class="mx-4 animate__animated animate__fadeIn animate__faster">
                        <form action="doAddCoupon.php" method="post">
                            <div class="row mb-3">
                                <label for="name" class="col-sm-2 col-form-label">優惠券名稱</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="例 : 清涼優惠" value="<?= isset($_SESSION['error']['filledData']['name']) ? $_SESSION['error']['filledData']['name'] : '' ?>" require>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="code" class="col-sm-2 col-form-label">兌換代碼</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="code" name="code" placeholder="例: ABC1234" require>
                                    <div id="passwordHelpBlock" class="form-text">
                                        (自定義前三個字母後四個數字)
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <span type="button" class="btn text-primary" id="codebtn">隨機生成一組亂碼</span>
                                </div>
                            </div>
                            <div class="row mb-3 align-items-center">
                                <label for="couponValid" class="col-sm-2 col-form-label">優惠券狀態</label>
                                <div class="col-sm-8">
                                    <div class="row ms-2">
                                        <div class="form-check mb-0 col-3">
                                            <input class="form-check-input" type="radio" name="couponValid" id="couponValid1" value="1" <?= (isset($_SESSION['error']['filledData']['couponValid']) && $_SESSION['error']['filledData']['couponValid'] == 1) ? 'checked' : '' ?> require>
                                            <label class="form-check-label" for="couponValid1">
                                                可使用
                                            </label>
                                        </div>
                                        <div class="form-check mb-0 col-3">
                                            <input class="form-check-input" type="radio" name="couponValid" id="couponValid2" value="2" <?= (isset($_SESSION['error']['filledData']['couponValid']) && $_SESSION['error']['filledData']['couponValid'] == 2) ? 'checked' : '' ?> require>
                                            <label class="form-check-label" for="couponValid0">
                                                已停用
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3 align-items-center">
                                <label for="discountType" class="col-sm-2 col-form-label">折扣類型</label>
                                <div class="col-sm-8">
                                    <div class="row ms-2">
                                        <div class="form-check mb-0 col-3">
                                            <input class="form-check-input" type="radio" name="discountType" id="discountType" value="打折" <?= (isset($_SESSION['error']['filledData']['discountType']) && $_SESSION['error']['filledData']['discountType'] == '打折') ? 'checked' : '' ?> require>
                                            <label class="form-check-label" for="discountType1">
                                                依百分比折扣
                                            </label>
                                        </div>
                                        <div class="form-check mb-0 col-3">
                                            <input class="form-check-input" type="radio" name="discountType" id="discountType" value="金額" <?= (isset($_SESSION['error']['filledData']['discountType']) && $_SESSION['error']['filledData']['discountType'] == '金額') ? 'checked' : '' ?> require>
                                            <label class="form-check-label" for="discountType2">
                                                依金額折價
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="discountValid" class="col-sm-2 col-form-label">優惠券百分比折扣<br>/金額折價</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="discountValid" name="discountValid" placeholder="優惠券百分比折扣/金額折價 例:0.75/50" value="<?= isset($_SESSION['error']['filledData']['discountValid']) ? $_SESSION['error']['filledData']['discountValid'] : '' ?>" require>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="startAt" class="col-sm-2 col-form-label">開始日期</label>
                                <div class="col-sm-4">
                                    <input type="date" class="form-control" id="startAt" name="startAt" value="<?= isset($_SESSION['error']['filledData']['startAt']) ? $_SESSION['error']['filledData']['startAt'] : '' ?>" onchange="updateCouponStatus(this)" require>
                                </div>
                                <label for="expiresAt" class="col-sm-2 col-form-label">到期日期</label>
                                <div class="col-sm-4">
                                    <input type="date" class="form-control" id="expiresAt" name="expiresAt" value="<?= isset($_SESSION['error']['filledData']['expiresAt']) ? $_SESSION['error']['filledData']['expiresAt'] : '' ?>" onchange="updateCouponStatus(this)" require>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="priceMin" class="col-sm-2 col-form-label">最低消費金額</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="priceMin" name="priceMin" value="<?= isset($_SESSION['error']['filledData']['priceMin']) ? $_SESSION['error']['filledData']['priceMin'] : '' ?>" require>
                                </div>
                                <label for="maxUsage" class="col-sm-2 col-form-label">可使用張數</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="maxUsage" name="maxUsage" value="<?= isset($_SESSION['error']['filledData']['maxUsage']) ? $_SESSION['error']['filledData']['maxUsage'] : '' ?>" require>
                                </div>
                            </div>
                            <div class="row mb-3 ">
                                <label for="activityNum" class="col-form-label col-sm-2">活動類型</label>
                                <div class="col-sm-10">
                                    <select class="form-select" id="" name="activityNum">
                                        <?php foreach ($rowsActivity as $rowActivity) : ?>
                                            <option name="activity<?= $rowActivity["id"] ?>" value="<?= $rowActivity["id"] ?>" <?= isset($_SESSION['error']['filledData']['activityNum']) && $_SESSION['error']['filledData']['activityNum'] == $rowActivity["id"] ? 'selected' : '' ?>><?= $rowActivity["activity_name"] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <button class="btn btn-primary" type="submit">送出</button>
                        </form>
                    </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; GOVENT 2023</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>
    <?php include('../public-js.php') ?>
    <script>
        // 生成多个随机字母
        function generateRandomLetters(length) {
            const letters = Array.from({
                length: 26
            }, (_, i) => String.fromCharCode('A'.charCodeAt(0) + i));
            let randomLettersString = '';

            for (let i = 0; i < length; i++) {
                const randomLetter = letters[Math.floor(Math.random() * letters.length)];
                randomLettersString += randomLetter;
            }

            return randomLettersString;
        }

        // 生成多个随机数字
        function generateRandomNumbers(length) {
            const numbers = Array.from({
                length: 2
            }, (_, i) => (i + 1).toString());
            let numberString = '';

            for (let i = 0; i < length; i++) {
                const randomNumber = numbers[Math.floor(Math.random() * numbers.length)];
                numberString += randomNumber;
            }

            return numberString;
        }

        // 生成随机代码
        function generateRandomCode() {
            const numberOfRandomLetters = 3;
            const numberOfRandomNumbers = 4;

            const randomLettersString = generateRandomLetters(numberOfRandomLetters);
            const numberString = generateRandomNumbers(numberOfRandomNumbers);

            const codeRandom = randomLettersString + numberString;
            console.log(codeRandom);
            document.getElementById('code').value = codeRandom;
        }
        document.getElementById('codebtn').addEventListener('click', generateRandomCode);
        // 示例调用
        generateRandomCode();
    </script>
    <script>
        // 函數：根據到期日期更新優惠券狀態
        function updateCouponStatus(dateInput) {
            // 從 HTML 元素中獲取日期
            let expirationDate = document.getElementById("expiresAt").value;
            let startDate = document.getElementById("startAt").value;
            if (!expirationDate) {
                return;
            }
            // 將日期轉換為時間戳
            let expirationTimestamp = new Date(expirationDate).getTime();
            let startTimestamp = new Date(startDate).getTime();
            // 獲取當前時間戳
            let currentTimestamp = new Date().getTime();

            // 比較時間戳並更新優惠券狀態
            if (expirationTimestamp < currentTimestamp || startTimestamp > currentTimestamp) {
                // 優惠券已過期
                document.getElementById("couponValid2").checked = true;
            } else {
                // 優惠券仍然有效
                document.getElementById("couponValid1").checked = true;
            }
        }

        // 在頁面加載時調用該函數
        window.onload = updateCouponStatus;
    </script>

</body>

</html>