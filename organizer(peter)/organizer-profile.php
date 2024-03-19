<?php
require_once("../connect_server.php");

if (!isset($_GET["id"])) {
    header("location: organizer-list.php");
}
$id = $_GET["id"];

$sql = "SELECT organizer.*, member_list.name AS user_name, member_list.email AS user_email, member_list.phone AS user_phone 
FROM organizer
JOIN member_list ON organizer.user_id = member_list.id 
WHERE organizer.id = $id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$organizer_id = $row["id"];

$sqlEvent = "SELECT * FROM event WHERE merchant_id = $organizer_id";
$resultEvent = $conn->query($sqlEvent);
$rowsEvent = $resultEvent->fetch_all(MYSQLI_ASSOC);
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

                    <!-- Page Heading -->

                    <div class="d-sm-flex align-items-center mb-4 justify-content-between mx-4 pt-3">
                        <div class="d-flex">
                            <h1 class="h3 mb-0 text-gray-800 font-weight-bolder">主辦單位資料</h1>
                            <a href="organizer-list.php" class="btn btn-main-color py-1 mx-3"><i class="bi bi-arrow-left me-1"></i>回全部列表</a>
                        </div>
                        <div>
                            <a class="btn btn-main-color me-1" href="organizer-edit.php?id=<?= $row["id"] ?>">
                                編輯資訊<i class="bi bi-pencil-square ms-2"></i>
                            </a>
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                刪除資料<i class="bi bi-trash-fill ms-2"></i>
                            </button>
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5 text-danger" id="exampleModalLabel"><i class="bi bi-exclamation-triangle-fill me-2"></i>確定要刪除這筆資料嗎？</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row mb-3">
                                                <div class="col-4">前台顯示名稱</div>
                                                <div class="col-6"><?= $row["name"] ?></div>
                                            </div>
                                            <hr>
                                            <div class="text-gray-600 mb-2 small">關聯會員資料</div>
                                            <div class="row mb-3">
                                                <div class="col-4">會員姓名</div>
                                                <div class="col-6"><?= $row["user_name"] ?></div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-4">會員email</div>
                                                <div class="col-6"><?= $row["user_email"] ?></div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                                            <a href="organizer-doDelete.php?id=<?= $row["id"] ?>" class="btn btn-danger">確定</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Content Row -->
                    <div class="mx-4 pb-4 animate__animated animate__fadeIn animate__faster">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="card mb-4 border-0 shadow">
                                    <div class="card-body text-center">
                                        <style>
                                            .organizer-avatar {
                                                display: inline-block;
                                                width: 200px;
                                                height: 200px;
                                                background: url("organizer_avatar/<?= $row["avatar"] ?>");
                                                background-size: cover;
                                                background-position: 50% 50%;
                                                background-repeat: no-repeat;
                                                transition: 0.3s;
                                            }
                                        </style>
                                        <div class="organizer-avatar rounded-circle mt-2"></div>
                                        <div class="mt-3">
                                            <button type="button" class="btn btn-main-color" data-bs-toggle="modal" data-bs-target="#avatar">
                                                更換大頭貼<i class="ms-2 bi bi-pencil-square"></i>
                                            </button>
                                        </div>
                                        <div class="modal fade" id="avatar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">更換大頭貼</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="organizer-avatar-doUpload.php" method="post" enctype="multipart/form-data">
                                                        <div class="modal-body row">
                                                            <img src="" alt="" id="preview" class="col rounded-circle">
                                                        </div>
                                                        <div class="modal-footer d-flex justify-content-between">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                                                            <input type="text" class="d-none" name="id" value="<?= $row["id"] ?>">
                                                            <div>
                                                                <label class="btn btn-main-color mt-2 me-1">
                                                                    <div>上傳</div>
                                                                    <input class="d-none" type="file" name="avatar" id="upload-avater" accept="image/gif,image/jpeg,image/png,.svg">
                                                                </label>
                                                                <input type="submit" class="btn btn-main-color" name="" id="" value="送出">
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <h4 class="my-3 font-weight-bolder"><?= $row["name"] ?></h4>
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
                                <div class="card mb-4 mb-lg-0 border-0 shadow">
                                    <div class="card-body p-0">
                                        <ul class="list-group list-group-flush rounded-3">
                                            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                                <span><i class="bi bi-person-fill me-2"></i>關聯會員名稱</span>
                                                <p class="mb-0"><?= $row["user_name"] ?></p>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                                <span><i class="bi bi-envelope-fill me-2"></i>email</span>
                                                <p class="mb-0"><?= $row["user_email"] ?></p>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                                <span><i class="bi bi-telephone-fill me-2"></i>連絡電話</span>
                                                <p class="mb-0"><?= $row["user_phone"] ?></p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card mt-4 mb-lg-0 border-0 shadow">
                                    <div class="card-body p-0">
                                        <ul class="list-group list-group-flush rounded-3">
                                            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                                <span><i class="bi bi-clock-fill me-2"></i>資料建立時間</span>
                                                <p class="mb-0"><?= $row["created_at"] ?></p>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                                <span><i class="bi bi-pencil-fill me-2"></i>更新時間</span>
                                                <p class="mb-0"><?= $row["update_at"] ?></p>
                                            </li>
                                        </ul>
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
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <p class="mb-0">前台顯示名稱</p>
                                                </div>
                                                <div class="col-sm-9">
                                                    <p class="text-muted mb-0"><?= $row["name"] ?></p>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <p class="mb-0">公司抬頭</p>
                                                </div>
                                                <div class="col-sm-9">
                                                    <p class="text-muted mb-0"><?= $row["business_name"] ?></p>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <p class="mb-0">統一編號</p>
                                                </div>
                                                <div class="col-sm-9">
                                                    <p class="text-muted mb-0"><?= $row["business_invoice"] ?></p>
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
                                                    <span class="btn mb-0 px-2 py-1 rounded disabled btn-warning text-black me-2">個人用戶</span>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <p class="mb-0">前台顯示名稱</p>
                                                </div>
                                                <div class="col-sm-9">
                                                    <p class="text-muted mb-0"><?= $row["name"] ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif ?>
                                <div class="card mb-4 border-0 shadow">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <p class="mb-0">銀行戶名</p>
                                            </div>
                                            <div class="col-sm-9">
                                                <p class="text-muted mb-0"><?= $row["bank_name"] ?></p>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <p class="mb-0">銀行代碼</p>
                                            </div>
                                            <div class="col-sm-9">
                                                <p class="text-muted mb-0"><?= $row["bank_code"] ?></p>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <p class="mb-0">分行</p>
                                            </div>
                                            <div class="col-sm-9">
                                                <p class="text-muted mb-0"><?= $row["bank_branch"] ?></p>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <p class="mb-0">銀行帳號</p>
                                            </div>
                                            <div class="col-sm-9">
                                                <p class="text-muted mb-0"><?= $row["amount_number"] ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card mb-4 mb-md-0 border-0 shadow">
                                    <div class="card-body">
                                        <p class="mb-4">上架活動</p>
                                        <ul class="p-0">
                                            <?php foreach ($rowsEvent as $row) : ?>
                                                <li class="mb-2 list-unstyled"><i class="bi bi-record-fill me-2" style="color: #588afe"></i><a class="text-black text-decoration-none" href="../event/update.php?id=<?=$row["id"] ?>"><?= $row["event_name"] ?></a></li>
                                            <?php endforeach ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
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