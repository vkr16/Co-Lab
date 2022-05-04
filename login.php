<?php

require_once "core/init.php";
require_once "core/no-session-allowed.php";

if (isset($_POST['btnsignin'])) {
    $useridentity = $_POST['userid'];
    $password = $_POST['password'];
    if (isset($_POST['staylogin'])) {
        $staylogin = true;
    } else {
        $staylogin = false;
    }

    if (isexist($useridentity)) {
        if (isactivated($useridentity)) {
            if (isvalid($useridentity, $password)) {
                savesession($staylogin, $useridentity);
            } else {
                $loadThis = "wrongPassAlert()";
            }
        } else {

            $loadThis = "accountInvalidAlert()";
        }
    } else {
        $loadThis = "accountNotFound()";
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

    <title>Masuk | Co-Lab</title>
</head>

<body onload="<?= $loadThis; ?>">
    <div class="container-fluid">
        <div class="row no-gutter">
            <div class="col-md-6">
                <div class="login d-flex align-items-center py-5">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-10 col-xl-7 mx-auto">
                                <h3 class="display-6">Masuk </h3>
                                <p class="text-muted mb-4">Silahkan masuk ke akun anda untuk mulai menggunakan layanan kami <i class="fa-solid fa-rocket"></i></p>
                                <form action="" method="post">
                                    <div class="form-group mb-3">
                                        <input id="inputUserIdentity" type="text" placeholder="Nama pengguna atau email" required="" autofocus="" class="form-control border-0 shadow-sm px-4 text-orange" autocomplete="off" name="userid" />
                                    </div>
                                    <div class="form-group mb-3">
                                        <input id="inputPassword" type="password" placeholder="Kata sandi" required="" class="form-control border-0 shadow-sm px-4 text-orange" autocomplete="off" name="password" />
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <div class="form-check mb-3">
                                            <input type="checkbox" class="form-check-input shadow-sm cb-orange" id="checkStayLogin" name="staylogin">
                                            <label class="form-check-label" for="checkStayLogin">Tetap masuk</label>
                                        </div>
                                        <span class="text-muted"><a href="recovery.php" class="text-orange text-decoration-none">Lupa kata sandi?</a></span>
                                    </div>
                                    <input type="submit" class="btn btn-block btn-orange mb-2 shadow-sm align-self-center" value="&nbsp;&nbsp;Masuk &nbsp;&nbsp;" name="btnsignin" />
                                </form>
                                <span class="text-muted">Belum punya akun? <a href="register.php" class="text-orange text-decoration-none">Buat akun baru</a></span>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 d-none d-md-flex login-bg-image"></div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/SweetAlert2/SweetAlert2.js"></script>
</body>

</html>

<script>
    function wrongPassAlert() {
        Swal.fire({
            icon: 'error',
            title: 'Kata Sandi Salah',
            text: 'Kata sandi yang anda masukkan tidak sesuai. Silahkan periksa kembali ejaan anda.',
            confirmButtonColor: '#ed7d2b',
            confirmButtonText: "Saya mengerti"
        })
    }

    function accountInvalidAlert() {
        Swal.fire({
            icon: 'warning',
            title: 'Akun Belum Diverifikasi',
            text: 'Silahkan lakukan verifikasi dengan mengikuti tautan yang dikirimkan ke email anda.',
            confirmButtonColor: '#ed7d2b',
            confirmButtonText: "Saya mengerti",
            footer: 'Belum menerima email aktivasi?&nbsp; <a href="resend-verification.php" class="text-decoration-none text-orange">Kirim ulang</a>'
        })
    }

    function accountNotFound() {
        Swal.fire({
            icon: 'error',
            title: 'Pengguna Tidak Dikenali',
            text: 'Kami tidak mengenali nama pengguna atau email yang anda masukkan. Harap periksa kembali ejaan anda.',
            confirmButtonColor: '#ed7d2b',
            confirmButtonText: "Saya mengerti"
        })
    }
</script>