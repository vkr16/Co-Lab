<?php

require_once "../core/init.php";
require_once "../core/user-session-only.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="icon" href="../assets/img/favicon.png">

    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">

    <!-- Fontawesome -->
    <link rel="stylesheet" href="../assets/vendor/fontawesome/css/all.min.css">

    <!-- Custom style -->
    <link rel="stylesheet" href="../assets/css/co-lab.css">

    <!-- Custom styles for navigation-->
    <link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">

    <title>Home | Co-Lab</title>


</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php include "views/sidebar.php" ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php include "views/topbar.php" ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Perbarui Data Pengguna</h1>

                    </div>
                    <div class="row">
                        <div class="col-lg-7">

                            <!-- Default Card Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header">
                                    Perbarui Data
                                </div>
                                <div class="card-body">
                                    <h5><i class="fa-solid fa-envelope"></i> Ubah Alamat Email </h5>
                                    <br>

                                    <form>
                                        <!-- <div class="form-group row">
                                            <label for="staticEmail" class="col-sm-3 col-form-label">Alamat email lama</label>
                                            <div class="col-sm-9">
                                                <input disabled readonly class="form-control-plaintext" id="staticEmail" value="contact.fikmif16@gmail.com">
                                            </div>
                                        </div> -->
                                        <div class="form-group row">
                                            <label for="inputEmail" class="col-sm-3 col-form-label">Alamat email baru</label>
                                            <div class="col-sm-9">
                                                <input type="email" class="form-control" id="inputEmail" placeholder="Masukkan alamat email baru">
                                            </div>
                                        </div>
                                        <br>
                                        <button class="btn btn-primary d-flex justify-content-end">Perbarui Email</button>
                                    </form>

                                    <br>
                                    <hr>

                                    <h5> <i class="fa-solid fa-lock"></i> Atur Ulang Kata Sandi</h5>
                                    <br>

                                    <form>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Kata Sandi Saat Ini</label>
                                            <div class="col-sm-9">
                                                <div class="input-group mb-3">
                                                    <input type="password" class="form-control" placeholder="Masukkan kata sandi lama" aria-describedby="button-addon2" id="old-pass">
                                                    <div class="input-group-append">
                                                        <span class="btn btn-outline-secondary" type="button" id="current-visib" onclick="changeVisibility(this.innerHTML , this.id)"><i class="fa-solid fa-eye"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail" class="col-sm-3 col-form-label">Kata Sandi Baru</label>
                                            <div class="col-sm-9">
                                                <div class="input-group mb-3">
                                                    <input type="password" class="form-control" placeholder="Masukkan kata sandi baru" aria-describedby="button-addon2" id="new-pass">
                                                    <div class="input-group-append">
                                                        <span class="btn btn-outline-secondary" type="button" id="new-visib" onclick="changeVisibility(this.innerHTML , this.id)"><i class="fa-solid fa-eye"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <button class="btn btn-primary d-flex justify-content-end">Perbarui Kata Sandi</button>
                                    </form>
                                </div>
                            </div>

                        </div>

                        <div class="col-lg-5">
                            <!-- Default Card Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header">
                                    Informasi Pengguna
                                </div>
                                <div class="card-body">
                                    <dl class="row">
                                        <?php
                                        $session_user = $_SESSION['cl_user'];
                                        $query = "SELECT * FROM users WHERE username = '$session_user'";
                                        $result = mysqli_query($link, $query);
                                        $data = mysqli_fetch_assoc($result);

                                        ?>
                                        <dt class="col-sm-4">Nama Lengkap</dt>
                                        <dd class="col-sm-8"><?= $data['fullname']; ?></dd>

                                        <dt class="col-sm-4">NIM</dt>
                                        <dd class="col-sm-8"><?= $data['studentid']; ?></dd>

                                        <dt class="col-sm-4">Alamat Email</dt>
                                        <dd class="col-sm-8"><?= $data['email']; ?></dd>

                                        <dt class="col-sm-4">Nama Pengguna</dt>
                                        <dd class="col-sm-8"><?= $data['username']; ?></dd>

                                    </dl>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- Content Row -->

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Co-Lab 2022</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="../assets/vendor/jquery/jquery.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../assets/js/sb-admin-2.min.js"></script>

</body>

</html>

<script>
    function changeVisibility(status, id) {

        if (status == '<i class="fa-solid fa-eye"></i>') {
            if (id == 'current-visib') {
                $("#old-pass").attr("type", "text");
                $("#current-visib").html('<i class="fa-solid fa-eye-slash"></i>');
            } else if (id == 'new-visib') {
                $("#new-pass").attr("type", "text");
                $("#new-visib").html('<i class="fa-solid fa-eye-slash"></i>');
            }
        } else {
            if (id == 'current-visib') {
                $("#old-pass").attr("type", "password");
                $("#current-visib").html('<i class="fa-solid fa-eye"></i>');
            } else if (id == 'new-visib') {
                $("#new-pass").attr("type", "password");
                $("#new-visib").html('<i class="fa-solid fa-eye"></i>');
            }
        }




    }
</script>