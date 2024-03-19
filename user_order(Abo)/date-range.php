<?php
require_once("../connect_server.php");


//沒有抓到兩個參數回去主頁面
if (!isset($_GET['endDateTime']) || !isset($_GET['startDateTime'])) {
    header('location: index-Abo.php');
}
// var_dump($_GET['startDateTime'], $_GET['endDateTime'], $_GET['status'], $_GET['page']);
$startTime = $_GET['startDateTime'];
$endTime = $_GET['endDateTime'];

//活動分類資料庫
$eventCategory = "SELECT * FROM event_category";
$resultCategory = $conn->query($eventCategory);
$rowsCategory = $resultCategory->fetch_all(MYSQLI_ASSOC);
//--------------------------------------------------------//


//計算頁數
if (isset($_GET['status'])) {
    $status = $_GET['status'];
    if ($status == 1) {
        $sqlPage = "SELECT user_order.*, user_order.id,user_order.valid AS user_order_valid
        FROM user_order
        JOIN campaign ON campaign.id = user_order.event_id
        WHERE user_order.valid = 1
        AND campaign.start_date BETWEEN '$startTime' AND '$endTime'";
    } else if ($status == 0) {
        $sqlPage = "SELECT user_order.*, user_order.id,user_order.valid AS user_order_valid
        FROM user_order
        JOIN campaign ON campaign.id = user_order.event_id
        WHERE user_order.valid = 0
        AND campaign.start_date BETWEEN '$startTime' AND '$endTime'";
    } else if ($status == 3) {
        $sqlPage = "SELECT user_order.*, user_order.id,user_order.valid AS user_order_valid
        FROM user_order
        JOIN campaign ON campaign.id = user_order.event_id
        WHERE user_order.valid IN (1, 0)
        AND campaign.start_date BETWEEN '$startTime' AND '$endTime'";
    }
} else {
    $sqlPage = "SELECT * FROM user_order";
}
$resultCount = $conn->query($sqlPage);
$countrows = $resultCount->fetch_all(MYSQLI_ASSOC);
$AllresultCount = $resultCount->num_rows;
$perPage = 4;
$pages = ceil($AllresultCount / $perPage);
//--------------------------------------------------------//

if (isset($_GET['status']) && isset($_GET['page']) && isset($_GET['startDateTime']) && isset($_GET['endDateTime'])) {
    // 檢查訂單是否取消
    $startTime = $_GET['startDateTime'];
    $endTime = $_GET['endDateTime'];
    $status = $_GET["status"];
    $page = $_GET['page'];
    $startItem = ($page - 1) * $perPage;

    // 獲取 status=1 和 status=0 的資料
    if ($status == 3) {
        $sql = "SELECT user_order.*, campaign.*,organizer.*,user_order.valid AS user_order_valid,organizer.valid AS organizer_valid, ticket.qr_code, member_list.name, event_category.event_name AS event_category_name , organizer.id AS organizer_id,user_order.id AS user_order_id, organizer.name AS organizer_name
        FROM user_order 
            JOIN campaign ON campaign.id = user_order.event_id
            JOIN ticket ON ticket.id = user_order.ticket_number
            JOIN member_list ON member_list.id = user_order.user_id
            JOIN event_category ON event_category.id = campaign.event_type_id
            JOIN organizer ON organizer.id = campaign.merchant_id
            WHERE user_order.valid IN (1, 0)
            AND campaign.start_date BETWEEN '$startTime' AND '$endTime'
            ORDER BY campaign.start_date ASC 
            LIMIT $startItem, $perPage";
    } else {
        $sql = "SELECT user_order.*, campaign.*,organizer.*,user_order.valid AS user_order_valid,organizer.valid AS organizer_valid, ticket.qr_code, member_list.name, event_category.event_name AS event_category_name, organizer.id AS organizer_id,user_order.id AS user_order_id, organizer.name AS organizer_name
        FROM user_order 
        JOIN campaign ON campaign.id = user_order.event_id
        JOIN ticket ON ticket.id = user_order.ticket_number
        JOIN member_list ON member_list.id = user_order.user_id
        JOIN event_category ON event_category.id = campaign.event_type_id
        JOIN organizer ON organizer.id = campaign.merchant_id
        WHERE user_order.valid = $status
        AND campaign.start_date BETWEEN '$startTime' AND '$endTime'
        ORDER BY campaign.start_date ASC 
        LIMIT $startItem, $perPage";
    }
    $result = $conn->query($sql);
    $rows = $result->fetch_all(MYSQLI_ASSOC);
} else {
    // 預設情況
    $status = 3;
    $page = 1;
    // 訂單資料庫串聯
    $sql = "SELECT user_order.*, campaign.*,organizer.*,user_order.valid AS user_order_valid,organizer.valid AS organizer_valid, ticket.qr_code, member_list.name, event_category.event_name AS event_category_name, organizer.id AS organizer_id,user_order.id AS user_order_id, organizer.name AS organizer_name
    FROM user_order
    JOIN campaign ON campaign.id = user_order.event_id
    JOIN ticket ON ticket.id = user_order.ticket_number
    JOIN member_list ON member_list.id = user_order.user_id
    JOIN event_category ON event_category.id = campaign.event_type_id
    JOIN organizer ON organizer.id = campaign.merchant_id
    WHERE  campaign.start_date BETWEEN '$startTime' AND '$endTime'
    ORDER BY campaign.start_date ASC
    LIMIT 0, $perPage";
    $result = $conn->query($sql);
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    //從主頁跳過來要先計算一次頁數
    $sqlFirstPage = "SELECT user_order.*, user_order.id,user_order.valid AS user_order_valid
    FROM user_order
    JOIN campaign ON campaign.id = user_order.event_id
    WHERE  campaign.start_date BETWEEN '$startTime' AND '$endTime'";
    $resultFirst = $conn->query($sqlFirstPage);
    $rowsFirst = $resultFirst->num_rows;
    $FirstPages = ceil($rowsFirst / $perPage);
}
//重制頁數
if (isset($_GET['status']) && in_array($status, [1, 0, 3])) {
    $page = 1;
}

