<?php
require_once "../core/init.php";
require_once "../core/admin-session-only.php";

if (isset($_POST['area_id'])) {
    $id = $_POST['area_id'];
    $query = "SELECT * FROM areas WHERE id = '$id'";
    $result = mysqli_query($link, $query);
    $data = mysqli_fetch_assoc($result);
    $thumbnail = $data['thumbnail'];

    $query = "DELETE FROM areas WHERE id = '$id'";

    if (mysqli_query($link, $query)) {
        $query = "DELETE FROM spaces WHERE area_id = '$id'";
        mysqli_query($link, $query);
        if ($thumbnail != 'area_default.png') {
            unlink('../assets/img/areas/' . $thumbnail);
        }
    }
}
