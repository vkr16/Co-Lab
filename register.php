<?php
require_once "core/init.php";
require_once "core/no-session-allowed.php";


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'assets/vendor/PHPMailer/src/Exception.php';
require 'assets/vendor/PHPMailer/src/PHPMailer.php';
require 'assets/vendor/PHPMailer/src/SMTP.php';

if (isset($_POST['btnsignup'])) {
    $fullname = $_POST['fullname'];
    $studentid = $_POST['studentid'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (isemailused($email)) {
        $loadThis = "emailUsedAlert()";
    } else {
        if (isusernametaken($username)) {
            $loadThis = "usernameUnavailable()";
        } else {
            if (isstudentidused($studentid)) {
                $errTitle = "Student id already registered";
                $errBody = "Each student ID number can only be used to register 1 account";
                $loadThis = "studentIdUsed()";
            } else {
                if (createaccount($fullname, $studentid, $username, $email, $password)) {

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
                    $mail->Subject = 'Co-Lab - Account Verification';
                    $mail->Body    = "Click this link to activate your account : <br> " . $home . "/activation.php?apl=" . $email . "&uid=" . $bytes;
                    if ($mail->send()) {
                        $query = "UPDATE users SET uniqueid='$bytes' WHERE email='$email'";
                        mysqli_query($link, $query);
                        header("Location: registration-successful.php?apl=" . $email);
                    } else {
                        $loadThis = "failToRegister()";
                    }
                } else {
                    $loadThis = "failToRegister()";
                }
            }
        }
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

    <title>Daftar | Co-Lab</title>
</head>

<body onload="<?= $loadThis ?>">
    <div class="container-fluid">
        <div class="row no-gutter">
            <div class="col-md-6">
                <div class="login d-flex align-items-center py-5">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-10 col-xl-7 mx-auto">
                                <h3 class="display-6">Daftar </h3>
                                <p class="text-muted mb-4">Menjadwalkan pembukuan ruangan tidak pernah semudah ini. Buat akun sekarang. <i class="fa-solid fa-couch"></i></p>
                                <form action="" method="post">
                                    <div class="form-group mb-3">
                                        <input id="inputFullname" type="text" placeholder="Nama lengkap" required="" autofocus="" class="form-control border-0 shadow-sm px-4 text-blue" autocomplete="off" name="fullname" />
                                    </div>
                                    <div class="form-group mb-3">
                                        <input id="inputStudentId" type="number" placeholder="Nomor induk mahasiswa" required="" autofocus="" class="form-control border-0 shadow-sm px-4 text-blue" autocomplete="off" name="studentid" />
                                    </div>
                                    <div class="form-group mb-3">
                                        <input id="inputUsername" type="text" placeholder="Nama pengguna" required="" autofocus="" class="form-control border-0 shadow-sm px-4 text-blue" autocomplete="off" name="username" />
                                    </div>
                                    <div class="form-group mb-3">
                                        <input id="inputEmail" type="email" placeholder="Alamat email" required="" autofocus="" class="form-control border-0 shadow-sm px-4 text-blue" autocomplete="off" name="email" />
                                    </div>
                                    <div class="form-group mb-3">
                                        <input id="inputPassword" type="password" placeholder="Kata sandi" required="" class="form-control border-0 shadow-sm px-4 text-blue" autocomplete="off" name="password" />
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <div class="form-check mb-3">
                                            <input required type="checkbox" class="form-check-input shadow-sm cb-blue" id="checkStayLogin" name="staylogin" onchange="agreeCheck()">
                                            <label class="form-check-label" for="checkStayLogin">Saya setuju dengan <a href="javascript:;" class="text-blue text-decoration-none">kebijakan & ketentuan privasi<a></label>
                                        </div>
                                    </div>
                                    <input disabled type="submit" class="btn btn-block btn-blue mb-2 shadow-sm align-self-center" value="&nbsp;&nbsp;Daftar &nbsp;&nbsp;" name="btnsignup" id="btnsignup" />
                                </form>
                                <span class="text-muted">Sudah memiliki akun? <a href="login.php" class="text-blue text-decoration-none">Masuk disini</a></span>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 d-none d-md-flex signup-bg-image"></div>
        </div>
    </div>

    <!-- SweetAlert2 JS -->
    <script src="assets/vendor/SweetAlert2/SweetAlert2.js"></script>

    <!-- Bootstrap JS -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<script>
    function usernameUnavailable() {
        Swal.fire({
            icon: 'error',
            title: 'Nama Pengguna Tidak Tersedia',
            text: 'Silahkan pilih nama pengguna lain',
            confirmButtonColor: '#2b468b',
            confirmButtonText: "Saya Mengerti"
        })
    }

    function emailUsedAlert() {
        Swal.fire({
            icon: 'error',
            title: 'Alamat Email Sudah Digunakan',
            text: 'Harap gunakan alamat email yang berbeda',
            confirmButtonColor: '#2b468b',
            confirmButtonText: "Saya Mengerti"
        })
    }

    function failToRegister() {
        Swal.fire({
            icon: 'error',
            title: 'Terjadi Kesalahan',
            text: 'Silahkan coba lagi, jika masalah berlanjut harap hubungi admin',
            confirmButtonColor: '#2b468b',
            confirmButtonText: "Saya Mengerti"
        })
    }

    function studentIdUsed() {
        Swal.fire({
            icon: 'error',
            title: 'NIM Sudah Terdaftar',
            text: 'Setiap NIM hanya dapat digunakan untuk mendaftarkan 1 akun saja',
            confirmButtonColor: '#2b468b',
            confirmButtonText: "Saya Mengerti"
        })
    }


    function agreeCheck() {
        var btn = document.getElementById("btnsignup");
        var cb = document.getElementById("checkStayLogin");

        if (cb.checked == true) {
            btn.disabled = false;
        } else {
            btn.disabled = true;
        }
    }
</script>