// var_dump($startTime, $endTime)
?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>訂單資訊</title>

    <?php include('../public_head.php') ?>
</head>

<body>
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
                        <h1 class="h3 mb-0 text-gray-800 font-weight-bolder me-3">訂單資訊</h1>
                        <div class="btn-group" role="group" aria-label="Basic outlined example">
                            <a href="date-range.php?status=<?= 3 ?>&page=<?= $page ?>&startDateTime=<?= $startTime ?>&endDateTime=<?= $endTime ?>">
                                <button type="button" class="btn btn-outline-primary">
                                    全部
                                </button>
                            </a>
                            <a href="date-range.php?status=<?= 1 ?>&page=<?= $page ?>&startDateTime=<?= $startTime ?>&endDateTime=<?= $endTime ?>"><button type="button" class="btn btn-outline-primary">
                                    已下單
                                </button></a>
                            <a href="date-range.php?status=<?= 0 ?>&page=<?= $page ?>&startDateTime=<?= $startTime ?>&endDateTime=<?= $endTime ?>"><button type="button" class="btn btn-outline-primary">
                                    已取消
                                </button></a>
                        </div>
                    </div>

                    <!-- 訂單資訊選項 -->
                    <!-- 時間搜尋 -->
                    <div class="mx-4 mt-4 mb-3">
                        <div class="d-flex justify-content-between">
                            <nav aria-label="Page navigation example ">
                                <ul class="pagination justify-content-center">
                                    <?php if (isset($_GET['status'])) : ?>
                                        <?php for ($i = 1; $i <= $pages; $i++) : ?>
                                            <li class="page-item"><a class="page-link" href="date-range.php?status=<?= $status ?>&page=<?= $i ?>&startDateTime=<?= $startTime ?>&endDateTime=<?= $endTime ?>"><?= $i ?></a></li>
                                        <?php endfor; ?>
                                    <?php else :   ?>
                                        <?php for ($i = 1; $i <= $FirstPages; $i++) : ?>
                                            <li class="page-item"><a class="page-link" href="date-range.php?status=<?= $status ?>&page=<?= $i ?>&startDateTime=<?= $startTime ?>&endDateTime=<?= $endTime ?>"><?= $i ?></a></li>
                                        <?php endfor; ?>
                                    <?php endif; ?>
                                </ul>
                            </nav>
                            <div>
                                <form class="form-inline" method="get" action="date-range.php">
                                    <div class="form-group ml-2">
                                        <label for="endDateTime">開始日期：</label>
                                        <input type="date" class="form-control" id="startDateTime" name="startDateTime" value="<?= $startTime ?>">
                                    </div>
                                    <div class="form-group ml-2">
                                        <label for="endDateTime">結束日期：</label>
                                        <input type="date" class="form-control" id="endDateTime" name="endDateTime" value="<?= $endTime ?>">
                                    </div>
                                    <button class="btn btn-outline-secondary ml-2" type="submit" id="searchButton">搜尋</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- 頁數 -->
                    <!-- 訂單內容 -->
                    <div class="mx-4 px-2 my-3">
                        <?php foreach ($rows as  $row) :
                        ?>
                            <div class="row">
                                <div class="col-12 card card-body py-3 border-left-primary mb-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="left">
                                            <div class="title py-1">
                                                <?= $row["event_name"] ?>
                                            </div>
                                            <div class="time py-1">
                                                <?= $row["start_date"] ?> ~ <?= $row["end_date"] ?>
                                            </div>
                                            <div class="number py-1">票券號碼 ： <?= $row["qr_code"] ?></div>
                                        </div>
                                        <div class="right">
                                            <p class="d-inline-flex gap-1">
                                                <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample<?= $row["id"] ?>" aria-expanded="false" aria-controls="collapseExample<?= $row["id"] ?>">
                                                    票券資訊
                                                </button>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="collapse col-12 p-0 mb-3" id="collapseExample<?= $row["id"] ?>">
                                    <div class="card card-body">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>票號</th>
                                                    <th>主辦單位</th>
                                                    <th>參加人</th>
                                                    <th>票種</th>
                                                    <th>單價</th>
                                                    <th>有效期限</th>
                                                    <th>狀態</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><?= $row["qr_code"] ?></td>
                                                    <td><?= $row["organizer_name"] ?></td>
                                                    <td><?= $row["name"] ?></td>
                                                    <td><?= $row["event_category_name"] ?></td>
                                                    <td><?= $row["event_price"] ?></td>
                                                    <td>
                                                        <?= $row["start_date"] ?> ~<br /> <?= $row["end_date"] ?>
                                                    </td>
                                                    <td><?php
                                                        if ($row["user_order_valid"] == 1) {
                                                            echo "已下單";
                                                        } else if ($row["user_order_valid"] == 0) {
                                                            echo "取消訂單";
                                                        } else {
                                                            echo "未下單";
                                                        }
                                                        ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>

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
                <div class="modal-body">
                    Select "Logout" below if you are ready to end your current session.
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">
                        Cancel
                    </button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>
    <?php include('../public-js.php') ?>
</body>

</html>