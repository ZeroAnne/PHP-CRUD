<?php
// if(!isset($_GET["id"])){
//      header("location: 404.php");
// }

$id = $_GET["id"];

require_once("../connect_server.php");

$sql = "SELECT * FROM ticket_type WHERE id=$id AND valid=2";

$result = $conn->query($sql);
$ticketType = $result->num_rows;

$ticketTypeRow = $result->fetch_assoc();

if ($ticketTypeRow) {

    $ticket_type_id = $ticketTypeRow["ticket_type_id"];
    $category_id = $ticketTypeRow["category_id"];

    switch ($ticket_type_id) {
        case 0:
            $seatChoice = "不行";
            break;
        case 1:
            $seatChoice = "可以";
            break;
        default:
            $seatChoice = "座位設定未選擇";
    }

    switch ($category_id) {
        case 1:
            $categoryName = "演唱會";
            break;
        case 2:
            $categoryName = "展覽";
            break;
        case 3:
            $categoryName = "快閃限定活動";
            break;
        case 4:
            $categoryName = "市集";
            break;
        case 5:
            $categoryName = "粉絲見面會";
            break;
        case 6:
            $categoryName = "課程講座";
            break;
        case 7:
            $categoryName = "體育賽事";
            break;
        case 8:
            $categoryName = "景點門票";
            break;
        default:
            $categoryName = "票卷種類未選擇";
    }
} else {
    $seatChoice = "座位設定未選擇";
    $categoryName = "票卷種類未選擇";
}

$categories = [
    1 => "演唱會",
    2 => "展覽",
    3 => "快閃限定活動",
    4 => "市集",
    5 => "粉絲見面會",
    6 => "課程講座",
    7 => "體育賽事",
    8 => "景點門票"
];

$sqlImg = "SELECT ticket_type.category_id, ticket_images.* FROM ticket_type
JOIN ticket_images ON ticket_type.category_id = ticket_images.id WHERE $id = ticket_type.id ";
$imgResult = $conn->query($sqlImg);
$rowsImg = $imgResult->fetch_assoc();

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

