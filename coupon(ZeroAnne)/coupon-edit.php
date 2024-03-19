<?php
session_start();
session_destroy();
if (!isset($_GET["id"])) {
    header("location: coupon-list.php");
}
$id = $_GET["id"];
require_once("../connect_server.php");

$sql = "SELECT coupon.* ,coupon_valid_name, activity_name 
FROM coupon 
JOIN couponvalid ON coupon.coupon_valid=couponvalid.coupon_valid_id 
JOIN activity_category ON coupon.activity_num=activity_category.id WHERE coupon.id=$id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

//活動類別分類
$sqlActivity = "SELECT * FROM activity_category ";
$resultActivity = $conn->query($sqlActivity);
$rowsActivity = $resultActivity->fetch_all(MYSQLI_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>編輯優惠券</title>

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

                <!-- Begin Page Content -->
                <div class="modal fade" id="alertModal" tabindex="-1" aria-labelledby="" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">警告</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                確認刪除?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">關閉</button>
                                <a href="doDeleteCoupon.php?id=<?= $row["id"] ?>" type="button" class="btn btn-danger">確定刪除</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between pt-3 mx-4 mb-4">
                        <div class="d-flex">
                            <h1 class="h3 mb-0 text-gray-800 font-weight-bolder">編輯優惠券</h1>
                            <!-- session -->
                            <?php if (isset($_SESSION["error"]["message"])) : ?>
                                <div class="ms-3 px-2 alert-danger text-danger d-flex align-items-center rounded" role="alert"><?= $_SESSION["error"]["message"] ?></div>
                            <?php endif; ?>
                            <!-- session -->
                        </div>
                        <a href="coupon-list.php?page=1&order=1" class="text-primary d-flex align-items-center">
                            <div>
                                回編輯列表
                            </div>
                            <i class="bi bi-box-arrow-right fs-4 ms-3"></i>
                        </a>
                    </div>
                    <div class="mx-4">
                        <form action="doUpdateCoupon.php" method="post">
                            <input type="hidden" name="id" value="<?= $row["id"] ?> ">

                            <div class="row mb-3 align-items-center">
                                <div class="col-sm-2">
                                    <label for="code" class="col-form-label">ID</label>
                                </div>
                                <div class="col-sm-8">
                                    <div class=""><?= $row["id"] ?></div>
                                </div>
                            </div>
                            <div class="row mb-3 align-items-center">
                                <div class="col-sm-2">
                                    <label for="name" class="col-form-label">優惠券名稱</label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="name" name="name" value="<?php if (isset($_SESSION["error"]["filledData"])) : echo $_SESSION["error"]["filledData"]["name"];
                                                                                                            else : echo $row["coupon_name"];
                                                                                                            endif; ?>">
                                </div>
                            </div>
                            <div class="row mb-3 align-items-center">
                                <div class="col-sm-2">
                                    <label for="code" class="col-form-label">兌換代碼</label>
                                </div>
                                <div class="col-sm-8">
                                    <div class=""><?= $row["coupon_code"] ?></div>
                                </div>
                            </div>
                            <div class="row mb-3 align-items-center">
                                <div class="col-sm-2">
                                    <label for="couponValid" class="col-form-label">優惠券狀態</label>
                                </div>
                                <div class="col-sm-8">
                                    <div class="row ps-3">
                                        <div class="col-3 form-check">
                                            <input class="form-check-input" type="radio" name="couponValid" id="couponValid1" value="1">
                                            <label class="form-check-label" for="couponValid1">
                                                可使用
                                            </label>
                                        </div>
                                        <div class="col-3 form-check">
                                            <input class="form-check-input" type="radio" name="couponValid" id="couponValid2" value="2">
                                            已停用
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3 align-items-center">
                                <div class="col-sm-2">
                                    <label for="discountType" class="col-form-label">折扣類型</label>
                                </div>
                                <div class="col-sm-8">
                                    <div class="row ps-3">
                                        <div class="form-check col-3">
                                            <input class="form-check-input" type="radio" name="discountType" id="discountType" value="打折" <?php if ($row["discount_type"] == "打折") echo "checked" ?>>
                                            <label class="form-check-label" for="discountType1">
                                                依百分比折扣
                                            </label>
                                        </div>
                                        <div class="form-check col-3">
                                            <input class="form-check-input" type="radio" name="discountType" id="discountType" value="金額" <?php if ($row["discount_type"] == "金額") echo "checked" ?>>
                                            <label class="form-check-label" for="discountType2">
                                                依金額折價
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="discountValid" class="col-sm-2 col-form-label text-nowrap">百分比折扣/金額折價</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="discountValid" name="discountValid" value="<?php if (isset($_SESSION["error"]["filledData"])) : echo $_SESSION["error"]["filledData"]["discountValid"];
                                                                                                                            else : echo $row["discount_valid"];
                                                                                                                            endif; ?>">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="startAt" class="col-sm-2 col-form-label">開始日期</label>
                                <div class="col-sm-4">
                                    <input type="date" class="form-control" id="startAt" name="startAt" value="<?php if (isset($_SESSION["error"]["filledData"])) : echo $_SESSION["error"]["filledData"]["startAt"];
                                                                                                                else : echo $row["start_at"];
                                                                                                                endif; ?>" onchange="updateCouponStatus(this)">
                                </div>
                                <label for="expiresAt" class="col-sm-2 col-form-label">到期日期</label>
                                <div class="col-sm-4">
                                    <input type="date" class="form-control" id="expiresAt" name="expiresAt" value="<?php if (isset($_SESSION["error"]["filledData"])) : echo $_SESSION["error"]["filledData"]["expiresAt"];
                                                                                                                    else : echo $row["expires_at"];
                                                                                                                    endif; ?>" onchange="updateCouponStatus(this)">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="priceMin" class="col-sm-2 col-form-label">最低消費金額</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="priceMin" name="priceMin" value="<?php if (isset($_SESSION["error"]["filledData"])) : echo $_SESSION["error"]["filledData"]["priceMin"];
                                                                                                                    else : echo $row["price_min"];
                                                                                                                    endif; ?>">
                                </div>
                                <label for="maxUsage" class="col-sm-2 col-form-label">可使用張數</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="priceMin" name="maxUsage" value="<?php if (isset($_SESSION["error"]["filledData"])) : echo $_SESSION["error"]["filledData"]["maxUsage"];
                                                                                                                    else : echo $row["max_usage"];
                                                                                                                    endif; ?>">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-2">
                                    <label for="activityNum" class="col-form-label">活動類型</label>
                                </div>
                                <div class="col-sm-10">
                                    <select class="form-select" id="" name="activityNum">
                                        <?php foreach ($rowsActivity as $rowActivity) : ?>
                                            <option name="activity<?= $rowActivity["id"] ?>" value="<?= $rowActivity["id"] ?>" <?php if ($row["activity_num"] == $rowActivity["id"]) echo "selected" ?>><?= $rowActivity["activity_name"] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div>
                                    <button class="btn btn-primary" type="submit">儲存</button>
                                    <a class="btn btn-primary" href="coupon-list.php?page=1&order=1">取消</a>
                                </div>
                                <button type="button" data-bs-toggle="modal" data-bs-target="#alertModal" class="btn btn-danger">刪除</button>
                            </div>
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
    <!-- Custom scripts for this template-->
    <?php include('../public-js.php') ?>
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