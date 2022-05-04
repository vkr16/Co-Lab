<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon">
            <img src="../assets/img/logo-white.png" width="40px">
        </div>
        <div class="sidebar-brand-text mx-2">Co-Lab</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item <?php echo $dashboard == true ? 'active' : '' ?>">
        <a class="nav-link" href="index.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Interface
    </div>

    <li class="nav-item <?php echo $room_management == true ? 'active' : '' ?>">
        <a class="nav-link" href="room-management.php">
            <i class="fa-solid fa-building fa-fw"></i>
            <span>Room Management</span></a>
    </li>
    <li class="nav-item <?php echo $user_management == true ? 'active' : '' ?>">
        <a class="nav-link" href="user-management.php">
            <i class="fa-solid fa-user-gear fa-fw"></i>
            <span>User Management</span></a>
    </li>


    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->