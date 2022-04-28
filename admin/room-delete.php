<?php
require_once "../core/init.php";
require_once "../core/admin-session-only.php";

if (isset($_POST['room_id'])) {
    $id = $_POST['room_id'];
    $query = "SELECT * FROM rooms WHERE id = '$id'";
    $result = mysqli_query($link, $query);
    $data = mysqli_fetch_assoc($result);
    $thumbnail = $data['thumbnail'];

    $query = "DELETE FROM rooms WHERE id = '$id'";
    if (mysqli_query($link, $query)) {
        unlink('../assets/img/rooms/' . $thumbnail);
    }
}
