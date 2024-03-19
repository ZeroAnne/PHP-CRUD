<?php
require_once("../connect_server.php");

$use = isset($_GET["use"]) ? $_GET["use"] : null;
$search = isset($search) ? $search : '';

if ($use !== null) {
    $use = $_GET["use"];
    $sqlTotal = "SELECT * FROM coupon WHERE coupon_valid='$use' ";
} elseif (isset($_GET["search"])) {
    $search = $_GET["search"];
    $sqlTotal = "SELECT * FROM coupon 
    JOIN couponvalid ON coupon.coupon_valid=couponvalid.coupon_valid_id 
    JOIN activity_category ON coupon.activity_num=activity_category.id 
    WHERE activity_name LIKE '%$search%'AND (coupon_valid=2 OR coupon_valid=1) OR coupon_name LIKE '%$search%'AND (coupon_valid=2 OR coupon_valid=1)";
} else {
    $sqlTotal = "SELECT * FROM coupon WHERE (coupon_valid=2 OR coupon_valid=1)";
}

//查詢資料//幾筆資料
$resultTotal = $conn->query($sqlTotal);
$totalUser = $resultTotal->num_rows;
$perPage = 5;
$pageCount = ceil($totalUser / $perPage);

if (isset($_GET["search"])) {
    $search = $_GET["search"];
    $sql = "SELECT coupon.* ,coupon_valid_name, activity_name 
    FROM coupon 
    JOIN couponvalid ON coupon.coupon_valid=couponvalid.coupon_valid_id 
    JOIN activity_category ON coupon.activity_num=activity_category.id 
    WHERE activity_name LIKE '%$search%'AND (coupon_valid=2 OR coupon_valid=1) OR coupon_name LIKE '%$search%'AND (coupon_valid=2 OR coupon_valid=1)";
} elseif (isset($_GET["use"]) && isset($_GET["page"]) && isset($_GET["order"])) {
    $use = $_GET["use"];
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
            $orderSql = "activity_num ASC";
            break;
        case 4:
            $orderSql = "activity_num DESC";
            break;
        default:
            $orderSql = "id ASC";
    }
    // var_dump($use);
    $starItem = ($page - 1) * $perPage;
    $sql = "SELECT coupon.* ,coupon_valid_name, activity_name 
    FROM coupon 
    JOIN couponvalid ON coupon.coupon_valid=couponvalid.coupon_valid_id 
    JOIN activity_category ON coupon.activity_num=activity_category.id AND coupon_valid='$use' ORDER BY $orderSql LIMIT $starItem,$perPage";
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
            $orderSql = "activity_num ASC";
            break;
        case 4:
            $orderSql = "activity_num DESC";
            break;
        default:
            $orderSql = "id ASC";
    }
    // var_dump($use);
    $starItem = ($page - 1) * $perPage;
    $sql = "SELECT coupon.* ,coupon_valid_name, activity_name 
    FROM coupon 
    JOIN couponvalid ON coupon.coupon_valid=couponvalid.coupon_valid_id 
    JOIN activity_category ON coupon.activity_num=activity_category.id AND (coupon_valid=2 OR coupon_valid=1) ORDER BY $orderSql LIMIT $starItem,$perPage";
} else {
    $page = 1;
    $order = 1;
    $sql = "SELECT coupon.* ,coupon_valid_name, activity_name 
    FROM coupon 
    JOIN couponvalid ON coupon.coupon_valid=couponvalid.coupon_valid_id 
    JOIN activity_category ON coupon.activity_num=activity_category.id WHERE(coupon_valid=2 OR coupon_valid=1)
    LIMIT 0,$perPage";
}

$result = $conn->query($sql);
$rows = $result->fetch_all(MYSQLI_ASSOC);
// var_dump($rows)


