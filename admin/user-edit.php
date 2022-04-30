<?php
$user_management = true;

require_once "../core/init.php";
require_once "../core/admin-session-only.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../assets/vendor/PHPMailer/src/Exception.php';
require '../assets/vendor/PHPMailer/src/PHPMailer.php';
require '../assets/vendor/PHPMailer/src/SMTP.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    if (isset($_POST['btnsave'])) {
        $query = "SELECT * FROM users WHERE id = '$id'";
        $result  = mysqli_query($link, $query);
        $data = mysqli_fetch_assoc($result);
        $emailold = $data['email'];

        $fullnameNew = $_POST['fullname'];
        $studentidNew = $_POST['studentid'];
        $usernameNew = $_POST['username'];
        $emailNew = $_POST['email'];
        $roleNew = $_POST['role'];

        $query = "UPDATE users SET fullname = '$fullnameNew',studentid = '$studentidNew',username = '$usernameNew', email = '$emailNew', role = '$roleNew' WHERE id = '$id'";

        if (mysqli_query($link, $query)) {
            if ($emailNew != $emailold) {

                $JSON_creds     = file_get_contents("../core/mail-credentials.json");
                $credentials    = json_decode($JSON_creds, true);
                $email_address  = $credentials['creds']['email'];
                $email_password = $credentials['creds']['password'];

                $mail           = new PHPMailer;
                $mail->isSMTP();
                $mail->SMTPAuth = true;
                $mail->Host     = 'smtp.gmail.com';
                $mail->Port     = 587;
                $mail->Username = $email_address;
                $mail->Password = $email_password;
                $mail->setFrom($email_address);
                $mail->addAddress($emailNew);
                $mail->isHTML(true);
                $mail->Subject = 'Co-Lab - Email Changed Successfully';
                $mail->Body    = "Your email address has been changed successfully <br> Your " . $emailold . " email address no longer associated with your Co-Lab account";
                if ($mail->send()) {
                    $loadThis = "alertSuccess()";
                } else {
                    $loadThis = "alertFailedSendEmail()";
                }
            }
            $loadThis = "alertSuccess()";
        } else {
            $loadThis = "alertFailed()";
        }
    }

    $query = "SELECT * FROM users WHERE id = '$id'";
    $result  = mysqli_query($link, $query);
    $data = mysqli_fetch_assoc($result);

    $fullnameold = $data['fullname'];
    $studentidold = $data['studentid'];
    $usernameold = $data['username'];
    $emailold = $data['email'];
    $roleold = $data['role'];
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

    <title>Edit User Information | Co-Lab</title>


</head>

<body id="page-top" onload="<?= isset($loadThis) ? $loadThis : '' ?>">
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
                        <h1 class="h3 mb-0 text-gray-800">User Management</h1>
                    </div>

                    <div class="card shadow col-md-12 ">
                        <div class="card-body table-responsive">
                            <h5 class="text-dark">User List</h5><br>
                            <form action="" method="POST">
                                <div class="form-row">
                                    <div class="form-group col-md-5">
                                        <label for="fullname">Full Name</label>
                                        <input required type="text" class="form-control" id="fullname" value="<?= $fullnameold ?>" name="fullname">
                                    </div>
                                    <div class="form-group col-md-7">
                                        <label for="email">Email address</label>
                                        <input required type="email" class="form-control" value=<?= $emailold ?> id="email" name="email">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="studentid">Student ID</label>
                                        <input required type="number" class="form-control" value="<?= $studentidold ?>" id="studentid" name="studentid">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="username">Username</label>
                                        <input required type="text" class="form-control" id="username" value="<?= $usernameold ?>" name="username">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="username">User role</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text" for="inputGroupSelect01">Set as</label>
                                            </div>
                                            <select class="custom-select" id="inputGroupSelect01" name="role">
                                                <option <?= $roleold == "user" ? "selected" : ""; ?> value="user">Normal User</option>
                                                <option <?= $roleold == "admin" ? "selected" : "";  ?> value="admin">Administrator</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <a href="user-management.php" class="btn btn-secondary"><i class="fa-solid fa-chevron-left"></i> Back</a>
                                <button type="submit" class="btn btn-red" name="btnsave"><i class="fa-regular fa-floppy-disk"></i> Save Changes</button>
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
            text: 'User information has been updated',
            icon: 'success',
            confirmButtonText: 'Done',
            confirmButtonColor: '#b6453d'
        })
    }
</script>