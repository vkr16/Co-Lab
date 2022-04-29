<?php
require_once "../core/init.php";
require_once "../core/admin-session-only.php";

if (isset($_POST['user_id'])) {
    $id = $_POST['user_id'];
    $query = "DELETE FROM users WHERE id = '$id'";
    mysqli_query($link, $query);
}
