<?php
require_once("../connect_server.php");

$sqlTotal = "SELECT * FROM organizer WHERE valid = 1";
$resultTotal = $conn->query($sqlTotal);
$totalUser = $resultTotal->num_rows;
$perPage = 10;

$pageCount = ceil($totalUser / $perPage); //celi=無條件進位

if (isset($_GET["search"])) {
    $search = $_GET["search"];
    $sql = "SELECT organizer.*, member_list.name AS user_name, member_list.email AS user_email FROM organizer
    JOIN member_list ON organizer.user_id = member_list.id WHERE organizer.name LIKE '%$search%' AND organizer.valid = 1
    ORDER BY id ASC";
    // $sql = "SELECT * FROM organizer WHERE name LIKE '%$search%'";
} elseif (isset($_GET["page"]) && isset($_GET["order"])) {
    $page = $_GET["page"];
    $order = $_GET["order"];
    switch ($order) {
        case 1:
            $orderSql = "id ASC"; //ASC升幕
            break;
        case 2:
            $orderSql = "name ASC";
            break;
        case 3:
            $orderSql = "name DESC";
            break;
        case 4:
            $orderSql = "organizer_type ASC";
            break;
        case 5:
            $orderSql = "organizer_type DESC";
            break;
        case 6:
            $orderSql = "user_name ASC";
            break;
        case 7:
            $orderSql = "user_name DESC";
            break;
        case 8:
            $orderSql = "created_at ASC";
            break;
        case 9:
            $orderSql = "created_at DESC";
            break;
        default:
            $orderSql = "id ASC";
    }
    $startItem = ($page - 1) * $perPage;
    $sql = "SELECT organizer.*, member_list.name AS user_name, member_list.email AS user_email FROM organizer
    JOIN member_list ON organizer.user_id = member_list.id WHERE organizer.valid = 1
    ORDER BY $orderSql LIMIT $startItem,$perPage";
} else {
    $order = 1;
    $page = 1;
    $sql = "SELECT organizer.*, member_list.name AS user_name, member_list.email AS user_email FROM organizer
    JOIN member_list ON organizer.user_id = member_list.id WHERE organizer.valid = 1
    ORDER BY id ASC LIMIT 0,$perPage";
}
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

    <title>主辦單位清單</title>
    <!-- 公用head -->
    <?php include('../public_head.php') ?>

    <link href="organizer.css" rel="stylesheet">

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
                        <h1 class="h3 mb-0 text-gray-800 font-weight-bolder">主辦單位清單</h1>
                        <?php if (!isset($_GET["search"])) : ?>
                            <div class="dropdown">
                                <button class="btn btn-main-color dropdown-toggle py-1 mx-3" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="0,10">
                                    列表分頁
                                </button>
                                <ul class="dropdown-menu animate__animated animate__fadeIn animate__faster">
                                    <?php for ($i = 1; $i <= $pageCount; $i++) : ?>
                                        <li><a class="dropdown-item" href="organizer-list.php?page=<?= $i ?>&order=<?= $order ?>"><?= $i ?></a></li>
                                    <?php endfor ?>
                                </ul>
                            </div>
                            <div class="text-gray-600">
                                目前在第<?= $page ?>頁
                            </div>
                        <?php else : ?>
                            <a href="organizer-list.php" class="btn btn-main-color py-1 mx-3"><i class="bi bi-arrow-left me-1"></i>回全部列表</a>
                        <?php endif ?>
                        <div class="ms-auto">
                            <form action="">
                                <div class="input-group rounded">
                                    <?php if (!isset($_GET["search"])) : ?>
                                        <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" name="search" />
                                    <?php else : ?>
                                        <input type="search" class="form-control rounded" value="<?= $_GET["search"] ?>" aria-label="Search" aria-describedby="search-addon" name="search" />
                                    <?php endif ?>
                                    <button class="input-group-text rounded border-0 ms-2" id="search-addon" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Content Row -->

                    <div>
                        <table class="table table-hover table-light mx-3 animate__animated animate__fadeIn animate__faster">
                            <?php if (!isset($_GET["search"])) : ?>
                                <thead>
                                    <tr class="text-nowrap">
                                        <th scope="col">
                                            主辦單位名稱
                                            <?php if ($order != 2) : ?>
                                                <a href="organizer-list.php?page=<?= $page ?>&order=2" class=""><i class="bi bi-caret-down-square-fill"></i></a>
                                            <?php else : ?>
                                                <a href="organizer-list.php?page=<?= $page ?>&order=3" class=""><i class="bi bi-caret-up-square-fill"></i></a>
                                            <?php endif ?>
                                        </th>
                                        <th scope="col">
                                            身分
                                            <?php if ($order != 4) : ?>
                                                <a href="organizer-list.php?page=<?= $page ?>&order=4" class=""><i class="bi bi-caret-down-square-fill"></i></a>
                                            <?php else : ?>
                                                <a href="organizer-list.php?page=<?= $page ?>&order=5" class=""><i class="bi bi-caret-up-square-fill"></i></a>
                                            <?php endif ?>
                                        </th>
                                        <th scope="col">
                                            關聯會員名稱
                                            <?php if ($order != 6) : ?>
                                                <a href="organizer-list.php?page=<?= $page ?>&order=6" class=""><i class="bi bi-caret-down-square-fill"></i></a>
                                            <?php else : ?>
                                                <a href="organizer-list.php?page=<?= $page ?>&order=7" class=""><i class="bi bi-caret-up-square-fill"></i></a>
                                            <?php endif ?>
                                        </th>
                                        <th scope="col">email</th>
                                        <th scope="col">
                                            註冊時間
                                            <?php if ($order != 8) : ?>
                                                <a href="organizer-list.php?page=<?= $page ?>&order=8" class=""><i class="bi bi-caret-down-square-fill"></i></a>
                                            <?php else : ?>
                                                <a href="organizer-list.php?page=<?= $page ?>&order=9" class=""><i class="bi bi-caret-up-square-fill"></i></a>
                                            <?php endif ?>
                                        </th>
                                        <th scope="col">操作</th>
                                    </tr>
                                </thead>
                            <?php else : ?>
                                <thead>
                                    <tr class="text-nowrap">
                                        <th scope="col">主辦單位名稱</th>
                                        <th scope="col">身分</th>
                                        <th scope="col">關聯會員名稱</th>
                                        <th scope="col">email</th>
                                        <th scope="col">註冊時間</th>
                                        <th scope="col">操作</th>
                                    </tr>
                                </thead>
                            <?php endif ?>
                            <tbody>
                                <?php foreach ($rows as $row) : ?>
                                    <tr class="text-nowrap">
                                        <td><?= $row["name"] ?></td>
                                        <?php if ($row["organizer_type"] == 1) : ?>
                                            <td>公司<i class="bi bi-record-fill mx-1" style="color: #6dbbb3"></i></td>
                                        <?php else : ?>
                                            <td>個人<i class="bi bi-record-fill mx-1" style="color: #f9d781"></i></td>
                                        <?php endif ?>
                                        <td><?= $row["user_name"] ?></td>
                                        <td><?= $row["user_email"] ?></td>
                                        <td><?= $row["created_at"] ?></td>
                                        <td>
                                            <a href="organizer-profile.php?id=<?= $row["id"] ?>" class="btn btn-main-color p-0 px-2"><span class="small"><i class="bi bi-eye-fill"></i></span></a>
                                            <a href="organizer-edit.php?id=<?= $row["id"] ?>" class="btn btn-main-color p-0 px-2"><span class="small"><i class="bi bi-pencil-square"></i></span></a>
                                            <!-- <a href="organizer-edit.php?id=<?= $row["id"] ?>" class="btn btn-danger p-0 px-2"><span class="small"><i class="bi bi-trash-fill"></i></span></a> -->
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
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