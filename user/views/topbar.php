<?php

$session_user = $_SESSION['cl_user'];
$query = "SELECT * FROM users WHERE username = '$session_user'";
$result = mysqli_query($link, $query);
$data = mysqli_fetch_assoc($result);

$fullname = $data['fullname'];
$studentid = $data['studentid'];

?>

<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Search -->
    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 navbar-search">

        <span class="text-primary small">Halaman ini dimuat pada : <?= date("j/n/Y, h:i A"); ?></span>


    </form>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">



        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $fullname . " (" . $studentid . ")" ?></span>
                <img class="img-profile rounded-circle" src="../assets/img/users/<?= $data['photo'] ?>">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item " href="<?= $home ?>/user/account-update.php">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Perbarui Data Pengguna
                </a>

                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="<?= $home ?>/logout.php">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Keluar
                </a>
            </div>
        </li>

    </ul>

</nav>
<!-- End of Topbar -->