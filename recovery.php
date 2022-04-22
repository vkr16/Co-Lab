<?php
require_once "core/init.php";
require_once "core/no-session-allowed.php";

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

<body>
    <div class="container-fluid">
        <div class="row no-gutter">
            <div class="col-md-6 d-none d-md-flex recovery-bg-image"></div>
            <div class="col-md-6">
                <div class="login d-flex align-items-center py-5">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-10 col-xl-7 mx-auto">
                                <h3 class="display-6">Account Recovery </h3>
                                <p class="text-muted mb-4">Please enter the email address associated with your account <i class="fa-solid fa-shield-halved"></i></p>
                                <form action="" method="post">
                                    <div class="form-group mb-3">
                                        <input id="inputUserIdentity" type="text" placeholder="Email address" required="" autofocus="" class="form-control border-0 shadow-sm px-4 text-red" autocomplete="off" name="username" />
                                    </div>
                                    <input type="submit" class="btn btn-block btn-red mb-2 shadow-sm align-self-center" value="&nbsp;&nbsp;Reset Password &nbsp;&nbsp;" name="submit" />
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
                <p class="mb-0"><strong> User Not Found</strong> <br>Please check your email or username</p>
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
</script>