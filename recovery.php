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
    $email = getemailfromidentity($useridentity);

    if (isexist($useridentity)) {
        $JSON_creds     = file_get_contents("core/mail-credentials.json");
        $credentials    = json_decode($JSON_creds, true);
        $email_address  = $credentials['creds']['email'];
        $email_password = $credentials['creds']['password'];


        $bytes =  bin2hex(random_bytes(20));

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
        $mail->Subject = 'Co-Lab - Account Recovery';
        $mail->Body    = "Click this link to reset your password : <br> " . $home . "/reset-password.php?apl=" . $email . "&uid=" . $bytes;
        if ($mail->send()) {
            $query = "UPDATE users SET uniqueid='$bytes' WHERE email='$email'";
            mysqli_query($link, $query);
            $succTitle = "Reset link sent";
            $succBody  = "A link has been sent to your email, click the link to reset your password";
            $loadThis = "succToast()";
        } else {
            $errTitle = "Failed to reset password";
            $errBody  = "System failure, please contact our system administrator";
            $loadThis = "errToast()";
        }
    } else {
        echo "not exist";
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

    <title>Co-Lab | Account Recovery</title>
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
                                <span><a href="login.php" class="text-decoration-none text-blue"><i class="fa-solid fa-arrow-left-long"></i> &nbsp; Back to login page</a></span><br><br>
                                <h3 class="display-6">Account Recovery </h3>
                                <p class="text-muted mb-4">Please enter the email address or username associated with your account <i class="fa-solid fa-shield-halved"></i></p>
                                <form action="" method="post">
                                    <div class="form-group mb-3">
                                        <input id="inputUserIdentity" type="text" placeholder="Email or username" required="" autofocus="" class="form-control border-0 shadow-sm px-4 text-red" autocomplete="off" name="useridentity" />
                                    </div>
                                    <input type="submit" class="btn btn-block btn-red mb-2 shadow-sm align-self-center" value="&nbsp;&nbsp;Reset Password &nbsp;&nbsp;" name="btnrecover" />
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
        <div id="succNotif" class="toast border-success ff-nunito" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto text-success"><i class="fa-solid fa-circle-check"></i> &nbsp; Success Notification</strong>
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
        var succtoast = new bootstrap.Toast(succNotif)
        succtoast.show()
    }
</script>