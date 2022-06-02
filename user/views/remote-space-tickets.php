<?php
require_once "../../core/init.php";
require_once "../../core/user-session-only.php";
if (isset($_POST['userid'])) {

    $userid = $_POST['userid'];

    $now = date("Y-m-d H:i:s");

    $query = "SELECT * FROM space_tickets WHERE user_id = '$userid' AND time_end>='$now' AND status = 'valid'";
    $result = mysqli_query($link, $query);
    if (mysqli_num_rows($result) == 0) {
?>
        <div class="col-md-12">
            <h4 class="bg-white p-4 rounded shadow">Anda tidak memiliki tiket aktif</h4>
        </div>
    <?php
    }
    while ($data = mysqli_fetch_assoc($result)) {
        $area_data =  getAreaDataById($data['area_id']);
        $area_name = $area_data['name'];
        $area_thumbnail = $area_data['thumbnail'];
    ?>

        <!-- row item -->
        <div class="col-md-3 px-2">
            <div class="card shadow mb-3" style="min-height: 420px;">
                <img src="../assets/img/areas/<?= $area_thumbnail ?>" class="card-img-top thumbnail-card-img" alt="...">
                <div class="card-body">
                    <h5 class="card-subtitle text-dark"><?= $area_name ?></h5><br>
                    <h6 class="card-subtitle text-dark"><?= $area_data['code'] . '-' . $data['space_no'] ?></h6>
                </div>
                <div class="card-footer">
                    <h6 class=" card-subtitle my-1 text-muted d-flex align-items-center">Berlaku pada <?= date_format(date_create($data['time_start']), 'd/m/Y'); ?> <br> Pukul <?= date_format(date_create($data['time_start']), 'H:i') . " - " . date_format(date_create($data['time_end']), 'H:i'); ?></h6>
                    <button class="btn btn-sm btn-success mt-1" onclick="showSpaceTicket(<?= $data['id'] ?>)"><i class="fa-solid fa-tag"></i> View</button>
                </div>
            </div>
        </div>
        <!-- row item end -->
<?php
    }
} else {
    echo "ERROR: REQUEST UNKNOWN";
}
?>