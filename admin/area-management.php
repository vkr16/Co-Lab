<?php
$space = true;

require_once "../core/init.php";
require_once "../core/admin-session-only.php";

if (isset($_POST['savearea'])) {
    $areaname = $_POST['areaname'];
    $areaname =  str_replace(array(
        "'",
        "\\",
        "\""
    ), '', $areaname);

    $location = $_POST['location'];
    $location =  str_replace(array(
        "'",
        "\\",
        "\""
    ), '', $location);

    $description   = $_POST['description'];
    $description = str_replace(array(
        "\r\n",
        "\n"
    ), '<br>', $description);
    $description =  str_replace(array(
        "'",
        "\\",
        "\""
    ), '', $description);

    $capacity = $_POST['capacity'];
    $status   = $_POST['status'];
    $code   = strtoupper($_POST['areacode']);


    if ($_FILES['thumbnail']['size'] != 0 && $_FILES['thumbnail']['error'] == 0) {
        $randStr = bin2hex(random_bytes(10));
        $path  = $_SERVER['DOCUMENT_ROOT'] . "/co-lab/assets/img/areas/";
        $path2 = $_FILES['thumbnail']['name'];
        $ext   = pathinfo($path2, PATHINFO_EXTENSION);
        $path  = $path . $randStr . '.' . $ext;

        $filenameondb = $randStr . '.' . $ext;

        move_uploaded_file($_FILES['thumbnail']['tmp_name'], $path);
    } else {
        $filenameondb = 'area_default.png';
    }

    if ($_FILES['layout']['size'] != 0 && $_FILES['layout']['error'] == 0) {
        $randStr = bin2hex(random_bytes(10));
        $path  = $_SERVER['DOCUMENT_ROOT'] . "/co-lab/assets/img/layouts/";
        $path2 = $_FILES['layout']['name'];
        $ext   = pathinfo($path2, PATHINFO_EXTENSION);
        $path  = $path . $randStr . '.' . $ext;

        $filenameondb2 = $randStr . '.' . $ext;

        move_uploaded_file($_FILES['layout']['tmp_name'], $path);
    } else {
        $filenameondb2 = 'layout_default.png';
    }
    $query = "INSERT INTO areas (name, location,description, capacity,code, thumbnail,layout, status) VALUES ('$areaname','$location','$description','$capacity','$code','$filenameondb','$filenameondb2','$status')";
    if ($result = mysqli_query($link, $query)) {
        $query = "SELECT id FROM areas WHERE code = '$code'";
        $result = mysqli_query($link, $query);
        $data = mysqli_fetch_assoc($result);
        $lastId = $data['id'];
        for ($i = 0; $i < $capacity; $i++) {
            $query = "INSERT INTO spaces (area_id,space_no) VALUES ('$lastId','$i'+1)";
            mysqli_query($link, $query);
        }

        $loadThis = 'alertSuccess()';
    } else {
        $loadThis = 'alertFailed()';
    }
}

