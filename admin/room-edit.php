<?php
$room_management = true;

require_once "../core/init.php";
require_once "../core/admin-session-only.php";

if (isset($_POST['btnsave'])) {
    $id = $_GET['id'];

    $query = "SELECT * FROM rooms WHERE id = '$id'";
    $result = mysqli_query($link, $query);
    $data = mysqli_fetch_assoc($result);
    $thumbnail = $data['thumbnail'];

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
        $randStr = bin2hex(random_bytes(10));
        $path  = $_SERVER['DOCUMENT_ROOT'] . "/co-lab/assets/img/rooms/";
        $path2 = $_FILES['thumbnail']['name'];
        $ext   = pathinfo($path2, PATHINFO_EXTENSION);
        $path  = $path . $randStr . '.' . $ext;

        $filenameondb = $randStr . '.' . $ext;

        move_uploaded_file($_FILES['thumbnail']['tmp_name'], $path);
        unlink('../assets/img/rooms/' . $thumbnail);

        $query = "UPDATE rooms SET room_name = '$room_name', location = '$location',capacity = '$capacity', thumbnail = '$filenameondb',status = '$status', description = '$description' WHERE id = '$id'";
    } else {
        $query = "UPDATE rooms SET room_name = '$room_name', location = '$location',capacity = '$capacity', status = '$status', description = '$description' WHERE id = '$id'";
    }

    if ($result = mysqli_query($link, $query)) {
        $loadThis = 'alertSuccess()';
    } else {
        $loadThis = 'alertFailed()';
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM rooms WHERE id = '$id'";
    $result = mysqli_query($link, $query);
    $data = mysqli_fetch_assoc($result);

    $room_name = $data['room_name'];
    $location = $data['location'];
    $capacity = $data['capacity'];
    $thumbnail = $data['thumbnail'];
    $status = $data['status'];
    $description = $data['description'];
    $description = str_replace(array(
        "<br>"
    ), "
", $description);
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
                            <h5 class="text-dark">Edit Room Information</h5><br>

                            <form action="" method="post" enctype="multipart/form-data">
                                <form>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="room_name">Room Name</label>
                                            <input value="<?= $room_name ?>" type="text" class="form-control" id="room_name" name="room_name">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="location">Location</label>
                                            <input value="<?= $location ?>" type="text" class="form-control" id="location" name="location">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-2">

                                            <label for="capacity">Capacity</label>
                                            <div class="input-group">
                                                <input value="<?= $capacity ?>" type="number" class="form-control" aria-describedby="basic-addon2" name="capacity">
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
                                                    <input type="file" onchange="imageSelected()" class="custom-file-input" id="thumbnailSelect" aria-describedby="inputGroupFileAddon01" name="thumbnail">
                                                    <label class="custom-file-label" id="labelThumbnailSelect" for="inputGroupFile01">Choose file</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="Status">Status</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <label class="input-group-text" for="inputGroupSelect01">Set</label>
                                                </div>
                                                <select class="custom-select" id="inputGroupSelect01" name="status">
                                                    <option <?= $status == 'active' ? 'selected' : ''; ?> value="active">Active</option>
                                                    <option <?= $status == 'inactive' ? 'selected' : ''; ?> value="inactive">Inactive</option>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="description">Description</label>
                                            <textarea class="form-control desc-textarea" name="description" placeholder="Description or Facilities"><?= $description; ?></textarea>
                                        </div>
                                    </div>
                                    <a href="room-management.php" class="btn btn-secondary">Cancel</a>
                                    <button type="submit" class="btn btn-red" name="btnsave"><i class="fa-regular fa-floppy-disk"></i> Save Changes</button>
                                </form>
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

    <!-- SweetAlert2 JS -->
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
            text: "Room details updated",
            icon: 'success',
            showCancelButton: false,
            showConfirmButton: false
        })
    }

    function alertFailed() {
        Swal.fire({
            title: 'Failed',
            text: "Something went wrong, data not updated",
            icon: 'error',
            showCancelButton: false,
            showConfirmButton: false
        })
    }

    function imageSelected() {
        if (document.getElementById("thumbnailSelect").value != '') {
            var input = document.getElementById("thumbnailSelect");
            document.getElementById("labelThumbnailSelect").innerHTML = input.files.item(0).name;
        }
    }

    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>