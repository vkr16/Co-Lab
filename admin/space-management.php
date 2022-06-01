<?php
$space = true;

require_once "../core/init.php";
require_once "../core/admin-session-only.php";

$now = date("Y-m-d H:i:s");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "SELECT * FROM areas WHERE id = '$id'";
    $result = mysqli_query($link, $query);
    $data = mysqli_fetch_assoc($result);

    $thumbnail = $data['thumbnail'];
    $areaname = $data['name'];
    $location = $data['location'];
    $capacity = $data['capacity'];
    $status = $data['status'];
    $areacode = $data['code'];
    $description = $data['description'];
    $layout = $data['layout'];
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
    <link rel="stylesheet" href="../assets/vendor/datatables/DataTables-1.11.5/css/dataTables.bootstrap4.min.css">

    <!-- Custom styles for navigation-->
    <link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom style -->
    <link rel="stylesheet" href="../assets/css/co-lab.css">

    <title>Area Bersama | Co-Lab</title>


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
                        <h1 class="h3 mb-0 text-gray-800">Manajemen Tempat Duduk</h1>
                        <!-- <a href="room-add.php" class="d-none d-sm-inline-block btn btn-sm btn-red shadow-sm"><i class="fas fa-plus fa-sm"></i> Add New Room</a> -->
                    </div>

                    <div class="row col-md-12" style="position: relative;">
                        <div class="col-md-8">
                            <div class="card shadow">
                                <div class="card-header">
                                    <h5 class="text-dark mt-2">Detail Informasi Area</h5>
                                </div>
                                <div class="card-body table-responsive">
                                    <!-- <h5 class="text-dark"><a href="#" onclick="history.back()" class="text-decoration-none text-dark"><i class="fa-solid fa-arrow-left-long"></i> Kembali</h5></a><br> -->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <img src="../assets/img/areas/<?= $thumbnail ?>" class="thumbnail-room shadow-sm rounded">
                                            </div>
                                            <h5><?= $areaname; ?></h5>
                                            <h6><i class="fa-solid fa-location-dot fa-fw"></i> <?= $location; ?></h6>
                                        </div>
                                        <div class="col-md-6">
                                            <dl class="row">
                                                <dt class="col-sm-6"><i class="fa-solid fa-people-group fa-fw"></i> Kapasitas</dt>
                                                <dd class="col-sm-6"><?= $capacity; ?> Orang</dd>

                                                <dt class="col-sm-6"><i class="fa-solid fa-toggle-<?= $status == 'active' ? 'on' : 'off'; ?> fa-fw"></i> Status</dt>
                                                <dd class="col-sm-6"><?= $status == 'active' ? 'Aktif' : 'Tidak Aktif'; ?></dd>

                                                <dt class="col-sm-6"><i class="fa-solid fa-key fa-fw"></i> Kode Area</dt>
                                                <dd class="col-sm-6"><?= $areacode; ?></dd>
                                            </dl>
                                            <hr>
                                            <dl class="row">
                                                <dt class="col-sm-6"><i class="fa-solid fa-align-left fa-fw"></i> Deskripsi</dt>
                                            </dl>
                                            <p><?= $description; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card shadow">
                                <div class=" card-header">
                                    <h5 class="text-dark  mt-2">Denah & Daftar Tempat Duduk</h5>
                                </div>
                                <div class="card-body">
                                    <img src="../assets/img/layouts/<?= $layout ?>" width="100%">
                                    <hr>
                                    <div class="row mx-auto d-flex justify-content-between">
                                        <?php
                                        $query = "SELECT * FROM spaces WHERE area_id = '$id'";
                                        $result = mysqli_query($link, $query);
                                        $spcount = mysqli_num_rows($result);
                                        if ($spcount < $capacity) {
                                        ?>
                                            <button class="btn btn-sm btn-red" data-toggle="modal" data-target="#addSpaceModal"><i class="fa-solid fa-plus fa-fw"></i> Tambah Tempat Duduk</button>&nbsp;
                                        <?php
                                        }
                                        ?>
                                        <button class="btn btn-sm btn-blue" onclick="resetPrompt(<?= $capacity ?>,'<?= $areaname ?>',<?= $id ?>)"><i class="fa-solid fa-clock-rotate-left fa-fw"></i> Atur Ulang</button>

                                    </div>
                                    <hr>

                                    <table class="table table-sm" id="table-spaces">
                                        <thead>
                                            <tr>
                                                <th class="col-md-1">#</th>
                                                <th class="col-md-4">Kode</th>
                                                <th class="col-md-3">Warna</th>
                                                <th class="col-md-4">Hapus</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                            $query = "SELECT * FROM spaces WHERE area_id = '$id' ORDER BY space_no";
                                            $result = mysqli_query($link, $query);


                                            if (mysqli_num_rows($result) > 0) {
                                                $i = 0;
                                                while ($data = mysqli_fetch_assoc($result)) {
                                                    $i++;
                                            ?>
                                                    <tr>
                                                        <th scope="row"><?= $i; ?></th>
                                                        <td><?= $areacode . '-' . $data['space_no']; ?></td>
                                                        <td onmousedown='$("#color<?= $areacode  . $data["space_no"] ?>").prop("disabled",false).focus().click()'>

                                                            <input type="color" value="<?= $data['color_code'] ?>" class="form-control" disabled id="color<?= $areacode  . $data["space_no"] ?>" onblur='$("#color<?= $areacode  . $data["space_no"] ?>").prop("disabled",true);updateColor(<?= $data["id"] ?>, $(this).val())'>

                                                        </td>
                                                        <td><button class="btn btn-sm btn-danger btn-block" onclick="deleteSpace(<?= $data['id'] ?>,'<?= $areacode . '-' . $data['space_no'] ?>')"><i class="fa-solid fa-ban"></i> Hapus</button></td>
                                                    </tr>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <br>
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

    <!-- Modal x-->
    <div class="modal fade" id="addSpaceModal" tabindex="-1" aria-labelledby="addSpaceModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSpaceModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">

                        <label class="ml-2">Silahkan pilih nomor kursi yang ingin di tambahkan</label>
                        <div class="col-md-9">
                            <select class="form-control form-control-sm" id="spacenoselect" name="spaceno" id="inputGroupSelect01">
                                <?php
                                $query = "SELECT * FROM spaces WHERE area_id = '$id'";
                                $result = mysqli_query($link, $query);
                                $arr_a = array();
                                $arr_b = array();
                                while ($data = mysqli_fetch_assoc($result)) {
                                    array_push($arr_a, $data['space_no']);
                                }
                                for ($i = 0; $i < $capacity; $i++) {
                                    array_push($arr_b, $i + 1);
                                }
                                $diff = array_diff($arr_b, $arr_a);
                                foreach ($diff as $index => $value) {
                                    echo ' <option value="' . $value . '">' . $areacode . '-' . $value . '</option>';
                                }

                                ?>
                                <option value="161199">Tambah Semua</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-sm btn-primary btn-block" onclick="addSpace(<?= $id ?>,$('#spacenoselect').val(),<?= $capacity ?>)">Tambah</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal x end -->

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
        $('#table-spaces').DataTable({
            "columnDefs": [{
                "searchable": false,
                "targets": 0
            }],
            "ordering": false,
            "dom": "<'row'<'col-sm-12 col-md-8'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-12 col-md-12'p>>",
            lengthMenu: [5],
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

    function updateColor(spaceid, color) {
        $.post("space-update.php", {
                id: spaceid,
                color: color,
            },
            function(data) {

            });
    }

    function deleteSpace(id, space) {
        Swal.fire({
            title: 'Anda yakin ingin menghapus spot ' + space + ' ?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Hapus',
            confirmButtonColor: '#3085d6',
        }).then((result) => {
            if (result.isConfirmed) {
                $.post("space-delete.php", {
                        space_id: id
                    },
                    function(data) {
                        Swal.fire({
                            title: 'Dihapus',
                            text: 'Tempat duduk berhasil dihapus',
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

    function resetPrompt(capacity, areaname, areaid) {
        Swal.fire({
            title: 'Atur Ulang "' + areaname + '"?',
            text: "Ini akan mengembalikan pemetaan nomor kursi ke default. Lanjutkan?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Atur ulang',
            confirmButtonColor: '#f0a441',
        }).then((result) => {
            if (result.isConfirmed) {
                $.post("space-reset.php", {
                        areaid: areaid,
                        capacity: capacity
                    },
                    function(data) {
                        Swal.fire({
                            title: 'Selesai',
                            text: 'Berhasil di atur ulang',
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

    function addSpace(areaid, spaceno, capacity) {
        $.post("space-add.php", {
                areaid: areaid,
                spaceno: spaceno,
                capacity: capacity
            },
            function(data) {
                Swal.fire({
                    title: 'Berhasil',
                    text: 'Tempat duduk berhasil di tambahkan',
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
</script>