if (isset($_POST['updatearea'])) {
    $updateThumbnail = false;
    $updateLayout = false;
    $areaid = $_POST['hiddenID'];
    $areaname = $_POST['areaname'];
    $areaname =  str_replace(array(
        "'",
        "\\",
        "\""
    ), '', $areaname);

    $location = $_POST['location'];
    $location =  str_replace(array(
        "'",
        "\\",
        "\""
    ), '', $location);

    $description   = $_POST['description'];
    $description = str_replace(array(
        "\r\n",
        "\n"
    ), '<br>', $description);
    $description =  str_replace(array(
        "'",
        "\\",
        "\""
    ), '', $description);

    $capacity = $_POST['capacity'];
    $status   = $_POST['status'];

    $query = "SELECT * FROM spaces WHERE area_id = '$areaid'";
    $result = mysqli_query($link, $query);
    $data = mysqli_fetch_assoc($result);
    $spacesCount = mysqli_num_rows($result);

    if ($capacity >= $spacesCount) {
        if ($_FILES['thumbnail']['size'] != 0 && $_FILES['thumbnail']['error'] == 0) {
            $randStr = bin2hex(random_bytes(10));
            $path  = $_SERVER['DOCUMENT_ROOT'] . "/co-lab/assets/img/areas/";
            $path2 = $_FILES['thumbnail']['name'];
            $ext   = pathinfo($path2, PATHINFO_EXTENSION);
            $path  = $path . $randStr . '.' . $ext;

            $filenameondb = $randStr . '.' . $ext;

            $query = "SELECT * FROM areas WHERE id = '$areaid'";
            $result = mysqli_query($link, $query);
            $data = mysqli_fetch_assoc($result);
            $thumbnail = $data['thumbnail'];

            if ($thumbnail != 'area_default.png') {
                unlink('../assets/img/areas/' . $thumbnail);
            }

            $updateThumbnail = true;

            move_uploaded_file($_FILES['thumbnail']['tmp_name'], $path);
        }



        if ($_FILES['layout']['size'] != 0 && $_FILES['layout']['error'] == 0) {
            $randStr = bin2hex(random_bytes(10));
            $path  = $_SERVER['DOCUMENT_ROOT'] . "/co-lab/assets/img/layouts/";
            $path2 = $_FILES['layout']['name'];
            $ext   = pathinfo($path2, PATHINFO_EXTENSION);
            $path  = $path . $randStr . '.' . $ext;

            $filenameondb2 = $randStr . '.' . $ext;

            $query = "SELECT * FROM areas WHERE id = '$areaid'";
            $result = mysqli_query($link, $query);
            $data = mysqli_fetch_assoc($result);
            $layout = $data['layout'];

            if ($layout != 'layout_default.png') {
                unlink('../assets/img/layouts/' . $layout);
            }

            $updateLayout = true;

            move_uploaded_file($_FILES['layout']['tmp_name'], $path);
        }

        if ($updateThumbnail == true && $updateLayout == true) {
            $query = "UPDATE areas SET name = '$areaname', location = '$location',description='$description',thumbnail = '$filenameondb', layout = '$filenameondb2', capacity = '$capacity', status = '$status' WHERE id = '$areaid'";
        } elseif ($updateThumbnail == true) {
            $query = "UPDATE areas SET name = '$areaname', location = '$location',description='$description',thumbnail = '$filenameondb', capacity = '$capacity', status = '$status' WHERE id = '$areaid'";
        } elseif ($updateLayout == true) {
            $query = "UPDATE areas SET name = '$areaname', location = '$location',description='$description',layout = '$filenameondb2', capacity = '$capacity', status = '$status' WHERE id = '$areaid'";
        } else {
            $query = "UPDATE areas SET name = '$areaname', location = '$location',description='$description', capacity = '$capacity', status = '$status' WHERE id = '$areaid'";
        }


        if ($result = mysqli_query($link, $query)) {
            $loadThis = 'alertSuccess()';
        } else {
            $loadThis = 'alertFailed()';
        }
    } else {
        $loadThis = 'alertOverlimit()';
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
    <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="icon" href="../assets/img/favicon.png">

    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">

    <!-- Fontawesome -->
    <link rel="stylesheet" href="../assets/vendor/fontawesome/css/all.min.css">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="../assets/vendor/datatables/DataTables-1.11.5/css/dataTables.bootstrap4.min.css">

    <!-- Custom styles for navigation-->
    <link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom style -->
    <link rel="stylesheet" href="../assets/css/co-lab.css">

    <title>Manajemen Space | Co-Lab</title>


</head>

<body id="page-top" onload="<?= $loadThis ?>">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include "views/sidebar.php" ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include "views/topbar.php" ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Manajemen Space</h1>
                        <button class="d-none d-sm-inline-block btn btn-sm btn-red shadow-sm" data-toggle="modal" data-target="#addAreaModal"><i class="fas fa-plus fa-sm"></i> Tambah Area</button>
                    </div>

                    <div class="card shadow col-md-12 ">
                        <div class="card-body table-responsive">
                            <h5 class="text-dark">Daftar Area</h5><br>
                            <table class="table table-striped" id="rooms_table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Ruangan</th>
                                        <th>Kapasitas</th>
                                        <th>Lokasi</th>
                                        <th>Status</th>
                                        <th>Foto</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = "SELECT * FROM areas";
                                    $result = mysqli_query($link, $query);
                                    $i = 0;
                                    while ($data = mysqli_fetch_assoc($result)) {
                                        $i++;
                                        $description = $data['description'];
                                        $description = str_replace(array(
                                            "<br>"
                                        ), '\n', $description);
                                    ?>
                                        <tr>
                                            <td class="align-middle"><?= $i; ?></td>
                                            <td class="align-middle"><?= $data['name']; ?></td>
                                            <td class="align-middle"><?= $data['capacity']; ?> Orang</td>
                                            <td class="align-middle"><?= $data['location']; ?></td>
                                            <td class="align-middle"><?= $data['status'] == 'inactive' ? '<i class="fa-regular fa-circle-xmark text-danger"></i> Inactive' : '<i class="fa-regular fa-circle-check text-success"></i> Aktif'; ?> </td>
                                            <td class="align-middle"><img src="../assets/img/areas/<?= $data['thumbnail']; ?>" width="200px" class="rounded img-thumbnail"></td>
                                            <td class="align-middle">
                                                <button class=" btn btn-sm btn-danger mr-3 mb-1 btn-block" onclick="deleteArea(<?= $data['id'] ?>)"><i class="fa-solid fa-ban"></i> &nbsp; Hapus</button>

                                                <button class=" btn btn-sm btn-blue mr-3 mb-1 btn-block" onclick="editArea(<?= $data['id'] . ',\'' . $data['name'] . '\',\'' . $data['location'] . '\',\'' . $description . '\',' . $data['capacity'] . ',\'' . $data['status'] . '\'' ?>)"><i class="fa-regular fa-pen-to-square"></i> &nbsp; Ubah</button>

                                                <a href="space-management.php?id=<?= $data['id'] ?>" class="btn btn-sm btn-orange mb-1 btn-block"><i class="fa-solid fa-circle-info"></i> &nbsp; Detail</a>
                                            </td>
                                        </tr>
                                    <?php

                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php include "views/footer.php" ?>

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>


    <!-- Modal 1-->
    <div class="modal fade" id="addAreaModal" tabindex="-1" aria-labelledby="addAreaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addAreaModalLabel">Tambah Area Bersama</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="inputAreaName">Nama Area</label>
                            <input type="text" required name="areaname" class="form-control" id="inputAreaName" placeholder="Nama Area">
                        </div>
                        <div class="form-group">
                            <label for="inputLocation">Lokasi</label>
                            <input type="text" required name="location" class="form-control" id="inputLocation" placeholder="Lokasi">
                        </div>
                        <div class="form-group">
                            <label for="inputAreaCode">Kode Area</label>
                            <input type="text" required name="areacode" class="form-control" maxlength="4" style=" text-transform: uppercase;" id="inputAreaCode" placeholder="Kode Area (maks. 4 karakter)" onfocus="$('#kodeareanotes').show()" onblur="$('#kodeareanotes').hide()">
                            <small id="kodeareanotes" style="display: none;">Catatan : <br>
                                <ul>
                                    <li>Kode area digunakan sebagai identitas suatu tempat duduk pada area tertentu.</li>
                                    <li>Contoh, tempat duduk pada area berkode "PM" akan memiliki kode PM1, PM2, PM3, dst...</li>
                                    <li>Kode area tidak dapat diubah setelah ditetapkan.</li>
                                </ul>
                            </small>
                        </div>
                        <div class="form-group mb-3">
                            <label for="thumbnail">Foto Area</label>
                            <div class="input-group ">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroupFileAddon01">Unggah</span>
                                </div>
                                <div class="custom-file">
                                    <input onchange="imageSelected()" type="file" class="custom-file-input" id="thumbnail2" aria-describedby="inputGroupFileAddon01" name="thumbnail" accept=".jpg,.jpeg,.png">
                                    <label class="custom-file-label" for="inputGroupFile01" id="labelThumbnail">Pilih gambar</label>
                                </div>
                            </div>
                            <small>Harap gunakan gambar dengan format .jpg, .jpeg, atau .png untuk hasil terbaik</small>
                        </div>
                        <div class="form-group mb-3">
                            <label for="layout">Tata Letak Area</label>
                            <div class="input-group ">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroupFileAddon01">Unggah</span>
                                </div>
                                <div class="custom-file">
                                    <input onchange="imageSelected()" type="file" class="custom-file-input" id="layout2" aria-describedby="inputGroupFileAddon01" name="layout" accept=".jpg,.jpeg,.png">
                                    <label class="custom-file-label" for="inputGroupFile01" id="labellayout">Pilih gambar</label>
                                </div>
                            </div>
                            <small>Harap gunakan gambar dengan rasio 1:1 untuk hasil terbaik</small>
                        </div>
                        <div class="form-group">
                            <label for="inputDescription">Deskripsi</label>
                            <textarea type="text" required name="description" class="form-control" style="min-height: 100px;max-height: 250px;" id="inputDescription" placeholder="Deskripsi"></textarea>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputCapacity">Kapasitas</label>
                                <input type="number" name="capacity" class="form-control" id="inputCapacity" required min="1" placeholder="Kapasitas">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputStatus">Status</label>
                                <select id="inputStatus" name="status" class="form-control">
                                    <option value="active" selected>Aktif (Default)</option>
                                    <option value="inactive">Tidak Aktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" name="savearea" class="btn btn-red"><i class="fa-regular fa-floppy-disk fa-fw"></i> Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Modal 1 end -->

    <!-- Modal 2-->
    <div class="modal fade" id="editAreaModal" tabindex="-1" aria-labelledby="editAreaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editAreaModalLabel">Tambah Area Bersama</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="text" name="hiddenID" id="hiddenID" hidden readonly>
                        <div class="form-group">
                            <label for="inputAreaName">Nama Area</label>
                            <input type="text" required name="areaname" class="form-control" id="editAreaName" placeholder="Nama Area">
                        </div>
                        <div class="form-group">
                            <label for="inputLocation">Lokasi</label>
                            <input type="text" required name="location" class="form-control" id="editLocation" placeholder="Lokasi">
                        </div>
                        <div class="form-group mb-3">
                            <label for="thumbnail">Foto Area (Opsional)</label>
                            <div class="input-group ">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroupFileAddon01">Unggah</span>
                                </div>
                                <div class="custom-file">
                                    <input onchange="imageSelected()" type="file" class="custom-file-input" id="thumbnail" aria-describedby="inputGroupFileAddon01" name="thumbnail" accept=".jpg,.jpeg,.png">
                                    <label class="custom-file-label" for="inputGroupFile01" id="labelThumbnail">Pilih gambar</label>
                                </div>
                            </div>
                            <small>Harap gunakan gambar dengan format .jpg, .jpeg, atau .png untuk hasil terbaik</small>
                        </div>
                        <div class="form-group mb-3">
                            <label for="layout">Tata Letak Area (Opsional)</label>
                            <div class="input-group ">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroupFileAddon01">Unggah</span>
                                </div>
                                <div class="custom-file">
                                    <input onchange="imageSelected()" type="file" class="custom-file-input" id="layout" aria-describedby="inputGroupFileAddon01" name="layout" accept=".jpg,.jpeg,.png">
                                    <label class="custom-file-label" for="inputGroupFile01" id="labellayout">Pilih gambar</label>
                                </div>
                            </div>
                            <small>Harap gunakan gambar dengan rasio 1:1 untuk hasil terbaik</small>
                        </div>
                        <div class="form-group">
                            <label for="inputDescription">Deskripsi</label>
                            <textarea type="text" required name="description" class="form-control" style="min-height: 100px;max-height: 250px;" id="editDescription" placeholder="Deskripsi"></textarea>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputCapacity">Kapasitas</label>
                                <input type="number" name="capacity" class="form-control" id="editCapacity" required min="1" placeholder="Kapasitas">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputStatus">Status</label>
                                <select id="editStatus" name="status" class="form-control">
                                    <option value="active" selected>Aktif</option>
                                    <option value="inactive">Tidak Aktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" name="updatearea" class="btn btn-red"><i class="fa-regular fa-floppy-disk fa-fw"></i> Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Modal 2 end -->

    <!-- Bootstrap core JavaScript-->
    <script src="../assets/vendor/jquery/jquery.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- DataTable JavaScript -->
    <script src="../assets/vendor/datatables/DataTables-1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="../assets/vendor/datatables/DataTables-1.11.5/js/dataTables.bootstrap4.min.js"></script>


    <!-- Custom scripts for all pages-->
    <script src="../assets/js/sb-admin-2.min.js"></script>

    <script src="../assets/vendor/SweetAlert2/SweetAlert2.js"></script>

</body>

</html>

<script>
    $(document).ready(function() {
        $('#rooms_table').DataTable({
            "language": {
                "search": "Cari : ",
                "lengthMenu": "Tampilkan _MENU_ data per halaman",
                "zeroRecords": "Tidak ada data yang cocok ditemukan.",
                "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
                "infoEmpty": "Data tidak tersedia",
                "infoFiltered": "(Difilter dari _MAX_ total data)",
                "paginate": {
                    "first": "Pertama",
                    "last": "Terakhir",
                    "next": "Selanjutnya",
                    "previous": "Sebelumnya"
                },
            }
        });
    });

    function deleteArea(id) {
        Swal.fire({
            title: 'Anda yakin ingin menghapus area ini?',
            text: 'Menghapus area ini akan menghapus seluruh kursi yang ada didalamnya!',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Hapus',
            confirmButtonColor: '#3085d6',
        }).then((result) => {
            if (result.isConfirmed) {
                $.post("area-delete.php", {
                        area_id: id
                    },
                    function(data) {
                        Swal.fire({
                            title: 'Dihapus',
                            text: 'Area berhasil dihapus',
                            icon: 'success',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonText: 'Selesai',
                            confirmButtonColor: '#3085d6',
                        }).then((result) => {
                            /* Read more about isConfirmed, isDenied below */
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        })
                    });
            }
        })
    }

    function editArea(id, name, location, description, capacity, status) {
        $('#editAreaModal').modal('show');
        $('#hiddenID').val(id);
        $('#editAreaName').val(name);
        $('#editLocation').val(location);
        $('#editDescription').val(description);
        $('#editCapacity').val(capacity);
        if (status == "active") {
            $('#editStatus').select().val('active');
        } else {
            $('#editStatus').select().val('inactive');
        }
    }

    function alertSuccess() {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: 'Data berhasil di simpan!',
            confirmButtonColor: '#b6453d',
        })
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    }

    function alertFailed() {
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: 'Data tidak berhasil di simpan!',
            confirmButtonColor: '#b6453d',
        })
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    }

    function alertOverlimit() {
        Swal.fire({
            icon: 'warning',
            title: 'Gagal',
            text: 'Jumlah tempat duduk yang terdaftar melebihi kapasitas, silahkan hapus beberapa tempat duduk sebelum mengurangi kapasitas area.',
            confirmButtonColor: '#b6453d',
        })
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    }
</script>

<style>
    ::-webkit-input-placeholder {
        /* WebKit browsers */
        text-transform: none;
    }

    :-moz-placeholder {
        /* Mozilla Firefox 4 to 18 */
        text-transform: none;
    }

    ::-moz-placeholder {
        /* Mozilla Firefox 19+ */
        text-transform: none;
    }

    :-ms-input-placeholder {
        /* Internet Explorer 10+ */
        text-transform: none;
    }

    ::placeholder {
        /* Recent browsers */
        text-transform: none;
    }
</style>