<?php include("../alert.php"); ?>

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
                    <div class="d-sm-flex align-items-center justify-content-between mb-4 mx-4">
                        <h1 class="h3 mb-0 text-gray-800 font-weight-bolder"><a href="ticket-type.php?id=<?= $id ?>" title="回到票卷種類管理"><i class="bi bi-backspace px-1"></i>
                            </a>票卷種類個別資料
                        </h1>
                    </div>

                    <!-- Content Row -->
                    <div class="animate__animated animate__fadeIn animate__faster">
                        <form action="doUpdateTicketType.php" method="post">
                            <input type="hidden" name="id" value="<?= $ticketTypeRow["id"] ?>">
                            <!-- <?php var_dump($ticketTypeRow["id"]); ?> -->
                            <div class="card mb-3">
                                <div class="row g-0">
                                    <div class="col-md-4 d-flex align-items-center justify-content-center">
                                        <img class="image-thumbnail rounded" src="../ticket(Angus Lin)/images/<?= $rowsImg['images'] ?>" style="max-width:100%" alt="">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <div class="card-header">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <a class="btn" type="button" style="transition: background-color 0.3s, color 0.3s;" onmouseover="this.style.backgroundColor='#fd7e14'; this.style.color='white';" onmouseout="this.style.backgroundColor=''; this.style.color='';">票卷名稱：</a>
                                                    </div>
                                                    <input type="text" class="form-control" name="name" id="name" value="<?= $ticketTypeRow["name"] ?>" required>
                                                </div>
                                            </div>
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item">
                                                    <div class="input-group-prepend">
                                                        <a class="btn" type="button" style="transition: background-color 0.3s, color 0.3s;" onmouseover="this.style.backgroundColor='#fd7e14'; this.style.color='white';" onmouseout="this.style.backgroundColor=''; this.style.color='';">活動編號：<?= $ticketTypeRow["event_id"] ?>
                                                        </a>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <a class="btn" type="button" style="transition: background-color 0.3s, color 0.3s;" onmouseover="this.style.backgroundColor='#fd7e14'; this.style.color='white';" onmouseout="this.style.backgroundColor=''; this.style.color='';">票卷種類：</a>
                                                        </div>
                                                        <select class="custom-select" id="category_id" name="category_id">
                                                            <!-- <?= ($name == $categoryName) ? 'selected' : '' ?> is a ternary operator that checks if the current category name ($name) matches the $categoryName variable. If they match, it outputs selected, which marks this <option> as the currently selected one in the dropdown. If they do not match, it outputs nothing, leaving the option unselected.
                                                            <?= $name ?> outputs the category name, which is displayed to the user in the dropdown menu -->
                                                            <?php foreach ($categories as $id => $name) : ?>
                                                                <option value="<?= $id ?>" <?= ($name == $categoryName) ? 'selected' : '' ?>><?= $name ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <a class="btn" type="button" style="transition: background-color 0.3s, color 0.3s;" onmouseover="this.style.backgroundColor='#fd7e14'; this.style.color='white';" onmouseout="this.style.backgroundColor=''; this.style.color='';">可否選擇座位：</a>
                                                        </div>
                                                        <select class="custom-select" id="ticket_type_id" name="ticket_type_id">
                                                            <?php if ($seatChoice == "可以") : ?>
                                                                <option value="1" selected>可以</option>
                                                                <option value="0">不行</option>
                                                            <?php else : ?>
                                                                <option value="1">可以</option>
                                                                <option value="0" selected>不行</option>
                                                            <?php endif; ?>
                                                        </select>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <a class="btn" type="button" style="transition: background-color 0.3s, color 0.3s;" onmouseover="this.style.backgroundColor='#fd7e14'; this.style.color='white';" onmouseout="this.style.backgroundColor=''; this.style.color='';">票卷價格：</a>
                                                        </div>
                                                        <input type="number" class="form-control" name="price" id="price" value="<?= $ticketTypeRow["price"] ?>" required>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <a class="btn" type="button" style="transition: background-color 0.3s, color 0.3s;" onmouseover="this.style.backgroundColor='#fd7e14'; this.style.color='white';" onmouseout="this.style.backgroundColor=''; this.style.color='';">票卷數量：</a>
                                                        </div>
                                                        <input type="number" class="form-control" name="max_quantity" id="max_quantity" value="<?= $ticketTypeRow["max_quantity"] ?>" required>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <a class="btn" type="button" style="transition: background-color 0.3s, color 0.3s;" onmouseover="this.style.backgroundColor='#fd7e14'; this.style.color='white';" onmouseout="this.style.backgroundColor=''; this.style.color='';">票卷剩餘數量：</a>
                                                        </div>
                                                        <input type="number" class="form-control" name="remaining_quantity" id="remaining_quantity" value="<?= $ticketTypeRow["remaining_quantity"] ?>" required>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="input-group-prepend">
                                                        <a class="btn" type="button" style="transition: background-color 0.3s, color 0.3s;" onmouseover="this.style.backgroundColor='#fd7e14'; this.style.color='white';" onmouseout="this.style.backgroundColor=''; this.style.color='';" id="created_at" name="created_at">創建時間：<?= $ticketTypeRow["created_at"] ?></a>
                                                    </div>
                                                </li>
                                                <li class="list-group-item px-4">
                                                    <button class="btn btn-outline-warning" type="submit" style="transition: background-color 0.3s, color 0.3s;" onmouseover="this.style.backgroundColor='#fd7e14'; this.style.color='white';" onmouseout="this.style.backgroundColor=''; this.style.color='';">
                                                        <i class="bi bi-floppy-fill"></i> 儲存
                                                    </button>
                                                    <a class="btn btn-outline-danger mx-2" href="ticket-type.php?id=<?= $id ?>" style="transition: background-color 0.3s, color 0.3s;" onmouseover="this.style.backgroundColor='#fd7e14'; this.style.color='white';" onmouseout="this.style.backgroundColor=''; this.style.color='';">
                                                        <i class="bi bi-x-octagon-fill"></i> 取消
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
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