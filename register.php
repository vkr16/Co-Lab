<?php
require_once "core/init.php";

if (isset($_POST['btnsignup'])) {
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (isemailused($email)) {
        $errTitle = "Email already used";
        $errBody = "Please use another email account";
        $loadThis = "errToast()";
    } else {
        if (isusernametaken($username)) {
            $errTitle = "Username unavaliable";
            $errBody = "Please pick another username";
            $loadThis = "errToast()";
        } else {
            if (createaccount($fullname, $username, $email, $password)) {
                $succTitle = "Registration Successful";
                $succBody = "Please check your inbox for email verification";
                $loadThis = "succToast()";
            } else {
                $errTitle = "Registration Failed";
                $errBody = "System failure, please contact our system administrator";
                $loadThis = "errToast()";
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
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="icon" href="assets/img/favicon.png">

    <!-- Custom style -->
    <link rel="stylesheet" href="assets/css/co-lab.css">

    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">

    <!-- Fontawesome -->
    <link rel="stylesheet" href="assets/fontawesome/css/all.min.css">

    <title>Co-Lab | Sign Up</title>
</head>

<body onload="<?= $loadThis ?>">
    <div class="container-fluid">
        <div class="row no-gutter">
            <div class="col-md-6">
                <div class="login d-flex align-items-center py-5">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-10 col-xl-7 mx-auto">
                                <h3 class="display-6">Sign Up </h3>
                                <p class="text-muted mb-4">Book your space right from your room <i class="fa-solid fa-couch"></i></p>
                                <form action="" method="post">
                                    <div class="form-group mb-3">
                                        <input id="inputFullname" type="text" placeholder="Full Name" required="" autofocus="" class="form-control border-0 shadow-sm px-4 text-blue" autocomplete="off" name="fullname" />
                                    </div>
                                    <div class="form-group mb-3">
                                        <input id="inputUsername" type="text" placeholder="Username" required="" autofocus="" class="form-control border-0 shadow-sm px-4 text-blue" autocomplete="off" name="username" />
                                    </div>
                                    <div class="form-group mb-3">
                                        <input id="inputEmail" type="email" placeholder="Email address" required="" autofocus="" class="form-control border-0 shadow-sm px-4 text-blue" autocomplete="off" name="email" />
                                    </div>
                                    <div class="form-group mb-3">
                                        <input id="inputPassword" type="password" placeholder="Password" required="" class="form-control border-0 shadow-sm px-4 text-blue" autocomplete="off" name="password" />
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <div class="form-check mb-3">
                                            <input required type="checkbox" class="form-check-input shadow-sm cb-blue" id="checkStayLogin" name="staylogin" onchange="agreeCheck()">
                                            <label class="form-check-label" for="checkStayLogin">I agree to <a href="javascript:;" class="text-blue text-decoration-none">privacy policy & terms </a></label>
                                        </div>
                                    </div>
                                    <input disabled type="submit" class="btn btn-block btn-blue mb-2 shadow-sm align-self-center" value="&nbsp;&nbsp;Sign Up &nbsp;&nbsp;" name="btnsignup" id="btnsignup" />
                                </form>
                                <span class="text-muted">Already have an account? <a href="login.php" class="text-blue text-decoration-none">Sign in instead</a></span>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 d-none d-md-flex signup-bg-image"></div>
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
    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
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