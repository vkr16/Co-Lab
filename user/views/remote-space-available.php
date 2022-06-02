<?php
require_once "../../core/init.php";
require_once "../../core/user-session-only.php";

if (isset($_POST['area_id'])) {

    $area_id = $_POST['area_id'];
    $time_start = $_POST['time_start'];

    $tgl = substr($time_start, 0, 2);
    $bln = substr($time_start, 3, 2);
    $thn = substr($time_start, 6, 4);
    $jam = substr($time_start, 11);

    $time_start = $thn . "/" . $bln . "/" . $tgl . ' ' . $jam;

    $time_end = $_POST['time_end'];

    $tgl = substr($time_end, 0, 2);
    $bln = substr($time_end, 3, 2);
    $thn = substr($time_end, 6, 4);
    $jam = substr($time_end, 11);

    $time_end = $thn . "/" . $bln . "/" . $tgl . ' ' . $jam;

    $time_start = date_format(date_create($time_start), 'Y-m-d H:i:s');
    $time_end = date_format(date_create($time_end), 'Y-m-d H:i:s');
    $now = date_format(date_create(date("Y-m-d H:i:s")), 'Y-m-d H:i:s');
    $area_data = getAreaDataById($area_id);

    if (!isPast($time_start)) {
?>
        <div class="d-flex justify-content-center">
            <img src="../assets/img/layouts/<?= $area_data['layout'] ?>" width="70%">
        </div>

        <?php

        $query = "SELECT * FROM spaces WHERE area_id = '$area_id' ORDER BY space_no";
        $result = mysqli_query($link, $query);
        ?>
        <hr>
        <h5 class="text-dark text-center">Silahkan Pilih Kursi Yang Tersedia</h5>
        <hr>
        <div class="">
            <div class="btn-group-toggle text-center" data-toggle="buttons">

                <?php
                while ($data = mysqli_fetch_assoc($result)) {
                    if (isSpaceConflict($data['space_no'], $area_id, $time_start, $time_end)) { ?>
                        <label class="btn btn-danger disabled shadow-sm my-1 spaceButton">
                            <input disabled type="radio" class="shadow" required name="spaceOptions" onclick="spaceSelected()" value="<?= $data['space_no'] ?>"><i class="fa-solid fa-square" style="color:<?= $data['color_code'] ?>"></i> <?= $area_data['code'] . '-' . $data['space_no'] ?>
                        </label>
                    <?php
                    } else {
                    ?>
                        <label class="btn btn-outline-success shadow-sm my-1 spaceButton">
                            <input type="radio" class="shadow" required name="spaceOptions" onclick="spaceSelected()" value="<?= $data['space_no'] ?>"><i class="fa-solid fa-square" style="color:<?= $data['color_code'] ?>"></i> <?= $area_data['code'] . '-' . $data['space_no'] ?>
                        </label>
                <?php
                    }
                }
                ?>
            </div>
        </div>
    <?php
    } else {
    ?>
        <div class="text-warning display-4">
            <i class="fa-solid fa-circle-exclamation mx-auto"></i> Error
        </div><br>
        <div class="text-dark">
            <H5>Waktu yang anda minta terlalu lampau, batas waktu lampau yang di izinkan adalah maksimal 9 menit!!</H5>
        </div>
<?php
    }
}

?>