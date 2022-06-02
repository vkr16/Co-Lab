<?php
require_once "../../core/init.php";
require_once "../../core/user-session-only.php";


if (isset($_POST['ticketID'])) {
    $ticketID = $_POST['ticketID'];

    $now = date('Y-m-d H:i:s');
    $query = "UPDATE space_tickets SET status = 'invalid', invalidated = '$now' WHERE id = '$ticketID'";
    if (mysqli_query($link, $query)) {
        return true;
    } else {
        return false;
    }
}
