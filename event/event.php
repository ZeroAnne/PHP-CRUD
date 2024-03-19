<?php
require_once("../connect_server.php");

$sqlTotal = "SELECT * FROM event WHERE valid= 1";
$resultTotal = $conn->query($sqlTotal);
$totalEvent = $resultTotal->num_rows;
$perPage = 10;
$pageCount = ceil($totalEvent / $perPage);

$sqlActivityCategory = "SELECT * FROM activity_category";
$result = $conn->query($sqlActivityCategory);
$rowsActivityCategory = $result->fetch_all(MYSQLI_ASSOC);


// $sqleventType = "SELECT event.event_type_id,activity_category.* FROM event JOIN activity_category 
// ON event.event_type_id = activity_category.id ORDER BY activity_category.id";
//     $resultType = $conn->query($sqleventType);
//     $rowstType=$resultType->fetch_all(MYSQLI_ASSOC);
// // var_dump($rowstType);

//     if ($resultType->num_rows > 0) {
//         // 使用迴圈遍歷所有資料列
//         while ($rowType = $resultType->fetch_assoc()) {
//             // 在這裡可以使用 $rowType['activity_name'] 等來存取每一列資料的欄位值
//             //echo "Event Type ID: " . $rowType['event_type_id'] . ", Activity Name: " . $rowType['activity_name'] . "<br>";
//         }
//     } else {
//         echo "0 筆結果";
//     }
//     // $rowType = $resultType->fetch_assoc();







if (isset($_GET["search"])) {
    $sqlTotal = "SELECT * FROM event WHERE valid= 1";
    $search = $_GET["search"];
    $sql = "SELECT event.*, activity_category.activity_name AS category_name, organizer.name AS merchant_name
    FROM event
    JOIN activity_category ON event.event_type_id = activity_category.id
    JOIN organizer ON event.merchant_id = organizer.id
    WHERE event.event_name LIKE '%$search%' AND event.valid=1";

    // $sql = "SELECT event.*, activity_category.activity_name AS category_name, organizer.name AS merchant_name
    // FROM event
    // JOIN activity_category ON event.event_type_id = activity_category.id
    // JOIN organizer ON event.merchant_id = organizer.id
    // WHERE event.valid=1 ORDER BY event.id ASC LIMIT 0, $perPage";

    $result = $conn->query($sql);
    // $row = $result->fetch_all(MYSQLI_ASSOC);

    while ($row = $result->fetch_assoc()) {
        // echo $row['event_name'] . '<br>';
    }
} elseif (isset($_GET["event_type_id"])) {

    $eventTypeId = $_GET["event_type_id"];
    //var_dump($eventTypeId);
    $sql = "SELECT event.*, activity_category.activity_name AS category_name, organizer.name AS merchant_name
    FROM event
    JOIN activity_category ON event.event_type_id = activity_category.id
    JOIN organizer ON event.merchant_id = organizer.id
    WHERE event.event_type_id=$eventTypeId LIMIT $perPage";

    $sqlTotal = "SELECT * FROM event WHERE valid= 1";
} elseif (isset($_GET["page"]) && isset($_GET["order"])) {

    $page = $_GET["page"];
    $order = $_GET["order"];
    switch ($order) {
        case 1:
            $orderSql = "id ASC";
            break;
        case 2:
            $orderSql = "id DESC";
            break;
        case 3:
            $orderSql = "start_date ASC";
            break;
        case 4:
            $orderSql = "start_date DESC";
            break;
        default:
            $orderSql = "id ASC";
    }

    $startItem = ($page - 1) * $perPage;

    $sql = "SELECT event.*,activity_category.activity_name AS category_name, organizer.name AS merchant_name
    FROM event
    JOIN activity_category ON event.event_type_id = activity_category.id
    JOIN organizer ON event.merchant_id = organizer.id
    WHERE event.valid=1 ORDER BY event.$orderSql LIMIT $startItem,$perPage";
} else {
    $page = 1;
    $order = 1;
    $sql = "SELECT event.*, activity_category.activity_name AS category_name, organizer.name AS merchant_name
    FROM event
    JOIN activity_category ON event.event_type_id = activity_category.id
    JOIN organizer ON event.merchant_id = organizer.id
    WHERE event.valid=1 ORDER BY event.id ASC LIMIT 0, $perPage";
}

$result = $conn->query($sql);
$eventCount = $result->num_rows;






