<?php
require_once "../core/init.php";
require_once "../core/admin-session-only.php";

if (isset($_POST['areaid'])) {
    $id = $_POST['areaid'];
    $spaceno = $_POST['spaceno'];
    $capacity = $_POST['capacity'];

    if ($spaceno != '161199') {
        $query = "INSERT INTO spaces (area_id, space_no) VALUES ('$id','$spaceno')";
        mysqli_query($link, $query);
    } else {

        $query = "SELECT * FROM spaces WHERE area_id = '$id'";
        $result = mysqli_query($link, $query);
        $arr_a = array();
        $arr_b = array();
        while ($data = mysqli_fetch_assoc($result)) {
            array_push($arr_a, $data['space_no']);
        }
        for ($i = 0; $i < $capacity; $i++) {
            array_push($arr_b, $i + 1);
        }
        $diff = array_diff($arr_b, $arr_a);
        foreach ($diff as $index => $value) {
            $query = "INSERT INTO spaces (area_id, space_no) VALUES ('$id','$value')";
            mysqli_query($link, $query);
        }
    }
}
