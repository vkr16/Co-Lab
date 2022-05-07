<?php

require_once "../core/init.php";
require_once "../core/user-session-only.php";

if (isset($_POST['submit'])) {

    // Preprocess the date before inserted to database
    $date = $_POST['date'];
    $tgl = substr($date, 0, 2);
    $bln = substr($date, 3, 2);
    $thn = substr($date, 6, 4);
    $date = $thn . "/" . $bln . "/" . $tgl;

    $timeStart = $_POST['hour1'] . ":" . $_POST['minute1'];
    $timeStart = date_format(date_create($timeStart), 'H:i');
    $startDateTime = $date . " " . $timeStart;
    $startDateTime = date_create($startDateTime);

    $timeEnd = $_POST['hour2'] . ":" . $_POST['minute2'];
    $timeEnd = date_format(date_create($timeEnd), 'H:i');
    $endDateTime = $date . " " . $timeEnd;
    $endDateTime = date_create($endDateTime);

    $notes = $_POST['notes'];
    $notes = str_replace(array(
        "\r\n",
        "\n"
    ), '<br>', $notes);
    // Preprocess end here


}

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

    <!-- Datepicker CSS -->
    <link rel="stylesheet" href="../assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css">

    <!-- Custom style -->
    <link rel="stylesheet" href="../assets/css/co-lab.css">

    <!-- Custom styles for navigation-->
    <link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">

    <title>Detail Ruangan | Co-Lab</title>


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
                <div class="container-fluid mb-4">

                    <!-- Page Heading -->
                    <form>
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">Detail Ruangan</h1>
                        </div>
                    </form>
                    <div class="row">


                        <div class="col-md-7">
                            <div class="card shadow-sm">
                                <div class="card-header">
                                    Informasi Ruangan
                                </div>
                                <div class="card-body">
                                    <!-- <h4 class="card-title text-dark">Ruang Rapat Bersama 2</h4> -->


                                    <div class="row">

                                        <div class="col-md-4">
                                            <img src="../assets/img/rooms/5005c850e804963b7d5f.jpeg" class="img-fluid rounded mb-2" style="width: 100%;height: 200px;object-fit: cover; ">
                                            <span class="btn btn-sm btn-block btn-danger disabled">Sedang Digunakan</span>
                                            <button class="btn btn-block btn-primary" data-toggle="modal" data-target="#bookingModal"> <i class="fa-regular fa-calendar-plus"></i> &nbsp;Buat Jadwal</button>
                                        </div>
                                        <div class="col-md-8">
                                            <dl class="row">
                                                <dt class="col-sm-5"><i class="fa-solid fa-building fa-fw"></i> &nbsp; Nama Ruangan</dt>
                                                <dd class="col-sm-7">Ruang Rapat Bersama 2</dd>

                                                <dt class="col-sm-5"><i class="fa-solid fa-people-group fa-fw"></i> &nbsp; Kapasitas</dt>
                                                <dd class="col-sm-7">27 Orang</dd>

                                                <dt class="col-sm-5"><i class="fa-solid fa-location-dot fa-fw"></i> &nbsp; Lokasi</dt>
                                                <dd class="col-sm-7">Lantai 3 Ruang A3.2</dd>

                                                <dt class="col-sm-5"><i class="fa-solid fa-align-left fa-fw"></i> &nbsp; Deskripsi</dt>
                                                <dd class="col-sm-7">Lorem ipsum dolor sit amet consectetur adipisicing elit. Corporis vitae, aliquam suscipit tempore harum, facilis quasi at esse cumque, optio velit perferendis reiciendis expedita repellat quas. Minus culpa repellendus quibusdam!</dd>


                                            </dl>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="card shadow-sm">
                                <div class="card-header">
                                    Daftar Pembukuan
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">First</th>
                                                <th scope="col">Last</th>
                                                <th scope="col">Handle</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th scope="row">1</th>
                                                <td>Mark</td>
                                                <td>Otto</td>
                                                <td>@mdo</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">2</th>
                                                <td>Jacob</td>
                                                <td>Thornton</td>
                                                <td>@fat</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">3</th>
                                                <td colspan="2">Larry the Bird</td>
                                                <td>@twitter</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

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

    <!-- Modal -->
    <div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="" method="POST">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="bookingModalLabel">Jadwalkan Peminjaman Ruangan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="">
                            <div class="form-group row">
                                <label for="datepicker" class="col-sm-4 col-form-label">Pilih tanggal</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm bg-white" name="date" id="datepicker" readonly />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="timestart" class="col-sm-4 col-form-label">Pilih waktu mulai </label>
                                <div class="col-sm-3">
                                    <select class="custom-select custom-select-sm text-center" id="hour1" name="hour1" onchange="optCorrection()">
                                        <option value="6">06</option>
                                        <option value="7">07</option>
                                        <option value="8">08</option>
                                        <option value="9">09</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                        <option value="13">13</option>
                                        <option value="14">14</option>
                                        <option value="15">15</option>
                                        <option value="16">16</option>
                                        <option value="17">17</option>
                                        <option value="18">18</option>
                                        <option value="19">19</option>
                                        <option value="20">20</option>
                                        <option value="21">21</option>
                                    </select>
                                </div>
                                <strong>:</strong>
                                <div class="col-sm-3">
                                    <select class="custom-select custom-select-sm text-center" id="minute1" name="minute1" onchange="optCorrection()">
                                        <option value="0">00</option>
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="30">30</option>
                                        <option value="40">40</option>
                                        <option value="50">50</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="timestart" class="col-sm-4 col-form-label">Pilih waktu selesai </label>
                                <div class="col-sm-3">
                                    <select class="custom-select custom-select-sm text-center" id="hour2" name="hour2" onchange="optCorrection()">
                                        <option value="6">06</option>
                                        <option value="7">07</option>
                                        <option value="8">08</option>
                                        <option value="9">09</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                        <option value="13">13</option>
                                        <option value="14">14</option>
                                        <option value="15">15</option>
                                        <option value="16">16</option>
                                        <option value="17">17</option>
                                        <option value="18">18</option>
                                        <option value="19">19</option>
                                        <option value="20">20</option>
                                        <option value="21">21</option>
                                    </select>
                                </div>
                                <strong>:</strong>
                                <div class="col-sm-3">
                                    <select class="custom-select custom-select-sm text-center" id="minute2" name="minute2" oninput="optCorrection()">
                                        <option value="9">09</option>
                                        <option value="19">19</option>
                                        <option value="29">29</option>
                                        <option value="39">39</option>
                                        <option value="49">49</option>
                                        <option value="59">59</option>
                                    </select>
                                </div>
                            </div>
                            <div class=" form-group row">
                                <label for="notes" class="col-sm-4 col-form-label">Catatan / Informasi Kegiatan </label>
                                <div class="col-sm-8">
                                    <textarea required name="notes" id="notes" rows="10" class="form-control" style="min-height: 80px;height:80px;max-height:160px"></textarea>
                                </div>

                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" name="submit"> <i class="fa-regular fa-calendar-plus"></i> &nbsp; Jadwalkan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <!-- Bootstrap core JavaScript-->
    <script src="../assets/vendor/jquery/jquery.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../assets/js/sb-admin-2.min.js"></script>

    <!-- datepicker js -->
    <script src="../assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <script src="../assets/vendor/bootstrap-datepicker/js/locales/bootstrap-datepicker.id.min.js"></script>

