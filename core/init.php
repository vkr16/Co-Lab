<?php
date_default_timezone_set('Asia/Jakarta');

if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
    $home = 'https://';
} else {
    $home = 'http://';
}
$home   .= $_SERVER['HTTP_HOST'] . '/co-lab';
$assets  = $home . '/assets';
$dbphp   = $_SERVER['DOCUMENT_ROOT'] . '/co-lab/core/db.php';
$functionsphp =  $_SERVER['DOCUMENT_ROOT'] . '/co-lab/core/functions.php';

session_start();
require_once "$dbphp";
require_once "$functionsphp";
