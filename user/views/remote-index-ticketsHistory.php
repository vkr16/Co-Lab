<?php
require_once "../../core/init.php";
require_once "../../core/user-session-only.php";

?>

<thead>
    <tr>
        <th>No</th>
        <th>Ruang / Laboratorium</th>
        <th>Tanggal</th>
        <th>Waktu</th>
    </tr>
</thead>
<tbody>

    <?php

    if (isset($_POST['userid'])) {

        $userid = $_POST['userid'];
        $now = date("Y-m-d H:i:s");

        $query = "SELECT * FROM tickets WHERE user_id = '$userid' AND time_end<'$now'";
        $result = mysqli_query($link, $query);
        if (mysqli_num_rows($result) == 0) {
    ?>

        <?php
        }
        $i = 0;
        while ($data = mysqli_fetch_assoc($result)) {
            $room_data =  getRoomDataById($data['room_id']);
            $room_name = $room_data['room_name'];
            $room_thumbnail = $room_data['thumbnail'];
            $i++;
        ?>

            <!-- row item -->
            <tr>
                <td class="col-md-1"><?= $i; ?></td>
                <td class="col-md-7"><?= $room_name; ?></td>
                <td class="col-md-2"><?= date_format(date_create($data['time_start']), 'd / m / Y'); ?></td>
                <td class="col-md-2"><?= date_format(date_create($data['time_start']), 'H:i') . " - " . date_format(date_create($data['time_end']), 'H:i'); ?></td>
            </tr>
            <!-- row item end -->
    <?php
        }
    } else {
        echo "ERROR: REQUEST UNKNOWN";
    }
    ?>

</tbody>