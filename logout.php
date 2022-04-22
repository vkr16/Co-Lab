<?php
require_once "core/init.php";
session_destroy();
setcookie('CL_Session', '', time() - (86400), "/");
header("Location: login.php");
