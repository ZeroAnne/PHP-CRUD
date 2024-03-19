<?php
require_once("../connect_server.php");

$sqlMember = "SELECT member_list.id, member_list.name, member_list.email AS user_id FROM member_list
WHERE id NOT IN(SELECT user_id FROM organizer) AND valid = 1
ORDER BY member_list.id ASC
";
$resultMember = $conn->query($sqlMember);
$rows = $resultMember->fetch_all(MYSQLI_ASSOC);

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $sql = "SELECT * FROM member_list WHERE id = $id";
    // $sql = "SELECT organizer.*, member_list.name AS user_name, member_list.email AS user_email, member_list.phone AS user_phone FROM organizer
    // JOIN member_list ON organizer.user_id = member_list.id WHERE organizer.id = $id";
    $result = $conn->query($sql);
    $userRow = $result->fetch_assoc();
}
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
                    <form action="organizer-doAdd.php" method="post" enctype="multipart/form-data">
                        <div class="d-sm-flex align-items-center justify-content-between pt-3 mb-4 mx-4">
                            <div class="d-sm-flex align-items-center">
                                <h1 class="h3 mb-0 text-gray-800 font-weight-bolder">手動新增（主辦單位）</h1>
                                <div class="dropdown ms-1">
                                    <button class="btn btn-main-color dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="0,10">
                                        可新增會員列表
                                    </button>
                                    <ul class="dropdown-menu animate__animated animate__fadeIn animate__faster" style="max-height: 500px; overflow-y:auto;">
                                        <?php foreach ($rows as $row) : ?>
                                            <li>
                                                <a class="dropdown-item" href="?id=<?= $row["id"] ?>">
                                                    <div class="row" style="width: 450px">
                                                        <div class="col-4">會員名：<?= $row["name"] ?></div>
                                                        <div class="col">帳號：<?= $row["user_id"] ?></div>
                                                    </div>
                                                </a>
                                            </li>
                                            <hr class="m-1">
                                        <?php endforeach ?>
                                    </ul>
                                </div>
                            </div>
                            <div>
                                <?php if (isset($_GET["id"])) : ?>
                                    <input class="d-none" type="text" name="userId" value="<?= $_GET["id"] ?>">
                                    <input class="btn btn-main-color" type="submit" name="submit" value="送出"></input>
                                <?php endif ?>
                            </div>
                        </div>
                        <?php if (isset($_GET["id"])) : ?>
                            <div class="m-4 animate__animated animate__fadeIn animate__faster">
                                <div class="row">
                                    <div class="col-4 pe-4">
                                        <h4>會員資料</h4>
                                        <hr>
                                        <div class="row g-3">
                                            <div class="col-md-8">
                                                <label for="inputEmail4" class="form-label">會員姓名</label>
                                                <span class="form-control bg-body-secondary"><?= $userRow["name"] ?></span>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="inputEmail4" class="form-label">性別</label>
                                                <span class="form-control bg-body-secondary">
                                                    <?php if ($userRow["gender"] == 1) : ?>
                                                        男性
                                                    <?php else : ?>
                                                        女性
                                                    <?php endif ?>
                                                </span>
                                            </div>
                                            <div class="col-md-12">
                                                <label for="inputPassword4" class="form-label">出生年月日</label>
                                                <span class="form-control bg-body-secondary"><?= $userRow["born_date"] ?></span>
                                            </div>
                                            <div class="col-md-12">
                                                <label for="inputEmail4" class="form-label">email</label>
                                                <span class="form-control bg-body-secondary"><?= $userRow["email"] ?></span>
                                            </div>
                                            <div class="col-md-12">
                                                <label for="inputPassword4" class="form-label">手機</label>
                                                <span class="form-control bg-body-secondary"><?= $userRow["phone"] ?></span>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="ps-4 col-8 animate__animated animate__fadeIn animate__faster">
                                        <h4>新增主辦單位資料</h4>
                                        <hr>
                                        <div class="row g-3">
                                            <div class="col-9">
                                                <div class="row g-3">
                                                    <div class="col-12">
                                                        <div class="row">
                                                            <div class="form-check col-3 ms-3">
                                                                <label class="form-check-label" for="flexRadioDefault1">
                                                                    <input class="form-check-input" type="radio" name="organizerType" value="0" checked>
                                                                    個人
                                                                </label>
                                                            </div>
                                                            <div class="form-check col">
                                                                <label class="form-check-label" for="flexRadioDefault2">
                                                                    <input class="form-check-input" type="radio" name="organizerType" value="1">
                                                                    商家
                                                                </label>
                                                            </div>
                                                            <script>
                                                                let organizerType = document.getElementsByName("organizerType");

                                                                organizerType[0].onclick = function() {
                                                                    let companyForms = document.querySelectorAll("#company_form")
                                                                    companyForms.forEach((form) => form.className = "d-none");
                                                                }
                                                                organizerType[1].onclick = function() {
                                                                    let companyForms = document.querySelectorAll("#company_form")
                                                                    companyForms.forEach((form) => form.className = "col-6 animate__animated animate__fadeIn");
                                                                }
                                                            </script>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <label for="inputPassword4" class="form-label">前台顯示名稱</label>
                                                        <input class="form-control bg-light-subtle" type="text" name="name">
                                                    </div>
                                                    <div class="d-none" id="company_form">
                                                        <label for="inputPassword4" class="form-label">公司抬頭</label>
                                                        <input class="form-control bg-light-subtle" type="text" name="businessName">
                                                    </div>
                                                    <div class="d-none" id="company_form">
                                                        <label for="inputPassword4" class="form-label">統一編號</label>
                                                        <input class="form-control bg-light-subtle" type="text" name="businessInvoice">
                                                    </div>
                                                    <div class="col-6">
                                                        <label for="inputPassword4" class="form-label">銀行戶名</label>
                                                        <input class="form-control bg-light-subtle" type="text" name="bankName">
                                                    </div>
                                                    <div class="col-6">
                                                        <label for="inputPassword4" class="form-label">銀行代碼</label>
                                                        <input class="form-control bg-light-subtle" type="text" name="bankCode">
                                                    </div>
                                                    <div class="col-6">
                                                        <label for="inputPassword4" class="form-label">分行</label>
                                                        <input class="form-control bg-light-subtle" type="text" name="bankBranch">
                                                    </div>
                                                    <div class="col-6">
                                                        <label for="inputPassword4" class="form-label">銀行帳號</label>
                                                        <input class="form-control bg-light-subtle" type="text" name="amountNumber">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-3 g-2">
                                                <div class="row g-2">
                                                    <div class="col-12 mt-4">
                                                        <label for="inputPassword4" class="form-label">上傳大頭貼</label>
                                                        <img class="img-fluid mt-2" src="organizer_avatar/default.png" alt="">
                                                    </div>
                                                    <div class="col-12" style="margin-top: 10px;">
                                                        <label class="btn btn-secondary mt-2 me-1">
                                                            <div>上傳</div>
                                                            <input class="d-none" type="file" name="avatar" id="upload-avater" accept="image/gif,image/jpeg,image/png,.svg">
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <script>
                                                let input = document.getElementById("upload-avater");
                                                // let previewImg = document.getElementsById("preview");
                                                var previewImg = document.getElementsByTagName('img')[3];

                                                function upload(e) {
                                                    let uploadImg = e.target.files || e.dataTransfer.files;
                                                    console.log(uploadImg);
                                                    previewImg.src = window.URL.createObjectURL(uploadImg[0]);
                                                }

                                                input.addEventListener('change', upload);
                                            </script>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif ?>
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