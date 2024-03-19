<?php

// catch error on webpage
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once("../connect_server.php");

$sqlTicketCategory = "SELECT * FROM ticket_category";

$sqlTotal = "SELECT * FROM ticket_type WHERE valid=2";
$perPage = 8;
$resultPage = $conn->query($sqlTotal);
$pageTotalCount = $resultPage->num_rows;
$pageCount = ceil($pageTotalCount / $perPage);
// var_dump($pageCount);

if (isset($_GET["category"])) {
    $category = $_GET["category"];
    $page = isset($_GET["page"]) ? $_GET["page"] : 1;
    // This line of code uses the ternary operator, which is a shorthand for an if-else statement. The ternary operator is written as condition ? exprIfTrue : exprIfFalse.
    // If the Condition is True ($_GET["page"]):
    // If the page parameter is present in the URL, its value is retrieved using $_GET["page"].
    //If the Condition is False (1):
    // If the page parameter is not present in the URL, the expression after the colon (:) is used, which in this case is 1.
    // This means that if no specific page is requested, the script defaults to using page number 1.
    $startTicket = ($page - 1) * $perPage;
    $sqlTicketType = "SELECT * FROM ticket_type WHERE category_id = $category AND valid = '2' LIMIT $startTicket, $perPage";
    $sqlTicketTypeCount = "SELECT * FROM ticket_type WHERE category_id = $category AND valid = '2'";
    $resultTicketType = $conn->query($sqlTicketTypeCount);
    $pageTotalCount = $resultTicketType->num_rows;
    $pageCount = ceil($pageTotalCount / $perPage);
} else {
    $page = isset($_GET["page"]) ? $_GET["page"] : 1;
    $category = isset($_GET["category"]) ? $_GET["category"] : "";
    $startTicket = ($page - 1) * $perPage;
    $sqlTicketType = "SELECT * FROM ticket_type WHERE valid = '2' LIMIT $startTicket, $perPage";
    $sqlTicketTypeCount = "SELECT * FROM ticket_type WHERE valid = '2'";
}



// if (isset($_GET["category"])){
//     $category = $_GET["category"];
//     $sqlTicketType = "SELECT * FROM ticket_type WHERE category_id = $category";

// }else if(isset($_GET["page"])){
//     $page = $_GET["page"];
//     $startTicket = ($page - 1) * $perPage;
//     // var_dump($startTicket, $perPage, $pageCount);
//     $sqlTicketType = "SELECT * FROM ticket_type Limit $startTicket, $perPage";
// }else{
//     $page = 1;
//     $sqlTicketType = "SELECT * FROM ticket_type Limit 0, $perPage";    
// }

$result = $conn->query($sqlTicketCategory);
$rowsTicketCategory = $result->fetch_all(MYSQLI_ASSOC);
// var_dump($rows);

$resultTicketType = $conn->query($sqlTicketType);
$rowsTicketType = $resultTicketType->fetch_all(MYSQLI_ASSOC);

$resultCount = $conn->query($sqlTicketTypeCount);
$TicketTypeCount = $resultCount->num_rows;
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>ticket-list</title>

    <!-- 公用head -->
    <?php include('../public_head.php') ?>

</head>

<body id="page-top">

