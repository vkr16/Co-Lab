<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">

</head>

<body>
</body>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<script src="assets/vendor/SweetAlert2/SweetAlert2.js"></script>

<?php
require_once "core/init.php";
require_once "core/no-session-allowed.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'assets/vendor/PHPMailer/src/Exception.php';
require 'assets/vendor/PHPMailer/src/PHPMailer.php';
require 'assets/vendor/PHPMailer/src/SMTP.php';


if (isset($_GET['apl'])) {
    $email = $_GET['apl'];
    if (isexist($email)) {
        $query = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($link, $query);

        $data = mysqli_fetch_assoc($result);
        $validity = $data['validity'];
        if ($validity != "invalid") {
            header("Location: login.php");
        } else {
            $JSON_creds     = file_get_contents("core/mail-credentials.json");
            $credentials    = json_decode($JSON_creds, true);
            $email_address  = $credentials['creds']['email'];
            $email_password = $credentials['creds']['password'];


            $query = "SELECT * FROM users WHERE email='$email'";
            $result = mysqli_query($link, $query);
            $data = mysqli_fetch_assoc($result);
            $uniqueid = $data['uniqueid'];

            $mail           = new PHPMailer;
            $mail->isSMTP();
            $mail->SMTPAuth = true;
            $mail->Host     = 'smtp.gmail.com';
            $mail->Port     = 587;
            $mail->Username = $email_address;
            $mail->Password = $email_password;
            $mail->setFrom($email_address);
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Verifikasi Akun Co-Lab';
            $mail->Body    = "Klik tautan berikut untuk memverifikasi akun anda : <br> " . $home . "/activation.php?apl=" . $email . "&uid=" . $uniqueid;
            if ($mail->send()) {
                header("Location: registration-successful.php?apl=" . $email);
            } else {
                echo "<script type=text/javascript>
        Swal.fire({
            icon: 'error',
            title: 'Terjadi kesalahan',
            text: \"Silahkan coba lagi, jika masalah berlanjut harap hubungi admin\",
            confirmButtonColor: \"#ed7d2b\",
            confirmButtonText: \"Saya mengerti\",
            allowEscapeKey: false,
            allowOutsideClick: false
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = \"login.php\";
            }
        })
        </script>";
            }
        }
    } else {
        echo "<script type=text/javascript>
        Swal.fire({
            icon: 'error',
            title: 'Email Tidak Dikenali',
            text: \"Tidak ditemukan pengguna dengan email tersebut.\",
            confirmButtonColor: \"#ed7d2b\",
            confirmButtonText: \"Kembali\",
            allowEscapeKey: false,
            allowOutsideClick: false
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = \"login.php\";
            }
        })
        </script>";
        // header("Location: login.php");
    }
} else {
    echo "<script type=\"text/Javascript\">
    (async () => {

        const { value: email } = await Swal.fire({
          title: 'Aktivasi Akun',
          input: 'email',
          inputLabel: 'Masukkan alamat email yang terhubung dengan akun anda.',
          inputPlaceholder: 'Masukkan alamat email anda',
          confirmButtonText: \"Kirim\",
          allowEscapeKey: false,
          allowOutsideClick: false
        })
        
        if (email) {
            window.location.href = \"resend-verification.php?apl=\"+ email;
        }
        
        })()
    </script>";
}
?>


</html>