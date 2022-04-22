<?php

require_once "core/init.php";
require_once "core/no-session-allowed.php";

$email = $_GET['apl'];
$uid = $_GET['uid'];
$query = "SELECT * FROM users WHERE email = '$email'";
$result = mysqli_query($link, $query);

$data = mysqli_fetch_assoc($result);
$validity = $data['validity'];
$uniqueid = $data['uniqueid'];

if ($validity != "invalid") {
    header("Location: login.php");
}

if ($uid == $uniqueid) {
    $query = "UPDATE users SET validity = 'valid' WHERE email='$email'";
    mysqli_query($link, $query);
    header("Location: activation-successful.php?apl=" . $email . "&uid=" . $uid);
} else {
    header("Location: login.php");
}
