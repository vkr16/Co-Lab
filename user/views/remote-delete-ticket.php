<?php
require_once "../../core/init.php";
require_once "../../core/user-session-only.php";


if (isset($_POST['ticketID'])) {
    $ticketID = $_POST['ticketID'];

    $query = "DELETE FROM tickets WHERE id = '$ticketID'";
    if (mysqli_query($link, $query)) {
        return true;
    } else {
        return false;
    }
}
