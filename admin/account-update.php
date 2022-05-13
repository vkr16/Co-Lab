<?php

require_once "../core/init.php";
require_once "../core/admin-session-only.php";


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../assets/vendor/PHPMailer/src/Exception.php';
require '../assets/vendor/PHPMailer/src/PHPMailer.php';
require '../assets/vendor/PHPMailer/src/SMTP.php';

$activeUsername = $_SESSION['cl_user'];

if (isset($_POST['btnUpdateEmail'])) {
    $newEmail = $_POST['newmail'];

    if (isemailused($newEmail)) {
        $loadThis = "emailUsed()";
    } else {
        $query = "SELECT * FROM users WHERE username = '$activeUsername'";
        $result = mysqli_query($link, $query);
        $data = mysqli_fetch_assoc($result);
        $oldEmail = $data['email'];
        if (updateEmail($newEmail, $activeUsername)) {

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
            $mail->addAddress($newEmail);
            $mail->isHTML(true);
            $mail->Subject = 'Perubahan Alamat Email - Co-Lab';
            $mail->Body    = "<h3>Alamat email anda berhasil di perbarui</h3> " . $oldEmail . " tidak lagi terhubung dengan akun Co-Lab anda.";
            $mail->send();

            $loadThis = "emailUpdated()";
        } else {
            $loadThis = "failedToUpdate()";
        }
    }
}


if (isset($_POST['btnUpdatePass'])) {
    $oldPass = $_POST['oldPass'];
    $newPass = $_POST['newPass'];

    if (isvalid($activeUsername, $oldPass)) {
        if (updatePass($activeUsername, $newPass)) {
            $loadThis = "passwordUpdated()";
        } else {
            $loadThis = "failedToUpdatePass()";
        }
    } else {
        $loadThis = "failedPasswordInvalid()";
    }
}

