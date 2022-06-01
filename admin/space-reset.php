<?php
$room_management = true;

require_once "../core/init.php";
require_once "../core/admin-session-only.php";


if (isset($_POST['areaid'])) {
    $areaid = $_POST['areaid'];
    $capacity = $_POST['capacity'];
    $color = $_POST['color'];

    $query = "DELETE FROM spaces WHERE area_id = '$areaid'";
    $result = mysqli_query($link, $query);

    for ($i = 0; $i < $capacity; $i++) {
        $query = "INSERT INTO spaces (area_id,space_no) VALUES ('$areaid','$i'+1)";
        mysqli_query($link, $query);
    }
}
