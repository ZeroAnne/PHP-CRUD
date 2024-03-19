<?php
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
// var_dump($row);


?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>個別優惠券資訊</title>

    <!-- 公用head -->
    <?php include('../public_head.php') ?>

</head>

<body id="page-top">
    <!-- 照結果顯示alert -->
    <?php include('../alert.php'); ?>
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
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between pt-3 mb-4 mx-4">
                        <h1 class="h3 mb-0 text-gray-800 font-weight-bolder">個別優惠券資訊</h1>
                        <a href="coupon-list.php?page=1&order=1" class="text-primary d-flex align-items-center">
                            <div>
                                回優惠券列表
                            </div>
                            <i class="bi bi-box-arrow-right fs-4 ms-3"></i>
                        </a>
                    </div>
                    <div class="mx-4 animate__animated animate__fadeIn animate__faster">
                        <table class="table table-bordered ">
                            <tr>
                                <th>ID</th>
                                <td colspan="3"><?= $row["id"] ?></td>
                            </tr>
                            <tr>
                                <th>優惠券名稱</th>
                                <td><?= $row["coupon_name"] ?></td>
                                <th>兌換代碼</th>
                                <td><?= $row["coupon_code"] ?></td>
                            </tr>
                            <tr>
                                <th>使用狀態</th>
                                <td colspan="3"><?= $row["coupon_valid_name"] ?></td>
                            </tr>
                            <tr>
                                <th>折扣類型</th>
                                <td><?= $row["discount_type"] ?></td>
                                <th>打折/金額折價</th>
                                <td><?= $row["discount_valid"] ?></td>
                            </tr>
                            <tr>
                                <th>開始日期</th>
                                <td><?= $row["start_at"] ?></td>
                                <th>到期日期</th>
                                <td><?= $row["expires_at"] ?></td>
                            </tr>
                            <tr>
                                <th>最低消費</th>
                                <td colspan="3"><?= $row["price_min"] ?></td>
                            </tr>
                            <tr>
                                <th>剩餘張數</th>
                                <td colspan="3"><?= $row["max_usage"] ?></td>
                            </tr>
                            <tr>
                                <th>適用活動</th>
                                <td colspan="3"><?= $row["activity_name"] ?></td>
                            </tr>
                        </table>
                        <div class="py-1">
                            <a href="coupon-edit.php?id=<?= $row["id"] ?>" class="btn text-primary btn-lg" title="編輯資料"><i class="bi bi-pencil-fill"></i>編輯修改</a>
                        </div>
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

</body>

</html>