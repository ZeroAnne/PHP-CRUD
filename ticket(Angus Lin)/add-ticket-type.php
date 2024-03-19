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
                    <div class="d-sm-flex align-items-center justify-content-between mb-4 mx-4 pt-3">
                        <h1 class="h3 mb-0 text-gray-800 font-weight-bolder"><a href="../ticket(Angus%20Lin)/ticket-list.php" title="回到票卷種類管理"><i class="bi bi-backspace px-1"></i>
                            </a>新增票卷種類
                        </h1>
                    </div>

                    <!-- Content Row -->
                    <form action="DoAddTicketType.php" method="post" class="animate__animated animate__fadeIn animate__faster mx-4">
                        <div class="row">
                            <div class="form-group col-4">
                                <label for="exampleFormControlSelect1">是否有座位選擇</label>
                                <select class="form-control" id="seat" name="seat" required>
                                    <option value="1">有</option>
                                    <option value="0">無</option>
                                </select>
                            </div>
                            <div class="form-group col-8">
                                <label for="exampleFormControlSelect1">票卷種類</label>
                                <select class="form-control" id="ticketType" name="ticketType" required>
                                    <option value="1">演唱會</option>
                                    <option value="2">展覽</option>
                                    <option value="3">快閃限定活動</option>
                                    <option value="4">市集</option>
                                    <option value="5">粉絲見面會</option>
                                    <option value="6">課程講座</option>
                                    <option value="7">體育賽事</option>
                                    <option value="8">景點門票</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <div class="form-group">
                                <label for="exampleFormControlInput1">票卷名稱</label>
                                <input type="text" class="form-control" id="ticketName" name="ticketName" placeholder="Govent" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col">
                                <label for="exampleFormControlInput1">票卷價格</label>
                                <input type="number" class="form-control" id="ticketPrice" name="ticketPrice" placeholder="0" required>
                            </div>
                            <div class="form-group col">
                                <label for="exampleFormControlInput1">票卷總數</label>
                                <input type="number" class="form-control" id="ticketTotal" name="ticketTotal" placeholder="0" required>
                            </div>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-outline-warning"><i class="bi bi-plus-circle-fill"></i> 新增</button>
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