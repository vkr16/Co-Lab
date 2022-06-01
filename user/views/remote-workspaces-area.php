<?php
require_once "../../core/init.php";
require_once "../../core/user-session-only.php";
if (isset($_POST['getrooms'])) {

    $query = "SELECT * FROM areas WHERE status = 'active'";
    $result = mysqli_query($link, $query);

    if (mysqli_num_rows($result) == 0) {
        echo '<h4 class="p-3">Belum ada ruangan yang tersedia saat ini</h4>';
    }
    while ($data = mysqli_fetch_assoc($result)) {
?>

        <!-- row item -->
        <div class="col-md-3 px-2">
            <div class="card shadow mb-3" style="min-height: 420px;">
                <img src="../assets/img/areas/<?= $data['thumbnail'] ?>" class="card-img-top thumbnail-card-img" alt="...">
                <div class="card-body">
                    <h5 class="card-title text-dark"><?= $data['name'] ?></h5>
                    <h6 class=" card-subtitle mb-2 text-muted">Kapasitas total <?= $data['capacity']; ?> orang</h6>
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
    echo "ERROR: REQUEST UNKNOWN";
}
?>