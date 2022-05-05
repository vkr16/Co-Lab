<?php
require_once "core/init.php";
require_once "core/no-session-allowed.php";

if (isset($_GET['apl']) && isset($_GET['uid'])) {
    $email = $_GET['apl'];
    $uid   = $_GET['uid'];

    if (!isuidmatch($email, $uid)) {
        header("Location: login.php");
    } else {
        if (isset($_POST['btnreset'])) {
            $password = $_POST['password'];
            if (resetpassword($email, $password)) {
                $newuid = changeuniqueid($email);
                $loadThis = "recoverySuccess()";
            } else {
                $loadThis = "systemFailed()";
            }
        }
    }
} else {
    header("Location: login.php");
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

    <title>Atur Ulang Kata Sandi | Co-Lab</title>
</head>

<body onload="<?= $loadThis ?>">
    <div class="container-fluid">
        <div class="row no-gutter">
            <div class="col-md-6">
                <div class="login d-flex align-items-center py-5">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-10 col-xl-7 mx-auto">
                                <h3 class="display-6">Atur Ulang Kata Sandi</h3>
                                <p class="text-muted mb-4">Buat kata sandi baru untuk akun anda <i class="fa-solid fa-key"></i></p>
                                <form action="" method="post">

                                    <div class="form-group mb-3">
                                        <input id="newPassword" type="password" placeholder="Kata sandi baru" required="" class="form-control border-0 shadow-sm px-4 text-blue" autocomplete="off" name="password" />
                                    </div>
                                    <input type="submit" class="btn btn-block btn-blue mb-2 shadow-sm align-self-center" value="&nbsp;&nbsp;Atur Kata Sandi Baru &nbsp;&nbsp;" name="btnreset" id="btnreset" />
                                </form>
                                <span class="text-muted">atau <a href="login.php" class="text-blue text-decoration-none">Masuk ke akun</a></span>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 d-none d-md-flex signup-bg-image"></div>
        </div>
    </div>


    <!-- Bootstrap JS -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- SweetAlert2 JS -->
    <script src="assets/vendor/SweetAlert2/SweetAlert2.js"></script>
</body>

</html>

<script>
    function systemFailed() {
        Swal.fire({
            icon: 'error',
            title: 'Terjadi Kesalahan',
            text: 'Silahkan coba lagi, jika masalah berlanjut harap hubungi admin.',
            confirmButtonText: "Saya Mengerti",
            confirmButtonColor: '#2b468b'
        })
    }

    function recoverySuccess() {
        Swal.fire({
            icon: 'success',
            title: 'Akun Dipulihkan',
            text: 'Kata sandi telah diatur ulang, silahkan masuk dengan kata sandi yang baru.',
            confirmButtonText: "Masuk",
            allowOutsideClick: false,
            allowEscapeKey: false,
            confirmButtonColor: '#2b468b'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "login.php";
            }
        })
    }
</script>