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
            <i class="fa-solid fa-flask-vial"></i>
            <span>Laboratorium</span></a>
    </li>
    <li class="nav-item <?php echo $space == true ? 'active' : '' ?>">
        <a class="nav-link" href="workspaces.php">
            <i class="fa-solid fa-house-laptop"></i>
            <span>Ruang Kerja Bersama</span></a>
    </li>
    <li class="nav-item <?php echo $myTickets == true ? 'active' : '' ?>">
        <a class="nav-link" href="my-tickets.php">
            <i class="fa-solid fa-ticket"></i>
            <span>Tiket Saya</span></a>
    </li>

    <!-- <div class="sidebar-heading">
        Interface
    </div> -->

    <!-- <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Utilities</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Custom Utilities:</h6>
                <a class="collapse-item" href="utilities-color.html">Colors</a>
                <a class="collapse-item" href="utilities-border.html">Borders</a>
                <a class="collapse-item" href="utilities-animation.html">Animations</a>
                <a class="collapse-item" href="utilities-other.html">Other</a>
            </div>
        </div>
    </li> -->

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->