<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="../assets/vendor/datatables/DataTables-1.11.5/css/dataTables.bootstrap4.min.css">
    <title>Document</title>
</head>

<body>


    <table class="table table-sm" id="bookinglist">
        <thead>
            <tr class="bg-info text-light">
                <th scope="col" class="col-sm-3">Space</th>
                <th scope="col" class="col-sm-6">Pengguna</th>
                <th scope="col" class="col-sm-3">Waktu</th>
            </tr>
        </thead>
        <tbody>

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

            $area_id = $_POST['area_id'];

            $query = "SELECT * FROM space_tickets WHERE time_start >= '$date' AND time_end < '$tomorrow' AND area_id = $area_id ORDER BY time_start";
            $result = mysqli_query($link, $query);
            $i = 1;

            if (mysqli_num_rows($result) > 0) {
                while ($data = mysqli_fetch_assoc($result)) {
                    $user_id = $data['user_id'];
                    $query2 = "SELECT * FROM users WHERE id = '$user_id'";
                    $result2 = mysqli_query($link, $query2);
                    $data2 = mysqli_fetch_assoc($result2);

                    $area_id = $data['area_id'];

                    $query3 = "SELECT * FROM areas WHERE id = '$area_id'";
                    $result3 = mysqli_query($link, $query3);
                    $data3 = mysqli_fetch_assoc($result3);
                    $area_code = $data3['code'];

                    $now = date("Y-m-d H:i:s");
                    $tmrw = date('Y-m-d H:i:s', strtotime($now . ' + 1 days'));
                    if ($data['time_start'] <= $now && $data['time_end'] >= $now) {
            ?>
                        <tr class="bg-success text-white">
                            <td><?= $area_code . '-' . $data['space_no']; ?></td>
                            <td><?= $data2['fullname']; ?></td>
                            <td><?= date('H:i', strtotime($data['time_start'])) . ' - ' . date('H:i', strtotime($data['time_end'])); ?></td>
                        </tr>
                    <?php
                        $i++;
                    } elseif ($data['time_start'] > $now && $data['time_end'] > $now) {
                    ?>
                        <tr class="text-info">
                            <td><?= $area_code . '-' . $data['space_no']; ?></td>
                            <td><?= $data2['fullname']; ?></td>
                            <td><?= date('H:i', strtotime($data['time_start'])) . ' - ' . date('H:i', strtotime($data['time_end'])); ?></td>
                        </tr>
                    <?php
                        $i++;
                    } else {
                    ?>
                        <tr>
                            <td><?= $area_code . '-' . $data['space_no']; ?></td>
                            <td><?= $data2['fullname']; ?></td>
                            <td><?= date('H:i', strtotime($data['time_start'])) . ' - ' . date('H:i', strtotime($data['time_end'])); ?></td>
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
        </tbody>
    </table>


    <!-- DataTable JavaScript -->
    <script src="../assets/vendor/datatables/DataTables-1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="../assets/vendor/datatables/DataTables-1.11.5/js/dataTables.bootstrap4.min.js"></script>
</body>

</html>

<script>
    $('#bookinglist').DataTable({
        "dom": "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-12 col-md-12'p>>",
        "language": {
            "search": "Cari : ",
            "lengthMenu": "_MENU_ data per halaman",
            "zeroRecords": "Tidak ada data yang cocok ditemukan.",
            "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
            "infoEmpty": "Data tidak tersedia",
            "infoFiltered": "(Difilter dari _MAX_ total data)",
            "paginate": {
                "first": "Pertama",
                "last": "Terakhir",
                "next": ">>",
                "previous": "<<"
            },
        }
    });
</script>