</body>

</html>

<script>
    $(document).ready(function() {
        $("#datepicker").datepicker({
            language: 'id',
            orientation: "auto right",
            format: "dd/mm/yyyy",
            startView: "days",
            minViewMode: "days",
            startDate: "0d"
        }).datepicker("setDate", 'now');
    });

    function optCorrection() {
        $("#hour2 option").each(function() {
            if (parseInt($(this).val()) < parseInt($("#hour1").val())) {
                $(this).attr("disabled", "disabled").attr("hidden", "hidden");
                var selected = parseInt($("#hour1").val());
                $("#hour2 option[value=" + selected + "]").attr("selected", "selected").siblings().removeAttr("selected");
                if (!$("#hour2").val()) {
                    $("#hour2 option[value=21]").attr("selected", "selected").siblings().removeAttr("selected");
                }
            } else {
                $(this).removeAttr("disabled").removeAttr("hidden");
            }
        });

        if (parseInt($("#hour1").val()) == parseInt($("#hour2").val())) {
            $("#minute2 option").each(function() {
                if (parseInt($(this).val()) < parseInt($("#minute1").val())) {
                    $(this).attr("disabled", "disabled").attr("hidden", "hidden");
                    var selected = parseInt($("#minute1").val()) + 9;
                    $("#minute2 option[value='" + selected + "']").attr("selected", "selected").siblings().removeAttr("selected");

                    if (!$("#minute2").val()) {
                        $("#minute2 option[value=59]").attr("selected", "selected").siblings().removeAttr("selected");
                    }
                } else {
                    $(this).removeAttr("disabled").removeAttr("hidden");
                }

            });
        } else {
            $("#minute2 option").each(function() {
                $(this).removeAttr("disabled").removeAttr("hidden");
            });
        }
    }
</script>