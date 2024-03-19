<?php
require_once("../connect_server.php");

if (!isset($_GET["id"])) {
    header("location: organizer-list.php");
}
$id = $_GET["id"];

if (isset($_GET["updateType"])) {
    $updateType = $_GET["updateType"];
}

$sql = "SELECT organizer.*, member_list.name AS user_name, member_list.email AS user_email, member_list.phone AS user_phone FROM organizer
JOIN member_list ON organizer.user_id = member_list.id WHERE organizer.id = $id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>主辦單位資料</title>

    <!-- 公用head -->
    <?php include('../public_head.php') ?>

    <link href="organizer.css" rel="stylesheet">

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

                    <form action="organizer-doEdit.php" method="post" enctype="multipart/form-data">
                        <!-- Page Heading -->
                        <input type="text" class="d-none" name="id" value="<?= $row["id"] ?>">
                        <input type="text" class="d-none" name="organizerType" value="<?= $row["organizer_type"] ?>">
                        <?php if (isset($_GET["updateType"])) : ?>
                            <input type="text" class="d-none" name="updateType" value="<?= $updateType ?>">
                        <?php endif ?>

                        <div class="d-sm-flex align-items-center mb-4 justify-content-between mx-4 pt-3">
                            <h1 class="h3 mb-0 text-gray-800 font-weight-bolder">編輯資料
                                <?php if (isset($_GET["updateType"])) : ?>
                                    （升級企業用戶）
                                <?php endif ?>
                            </h1>
                            <div class="d-flex">
                                <a class="btn btn-secondary mx-2" href="organizer-profile.php?id=<?= $row["id"] ?>">取消</a>
                                <input class="btn btn-main-color" type="submit" name="submit" value="儲存"></input>
                            </div>
                        </div>
                        <!-- Content Row -->
                        <div class="mx-4 pb-4 animate__animated animate__fadeIn animate__faster">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="card mb-4 border-0 shadow">
                                        <div class="card-body text-center">
                                            <style>
                                                .organizer-avatar-edit {
                                                    width: 200px;
                                                    height: 200px;
                                                    background: url("organizer_avatar/<?= $row["avatar"] ?>");
                                                    background-size: cover;
                                                    background-position: 50% 50%;
                                                    transition: 0.3s;
                                                }
                                            </style>
                                            <div class="d-inline-flex">
                                                <div class="organizer-avatar-edit rounded-circle mt-2 text-white d-flex align-items-center justify-content-center">

                                                </div>
                                            </div>
                                            <h4 class="my-3 font-weight-bolder"><?= $row["name"] ?></h4>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <?php if ($row["organizer_type"] == 1) : ?>
                                        <div class="card mb-4 border-0 shadow">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <p class="mb-0">用戶類別</p>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <span class="mb-0 text-bg-company px-2 py-1 rounded">企業用戶</span>
                                                        <span class="mb-0 text-bg-danger px-2 py-1 rounded">無法變更</span>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row align-items-center">
                                                    <div class="col-sm-3">
                                                        <p class="mb-0">前台顯示名稱<i class="bi bi-pencil-square ms-2"></i></p>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="name" value="<?= $row["name"] ?>">
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row align-items-center">
                                                    <div class="col-sm-3">
                                                        <p class="mb-0">公司抬頭<i class="bi bi-pencil-square ms-2"></i></p>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="businessName" value="<?= $row["business_name"] ?>">
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row align-items-center">
                                                    <div class="col-sm-3">
                                                        <p class="mb-0">統一編號<i class="bi bi-pencil-square ms-2"></i></p>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="text" onkeyup="value=value.replace(/[^\d]/g,'') " class="form-control" name="businessInvoice" maxlength="8" value="<?= $row["business_invoice"] ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php else : ?>
                                        <div class="card mb-4 border-0 shadow">
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col-sm-3">
                                                        <p class="mb-0">用戶類別</p>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <?php if (!isset($_GET["updateType"])) : ?>
                                                            <span class="btn mb-0 px-2 py-1 rounded disabled btn-warning text-black me-1">個人用戶</span>
                                                            <a href="organizer-edit.php?id=<?= $id ?>&updateType=1" class="btn mb-0 btn-success px-2 py-1 rounded">升級企業用戶</a>
                                                        <?php else : ?>
                                                            <span class="btn mb-0 px-2 py-1 rounded disabled btn-success me-1">企業用戶</span>
                                                        <?php endif ?>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row align-items-center">
                                                    <div class="col-sm-3">
                                                        <p class="mb-0">前台顯示名稱<i class="bi bi-pencil-square ms-2"></i></p>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="name" value="<?= $row["name"] ?>">
                                                    </div>
                                                </div>
                                                <?php if (isset($_GET["updateType"])) : ?>
                                                    <hr>
                                                    <div class="row align-items-center">
                                                        <div class="col-sm-3">
                                                            <p class="mb-0">公司抬頭<i class="bi bi-pencil-square ms-2"></i></p>
                                                        </div>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" name="businessName" value="<?= $row["business_name"] ?>">
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row align-items-center">
                                                        <div class="col-sm-3">
                                                            <p class="mb-0">統一編號<i class="bi bi-pencil-square ms-2"></i></p>
                                                        </div>
                                                        <div class="col-sm-9">
                                                            <input type="text" onkeyup="value=value.replace(/[^\d]/g,'') " class="form-control" name="businessInvoice" maxlength="8" value="<?= $row["business_invoice"] ?>">
                                                        </div>
                                                    </div>
                                                <?php endif ?>
                                            </div>
                                        </div>
                                    <?php endif ?>
                                    <div class="card mb-4 border-0 shadow">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col-sm-3">
                                                    <p class="mb-0">銀行戶名<i class="bi bi-pencil-square ms-2"></i></p>
                                                </div>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="bankName" value="<?= $row["bank_name"] ?>">
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row align-items-center">
                                                <div class="col-sm-3">
                                                    <p class="mb-0">銀行代碼<i class="bi bi-pencil-square ms-2"></i></p>
                                                </div>
                                                <div class="col-sm-9">
                                                    <input type="text" onkeyup="value=value.replace(/[^\d]/g,'') " class="form-control" name="bankCode" maxlength="3" value="<?= $row["bank_code"] ?>">
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row align-items-center">
                                                <div class="col-sm-3">
                                                    <p class="mb-0">分行<i class="bi bi-pencil-square ms-2"></i></p>
                                                </div>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="bankBranch" value="<?= $row["bank_branch"] ?>">
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row align-items-center">
                                                <div class="col-sm-3">
                                                    <p class="mb-0">銀行帳號<i class="bi bi-pencil-square ms-2"></i></p>
                                                </div>
                                                <div class="col-sm-9">
                                                    <input type="text" onkeyup="value=value.replace(/[^\d]/g,'') " class="form-control" name="amountNumber" value="<?= $row["amount_number"] ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
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
    <script>
        import Swal from 'sweetalert2/dist/sweetalert2.js';
        import 'sweetalert2/src/sweetalert2.scss';
        Swal.fire({
            title: "Good job!",
            text: "You clicked the button!",
            icon: "success"
        });
    </script>
    <?php include('../public-js.php') ?>

</body>

</html>