<?php
require_once("../connect_server.php");

$id = $_GET['id'];
// var_dump($id);
//活動種類資料庫
$sqlCategory = "SELECT * FROM event_category";
$resultCategory = $conn->query($sqlCategory);
$rowsCategory = $resultCategory->fetch_all(MYSQLI_ASSOC);
// 票券資訊資料庫
$sql = "SELECT user_order.*, campaign.*, organizer.*, user_order.valid AS user_order_valid, organizer.valid AS organizer_valid, ticket.qr_code, member_list.name, event_category.event_name AS event_category_name, organizer.id AS organizer_id,user_order.id AS user_order_id, organizer.name AS organizer_name
FROM user_order
JOIN campaign ON campaign.id = user_order.event_id
JOIN ticket ON ticket.id = user_order.ticket_number
JOIN member_list ON member_list.id = user_order.user_id
JOIN event_category ON event_category.id = campaign.event_type_id
JOIN organizer ON organizer.id = campaign.merchant_id
WHERE user_order.id = $id";
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

    <title>編輯頁面</title>

    <?php include('../public_head.php') ?>

</head>

<body id="page-top">
    <!-- 照結果顯示alert -->
    <?php include('../alert.php'); ?>
    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- SideBar -->
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
                    <div class="d-sm-flex align-items-center pt-3 mb-4 mx-4">
                        <h1 class="h3 mb-0 text-gray-800 font-weight-bolder me-3">編輯訂單</h1>
                    </div>

                    <!-- Content Row -->
                    <form class="row g-3 mx-3 needs-validation" action="do-change-order.php
                    " method="post" novalidate>
                        <input type="hidden" name="ID" value="<?= $row['user_order_id'] ?>">
                        <div class="col-md-4">
                            <label for="validationCustom01" class="form-label">使用者</label>
                            <input name="name" type="text" class="form-control" id="validationCustom01" value="<?= $row['name'] ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label for="validationCustom02" class="form-label">活動名稱</label>
                            <input name="event_name" type="text" class="form-control" id="validationCustom02" value="<?= $row['event_name'] ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label for="validationCustomUsername" class="form-label">主辦單位</label>
                            <div class="input-group has-validation">
                                <input type="text" class="form-control" id="validationCustomUsername" aria-describedby="inputGroupPrepend" value="<?= $row['organizer_name'] ?>" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="validationCustom04" class="form-label">票種</label>
                            <select class="form-select" id="validationCustom04" required>
                                <option selected disabled value=""><?= $row['event_category_name'] ?></option>
                                <?php foreach ($rowsCategory as $rowCategory) : ?>
                                    <option><?= $rowCategory['event_name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="validationCustom05" class="form-label">價格</label>
                            <input type="text" class="form-control" id="validationCustom05" value="<?= $row['event_price'] ?>" required>
                        </div>
                        <div class="col-12 ">
                            <button class="btn btn-primary" type="submit">修改</button>
                            <a class="btn btn-primary" href="index-Abo.php">取消</a></a>
                        </div>
                    </form>
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