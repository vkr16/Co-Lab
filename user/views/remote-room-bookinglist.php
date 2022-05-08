<?php
require_once "../../core/init.php";
require_once "../../core/user-session-only.php";

$date = $_POST['date'];
$tgl = substr($date, 0, 2);
$bln = substr($date, 3, 2);
$thn = substr($date, 6, 4);
$date = $thn . "/" . $bln . "/" . $tgl;
$tomorrow = date('Y-m-d H:i:s', strtotime($date . ' + 1 days'));

$date = date_format(date_create($date), 'Y-m-d H:i:s');
$tomorrow = date_format(date_create($tomorrow), 'Y-m-d H:i:s');

$room_id = $_POST['room_id'];

$query = "SELECT * FROM tickets WHERE time_start >= '$date' AND time_end < '$tomorrow' AND room_id = $room_id ORDER BY time_start";
$result = mysqli_query($link, $query);
$i = 1;

if (mysqli_num_rows($result) > 0) {
    while ($data = mysqli_fetch_assoc($result)) {
        $user_id = $data['user_id'];
        $query2 = "SELECT * FROM users WHERE id = '$user_id'";
        $result2 = mysqli_query($link, $query2);
        $data2 = mysqli_fetch_assoc($result2);
        $now = date("Y-m-d H:i:s");
        $tmrw = date('Y-m-d H:i:s', strtotime($now . ' + 1 days'));
        if ($data['time_start'] < $now && $data['time_end'] > $now) {
?>
            <tr class="text-danger">
                <th scope="row"><?= $i; ?></th>
                <td><?= $data2['fullname']; ?></td>
                <td><?= date('H:i', strtotime($data['time_start'])); ?></td>
                <td><?= date('H:i', strtotime($data['time_end'])); ?></td>
            </tr>
        <?php
            $i++;
        } else {
        ?>
            <tr>
                <th scope="row"><?= $i; ?></th>
                <td><?= $data2['fullname']; ?></td>
                <td><?= date('H:i', strtotime($data['time_start'])); ?></td>
                <td><?= date('H:i', strtotime($data['time_end'])); ?></td>
            </tr>
    <?php
            $i++;
        }
    }
} else {
    ?>
    <tr>
        <th scope="row" colspan="4" class="text-center">Tidak Ada Jadwal Hari Ini</th>
    </tr>
<?php
}
?>