<?php
include("../alert.php");
?>
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
                        <h1 class="h3 mb-0 text-gray-800 font-weight-bolder">票卷種類管理</h1>
                    </div>
                    <ul class="nav nav-pills mx-4">
                        <li class="nav-item">
                            <?php if (!isset($_GET["category"])) : ?>
                                <a class="nav-link active" aria-current="page" href="ticket-list.php">全部票卷種類</a>
                            <?php else : ?>
                                <a class="nav-link" aria-current="page" href="ticket-list.php">全部票卷種類</a>
                            <?php endif ?>
                        </li>
                        <?php foreach ($rowsTicketCategory as $ticketCategory) : ?>
                            <li class="nav-item">
                                <a class="nav-link <?php if (isset($_GET["category"]) && $_GET["category"] == $ticketCategory["id"]) echo "active"; ?>" href="ticket-list.php?category=<?= $ticketCategory["id"] ?>">
                                    <?= $ticketCategory["name"] ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <!-- total count and add-ticket-type button -->
                    <div class="d-flex justify-content-between align-items-center my-2 mx-4">
                        <div>
                            共 <?= $TicketTypeCount ?> 種票
                        </div>
                        <div>
                            <a type="button" class="btn btn-outline-warning btn-sm" href="../ticket(Angus Lin)/add-ticket-type.php"><i class="bi bi-plus-lg"></i> 新增票卷種類</a>
                        </div>
                    </div>
                    <!-- ticket-type table -->
                    <div class="mx-4 animate__animated animate__fadeIn animate__faster">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>編號</th>
                                    <th>有無選擇座位</th>
                                    <th>活動編號</th>
                                    <th>票卷名稱</th>
                                    <th>票卷價格</th>
                                    <th>票卷總數</th>
                                    <th>剩餘票卷數</th>
                                    <th>刪除</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($rowsTicketType as $ticketType) : ?>

                                    <?php $category = isset($_GET["category"]) ? ($_GET["category"]) : ""; ?>

                                    <!-- delete pup-up window -->
                                    <div class="modal" id="alertModal<?= $ticketType["id"] ?><?= $page ?><?= $category ?>" tabindex="-1" aria-labelledby="" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">警告</h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    <span aria-hidden="true">&times;</span>
                                                </div>
                                                <div class="modal-body">
                                                    確認刪除?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                                                    <a href="doDeleteTicketType.php?id=<?= $ticketType["id"] ?>
                                                    <?= isset($_GET["page"]) ? '&page=' . ($_GET["page"]) : '' ?>
                                                    <?= isset($_GET["category"]) ? '&category=' . ($_GET["category"]) : '' ?>" class="btn btn-danger" class="btn btn-danger">確認</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <tr>
                                        <td>
                                            <?= $ticketType["id"] ?>
                                        </td>
                                        <td>
                                            <?= $ticketType["ticket_type_id"] ?>
                                        </td>
                                        <td>
                                            <?= $ticketType["event_id"] ?>
                                        </td>
                                        <td class="text-truncate" style="max-width: 25vw">
                                            <a class="p-1" href="ticket-type.php?id=<?= $ticketType["id"] ?>" title="詳細資料">
                                                <i class="bi bi-database-fill-add"></i>
                                            </a>
                                            <span>
                                                <?= $ticketType["name"] ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?= $ticketType["price"] ?>
                                        </td>
                                        <td>
                                            <?= $ticketType["max_quantity"] ?>
                                        </td>
                                        <td>
                                            <?= $ticketType["remaining_quantity"] ?>
                                        </td>
                                        <td>
                                            <button type="button" data-toggle="modal" data-target="#alertModal<?= $ticketType["id"] ?><?= $page ?><?= $category ?>" class="btn btn-danger">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- page nav -->
                    <nav aria-label="Page navigation example" class="d-flex justify-content-center">
                        <ul class="pagination">
                            <li class="page-item">
                                <?php if ($page == 1 || $page == 0) : ?>
                                    <a class="page-link" href="ticket-list.php?page=1<?php if (isset($category) && $category != '') echo "&category=$category" ?>" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                <?php else : ?>
                                    <a class="page-link" href="ticket-list.php?page=<?= $page - 1 ?><?php if (isset($category) && $category != '') echo "&category=$category" ?>" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                <?php endif; ?>
                            </li>
                            <?php for ($i = 1; $i <= $pageCount; $i++) : ?>

                                <li class="page-item <?php if ($page == $i) echo "active"; ?>"><a class="page-link" href="ticket-list.php?page=<?= $i ?><?php if (isset($category) && $category != '') echo "&category=$category" ?>"><?= $i ?></a></li>

                                <!-- isset($_GET["category"]) ? &category=$category : ""; -->
                            <?php endfor; ?>
                            <li class="page-item">
                                <?php if ($page == $pageCount) : ?>
                                    <!-- If on the last page, the link will lead to the current (last) page itself -->
                                    <a class="page-link" href="ticket-list.php?page=<?= $page ?><?php if (isset($category) && $category != '') echo "&category=$category" ?>" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                <?php else : ?>
                                    <!-- If not on the last page, the link will lead to the next page -->
                                    <a class="page-link" href="ticket-list.php?page=<?= $page + 1 ?><?php if (isset($category) && $category != '') echo "&category=$category" ?>" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                <?php endif; ?>
                            </li>
                        </ul>
                    </nav>
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