if (isset($_POST['btnUpdateUsername'])) {
    $newUsername = $_POST['newusername'];
    $oldUsername = $_SESSION['cl_user'];

    if (updateUsername($newUsername, $oldUsername)) {
        $loadThis = "usernameUpdated()";
    } else {
        $loadThis = "usernameUpdateFailed()";
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

    <!-- Custom styles for navigation-->
    <link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom style -->
    <link rel="stylesheet" href="../assets/css/co-lab.css">

    <title>Data Pengguna | Co-Lab</title>


</head>

<body id="page-top" onload="<?= $loadThis; ?>">

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
                        <h1 class="h3 mb-0 text-gray-800">Perbarui Data Pengguna</h1>

                    </div>
                    <div class="row">
                        <div class="col-lg-7">

                            <!-- Default Card Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header">
                                    Perbarui Data
                                </div>
                                <div class="card-body">

                                    <h5> <i class="fa-solid fa-lock"></i> Ubah Nama Pengguna</h5>
                                    <br>

                                    <form action="" method="POST">
                                        <div class="form-group row">
                                            <label for="inputusername" class="col-sm-3 col-form-label">Nama pengguna</label>
                                            <div class="col-sm-9">
                                                <div class="input-group mb-3">
                                                    <input type="text" name="newusername" class="form-control" placeholder="Masukkan nama pengguna baru anda">
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <button type="submit" name="btnUpdateUsername" class="btn btn-red d-flex justify-content-end">Perbarui Nama Pengguna</button>
                                    </form>
                                    <br>
                                    <hr>
                                    <h5><i class="fa-solid fa-envelope"></i> Ubah Alamat Email </h5>
                                    <br>

                                    <form action="" method="POST">
                                        <div class="form-group row">
                                            <label for="inputEmail" class="col-sm-3 col-form-label">Alamat email baru</label>
                                            <div class="col-sm-9">
                                                <input type="email" name="newmail" class="form-control" id="inputEmail" placeholder="Masukkan alamat email baru">
                                            </div>
                                        </div>
                                        <br>
                                        <button type="submit" name="btnUpdateEmail" class="btn btn-red d-flex justify-content-end">Perbarui Email</button>
                                    </form>

                                    <br>
                                    <hr>

                                    <h5> <i class="fa-solid fa-lock"></i> Atur Ulang Kata Sandi</h5>
                                    <br>

                                    <form action="" method="POST">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Kata Sandi Saat Ini</label>
                                            <div class="col-sm-9">
                                                <div class="input-group mb-3">
                                                    <input type="password" name="oldPass" class="form-control" placeholder="Masukkan kata sandi lama" aria-describedby="button-addon2" id="old-pass">
                                                    <div class="input-group-append">
                                                        <span class="btn btn-outline-secondary" type="button" id="current-visib" onclick="changeVisibility(this.innerHTML , this.id)"><i class="fa-solid fa-eye"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail" class="col-sm-3 col-form-label">Kata Sandi Baru</label>
                                            <div class="col-sm-9">
                                                <div class="input-group mb-3">
                                                    <input type="password" name="newPass" class="form-control" placeholder="Masukkan kata sandi baru" aria-describedby="button-addon2" id="new-pass">
                                                    <div class="input-group-append">
                                                        <span class="btn btn-outline-secondary" type="button" id="new-visib" onclick="changeVisibility(this.innerHTML , this.id)"><i class="fa-solid fa-eye"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <button type="submit" name="btnUpdatePass" class="btn btn-red d-flex justify-content-end">Perbarui Kata Sandi</button>
                                    </form>


                                </div>
                            </div>

                        </div>

                        <div class="col-lg-5">
                            <!-- Default Card Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header">
                                    Informasi Pengguna
                                </div>
                                <div class="card-body">
                                    <dl class="row">
                                        <?php
                                        $session_user = $_SESSION['cl_user'];
                                        $query = "SELECT * FROM users WHERE username = '$session_user'";
                                        $result = mysqli_query($link, $query);
                                        $data = mysqli_fetch_assoc($result);

                                        ?>
                                        <dt class="col-sm-4">Nama Lengkap</dt>
                                        <dd class="col-sm-8">: <?= $data['fullname']; ?></dd>

                                        <dt class="col-sm-4">Nomor Identitas</dt>
                                        <dd class="col-sm-8">: <?= $data['studentid']; ?></dd>

                                        <dt class="col-sm-4">Alamat Email</dt>
                                        <dd class="col-sm-8">: <?= $data['email']; ?></dd>

                                        <dt class="col-sm-4">Nama Pengguna</dt>
                                        <dd class="col-sm-8">: <?= $data['username']; ?></dd>

                                    </dl>

                                    <hr>
                                    <span class="text-secondary small mb-0 mt-0">* Perubahan pada nama lengkap dan nomor identitas hanya dapat dilakukan oleh administrator yang berbeda</span>
                                </div>
                            </div>

                        </div>
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

    <!-- Bootstrap core JavaScript-->
    <script src="../assets/vendor/jquery/jquery.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../assets/js/sb-admin-2.min.js"></script>

    <!-- SweetAlert2 JS -->
    <script src="../assets/vendor/SweetAlert2/SweetAlert2.js"></script>

</body>

</html>

<script>
    function changeVisibility(status, id) {

        if (status == '<i class="fa-solid fa-eye"></i>') {
            if (id == 'current-visib') {
                $("#old-pass").attr("type", "text");
                $("#current-visib").html('<i class="fa-solid fa-eye-slash"></i>');
            } else if (id == 'new-visib') {
                $("#new-pass").attr("type", "text");
                $("#new-visib").html('<i class="fa-solid fa-eye-slash"></i>');
            }
        } else {
            if (id == 'current-visib') {
                $("#old-pass").attr("type", "password");
                $("#current-visib").html('<i class="fa-solid fa-eye"></i>');
            } else if (id == 'new-visib') {
                $("#new-pass").attr("type", "password");
                $("#new-visib").html('<i class="fa-solid fa-eye"></i>');
            }
        }
    }

    function emailUpdated() {
        Swal.fire({
            icon: 'success',
            title: 'Perubahan Tersimpan',
            text: 'Alamat email anda berhasil di perbarui',
            confirmButtonColor: '#2b468b',
            confirmButtonText: "Selesai"
        })
    }

    function usernameUpdated() {
        Swal.fire({
            icon: 'success',
            title: 'Perubahan Tersimpan',
            text: 'Nama pengguna anda berhasil di perbarui',
            confirmButtonColor: '#2b468b',
            confirmButtonText: "Selesai"
        })
    }

    function usernameUpdateFailed() {
        Swal.fire({
            icon: 'error',
            title: 'Terjadi Kesalahan',
            text: 'Nama pengguna anda gagal di perbarui',
            confirmButtonColor: '#2b468b',
            confirmButtonText: "Tutup"
        })
    }

    function failedToUpdate() {
        Swal.fire({
            icon: 'error',
            title: 'Terjadi Kesalahan',
            text: 'Alamat email anda gagal di perbarui',
            confirmButtonColor: '#2b468b',
            confirmButtonText: "Tutup"
        })
    }

    function emailUsed() {
        Swal.fire({
            icon: 'error',
            title: 'Email Sudah Digunakan',
            text: 'Alamat email yang anda masukkan sudah terdaftar pada akun lain',
            confirmButtonColor: '#2b468b',
            confirmButtonText: "Tutup"
        })
    }

    function failedToUpdatePass() {
        Swal.fire({
            icon: 'error',
            title: 'Terjadi Kesalahan',
            text: 'Password gagal diperbarui',
            confirmButtonColor: '#2b468b',
            confirmButtonText: "Tutup"
        })
    }

    function failedPasswordInvalid() {
        Swal.fire({
            icon: 'warning',
            title: 'Kata Sandi Salah',
            text: 'Kata sandi anda tidak sesuai, harap periksa kembali ejaan anda',
            confirmButtonColor: '#2b468b',
            confirmButtonText: "Selesai"
        })
    }

    function passwordUpdated() {
        Swal.fire({
            icon: 'success',
            title: 'Kata Sandi Berhasil Diperbarui',
            text: 'Kata sandi anda telah berhasil diperbarui',
            confirmButtonColor: '#2b468b',
            confirmButtonText: "Selesai"
        })
    }
</script>