//時間判斷
foreach ($rows as $rowtime) {
    // 假設你有一個日期時間字符串
    $dateStringexpiresAt = $rowtime["expires_at"];
    $dateStringstartAt = $rowtime["start_at"];
    // 將日期時間字符串轉換為Unix時間戳
    $timeStampexpiresAt = strtotime($dateStringexpiresAt);
    $timeStampstartAt = strtotime($dateStringstartAt);
    // 獲取當前的Unix時間戳
    $currentTimeStamp = time();

    // 進行時間比較
    if ($timeStampexpiresAt < $currentTimeStamp || $timeStampstartAt > $currentTimeStamp) {
        // echo "{$dateString} 在現在之前。";
        $updatesql = "UPDATE coupon SET coupon_valid='2' WHERE id = '$rowtime[id]'";
        // var_dump($updatesql);
        if ($conn->query($updatesql) === TRUE) {
            // echo "更新成功";
        } else {
            // echo "更新資料錯誤: " . $conn->error;
        }
    } elseif ($timeStampexpiresAt > $currentTimeStamp || $timeStampstartAt < $currentTimeStamp) {
        // echo "{$dateString} 在現在之後。";
        $updatesql = "UPDATE coupon SET coupon_valid='1' WHERE id = '$rowtime[id]'";
        // var_dump($updatesql);
        if ($conn->query($updatesql) === TRUE) {
            // echo "更新成功";
        } else {
            // echo "更新資料錯誤: " . $conn->error;
        }
    } else {
        // echo "{$dateString} 和現在是相同的時間。";
    }
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

    <title>編輯優惠券</title>

    <!-- 公用head -->
    <?php include('../public_head.php') ?>

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
                    <div class="d-sm-flex align-items-center justify-content-between pt-3 mb-4 mx-4">
                        <h1 class="h3 mb-0 text-gray-800 font-weight-bolder">優惠券清單</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="mx-4 animate__animated animate__fadeIn animate__faster">
                        <div class="py-2">
                            <form action="">
                                <div class="input-group mb-3 ">
                                    <?php if (isset($_GET["search"])) : ?>
                                        <input type="text" class="form-control" value="<?= $_GET['search'] ?>" name="search">
                                        <button class="btn btn-primary" type="submit" id=""><i class="bi bi-search"></i></button>
                                    <?php else : ?>
                                        <input type="text" class="form-control" placeholder="請輸入優惠券名稱或適用活動" name="search">
                                        <button class="btn btn-primary" type="submit" id=""><i class=" bi bi-search"></i></button>
                                    <?php endif; ?>
                                </div>
                            </form>
                        </div>
                        <?php if (!isset($_GET["search"])) : ?>
                            <div class="pb-2 d-flex justify-content-between orders align-items-center">
                                <div class="btn-group">
                                    <a class="btn btn-outline-primary <?php if (!isset($_GET["use"])) echo "active"; ?>" href="coupon-list.php?page=1&order=<?= $order ?>">總票券量</a>
                                    <a class="btn btn-outline-primary <?php if ($use == 1) echo "active"; ?>" href="coupon-list.php?page=1&use=1&order=<?= $order ?>">可使用</a>
                                    <a class="btn btn-outline-primary <?php if ($use == 2) echo "active"; ?>" href="coupon-list.php?page=1&use=2&order=<?= $order ?>">已停用</a>
                                </div>
                                <div class="dropdown">
                                    <a class="btn btn-primary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="0,10">
                                        排序方式
                                    </a>
                                    <ul class="dropdown-menu">
                                        <?php if (!isset($_GET["order"])) : $order = 1; ?>
                                        <?php endif; ?>
                                        <?php if (isset($_GET["use"])) : ?>
                                            <li><a class="dropdown-item <?php if ($order == 1) echo "active"; ?>" href="coupon-list.php?page=<?= $page ?>&order=1&use=<?= $use ?>">ID由小<i class="bi bi-arrow-right-short"></i>大</a></li>
                                            <li><a class="dropdown-item <?php if ($order == 2) echo "active"; ?>" href="coupon-list.php?page=<?= $page ?>&order=2&use=<?= $use ?>">ID由大<i class="bi bi-arrow-right-short"></i>小</a></li>
                                            <li><a class="dropdown-item <?php if ($order == 3) echo "active"; ?>" href="coupon-list.php?page=<?= $page ?>&order=3&use=<?= $use ?>">活動類別由小<i class="bi bi-arrow-right-short"></i>大</a></li>
                                            <li><a class="dropdown-item <?php if ($order == 4) echo "active"; ?>" href="coupon-list.php?page=<?= $page ?>&order=4&use=<?= $use ?>">活動類別由大<i class="bi bi-arrow-right-short"></i>小</a></li>
                                        <?php else : ?>
                                            <li><a class="dropdown-item <?php if ($order == 1) echo "active"; ?>" href="coupon-list.php?page=<?= $page ?>&order=1">ID由小<i class="bi bi-arrow-right-short"></i>大</a></li>
                                            <li><a class="dropdown-item <?php if ($order == 2) echo "active"; ?>" href="coupon-list.php?page=<?= $page ?>&order=2">ID由大<i class="bi bi-arrow-right-short"></i>小</a></li>
                                            <li><a class="dropdown-item <?php if ($order == 3) echo "active"; ?>" href="coupon-list.php?page=<?= $page ?>&order=3">活動類別由小<i class="bi bi-arrow-right-short"></i>大</a></li>
                                            <li><a class="dropdown-item <?php if ($order == 4) echo "active"; ?>" href="coupon-list.php?page=<?= $page ?>&order=4">活動類別由大<i class="bi bi-arrow-right-short"></i>小</a></li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if (!isset($_GET["search"])) : ?>
                            <div class="pb-2 text-end">
                                共 <?= $totalUser ?> 筆
                            </div>
                        <?php else : ?>

                            <div class="pb-2 text-end">
                                搜尋"<?= $_GET['search'] ?>"的結果,
                                共 <?= $totalUser ?> 筆
                                <a href="coupon-list.php?page=1&order=1" class="text-primary">
                                    <div class="d-flex justify-content-end align-items-center">
                                        <div>回優惠券列表</div>
                                        <i class="bi bi-box-arrow-right fs-4 ms-3"></i>
                                    </div>
                                </a>
                            </div>
                        <?php endif; ?>
                        <table class="table text-center text-nowrap align-items-center table-hover ">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>兌換代碼</th>
                                    <th>優惠券名稱</th>
                                    <th>使用狀態</th>
                                    <th>折扣類型</th>
                                    <th>打折/金額折價</th>
                                    <th>開始日期</th>
                                    <th>到期日期</th>
                                    <th>最低消費</th>
                                    <th>剩餘張數</th>
                                    <th>適用活動</th>
                                    <th>編輯資訊</th>
                                </tr>
                            </thead>
                            <tbody class="">
                                <?php foreach ($rows as $row) : ?>
                                    <?php if (!isset($_GET["search"])) : ?>
                                        <div class="modal fade" id="alertModal<?= $row["id"] ?><?= $_GET["page"] ?><?= $_GET["order"] ?><?php if (isset($_GET["use"]))  echo $_GET["use"] ?>" tabindex="-1" aria-labelledby="" aria-hidden="true">
                                        <?php elseif (!isset($_GET["search"])) : ?>
                                            <div class="modal fade" id="alertModal<?= $_GET["search"] ?>" tabindex="-1" aria-labelledby="" aria-hidden="true">
                                            <?php else : ?>
                                                <div class="modal fade" id="alertModal" tabindex="-1" aria-labelledby="" aria-hidden="true">
                                                <?php endif; ?>
                                                <div class="modal-dialog modal-sm">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">警告</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            確認刪除?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">關閉</button>
                                                            <?php if (!isset($_GET["search"])) : ?>
                                                                <a href="doDeleteCoupon.php?id=<?= $row["id"] ?>&page=<?= $_GET["page"] ?>&order=<?= $_GET["order"] ?><?php if (isset($_GET["use"]))  echo '&use=' . $_GET["use"] ?> " type="button" class="btn btn-danger">確定刪除</a>
                                                            <?php elseif (isset($_GET["search"])) : ?>
                                                                <a href="doDeleteCoupon.php?id=<?= $row["id"] ?>&search=<?= $_GET["search"] ?>" type="button" class="btn btn-danger">確定刪除</a>
                                                            <?php else : ?>
                                                                <a href="doDeleteCoupon.php?id=<?= $row["id"] ?>" type="button" class="btn btn-danger">確定刪除</a>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                </div>
                                                <tr class="small">
                                                    <td><?= $row["id"] ?></td>
                                                    <td><?= $row["coupon_code"] ?></td>
                                                    <td><?= $row["coupon_name"] ?></td>
                                                    <td class="<?php if ($row["coupon_valid"] == 2) echo "text-danger"; ?>"><?= $row["coupon_valid_name"] ?></td>
                                                    <td><?= $row["discount_type"] ?></td>
                                                    <td><?= $row["discount_valid"] ?></td>
                                                    <td><?= $row["start_at"] ?></td>
                                                    <td><?= $row["expires_at"] ?></td>
                                                    <td><?= $row["price_min"] ?></td>
                                                    <td><?= $row["max_usage"] ?></td>
                                                    <td><?= $row["activity_name"] ?></td>
                                                    <td>
                                                        <a class="btn text-primary p-1" href="coupon.php?id=<?= $row["id"] ?>" title="詳細資料"><i class="bi bi-ticket-perforated-fill"></i></a>
                                                        <a class="btn text-primary p-1" href="coupon-edit.php?id=<?= $row["id"] ?>" title="編輯資料"><i class="bi bi-pencil-fill"></i></a>
                                                        <!-- <button type="button" data-bs-toggle="modal" data-bs-target="#alertModal" class="btn btn-danger">刪除</button> -->
                                                        <?php if (!isset($_GET["search"])) : ?>
                                                            <a class="btn text-primary p-1" data-bs-toggle="modal" data-bs-target="#alertModal<?= $row["id"] ?><?= $_GET["page"] ?><?= $_GET["order"] ?><?php if (isset($_GET["use"]))  echo $_GET["use"] ?> " title="刪除資料"><i class="bi bi-trash3"></i></a>
                                                        <?php else : ?>
                                                            <a class="btn text-primary p-1" data-bs-toggle="modal" data-bs-target="#alertModal " title="刪除資料"><i class="bi bi-trash3"></i></a>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?php if (!isset($_GET["search"])) : ?>
                            <?php if (isset($_GET["use"])) : ?>
                                <nav aria-label="Page navigation example d-flex justify-content-between align-items-center">
                                    <ul class="pagination">
                                        <li class="page-item">
                                            <?php if ($page == 1) : ?>
                                                <a class="page-link" href="coupon-list.php?page=<?= $page ?>&use=<?= $use ?>&order=<?= $order ?>" aria-label="Previous">
                                                    <span aria-hidden="true">&laquo;</span>
                                                </a>
                                            <?php else : ?>
                                                <a class="page-link" href="coupon-list.php?page=<?= $page - 1 ?>&use=<?= $use ?>&order=<?= $order ?>" aria-label="Previous">
                                                    <span aria-hidden="true">&laquo;</span>
                                                </a>
                                            <?php endif; ?>
                                        </li>
                                        <?php for ($i = 1; $i <= $pageCount; $i++) : ?>
                                            <li class="page-item <?php if ($page == $i) echo "active"; ?>"><a class="page-link" href="coupon-list.php?page=<?= $i ?>&use=<?= $use ?>&order=<?= $order ?>"><?= $i ?></a></li>
                                        <?php endfor; ?>
                                        <li class="page-item">
                                            <?php if ($page == $pageCount) : ?>
                                                <a class="page-link" href="coupon-list.php?page=<?= $page ?>&use=<?= $use ?>&order=<?= $order ?>" aria-label="Next">
                                                    <span aria-hidden="true">&raquo;</span>
                                                </a>
                                            <?php else : ?>
                                                <a class="page-link" href="coupon-list.php?page=<?= $page + 1 ?>&use=<?= $use ?>&order=<?= $order ?>" aria-label="Next">
                                                    <span aria-hidden="true">&raquo;</span>
                                                </a>
                                            <?php endif; ?>
                                        </li>
                                    </ul>
                                </nav>
                            <?php else : ?>
                                <nav aria-label="Page navigation example d-flex justify-content-between align-items-center">
                                    <ul class="pagination">
                                        <li class="page-item">
                                            <?php if ($page == 1) : ?>
                                                <a class="page-link" href="coupon-list.php?page=<?= $page ?>&order=<?= $order ?>" aria-label="Previous">
                                                    <span aria-hidden="true">&laquo;</span>
                                                </a>
                                            <?php else : ?>
                                                <a class="page-link" href="coupon-list.php?page=<?= $page - 1 ?>&order=<?= $order ?>" aria-label="Previous">
                                                    <span aria-hidden="true">&laquo;</span>
                                                </a>
                                            <?php endif; ?>
                                        </li>
                                        <?php for ($i = 1; $i <= $pageCount; $i++) : ?>
                                            <li class="page-item <?php if ($page == $i) echo "active"; ?>"><a class="page-link" href="coupon-list.php?page=<?= $i ?>&order=<?= $order ?>"><?= $i ?></a></li>
                                        <?php endfor; ?>
                                        <li class="page-item">
                                            <?php if ($page == $pageCount) : ?>
                                                <a class="page-link" href="coupon-list.php?page=<?= $page ?>&order=<?= $order ?>" aria-label="Next">
                                                    <span aria-hidden="true">&raquo;</span>
                                                </a>
                                            <?php else : ?>
                                                <a class="page-link" href="coupon-list.php?page=<?= $page + 1 ?>&order=<?= $order ?>" aria-label="Next">
                                                    <span aria-hidden="true">&raquo;</span>
                                                </a>
                                            <?php endif; ?>
                                        </li>
                                    </ul>
                                </nav>
                            <?php endif; ?>
                        <?php endif; ?>
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