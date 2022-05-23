<?php
require_once "core/init.php";
require_once "core/no-session-allowed.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'assets/vendor/PHPMailer/src/Exception.php';
require 'assets/vendor/PHPMailer/src/PHPMailer.php';
require 'assets/vendor/PHPMailer/src/SMTP.php';

if (isset($_POST['btnrecover'])) {
    $useridentity = $_POST['useridentity'];

    if (isexist($useridentity)) {
        $email = getemailfromidentity($useridentity);
        $JSON_creds     = file_get_contents("core/mail-credentials.json");
        $credentials    = json_decode($JSON_creds, true);
        $email_address  = $credentials['creds']['email'];
        $email_password = $credentials['creds']['password'];


        $bytes =  bin2hex(random_bytes(20));

        $mail           = new PHPMailer;
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->Host     = 'smtp.mail.yahoo.com';
        $mail->Port     = 587;
        $mail->Username = $email_address;
        $mail->Password = $email_password;
        $mail->setFrom($email_address);
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Co-Lab - Account Recovery';
        $mail->Body    = "Click this link to reset your password : <br> " . $home . "/reset-password.php?apl=" . $email . "&uid=" . $bytes;
        if ($mail->send()) {
            $query = "UPDATE users SET uniqueid='$bytes' WHERE email='$email'";
            mysqli_query($link, $query);
            $loadThis = "successSendingMail()";
        } else {
            $loadThis = "systemFailed()";
        }
    } else {
        $loadThis = "userNotFound()";
    }
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="icon" href="assets/img/favicon.png">

    <!-- Custom style -->
    <link rel="stylesheet" href="assets/css/co-lab.css">

    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">

    <!-- Fontawesome -->
    <link rel="stylesheet" href="assets/vendor/fontawesome/css/all.min.css">

    <title>Pemulihan Akun | Co-Lab</title>
</head>

<body onload="<?= $loadThis; ?>">
    <div class="container-fluid">
        <div class="row no-gutter">
            <div class="col-md-6 d-none d-md-flex recovery-bg-image"></div>
            <div class="col-md-6">
                <div class="login d-flex align-items-center py-5">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-10 col-xl-7 mx-auto">
                                <span><a href="login.php" class="text-decoration-none text-blue"><i class="fa-solid fa-arrow-left-long"></i> &nbsp; Kembali ke halaman masuk</a></span><br><br>
                                <h3 class="display-6">Pemulihan Akun </h3>
                                <p class="text-muted mb-4">Harap masukkan nama pengguna atau email yang terhubung dengan akun anda <i class="fa-solid fa-shield-halved"></i></p>
                                <form action="" method="post">
                                    <div class="form-group mb-3">
                                        <input id="inputUserIdentity" type="text" placeholder="Nama pengguna atau email" required="" autofocus="" class="form-control border-0 shadow-sm px-4 text-red" autocomplete="off" name="useridentity" />
                                    </div>
                                    <input type="submit" class="btn btn-block btn-red mb-2 shadow-sm align-self-center" value="&nbsp;&nbsp;Atur Ulang Kata Sandi &nbsp;&nbsp;" name="btnrecover" />
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Bootstrap JS -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- SweetAlert2 JS -->
    <script src="assets/vendor/SweetAlert2/SweetAlert2.js"></script>
</body>

</html>

<script>
    function successSendingMail() {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil Terkirim',
            text: 'Silahkan klik tautan pada email yang kami kirimkan untuk mengatur ulang kata sandi anda.',
            confirmButtonColor: '#b6453d',
            confirmButtonText: "Saya Mengerti"
        })
    }

    function systemFailed() {
        Swal.fire({
            icon: 'error',
            title: 'Terjadi Kesalahan',
            text: 'Silahkan coba lagi, jika masalah berlanjut harap hubungi admin',
            confirmButtonText: "Saya Mengerti"
        })
    }

    function userNotFound() {
        Swal.fire({
            icon: 'error',
            title: 'Akun Tidak Ditemukan',
            text: 'Silahkan periksa kembali ejaan nama pengguna atau email anda',
            confirmButtonColor: '#b6453d',
            confirmButtonText: "Saya Mengerti"
        })
    }
</script>