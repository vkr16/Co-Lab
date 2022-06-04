<?php
$dashboard = true;
require_once "../core/init.php";
require_once "../core/admin-session-only.php";




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

    <link rel="stylesheet" href="../assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css">


    <!-- Custom styles for navigation-->
    <link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom style -->
    <link rel="stylesheet" href="../assets/css/co-lab.css">

    <title>Panel Admin | Co-Lab</title>


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
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">Manajemen Tiket Aktif</h1>

                    <div class="card shadow col-md-12 ">
                        <div class="card-body table-responsive">
                            <h5 class="text-dark">Daftar Tiket Aktif Penggunaan Ruangan / Laboratorium</h5>
                            <br>

                            <table class="table" id="rooms_table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Pengguna</th>
                                        <th>Ruangan / Lab</th>
                                        <th>Tanggal</th>
                                        <th>Waktu</th>
                                        <th>Catatan</th>
                                        <th>Batalkan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $now = date('Y-m-d H:i:s');
                                    $query = "SELECT * FROM tickets WHERE time_end >= '$now' AND status = 'valid'";
                                    $result  = mysqli_query($link, $query);
                                    $i = 0;
                                    while ($data = mysqli_fetch_assoc($result)) {
                                        $i++;
                                        $user_data = getUserDataById($data['user_id']);
                                        $room_data = getRoomDataById($data['room_id']);

                                    ?>
                                        <tr>
                                            <td><?= $i; ?></td>
                                            <td><?= $user_data['fullname']; ?></td>
                                            <td><?= $room_data['room_name'] ?></td>
                                            <td><?= date_format(date_create($data['time_start']), 'd-m-Y') ?></td>
                                            <td><?= date_format(date_create($data['time_start']), 'H:i') . ' - ' . date_format(date_create($data['time_end']), 'H:i') ?></td>
                                            <td><?= $data['notes'] ?></td>
                                            <td><button class="btn btn-sm btn-red" onclick="cancelPrompt(<?= $data['id'] ?>)"><i class="fa-solid fa-ban fa-fw"></i> Batalkan</button></td>
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
                    <div class="card shadow col-md-12 ">
                        <div class="card-body table-responsive">
                            <h5 class="text-dark">Daftar Tiket Aktif Penggunaan Area Bersama</h5>
                            <br>

                            <table class="table" id="rooms_table2">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Pengguna</th>
                                        <th>Area</th>
                                        <th>No. Tempat</th>
                                        <th>Tanggal</th>
                                        <th>Waktu</th>
                                        <th>Batalkan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $now = date('Y-m-d H:i:s');
                                    $query = "SELECT * FROM space_tickets WHERE time_end >= '$now' AND status = 'valid'";
                                    $result  = mysqli_query($link, $query);
                                    $i = 0;
                                    while ($data = mysqli_fetch_assoc($result)) {
                                        $i++;
                                        $user_data = getUserDataById($data['user_id']);
                                        $area_data = getAreaDataById($data['area_id']);

                                    ?>
                                        <tr>
                                            <td><?= $i; ?></td>
                                            <td><?= $user_data['fullname']; ?></td>
                                            <td><?= $area_data['name'] ?></td>
                                            <td><?= $area_data['code'] . '-' . $data['space_no'] ?></td>
                                            <td><?= date_format(date_create($data['time_start']), 'd-m-Y') ?></td>
                                            <td><?= date_format(date_create($data['time_start']), 'H:i') . ' - ' . date_format(date_create($data['time_end']), 'H:i') ?></td>
                                            <td><button class="btn btn-sm btn-red" onclick="cancelSpacePrompt(<?= $data['id'] ?>)"><i class="fa-solid fa-ban fa-fw"></i> Batalkan</button></td>
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


    <!-- Bootstrap core JavaScript-->
    <script src="../assets/vendor/jquery/jquery.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- DataTable JavaScript -->
    <script src="../assets/vendor/datatables/DataTables-1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="../assets/vendor/datatables/DataTables-1.11.5/js/dataTables.bootstrap4.min.js"></script>


    <!-- datepicker js -->
    <script src="../assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <script src="../assets/vendor/bootstrap-datepicker/js/locales/bootstrap-datepicker.id.min.js"></script>


    <!-- Custom scripts for all pages-->
    <script src="../assets/js/sb-admin-2.min.js"></script>

    <script src="../assets/vendor/SweetAlert2/SweetAlert2.js"></script>


</body>

</html>

<script>
    $(document).ready(function() {
        $('#rooms_table').DataTable({
            "language": {
                "search": "Cari : ",
                "lengthMenu": "Tampilkan _MENU_ data per halaman",
                "zeroRecords": "Tidak ada data yang cocok ditemukan.",
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
        })
        $('#rooms_table2').DataTable({
            "language": {
                "search": "Cari : ",
                "lengthMenu": "Tampilkan _MENU_ data per halaman",
                "zeroRecords": "Tidak ada data yang cocok ditemukan.",
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
        })


        $("#datepicker2").datepicker({
            language: 'id',
            orientation: "bottom right",
            format: "dd/mm/yyyy",
            startView: "days",
            minViewMode: "days",
            startDate: "0d"
        }).datepicker("setDate", 'now');

    });

    function copyRomid(Romid, Roname) {
        $("#roname").html(Roname);
        $('#scheduleModal').modal('show');
        console.log(Romid);
        $("#hiddenRomid").val(Romid);
        getBookingList();
    }

    function getBookingList() {
        $.post("views/remote-room-bookinglist.php", {
                date: $("#datepicker2").val(),
                room_id: $("#hiddenRomid").val(),
            },
            function(data) {
                $("#bookingtable").html(data)
            });
    }

    function cancelPrompt(ticketID) {
        Swal.fire({
            icon: 'question',
            title: 'Apakah Anda Yakin?',
            text: 'Menghapus tiket akan membatalkan pembukuan yang dibuat oleh pengguna',
            showCancelButton: true,
            cancelButtonText: "Batal",
            confirmButtonText: "Ya, Hapus dan Batalkan"
        }).then((result) => {
            if (result.isConfirmed) {

                $.post("views/remote-delete-ticket.php", {
                        ticketID: ticketID
                    },
                    function(data) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Tiket berhasil di batalkan',
                            confirmButtonText: "Selesai"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        })
                    });
            }
        })
    }

    function cancelSpacePrompt(ticketID) {
        Swal.fire({
            icon: 'question',
            title: 'Apakah Anda Yakin?',
            text: 'Menghapus tiket akan membatalkan pembukuan yang dibuat oleh pengguna',
            showCancelButton: true,
            cancelButtonText: "Batal",
            confirmButtonText: "Ya, Hapus dan Batalkan"
        }).then((result) => {
            if (result.isConfirmed) {
                $.post("views/remote-delete-spaceticket.php", {
                        ticketID: ticketID
                    },
                    function(data) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Tiket berhasil dibatalkan.',
                            confirmButtonText: "Selesai"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        })
                    });
            }
        })
    }
</script>