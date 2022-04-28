<?php
require_once "../core/init.php";
require_once "../core/admin-session-only.php";

if (isset($_POST['room_id'])) {
    $id = $_POST['room_id'];

    $query = "DELETE FROM rooms WHERE id = '$id'";
    if (mysqli_query($link, $query)) {
        echo "true";
    } else {
        echo "false";
    }
}
