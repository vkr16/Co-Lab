<?php
require_once "../../core/init.php";
require_once "../../core/user-session-only.php";
if (isset($_POST['keyword'])) {
    $keyword = $_POST['keyword'];
    $query = "SELECT * FROM areas WHERE status = 'active' AND name LIKE '%$keyword%'";
    $result = mysqli_query($link, $query);
    if (mysqli_num_rows($result) > 0) {

        while ($data = mysqli_fetch_assoc($result)) {
?>

            <!-- row item -->
            <div class="col-md-3 px-2">
                <div class="card shadow mb-3" style="min-height: 420px;">
                    <img src="../assets/img/areas/<?= $data['thumbnail'] ?>" class="card-img-top thumbnail-card-img">
                    <div class="card-body">
                        <h5 class="card-title text-dark"><?= $data['name'] ?></h5>
                        <h6 class=" card-subtitle mb-2 text-muted">Max Capacity <?= $data['capacity']; ?> Persons</h6>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <a href="area-detail.php?r=<?= $data['id'] ?>" class="btn btn-primary">Lihat Detail</a>
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