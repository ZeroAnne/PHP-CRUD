<?php
require_once("../connect_server.php");

$sql = "SELECT organizer.id, organizer.name FROM organizer WHERE valid=1";
$result = $conn->query($sql);
$rows = $result->fetch_all(MYSQLI_ASSOC);
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

    <!-- 公用head -->
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
                        <h1 class="h3 mb-0 text-gray-800 font-weight-bolder">新增活動</h1>
                    </div>

                    <div class="mx-4">
                        <div class="pb-3 my-3">
                            <a class="btn btn-primary text-white" href="event.php">回活動列表</a>
                        </div>
                        <form action="doAddevent.php" method="post" enctype="multipart/form-data" class="row">
                            <div class="row mb-3 col-lg-6">
                                <label for="event_name" class="col-sm-2 col-form-label">活動名稱</label>
                                <div class="col-sm-10">
                                    <input name="event_name" type="text" class="form-control" id="event_name" required>
                                </div>
                            </div>
                            <div class="row mb-3 col-lg-6">
                                <label for="event_type_id" class="col-sm-2 col-form-label">活動種類</label>
                                <div class="col-sm-10">
                                    <select class="form-control" type="text" name="event_type_id" aria-label="Default select example" required>
                                        <option value="">請選擇活動類型</option>
                                        <option value="1">演唱會</option>
                                        <option value="2">展覽</option>
                                        <option value="3">快閃限定活動</option>
                                        <option value="4">市集</option>
                                        <option value="5">粉絲見面會</option>
                                        <option value="6">課程講座</option>
                                        <option value="7">景點門票</option>
                                        <option value="8">體育賽事</option>

                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3 col-lg-6">
                                <label for="start_date" class="col-sm-2 col-form-label">開始日期</label>
                                <div class="col-sm-10">
                                    <input name="start_date" type="datetime-local" class="form-control" id="start_date" required>
                                </div>
                            </div>
                            <div class="row mb-3 col-lg-6">
                                <label for="end_date" class="col-sm-2 col-form-label">結束日期</label>
                                <div class="col-sm-10">
                                    <input name="end_date" type="datetime-local" class="form-control" id="end_date" required>
                                </div>
                            </div>
                            <div class="row mb-3 col-lg-6">
                                <label for="address" class="col-sm-2 col-form-label">地點</label>
                                <div class="col-sm-10">
                                    <input name="address" type="text" class="form-control" id="address" required>
                                </div>
                            </div>
                            <div class="row mb-3 col-lg-6">
                                <label for="merchant_id" class="col-sm-2 col-form-label">主辦單位</label>
                                <div class="col-sm-10">
                                    <select class="form-control" type="text" name="merchant_id" aria-label="Default select example" required>
                                        <?php foreach ($rows as $row) : ?>
                                            <option value="<?= $row["id"] ?>"><?= $row["name"] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3 col-lg-6">

                                <label for="images" class="col-sm-2 col-form-label">活動圖片</label>
                                <div class="col-sm-10">
                                    <input name="images" type="file" class="form-control" id="images" required>
                                </div>
                            </div>

                            <div class="row mb-3 col-lg-6">
                                <label for="event_price" class="col-sm-2 col-form-label">票價</label>
                                <div class="col-sm-10">
                                    <input name="event_price" type="text" class="form-control" id="event_price" required>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <button class="btn btn-primary text-white my-3" type="submit" name="add">送出</button>
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

    <?php include('../public-js.php') ?>

</body>

</html>