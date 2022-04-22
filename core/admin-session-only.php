<?php
require_once "init.php";

if (isset($_SESSION['cl_user'])) {
    if (!isadmin($_SESSION['cl_user'])) {
        header('Location: ../user/');
    }
} else {
    header("Location: ../login.php");
}
