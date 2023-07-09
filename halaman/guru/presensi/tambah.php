<?php
if (isset($_POST['submit'])) {
    $tanggal = $mysqli->real_escape_string($_POST['tanggal']);

    $q = "
        INSERT INTO presensi_mata_pelajaran_kelas (
            id_mata_pelajaran_kelas,
            tanggal
        ) VALUES (
            '" . $_GET['id'] . "',
            '$tanggal' 
        )";

    if ($mysqli->query($q)) {
        echo "<script>location.href = '?h=mata_pelajaran&id=" . $_GET['id'] . "';</script>";
    } else {
        echo "<script>alert('Tambah Data Gagal!')</script>";
        die($mysqli->error);
    }
}
?>
<main class="content">
    <div class="container-fluid p-0">
        <h1 class="mb-3">Halaman Presensi dan Forum Diskusi</h1>

        <div class="row justify-content-center">
            <div class="col-12 col-md-5">
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
                    <div class="card-header d-flex justify-content-between">
                        <h3>Tambah Presensi</h3>
                        <a href="?h=mata_pelajaran&id=<?= $_GET['id']; ?>" class="btn btn-secondary">Kembali</a>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="mb-3">
                                <label class="form-label">Tanggal</label>
                                <input type="date" class="form-control" name="tanggal" value="<?= Date("Y-m-d"); ?>" required autocomplete="off">
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary float-end">Tambah</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md bg-white">
                <div class="py-3 px-4 border-bottom">
                    <h4 class="mb-0">Forum Diskusi Kelas</h4>
                </div>
                <?php include_once('templates/forum_diskusi.php') ?>
            </div>
        </div>

    </div>
</main>