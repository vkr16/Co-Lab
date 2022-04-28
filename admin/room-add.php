<?php
$room_management = true;

require_once "../core/init.php";
require_once "../core/admin-session-only.php";

if (isset($_POST['save'])) {
    $room_name = $_POST['room_name'];
    $room_name = str_replace(array(
        "'",
        "\\",
        "\""
    ), '', $room_name);
    $location = $_POST['location'];
    $location = str_replace(array(
        "'",
        "\\",
        "\""
    ), '', $location);
    $capacity = $_POST['capacity'];
    $status = $_POST['status'];
    $description = $_POST['description'];
    $description = str_replace(array(
        "\r\n",
        "\n"
    ), '<br>', $description);

    if ($_FILES['thumbnail']['size'] != 0 && $_FILES['thumbnail']['error'] == 0) {
        // $query  = "SELECT MAX(id) AS PreviousId FROM rooms";
        // $result = mysqli_query($link, $query);
        // $data = mysqli_fetch_assoc($result);
        // $PreviousId = $data['PreviousId'];
        // $PreviousId = $PreviousId + 1;
        $randStr = bin2hex(random_bytes(10));
        $path  = $_SERVER['DOCUMENT_ROOT'] . "/co-lab/assets/img/rooms/";
        $path2 = $_FILES['thumbnail']['name'];
        $ext   = pathinfo($path2, PATHINFO_EXTENSION);
        $path  = $path . $randStr . '.' . $ext;

        $filenameondb = $randStr . '.' . $ext;

        move_uploaded_file($_FILES['thumbnail']['tmp_name'], $path);
    } else {
        $filenameondb = 'default_thumbnail.jpg';
    }

    $query = "INSERT INTO rooms (room_name, location, capacity, thumbnail, status, description) VALUES ('$room_name','$location','$capacity','$filenameondb','$status','$description')";
    if ($result = mysqli_query($link, $query)) {
        $loadThis = 'alertSuccess()';
    } else {
        $loadThis = 'alertFailed()';
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
    <link rel="stylesheet" href="../assets/vendor/datatables/DataTables-1.11.5/css/dataTables.bootstrap4.min.css">

    <!-- Custom styles for navigation-->
    <link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom style -->
    <link rel="stylesheet" href="../assets/css/co-lab.css">

    <title>Co-Lab | Admin Home</title>


</head>

<body id="page-top" onload="<?= $loadThis ?>">

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
                        <h1 class="h3 mb-0 text-gray-800">Room Management</h1>
                    </div>

                    <div class="card shadow col-md-12 ">
                        <div class="card-body">
                            <h5 class="text-dark">Add New Room</h5><br>

                            <form action="" method="POST" enctype="multipart/form-data">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="room_name">Room Name</label>
                                        <input type="text" class="form-control" id="room_name" placeholder="Multimedia Laboratory" name="room_name" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="location">Location</label>
                                        <input type="text" class="form-control" id="location" placeholder="2nd Floor (A2.5)" name="location" required>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-2">

                                        <label for="capacity">Capacity</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" placeholder="30" aria-describedby="basic-addon2" name="capacity" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="basic-addon2">Persons</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="thumbnail">Thumbnail (Optional)</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                                            </div>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="thumbnail" aria-describedby="inputGroupFileAddon01" name="thumbnail" accept=".jpg,.jpeg,.png">
                                                <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="availability">Availability</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text" for="inputGroupSelect01">Set</label>
                                            </div>
                                            <select class="custom-select" id="inputGroupSelect01" name="status">
                                                <option selected value="active">Active (Default)</option>
                                                <option value="inactive">Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="description">Description</label>
                                        <textarea class="form-control desc-textarea" name="description" placeholder="Description or Facilities" required></textarea>
                                    </div>
                                </div>
                                <a href="room-management.php" class="btn btn-secondary"><i class="fa-solid fa-arrow-left-long"></i> Back</a>
                                <button type="submit" class="btn btn-red" name="save"><i class="fa-regular fa-floppy-disk"></i> Save</button>
                            </form>
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

    <script src="../assets/vendor/SweetAlert2/SweetAlert2.js"></script>

</body>

</html>

<script>
    $(document).ready(function() {
        $('#rooms_table').DataTable();
    });


    function alertSuccess() {
        Swal.fire({
            title: 'Success',
            text: "New data has been saved to database",
            icon: 'success',
            showCancelButton: false,
            showConfirmButton: false
        })
    }

    function alertFailed() {
        Swal.fire({
            title: 'Failed',
            text: "Something went wrong, data not saved",
            icon: 'error',
            showCancelButton: false,
            showConfirmButton: false
        })
    }

    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>