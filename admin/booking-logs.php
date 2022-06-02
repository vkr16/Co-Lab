<?php
$logs = true;

require_once "../core/init.php";
require_once "../core/admin-session-only.php";

$now = date("Y-m-d H:i:s");

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
    <link rel="stylesheet" href="../assets/vendor/datatables/DataTables-1.11.5/css/dataTables.bootstrap4.min.css">

    <!-- Custom styles for navigation-->
    <link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom style -->
    <link rel="stylesheet" href="../assets/css/co-lab.css">

    <title>Log Pembukuan | Co-Lab</title>


</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include "views/sidebar.php" ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content position-absolute">

                <!-- Topbar -->
                <?php include "views/topbar.php" ?>

                <!-- Begin Page Content -->
                <div class="container-fluid mb-4">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Log Pembukuan</h1>
                    </div>
                    <div class="table-responsive card">
                        <div class="card-body">
                            <h5 class="text-dark">Peminjaman Ruangan / Laboratorium</h5>
                            <table class="table table-sm table-striped" id="logs-table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Nama Pengguna</th>
                                        <th scope="col">Ruangan / Lab</th>
                                        <th scope="col">Tanggal</th>
                                        <th scope="col">Waktu</th>
                                        <th scope="col">Catatan</th>
                                        <th scope="col">Pembatalan</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    $query = "SELECT * FROM tickets";
                                    $result = mysqli_query($link, $query);
                                    $i = 0;
                                    while ($data = mysqli_fetch_assoc($result)) {
                                        $room_id = $data['room_id'];
                                        $room_data = getRoomDataById($room_id);
                                        $user_id = $data['user_id'];
                                        $user_data = getUserDataById($user_id);

                                        $i++;
                                    ?>
                                        <tr>
                                            <th><?= $i; ?></th>
                                            <td class=""><?= $user_data['fullname']; ?></td>
                                            <td><?= $room_data['room_name']; ?></td>
                                            <td><?= date_format(date_create($data['time_start']), 'd-m-Y'); ?></td>
                                            <td><?= date_format(date_create($data['time_start']), 'H:i') . ' - ' . date_format(date_create($data['time_end']), 'H:i'); ?></td>
                                            <td><?= $data['notes']; ?></td>
                                            <td><?= $data['invalidated'] == NULL ? '-' : date_format(date_create($data['invalidated']), 'd-m-Y') . ' &nbsp; || &nbsp; ' . date_format(date_create($data['invalidated']), 'H:i A') ?></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>

                            </table>
                        </div>
                    </div>
                    <br>
                    <hr><br>
                    <div class="table-responsive card">
                        <div class="card-body">
                            <h5 class="text-dark">Penggunaan Area Bersama</h5>
                            <table class="table table-sm table-striped" id="logs-table2">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Nama Pengguna</th>
                                        <th scope="col">Area </th>
                                        <th scope="col">No. Tempat</th>
                                        <th scope="col">Tanggal</th>
                                        <th scope="col">Waktu</th>
                                        <th scope="col">Pembatalan</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    $query = "SELECT * FROM space_tickets";
                                    $result = mysqli_query($link, $query);
                                    $i = 0;
                                    while ($data = mysqli_fetch_assoc($result)) {
                                        $area_id = $data['area_id'];
                                        $area_data = getAreaDataById($area_id);
                                        $user_id = $data['user_id'];
                                        $user_data = getUserDataById($user_id);

                                        $i++;
                                    ?>
                                        <tr>
                                            <th><?= $i; ?></th>
                                            <td class=""><?= $user_data['fullname']; ?></td>
                                            <td><?= $area_data['name'] ?></td>
                                            <td><?= $area_data['code'] . '-' . $data['space_no'] ?></td>
                                            <td><?= date_format(date_create($data['time_start']), 'd-m-Y'); ?></td>
                                            <td><?= date_format(date_create($data['time_start']), 'H:i') . ' - ' . date_format(date_create($data['time_end']), 'H:i'); ?></td>
                                            <td><?= $data['invalidated'] == NULL ? '-' : date_format(date_create($data['invalidated']), 'd-m-Y') . ' &nbsp; || &nbsp; ' . date_format(date_create($data['invalidated']), 'H:i A') ?></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>

                            </table>
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

    <!-- DataTable JavaScript -->
    <script src="../assets/vendor/datatables/DataTables-1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="../assets/vendor/datatables/DataTables-1.11.5/js/dataTables.bootstrap4.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../assets/js/sb-admin-2.min.js"></script>

    <!-- SweetAlert JS -->
    <script src="../assets/vendor/SweetAlert2/SweetAlert2.js"></script>


</body>

</html>

<script>
    $(document).ready(function() {
        $('#logs-table').DataTable({
            "columnDefs": [{
                "searchable": false,
                "targets": 0
            }],
            "ordering": false,
            lengthMenu: [10, 20, 50, 100],
            "language": {
                "search": "Cari : ",
                "lengthMenu": "Tampilkan _MENU_ data per halaman",
                "zeroRecords": "Tidak ada data.",
                "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
                "infoEmpty": "Data tidak tersedia",
                "infoFiltered": "(Difilter dari _MAX_ total data)",
                "paginate": {
                    "first": "Pertama",
                    "last": "Terakhir",
                    "next": "Selanjutnya",
                    "previous": "Sebelumnya"
                },
            }
        });
        $('#logs-table2').DataTable({
            "columnDefs": [{
                "searchable": false,
                "targets": 0
            }],
            "ordering": false,
            lengthMenu: [10, 20, 50, 100],
            "language": {
                "search": "Cari : ",
                "lengthMenu": "Tampilkan _MENU_ data per halaman",
                "zeroRecords": "Tidak ada data.",
                "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
                "infoEmpty": "Data tidak tersedia",
                "infoFiltered": "(Difilter dari _MAX_ total data)",
                "paginate": {
                    "first": "Pertama",
                    "last": "Terakhir",
                    "next": "Selanjutnya",
                    "previous": "Sebelumnya"
                },
            }
        });
    });
</script>