// } elseif (isset($_GET["page"]) && isset($_GET["order"])) {
//     $page = $_GET["page"];
//     $order = $_GET["order"];
//     switch ($order) {
//         case 1:
//             $orderSql = "id ASC";
//             break;
//         case 2:
//             $orderSql = "id DESC";
//             break;
//         default:
//             $orderSql = "id ASC";
//     }

//     $startItem = ($page - 1) * $perPage;

//     $sql = "SELECT * FROM event WHERE valid=1 ORDER BY $orderSql LIMIT $startItem,$perPage";
// } else {
//     $page = 1;
//     $order = 1;
//     $sql = "SELECT * FROM event WHERE valid=1 ORDER BY id ASC LIMIT 0,$perPage";
// }



// if(isset($_GET["event_type_id"])){
//     $eventTypeId=$_GET["event_type_id"];
//     var_dump($eventTypeId);
//     $sql = "SELECT event.*, activity_category.activity_name AS category_name
//     FROM event JOIN activity_category ON event.event_type_id = activity_category.id WHERE event.event_type_id=$eventTypeId LIMIT $perPage";
// }else{
//     $sql = "SELECT event.*, activity_category.activity_name AS category_name
//     FROM event JOIN activity_category ON event.event_type_id = activity_category.id
//     LIMIT $perPage";
// }
// $result = $conn->query($sql);


// // if ($result->num_rows > 0) {
// //     while ($row = $result->fetch_assoc()) {
// //         // 處理每一行的資料
// //         echo "Event Name: " . $row["event_name"] . "<br>";
// //         echo "Event Type: " . $row["category_name"] . "<br>";
// //         // 其他欄位處理...
// //     }
// // } else {
// //     echo "No results found.";
// // }


// if (isset($_GET["category"])) {
//     $category = $_GET["category"];
//     $page = isset($_GET["page"]) ? $_GET["page"] : 1;
//     $startActivity = ($page - 1) * $perPage;
//     $sqlActivity = "SELECT * FROM activity_category WHERE id = $category LIMIT $startActivity, $perPage";

// } else {
//     $page = isset($_GET["page"]) ? $_GET["page"] : 1;
//     $startActivity = ($page - 1) * $perPage;
//     $sqlActivity = "SELECT * FROM activity_category LIMIT $startActivity, $perPage";
// }


// // $result = $conn->query($sqlActivity);

// // if ($result->num_rows > 0) {
// //     while ($row = $result->fetch_assoc()) {
// //         // 處理每一行的數據
// //         //echo $row['activity_name'] . '<br>';
// //     }
// // } else {
// //     echo "No results found.";
// // }




// if (isset($_GET["search"])) {
//     $search = $_GET["search"];
//     $sql = "SELECT * FROM event WHERE event_name LIKE '%$search%' AND valid=1";
//     $result = $conn->query($sql);

//     while ($row = $result->fetch_assoc()) {
//         // echo $row['event_name'] . '<br>';
//     }
// } elseif (isset($_GET["page"]) && isset($_GET["order"])) {
//     $page = $_GET["page"];
//     $order = $_GET["order"];
//     switch ($order) {
//         case 1:
//             $orderSql = "id ASC";
//             break;
//         case 2:
//             $orderSql = "id DESC";
//             break;
//         default:
//             $orderSql = "id ASC";
//     }

//     $startItem = ($page - 1) * $perPage;

