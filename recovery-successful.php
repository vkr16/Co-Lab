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

$email = $_GET['apl'];
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

    <title>Pemilihan Berhasil | Co-Lab</title>
</head>

<body onload="<?= $loadThis ?>">
    <div class="container-fluid">
        <div class="row no-gutter">
            <div class="col-md-6">
                <div class="login d-flex align-items-center py-5">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-10 col-xl-7 mx-auto">
                                <h2 class="ff-nunito">Account Recovered
                                    <i class="fa-solid fa-shield-halved"></i>
                                </h2>
                                <p class="text-muted mb-4">Your account password has been reset.</p>
                                <a href="login.php" class="btn btn-block btn-orange">Sign In Now</a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 d-none d-md-flex activated-bg-image"></div>
        </div>
    </div>

    <!-- BS Toast -->
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 11">
        <div id="errorNotif" class="toast border-danger ff-nunito" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto text-danger"><i class="fa-solid fa-circle-exclamation"></i> &nbsp; Error Notification</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body text-danger">
                <p class="mb-0"><strong> <?= $errTitle; ?></strong> <br><?= $errBody; ?></p>
            </div>
        </div>
    </div>

    <!-- BS Toast -->
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 11">
        <div id="successNotif" class="toast border-success ff-nunito" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto text-success"><i class="fa-solid fa-circle-check"></i> &nbsp; Action Success Notification</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body text-success">
                <p class="mb-0"><strong> <?= $succTitle; ?></strong> <br><?= $succBody; ?></p>
            </div>
        </div>
    </div>


    <!-- Bootstrap JS -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<script>
    function errToast() {
        var errtoast = new bootstrap.Toast(errorNotif)
        errtoast.show()
    }

    function succToast() {
        var succtoast = new bootstrap.Toast(successNotif)
        succtoast.show()
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