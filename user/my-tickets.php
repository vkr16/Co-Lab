<?php
$myTickets = true;
require_once "../core/init.php";
require_once "../core/user-session-only.php";

$user_id = getUserIdByUsername($_SESSION['cl_user']);
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


    <!-- DataTables CSS -->
    <link rel="stylesheet" href="../assets/vendor/datatables/DataTables-1.11.5/css/dataTables.bootstrap4.min.css">

    <!-- Fontawesome -->
    <link rel="stylesheet" href="../assets/vendor/fontawesome/css/all.min.css">

    <!-- Custom style -->
    <link rel="stylesheet" href="../assets/css/co-lab.css">

    <!-- Custom styles for navigation-->
    <link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">

    <title>Tiket Saya | Co-Lab</title>


</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php include "views/sidebar.php" ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php include "views/topbar.php" ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Tiket Aktif</h1>
                    </div>
                    <h5 class="h4 text-dark">Tiket Penggunaan Ruangan</h5>
                    <br>
                    <div class="row" id="tickets">
                    </div>
                    <hr>
                    <h5 class="h4 text-dark">Tiket Area Bersama</h5>
                    <br>
                    <div class="row" id="spacetickets">
                    </div>
                    <hr>
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h4 mb-0 text-gray-800">Riwayat / Tiket Kadaluarsa</h1>
                    </div>
                    <div class="col-md-12 card">
                        <h5 class="card-subtitle mt-4 ml-2 text-dark">Tiket Penggunaan Ruangan</h5>
                        <div class="card-body table-responsive" id="expiredTickets">
                        </div>
                    </div>
                    <hr>
                    <div class="col-md-12 card">
                        <h5 class="card-subtitle mt-4 ml-2 text-dark">Tiket Area Bersama</h5>
                        <div class="card-body table-responsive" id="expiredSpaceTickets">


                        </div>
                    </div>


                    <!-- Content Row -->

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white mt-4">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Co-Lab 2022</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <div class="modal fade" id="activeTicketModal" tabindex="-1" aria-labelledby="activeTicketModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class=" modal-header">
                    <h5 class="modal-title" id="activeTicketModalLabel">Detail Informasi Tiket</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="ticketmodaldata">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

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
        gettickets(<?= $user_id ?>);
    });

    function gettickets(userid) {
        $.post("views/remote-index-tickets.php", {
                userid: userid
            },
            function(data) {
                $("#tickets").html(data);
            });
        $.post("views/remote-space-tickets.php", {
                userid: userid
            },
            function(data) {
                $("#spacetickets").html(data);
            });
        $.post("views/remote-index-ticketsHistory.php", {
                userid: userid
            },
            function(data) {
                $("#expiredTickets").html(data);
            });
        $.post("views/remote-index-spaceticketsHistory.php", {
                userid: userid
            },
            function(data) {
                $("#expiredSpaceTickets").html(data);
            });
    }

    function showTicket(ticketID) {
        $('#activeTicketModal').modal('show');

        $.post("views/remote-index-ticketsShow.php", {
                ticketID: ticketID
            },
            function(data) {
                $("#ticketmodaldata").html(data);
            });
    }

    function showSpaceTicket(ticketID) {
        $('#activeTicketModal').modal('show');

        $.post("views/remote-space-ticketsShow.php", {
                ticketID: ticketID
            },
            function(data) {
                $("#ticketmodaldata").html(data);
            });
    }

    function cancelPrompt(ticketID) {
        Swal.fire({
            icon: 'question',
            title: 'Apakah Anda Yakin?',
            text: 'Menghapus tiket akan membatalkan pembukuan yang sudah anda buat',
            showCancelButton: true,
            cancelButtonText: "Batal",
            confirmButtonText: "Ya, Hapus dan Batalkan"
        }).then((result) => {
            if (result.isConfirmed) {

                $.post("views/remote-delete-ticket.php", {
                        ticketID: ticketID
                    },
                    function(data) {
                        $('#activeTicketModal').modal('hide');
                        gettickets(<?= $user_id ?>);
                    });
            }
        })
    }

    function cancelSpacePrompt(ticketID) {
        Swal.fire({
            icon: 'question',
            title: 'Apakah Anda Yakin?',
            text: 'Menghapus tiket akan membatalkan pembukuan yang sudah anda buat',
            showCancelButton: true,
            cancelButtonText: "Batal",
            confirmButtonText: "Ya, Hapus dan Batalkan"
        }).then((result) => {
            if (result.isConfirmed) {
                $.post("views/remote-delete-spaceticket.php", {
                        ticketID: ticketID
                    },
                    function(data) {
                        $('#activeTicketModal').modal('hide');
                        gettickets(<?= $user_id ?>);
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Tiket berhasil dibatalkan.',
                            confirmButtonText: "Selesai"
                        })
                    });
            }
        })
    }
</script>