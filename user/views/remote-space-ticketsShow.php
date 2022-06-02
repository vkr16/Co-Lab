<?php
require_once "../../core/init.php";
require_once "../../core/user-session-only.php";
if (isset($_POST['ticketID'])) {
    $ticketID = $_POST['ticketID'];

    $query = "SELECT * FROM space_tickets WHERE id = '$ticketID'";
    $result = mysqli_query($link, $query);
    $data = mysqli_fetch_assoc($result);
    $areadata = getAreaDataById($data['area_id']);
    $userdata = getUserDataBySession();
} ?>

<div class=" card">


    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="../assets/img/areas/<?= $areadata['thumbnail'] ?>" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="../assets/img/layouts/<?= $areadata['layout'] ?>" class="d-block w-100" alt="...">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-target="#carouselExampleControls" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-target="#carouselExampleControls" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </button>
    </div>

    <div class="card-body">
        <h5 class="card-title"><?= $areadata['name']; ?></h5>
        <h6 class=" card-subtitle my-1 text-muted d-flex align-items-center">Berlaku pada <?= date_format(date_create($data['time_start']), 'd/m/Y'); ?> <br> Pukul <?= date_format(date_create($data['time_start']), 'H:i') . " - " . date_format(date_create($data['time_end']), 'H:i'); ?></h6>
        <h6 class=" card-subtitle my-1 text-muted d-flex align-items-center">Nomor tempat &nbsp; <strong> <?= $areadata['code'] . ' - ' . $data['space_no']; ?> </strong></h6>
        <hr>
        <button class="btn btn-sm btn-danger" onclick="cancelSpacePrompt(<?= $data['id'] ?>)"><i class="fa-solid fa-trash"></i> Batalkan</button>
    </div>
</div>