<?php
require_once "init.php";

if (isset($_COOKIE['CL_Session'])) {
    autologin($_COOKIE['CL_Session']);
}

if (isset($_SESSION['cl_user'])) {
    if (isadmin($_SESSION['cl_user'])) {
        header('Location: admin/');
    } else {
        header('Location: user/');
    }
}
