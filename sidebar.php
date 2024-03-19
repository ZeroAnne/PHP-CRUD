<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        <div class="sidebar-brand-icon rotate-n-15">
            <!-- <i class="fa-solid fa-ticket"></i> -->
        </div>
        <div class="sidebar-brand-text mx-3"><img src="../logo.png" alt="" style="width: 80%;"></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Sidebar Message -->
    <div class="sidebar-card d-flex overflow-hidden" id="sidebarCard">
        <img class="sidebar-card-illustration" src="../image/drawkit-transport-scene-8.png" style="width: auto;" alt="...">
    </div>

    <!-- Nav Item - Dashboard -->
    <!-- <li class="nav-item active">
        <a class="nav-link text-shadow-20" href="index.html">
            <i class="bi bi-speedometer"></i>
            <span>平台管理</span></a>
    </li> -->

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Interface
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed text-shadow-20" href="#" data-toggle="collapse" data-target="#collapseMember" aria-expanded="true" aria-controls="collapseMember">
            <i class="bi bi-people-fill"></i>
            <span>會員管理</span>
        </a>
        <div id="collapseMember" class="collapse" aria-labelledby="headingMember" data-parent="#accordionSidebar">
            <div class="bg-white-transparency py-2 collapse-inner rounded text-shadow-20">
                <h6 class="collapse-header">Member Management</h6>
                <a class="collapse-item" href="../member(QunweiChen)/member_list.php">會員清單</a>
                <a class="collapse-item" href="../member(QunweiChen)/member_signup.php">會員註冊（客戶端）</a>
                <a class="collapse-item" href="../member(QunweiChen)/member_login.php">會員登入（客戶端）</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed text-shadow-20" href="#" data-toggle="collapse" data-target="#collapseOrganizer" aria-expanded="true" aria-controls="collapseOrganizer">
            <i class="bi bi-building-fill"></i>
            <span>主辦單位管理</span>
        </a>
        <div id="collapseOrganizer" class="collapse" aria-labelledby="headingOrganizer" data-parent="#accordionSidebar">
            <div class="bg-white-transparency py-2 collapse-inner rounded text-shadow-20">
                <h6 class="collapse-header">Orangizer Management</h6>
                <a class="collapse-item" href="../organizer(peter)/organizer-list.php">主辦單位清單</a>
                <a class="collapse-item" href="../organizer(peter)/organizer-add.php">手動新增</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed text-shadow-20" href="#" data-toggle="collapse" data-target="#collapseEvent" aria-expanded="true" aria-controls="collapseEvent">
            <i class="bi bi-calendar-event-fill"></i>
            <span>活動管理</span>
        </a>
        <div id="collapseEvent" class="collapse" aria-labelledby="headingEvent" data-parent="#accordionSidebar">
            <div class="bg-white-transparency py-2 collapse-inner rounded text-shadow-20">
                <h6 class="collapse-header">Event Management</h6>
                <a class="collapse-item" href="../event/event.php">活動清單</a>
                <a class="collapse-item" href="../ticket(Angus%20Lin)/ticket-list.php">票卷管理</a>
            </div>
        </div>
    </li>
    <li class="nav-item text-shadow-20">
        <a class="nav-link" href="../user_order(Abo)/index-Abo.php">
            <i class="bi bi-border-width"></i>
            <span>訂單管理</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed text-shadow-20" href="coupon-list.php" data-toggle="collapse" data-target="#collapseCoupon" aria-expanded="true" aria-controls="collapseCoupon">
            <i class="bi bi-calendar-event-fill"></i>
            <span>優惠卷管理</span>
        </a>
        <div id="collapseCoupon" class="collapse" aria-labelledby="headingCoupon" data-parent="#accordionSidebar">
            <div class="bg-white-transparency py-2 collapse-inner rounded text-shadow-20">
                <h6 class="collapse-header">Coupon Management</h6>
                <a class="collapse-item" href="../coupon(ZeroAnne)/coupon-list.php?page=1&order=1">優惠券清單</a>
                <a class="collapse-item" href="../coupon(ZeroAnne)/add-coupon.php">優惠券新增</a>
                <!-- <a class="collapse-item" href="../coupon(ZeroAnne)/coupon-list-edit.php">編輯/刪除優惠券</a> -->
            </div>
        </div>
    </li>
    <!-- Divider -->


    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>



</ul>
<!-- End of Sidebar -->