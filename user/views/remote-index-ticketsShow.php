<?php
require_once "../../core/init.php";
require_once "../../core/user-session-only.php";
if (isset($_POST['ticketID'])) {
    $ticketID = $_POST['ticketID'];

    $query = "SELECT * FROM tickets WHERE id = '$ticketID'";
    $result = mysqli_query($link, $query);
    $data = mysqli_fetch_assoc($result);
    $roomdata = getRoomDataById($data['room_id']);
    $userdata = getUserDataBySession();
} ?>

<div class=" card">
    <img src="../assets/img/rooms/<?= $roomdata['thumbnail'] ?>" class="card-img-top" alt="...">
    <div class="card-body">
        <h5 class="card-title"><?= $roomdata['room_name']; ?></h5>
        <h6 class=" card-subtitle my-1 text-muted d-flex align-items-center">Berlaku pada <?= date_format(date_create($data['time_start']), 'd/m/Y'); ?> <br> Pukul <?= date_format(date_create($data['time_start']), 'H:i') . " - " . date_format(date_create($data['time_end']), 'H:i'); ?></h6>
        <hr>
        <p class="card-text"><?= $data['notes']; ?></p>
        <hr>
        <button class="btn btn-sm btn-danger" onclick="cancelPrompt(<?= $data['id'] ?>)"><i class="fa-solid fa-trash"></i> Batalkan</button>
    </div>
</div>