//     $sql = "SELECT * FROM event WHERE valid=1 ORDER BY $orderSql LIMIT $startItem,$perPage";
// } else {
//     $page = 1;
//     $order = 1;
//     $sql = "SELECT * FROM event WHERE valid=1 ORDER BY id ASC LIMIT 0,$perPage";
// }
// $result = $conn->query($sql);
// $eventCount = $result->num_rows;


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
                        <h1 class="h3 mb-0 text-gray-800 font-weight-bolder">活動列表</h1>
                    </div>
                    <div class="mx-4 mb-3 d-flex justify-content-between">
                        <div>
                            <ul class="nav nav-pills">
                                <li class="nav-item">
                                    <a class="nav-link <?php if (!isset($_GET["event_type_id"])) echo "active"; ?>" aria-current="page" href="event.php">全部種類</a>
                                </li>
                                <?php foreach ($rowsActivityCategory as $ActivityCategory) : ?>
                                    <li class="nav-item">
                                        <a class="nav-link <?php if (isset($_GET["event_type_id"]) && $_GET["event_type_id"] == $ActivityCategory["id"]) echo "active"; ?>" href="event.php?event_type_id=<?= $ActivityCategory["id"] ?>">
                                            <?= $ActivityCategory["activity_name"] ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <form class="mb-3 form-inline navbar-search " action="" method="get">
                            <div class="d-flex">
                                <div class="input-group me-2">
                                    <input type="text" class="form-control small" name="search" placeholder="搜尋活動.." aria-label="Search" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="fas fa-search fa-sm"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="">
                                    <a class=" btn btn-primary text-white" href="add-event.php"><i class="bi bi-plus"></i>新增活動</a>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Content Row -->
                    <?php if ($eventCount > 0) : ?>
                        <div class="table-responsive px-4 animate__animated animate__fadeIn animate__faster">
                            <table class="table table-bordered bg-white align-middle rounded" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr class="text-nowrap text-center">
                                        <th class="align-middle">編號
                                            <?php if (!isset($_GET["event_type_id"])) : ?>
                                                <?php if (!isset($_GET["search"])) : ?>
                                                    <div class=" btn-group m-1">
                                                        <a class="btn btn-primary btn-sm  <?php if ($order == 1) echo "active" ?>" href="event.php?page=<?= $page ?>& order=1"> <i class="bi bi-sort-down-alt"></i></a>
                                                        <a class="btn btn-primary btn-sm <?php if ($order == 2) echo "active" ?>" href="event.php?page=<?= $page ?>&order=2"> <i class="bi bi-sort-down"></i></a>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </th>
                                        <th class="align-middle">活動名稱</th>
                                        <th class="align-middle">活動日期
                                            <?php if (!isset($_GET["event_type_id"])) : ?>
                                                <?php if (!isset($_GET["search"])) : ?>
                                                    <div class="btn-group">
                                                        <a class="btn btn-primary btn-sm  <?php if ($order == 3) echo "active" ?>" href="event.php?page=<?= $page ?>& order=3"> <i class="bi bi-sort-down-alt"></i></a>
                                                        <a class="btn btn-primary btn-sm  <?php if ($order == 4) echo "active" ?>" href="event.php?page=<?= $page ?>&order=4"> <i class="bi bi-sort-down"></i></a>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </th>
                                        <th class="align-middle">活動類型</th>
                                        <th class="align-middle">地點</th>
                                        <th class="align-middle">主辦單位</th>
                                        <th class="align-middle">活動圖片</th>
                                        <th class="align-middle">票價</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody class="small text-center">
                                    <?php while ($row = $result->fetch_assoc()) : ?>
                                        <tr>
                                            <td><?= $row["id"] ?></td>
                                            <td><?= $row["event_name"] ?></td>
                                            <td><?= $row["start_date"] ?> ~ <br><?= $row["end_date"] ?></td>
                                            <td><?= $row["category_name"] ?></td>
                                            <td><?= $row["address"] ?></td>
                                            <td><?= $row["merchant_name"] ?></td>
                                            <td>
                                                <img class="object-fit-contain" src="image/<?= $row["images"] ?>" alt="<?= $row["event_name"] ?>" style="max-width:100%; max-height:25vh">
                                            </td>

                                            <td><?= $row["event_price"] ?></td>

                                            <td style="width: 4vw;">
                                                <a class="m-2 btn btn-primary btn-sm" href="update.php?id=<?= $row["id"] ?>"><i class="bi bi-pencil-fill"></i></a>

                                                <button type="button" class="m-2 btn btn-danger  btn-sm" data-toggle="modal" data-target="#exampleModal"><i class="bi bi-trash-fill"></i>
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">警告</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                確定刪除?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-info" data-dismiss="modal">取消</button>
                                                                <a type="button" class="btn btn-danger" href="delete.php?id=<?= $row["id"] ?>">刪除</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                    <?php endwhile; ?>

                                </tbody>
                            </table>

                            <?php if (!isset($_GET["event_type_id"])) : ?>
                                <?php if (!isset($_GET["search"])) : ?>
                                    <div class="py-2 d-flex justify-content-center">
                                        <nav aria-label="Page navigation example">
                                            <ul class="pagination">
                                                <?php for ($i = 1; $i <= $pageCount; $i++) : ?>
                                                    <li class="page-item <?php if ($page == $i) echo "active"; ?>"><a class="page-link" href="event.php?page=<?= $i ?>&order=<?= $order ?>"><?= $i ?></a></li>
                                                <?php endfor; ?>

                                            </ul>
                                        </nav>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>


                        <?php else : ?>
                            目前無活動
                        <?php endif; ?>

                        </div>
                </div>
            </div>
        </div>


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