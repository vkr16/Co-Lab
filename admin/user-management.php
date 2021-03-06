<?php
$user_management = true;

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

    <title>Manajemen Pengguna | Co-Lab</title>


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
                        <h1 class="h3 mb-0 text-gray-800">Manajemen Pengguna</h1>
                    </div>

                    <div class="card shadow col-md-12 ">
                        <div class="card-body table-responsive">
                            <h5 class="text-dark">Daftar Pengguna</h5><br>
                            <table class="table" id="rooms_table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Lengkap</th>
                                        <th>NIM</th>
                                        <th>Nama Pengguna</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $user_session = $_SESSION['cl_user'];
                                    $query = "SELECT * FROM users WHERE username = '$user_session'";
                                    $result = mysqli_query($link, $query);
                                    $data = mysqli_fetch_assoc($result);
                                    $except_id = $data['id'];
                                    $query = "SELECT * FROM users WHERE id != '$except_id'";
                                    $result = mysqli_query($link, $query);
                                    $i = 0;
                                    while ($data = mysqli_fetch_assoc($result)) {
                                        $i++;
                                    ?>
                                        <tr>
                                            <td><?= $i; ?></td>
                                            <td><?= $data['fullname']; ?>&nbsp;<?= $data['role'] == 'admin' ? '<i class="fa-solid fa-crown text-orange" data-toggle="tooltip" data-placement="top" title="Administrator"></i>' : ''; ?></td>
                                            <td><?= $data['studentid']; ?></td>
                                            <td><?= $data['username']; ?></td>
                                            <td><?= $data['email']; ?></td>
                                            <td><?= $data['validity'] == 'invalid' ? '<i class="fa-regular fa-circle-xmark text-danger"></i> Belum diverifikasi' : '<i class="fa-regular fa-circle-check text-success"></i> Terverifikasi'; ?> </td>
                                            <td><button class=" btn btn-sm btn-danger mr-3 mb-1" onclick="deleteUser(<?= $data['id'] ?>,'<?= $data['fullname'] ?>')"><i class="fa-solid fa-ban"></i> &nbsp;Hapus</button>
                                                <a href="user-edit.php?id=<?= $data['id'] ?>" class=" btn btn-sm btn-blue mr-3 mb-1"><i class="fa-regular fa-pen-to-square"></i> &nbsp;Ubah</a>
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

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">??</span>
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

    function deleteUser(id, fullname) {
        Swal.fire({
            title: 'Anda yakin ingin menghapus <br>' + fullname + '?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Hapus',
            confirmButtonColor: '#3085d6',
        }).then((result) => {
            if (result.isConfirmed) {
                $.post("user-delete.php", {
                        user_id: id
                    },
                    function(data) {
                        Swal.fire({
                            title: 'Dihapus',
                            text: 'Pengguna berhasil dihapus',
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