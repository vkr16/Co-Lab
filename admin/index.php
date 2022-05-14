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
                    <h1 class="h3 mb-4 text-gray-800">Beranda Admin</h1>

                    <div class="card shadow col-md-12 ">
                        <div class="card-body table-responsive">
                            <h5 class="text-dark">Informasi Ketersediaan Ruangan</h5>
                            <br>

                            <table class="table" id="rooms_table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Ruangan</th>
                                        <th>Kapasitas</th>
                                        <th>Ketersediaan</th>
                                        <th>Penanggung Jawab</th>
                                        <th>Jadwal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = "SELECT * FROM rooms WHERE status = 'active'";
                                    $result  = mysqli_query($link, $query);
                                    $i = 0;
                                    $now = date("Y-m-d H:i:s");
                                    while ($data = mysqli_fetch_assoc($result)) {
                                        $i++;
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

                                    ?>
                                        <tr>
                                            <td><?= $i; ?></td>
                                            <td><?= $data['room_name'] . $data['id']; ?></td>
                                            <td><?= $data['capacity'] . " Orang"; ?></td>
                                            <td><?php if (isNowAvailable($data['id'])) {
                                                    echo '<i class="fa-regular fa-circle-check text-success"></i> &nbsp; Tersedia Saat Ini';
                                                } else {
                                                    echo '<i class="fa-regular fa-hourglass text-danger"></i> &nbsp; Sedang Digunakan';
                                                } ?></td>
                                            <td><?= $empty == false ? $data3['fullname'] : "-" ?></td>
                                            <td><button class="btn btn-sm btn-orange" onclick="copyRomid(<?= $data['id'] ?>,'<?= $data['room_name'] ?>')">Lihat Jadwal</button></td>
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

    <div class="modal fade" id="scheduleModal" tabindex="-1" aria-labelledby="scheduleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <h5 id="roname"></h5>
                    <br>
                    <div class="form-group row">
                        <label for="datepicker2" class="col-sm-7 col-form-label">Tampilkan jadwal untuk tanggal</label>

                        <div class="col-sm-5">
                            <input type="text" id="hiddenRomid" hidden>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control form-control-sm bg-white" name="date" id="datepicker2" readonly onchange="getBookingList()" />
                                <div class="input-group-append">
                                    <button class="btn btn-sm btn-outline-secondary" onclick="$('#datepicker2').focus()" type="button" id="button-addon2"><i class="fa-solid fa-calendar-days"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr class="bg-primary text-light">
                                <th scope="col" class="col-sm-1">No.</th>
                                <th scope="col" class="col-sm-3">Pengguna</th>
                                <th scope="col" class="col-sm-1">Mulai</th>
                                <th scope="col" class="col-sm-1">Selesai</th>
                                <th scope="col" class="col-sm-6">Catatan</th>
                            </tr>
                        </thead>
                        <tbody id="bookingtable">

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
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


    <!-- datepicker js -->
    <script src="../assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <script src="../assets/vendor/bootstrap-datepicker/js/locales/bootstrap-datepicker.id.min.js"></script>


    <!-- Custom scripts for all pages-->
    <script src="../assets/js/sb-admin-2.min.js"></script>

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
</script>