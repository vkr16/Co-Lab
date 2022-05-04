<?php

require_once "../core/init.php";
require_once "../core/user-session-only.php";

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

    <!-- Custom style -->
    <link rel="stylesheet" href="../assets/css/co-lab.css">

    <!-- Custom styles for navigation-->
    <link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">

    <title>Home | Co-Lab</title>


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
                    <form>
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">Home</h1>
                            <div class="form-group col-md-4">

                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Cari Ruangan . . ." id="searchKeyword" onkeyup="searchRooms();isSearchEmpty()" onchange="searchRooms();isSearchEmpty()">
                                    <div class="input-group-append clearer">
                                        <span class="btn input-group-text clearer" type="button" id="search-addon">
                                            <i class="fa-solid fa-magnifying-glass clearer"></i>
                                            </button>
                                    </div>
                                </div>
                                <p class="form-text text-muted mt-0" id="esc-help" style="display: none;">Tekan <kbd>Esc</kbd> untuk menghapus filter pencarian</p>

                            </div>
                        </div>
                    </form>
                    <div class="row" id="rooms">



                    </div>

                    <!-- Content Row -->

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
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
                    <a class="btn btn-primary" href="login.html">Logout</a>
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

<script>
    $(document).ready(function() {
        getrooms();
        isSearchEmpty();
        $("#esc-help").hide();

        $("#searchKeyword").keydown(function(event) {
            if (event.keyCode == 13) {
                $("#searchKeyword").blur();
            }
        });

        $(".clearer").click(function() {
            clearSearchBox();
            isSearchEmpty();
            getrooms();
        });

        $(window).keydown(function(event) {
            if (event.keyCode == 27) {
                clearSearchBox();
                isSearchEmpty();
                getrooms();
            }
        });

    });

    function isSearchEmpty() {
        if ($("#searchKeyword").val() == "") {
            $("#search-addon").html('<i class="fa-solid fa-magnifying-glass"></i>');
            $("#esc-help").hide();
        } else {
            $("#search-addon").html('<i class="fa-solid fa-delete-left"></i>');
            $("#esc-help").show();
        }
    }

    function getrooms() {
        $.post("views/remote-index-rooms.php", {
                getrooms: true
            },
            function(data) {
                $("#rooms").html(data);
            });
    }

    function searchRooms() {
        $.post("views/remote-index-search.php", {
                keyword: $("#searchKeyword").val()
            },
            function(data) {
                $("#rooms").html(data);
            });
    }

    function clearSearchBox() {
        $("#searchKeyword").val("");
        $("#esc-help").hide();
        isSearchEmpty();
    }
</script>