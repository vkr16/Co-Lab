<?php
require_once "../../core/init.php";
require_once "../../core/user-session-only.php";

?>
<table id="ticketHistory" class="table">
    <thead>
        <tr>
            <th>No</th>
            <th>Ruang / Laboratorium</th>
            <th>Tanggal</th>
            <th>Waktu</th>
            <th>Di Batalkan</th>
        </tr>
    </thead>
    <tbody>

        <?php

        if (isset($_POST['userid'])) {

            $userid = $_POST['userid'];
            $now = date("Y-m-d H:i:s");

            $query = "SELECT * FROM tickets WHERE user_id = '$userid' AND time_end<'$now' OR status = 'invalid'";
            $result = mysqli_query($link, $query);
            if (mysqli_num_rows($result) == 0) {
        ?>

            <?php
            }
            $i = 0;
            while ($data = mysqli_fetch_assoc($result)) {
                $room_data =  getRoomDataById($data['room_id']);
                if ($room_data == NULL) {
                    $room_data = array("room_name" => "<i>Ruangan Telah Dihapus</i>");
                }
                $room_name = $room_data['room_name'];
                $i++;
                $invalidateTime = date_create($data['invalidated']);

            ?>

                <!-- row item -->
                <tr>
                    <td class="col-md-1"><?= $i; ?></td>
                    <td class="col-md-4"><?= $room_name; ?></td>
                    <td class="col-md-2"><?= date_format(date_create($data['time_start']), 'd / m / Y'); ?></td>
                    <td class="col-md-2"><?= date_format(date_create($data['time_start']), 'H:i') . " - " . date_format(date_create($data['time_end']), 'H:i'); ?></td>
                    <td class="col-md-3"><?= $data['invalidated'] != NULL ? date_format($invalidateTime, 'd-m-Y') . ' pukul ' . date_format($invalidateTime, 'H:i') : '-';  ?></td>

                </tr>
                <!-- row item end -->
        <?php
            }
        } else {
            echo "ERROR: REQUEST UNKNOWN";
        }
        ?>

    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#ticketHistory').DataTable({
            lengthMenu: [5, 10, 20, 50, 100],
            "language": {
                "search": "Cari : ",
                "lengthMenu": "Tampilkan _MENU_ data per halaman",
                "zeroRecords": "Tidak ada data yang cocok ditemukan.",
                "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
                "infoEmpty": "Data tidak tersedia",
                "infoFiltered": "(Difilter dari _MAX_ total data)",
                "paginate": {
                    "first": "Pertama",
                    "last": "Terakhir",
                    "next": "Selanjutnya",
                    "previous": "Sebelumnya"
                },
            }
        })
    });
</script>