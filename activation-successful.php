<?php
require_once "core/init.php";
require_once "core/no-session-allowed.php";

if (isset($_GET['apl']) && isset($_GET['uid'])) {
    $email = $_GET['apl'];
    $uid   = $_GET['uid'];

    if (!isuidmatch($email, $uid)) {
        header("Location: login.php");
    } else {
        changeuniqueid($email);
    }
} else {
    header("Location: login.php");
}

$query = "SELECT * FROM users WHERE email = '$email'";
$result = mysqli_query($link, $query);

$data = mysqli_fetch_assoc($result);
$validity = $data['validity'];

if ($validity != "valid" && isset($_GET['apl']) && isset($_GET['uid'])) {
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

    <title>Verifikasi Berhasil | Co-Lab</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row no-gutter">
            <div class="col-md-6">
                <div class="login d-flex align-items-center py-5">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-10 col-xl-7 mx-auto">
                                <h2 class="ff-nunito">Akun Terverifikasi
                                    <span class="fa-stack fa-2xs">
                                        <i class="fa-solid fa-certificate fa-stack-2x"></i>
                                        <i class="fa-solid fa-check fa-stack-1x fa-inverse"></i>
                                    </span>
                                </h2>
                                <p class="text-muted mb-4">Akun anda telah aktif. Silahkan masuk untuk mulai menggunakan</p>
                                <a href="login.php" class="btn btn-block btn-orange">Masuk Sekarang</a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 d-none d-md-flex activated-bg-image"></div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>