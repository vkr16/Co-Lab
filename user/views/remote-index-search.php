<?php
require_once "../../core/init.php";
require_once "../../core/user-session-only.php";
if (isset($_POST['keyword'])) {
    $keyword = $_POST['keyword'];
    $query = "SELECT * FROM rooms WHERE status = 'active' AND room_name LIKE '%$keyword%'";
    $result = mysqli_query($link, $query);
    if (mysqli_num_rows($result) > 0) {

        while ($data = mysqli_fetch_assoc($result)) {
?>

            <!-- row item -->
            <div class="col-md-3 px-2">
                <div class="card shadow mb-3" style="min-height: 420px;">
                    <img src="../assets/img/rooms/<?= $data['thumbnail'] ?>" class="card-img-top thumbnail-card-img" alt="...">
                    <div class="card-body">
                        <h5 class="card-title text-dark"><?= $data['room_name'] ?></h5>
                        <h6 class=" card-subtitle mb-2 text-muted">Max Capacity <?= $data['capacity']; ?> Persons</h6>
                    </div>
                    <div class="card-footer">
                        <a href="#" class="btn btn-success">Available</a>
                    </div>
                </div>
            </div>
            <!-- row item end -->
<?php
        }
    } else {

        echo '<div class="alert alert-secondary mx-auto mt-4" role="alert">
        <h4>Tidak ada hasil pencarian untuk <a href="#" class="alert-link">' . $keyword . '</a>. Cobalah menggunakan kata kunci lain.</h4>
      </div>';
    }
} else {
    echo "ERROR: REQUEST UNKNOWN";
}
?>