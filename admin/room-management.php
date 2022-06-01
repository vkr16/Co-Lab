<?php
$room_management = true;

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

    <!-- Custom styles for navigation-->
    <link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom style -->
    <link rel="stylesheet" href="../assets/css/co-lab.css">

    <title>Manajemen Ruangan | Co-Lab</title>


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
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Manajemen Ruangan</h1>
                        <a href="room-add.php" class="d-none d-sm-inline-block btn btn-sm btn-red shadow-sm"><i class="fas fa-plus fa-sm"></i> Tambah Ruangan</a>
                    </div>

                    <div class="card shadow col-md-12 ">
                        <div class="card-body table-responsive">
                            <h5 class="text-dark">Daftar Ruangan</h5><br>
                            <table class="table" id="rooms_table">
                                <thead>
                                    <tr>
                                        <th class="col-md-1">No</th>
                                        <th class="col-md-3">Nama Ruangan</th>
                                        <th class="col-md-1">Kapasitas</th>
                                        <th class="col-md-3">Lokasi</th>
                                        <th class="col-md-1">Status</th>
                                        <th class="col-md-3">Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = "SELECT * FROM rooms";
                                    $result = mysqli_query($link, $query);
                                    $i = 0;
                                    while ($data = mysqli_fetch_assoc($result)) {
                                        $i++;
                                    ?>
                                        <tr>
                                            <td class="align-middle"><?= $i; ?></td>
                                            <td class="align-middle"><?= $data['room_name']; ?></td>
                                            <td class="align-middle"><?= $data['capacity']; ?> Orang</td>
                                            <td class="align-middle"><?= $data['location']; ?></td>
                                            <td class="align-middle"><?= $data['status'] == 'inactive' ? '<i class="fa-regular fa-circle-xmark text-danger"></i> Inactive' : '<i class="fa-regular fa-circle-check text-success"></i> Aktif'; ?> </td>
                                            <td class="align-middle">
                                                <button class=" btn btn-sm btn-danger mr-1 mb-1" onclick="deleteRoom(<?= $data['id'] ?>)"><i class="fa-solid fa-ban"></i> &nbsp; Hapus</button>
                                                <a href="room-edit.php?id=<?= $data['id'] ?>" class=" btn btn-sm btn-blue mr-1 mb-1"><i class="fa-regular fa-pen-to-square"></i> &nbsp; Ubah</a>
                                                <a href="room-detail.php?id=<?= $data['id'] ?>" class="btn btn-sm btn-orange mb-1"><i class="fa-solid fa-circle-info"></i> &nbsp; Detail</a>
                                            </td>
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
        });
    });

    function deleteRoom(id) {
        Swal.fire({
            title: 'Anda yakin ingin menghapus ruangan ini?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Hapus',
            confirmButtonColor: '#3085d6',
        }).then((result) => {
            if (result.isConfirmed) {
                $.post("room-delete.php", {
                        room_id: id
                    },
                    function(data) {
                        Swal.fire({
                            title: 'Dihapus',
                            text: 'Ruangan berhasil dihapus',
                            icon: 'success',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonText: 'Selesai',
                            confirmButtonColor: '#3085d6',
                        }).then((result) => {
                            /* Read more about isConfirmed, isDenied below */
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        })
                    });
            }
        })
    }
</script>