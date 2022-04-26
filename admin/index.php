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

    <!-- Custom styles for navigation-->
    <link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom style -->
    <link rel="stylesheet" href="../assets/css/co-lab.css">

    <title>Co-Lab | Admin Home</title>


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
                    <h1 class="h3 mb-4 text-gray-800">Admin Dashboard</h1>

                    <div class="card shadow col-md-12 ">
                        <div class="card-body table-responsive">
                            <h5 class="text-dark">Room Availability Information</h5>
                            <br>
                            <table class="table" id="rooms_table">
                                <thead>
                                    <tr>
                                        <th>Room Name</th>
                                        <th>Capacity</th>
                                        <th>Status</th>
                                        <th>PIC</th>
                                        <th>Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Laboratorium Komputer</td>
                                        <td>30</td>
                                        <td>Available</td>
                                        <td>-</td>
                                        <td><button class="btn btn-sm btn-orange">Check Details</button></td>
                                    </tr>
                                    <tr>
                                        <td>Laboratorium Multimedia</td>
                                        <td>40</td>
                                        <td>Booked </td>
                                        <td>Aditya Setiawan </td>
                                        <td><button class="btn btn-sm btn-orange">Check Details</button> </td>
                                    </tr>
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

</body>

</html>

<script>
    $(document).ready(function() {
        $('#rooms_table').DataTable();
    });
</script>