<?php
$semester = $mysqli->query("SELECT tingkat FROM semester ORDER BY tingkat DESC")->fetch_assoc();
if (isset($_POST['submit'])) {
    $nama = $mysqli->real_escape_string($_POST['nama']);
    $tingkat = $mysqli->real_escape_string($_POST['tingkat']);

    $_SESSION['old']['nama'] = $nama;
    $_SESSION['old']['tingkat'] = $tingkat;

    $validasi = $mysqli->query("SELECT tingkat FROM semester WHERE tingkat=$tingkat");
    if (!$validasi->num_rows) {
        $q = "INSERT INTO semester (nama, tingkat) VALUES ('$nama', '$tingkat')";

        if ($mysqli->query($q)) {
            $_SESSION['tambah_data']['nama'] =  $nama;
            echo "<script>location.href = '?h=semester';</script>";
        } else {
            echo "<script>alert('Tambah Data Gagal!')</script>";
            die($mysqli->error);
        }
    } else {
        $_SESSION['error'][] = "Tingkat $tingkat telah ditambahkan sebelumnya, data tingkat tidak dapat sama dengan semester yang lain.";
    }
}
?>
<main class="content">
    <div class="container-fluid p-0">
        <div class="mb-3 text-center">
            <h1 class="h3 d-inline align-middle">Tambah Semester</h1>
        </div>
        <div class="row justify-content-center">
            <div class="col-12 col-xl-6">
                <?php if (count($_SESSION['error'])) : ?>
                    <?php foreach ($_SESSION['error'] as $error) : ?>
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-message">
                                <?= $error; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
                <div class="card">
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="mb-3">
                                <label class="form-label">Nama Semester</label>
                                <input type="text" class="form-control" name="nama" required autocomplete="off" value="<?= $_SESSION['old']['nama'] ?? ''; ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tingkat</label>
                                <input type="number" class="form-control" name="tingkat" min="1" required autocomplete="off" value="<?= $_SESSION['old']['tingkat'] ?? (($semester['tingkat'] ?? 0) + 1); ?>">
                            </div>
                            <a href="?h=semester" class="btn btn-secondary float-start">Kembali</a>
                            <button type="submit" name="submit" class="btn btn-primary float-end">Tambah</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>