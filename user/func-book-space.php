<?php
$myTickets = true;
require_once "../core/init.php";
require_once "../core/user-session-only.php";

$user_id = getUserIdByUsername($_SESSION['cl_user']);

if (isset($_POST['area_id'])) {
    $user_id = $_POST['user_id'];
    $area_id = $_POST['area_id'];
    $space_no = $_POST['space_no'];

    $time_start = $_POST['time_start'];
    $time_end = $_POST['time_end'];


    $tgl = substr($time_start, 0, 2);
    $bln = substr($time_start, 3, 2);
    $thn = substr($time_start, 6, 4);
    $jam = substr($time_start, 11);

    $time_start = $thn . "/" . $bln . "/" . $tgl . ' ' . $jam;

    $tgl = substr($time_end, 0, 2);
    $bln = substr($time_end, 3, 2);
    $thn = substr($time_end, 6, 4);
    $jam = substr($time_end, 11);

    $time_end = $thn . "/" . $bln . "/" . $tgl . ' ' . $jam;

    $time_start = date_format(date_create($time_start), 'Y-m-d H:i:s');
    $time_end = date_format(date_create($time_end), 'Y-m-d H:i:s');

    if (isSpaceConflict($space_no, $area_id, $time_start, $time_end)) {
        echo "conflict";
    } else {
        $query = "INSERT INTO space_tickets (user_id,area_id,space_no,time_start,time_end) VALUES ('$user_id','$area_id','$space_no','$time_start','$time_end')";
        if (mysqli_query($link, $query)) {
            echo "ok";
        } else {
            echo "error";
        }
    }

    // echo $user_id . PHP_EOL;
    // echo $area_id . PHP_EOL;
    // echo $space_no . PHP_EOL;

    // echo $time_start . ' - ' . $time_end;
}
