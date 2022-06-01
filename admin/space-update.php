<?php
$room_management = true;

require_once "../core/init.php";
require_once "../core/admin-session-only.php";


if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $color = $_POST['color'];

    $query = "UPDATE spaces SET color_code = '$color' WHERE id = '$id'";
    $result = mysqli_query($link, $query);
}
