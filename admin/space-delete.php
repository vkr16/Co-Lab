<?php
require_once "../core/init.php";
require_once "../core/admin-session-only.php";

if (isset($_POST['space_id'])) {
    $id = $_POST['space_id'];
    $query = "DELETE FROM spaces WHERE id = '$id'";
    mysqli_query($link, $query);
}
