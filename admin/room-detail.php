<?php
$room_management = true;

require_once "../core/init.php";
require_once "../core/admin-session-only.php";

$now = date("Y-m-d H:i:s");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "SELECT * FROM rooms WHERE id = '$id'";
    $result = mysqli_query($link, $query);
    $data = mysqli_fetch_assoc($result);

    $thumbnail = $data['thumbnail'];
    $room_name = $data['room_name'];
    $location = $data['location'];
    $capacity = $data['capacity'];
    $description = $data['description'];
    $status = $data['status'];

    $room_id = $data['id'];
    $query2 = "SELECT * FROM tickets WHERE room_id='$room_id' AND time_start <= '$now' AND time_end >= '$now'";
    $result2 = mysqli_query($link, $query2);

    if (mysqli_num_rows($result2) > 0) {
        $data2 = mysqli_fetch_assoc($result2);

        $user_id = $data2['user_id'];
        $query3 = "SELECT * FROM users WHERE id = '$user_id'";
        $result3 = mysqli_query($link, $query3);
        $data3 = mysqli_fetch_assoc($result3);
        $empty = false;
    } else {
        $empty = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="icon" href="../assets/img/favicon.png">

    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">

    <!-- Fontawesome -->
    <link rel="stylesheet" href="../assets/vendor/fontawesome/css/all.min.css">

    <!-- DataTables CSS -->
    <!-- <link rel="stylesheet" href="../assets/vendor/datatables/DataTables-1.11.5/css/dataTables.bootstrap4.min.css"> -->

    <!-- Custom styles for navigation-->
    <link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom style -->
    <link rel="stylesheet" href="../assets/css/co-lab.css">

    <title>Detail Ruangan | Co-Lab</title>


</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include "views/sidebar.php" ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include "views/topbar.php" ?>

                <!-- Begin Page Content -->
                <div class="container-fluid mb-4">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Manajemen Ruangan</h1>
                        <!-- <a href="room-add.php" class="d-none d-sm-inline-block btn btn-sm btn-red shadow-sm"><i class="fas fa-plus fa-sm"></i> Add New Room</a> -->
                    </div>

                    <div class="card shadow col-md-12 ">
                        <div class="card-body table-responsive">
                            <h5 class="text-dark"><a href="#" onclick="history.back()" class="text-decoration-none text-dark"><i class="fa-solid fa-arrow-left-long"></i> Kembali</h5></a><br>
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="mb-3">
                                        <img src="../assets/img/rooms/<?= $thumbnail ?>" class="thumbnail-room shadow-sm rounded">
                                    </div>
                                    <h5><?= $room_name; ?></h5>
                                    <h6><i class="fa-solid fa-location-dot fa-fw"></i> <?= $location; ?></h6>
                                </div>
                                <div class="col-md-7">
                                    <dl class="row">
                                        <dt class="col-sm-4"><i class="fa-solid fa-people-group fa-fw"></i> Kapasitas</dt>
                                        <dd class="col-sm-8"><?= $capacity; ?> Orang</dd>

                                        <dt class="col-sm-4"><i class="fa-solid fa-align-left fa-fw"></i> Deskripsi</dt>
                                        <dd class="col-sm-8">
                                            <?= $description; ?>
                                        </dd>
                                        <dt class="col-sm-4"><i class="fa-solid fa-toggle-<?= $status == 'active' ? 'on' : 'off'; ?> fa-fw"></i> Status</dt>
                                        <dd class="col-sm-8"><?= $status == 'active' ? 'Aktif' : 'Tidak Aktif'; ?></dd>
                                        <dt class="col-sm-4"><i class="fa-solid fa-clipboard-check fa-fw"></i> Ketersediaan</dt>
                                        <dd class="col-sm-8"><?= $empty == true ? "<span class='text-success'>Tersedia Saat Ini</span>" : "<span class='text-danger'>Sedang Digunakan</span>"; ?></dd>
                                        <dt class="col-sm-4"><i class="fa-solid fa-user-tie fa-fw"></i> Penanggung Jawab</dt>
                                        <dd class="col-sm-8"><?= $empty == false ? $data3['fullname'] : "-" ?></dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php include "views/footer.php" ?>

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
                    <a class="btn btn-primary" href="../logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="../assets/vendor/jquery/jquery.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../assets/vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="../assets/js/sb-admin-2.min.js"></script>

</body>

</html>