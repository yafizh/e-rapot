<?php
$data = $mysqli->query("SELECT * FROM tugas_mata_pelajaran_kelas WHERE id=" . $_GET['idd'])->fetch_assoc();

if (isset($_POST['submit'])) {
    $nama = $mysqli->real_escape_string($_POST['nama']);
    $tanggal_mulai = $mysqli->real_escape_string($_POST['tanggal_mulai']);
    $tanggal_selesai = $mysqli->real_escape_string($_POST['tanggal_selesai']);
    $keterangan = $mysqli->real_escape_string($_POST['keterangan']);

    $file = $_FILES['file'];
    if ($file['error'] != 4) {
        $target_dir = "uploads/file_soal";
        $imageFileType = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $target_file = $target_dir . Date("YmdHis") . '.' . $imageFileType;

        if (!is_dir($target_dir)) mkdir($target_dir, 0700, true);
        if (!move_uploaded_file($file["tmp_name"], $target_file)) {
            echo "Sorry, there was an error uploading your file.";
        }
    } else $target_file = $data['file'];

    $q = "
        UPDATE tugas_mata_pelajaran_kelas SET 
            nama='$nama',
            tanggal_mulai='$tanggal_mulai',
            tanggal_selesai='$tanggal_selesai',
            file='$file',
            keterangan='$keterangan'
        WHERE 
            id=" . $_GET['idd'] . "
        ";

    if ($mysqli->query($q)) {
        echo "<script>location.href = '?h=mata_pelajaran&id=" . $_GET['id'] . "';</script>";
    } else {
        echo "<script>alert('Edit Data Gagal!')</script>";
        die($mysqli->error);
    }
}
?>
<main class="content">
    <div class="container-fluid p-0">
        <h1 class="mb-3">Halaman Tugas dan Forum Diskusi</h1>

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
                        <h3>Edit Tugas</h3>
                        <a href="?h=mata_pelajaran&id=<?= $_GET['id']; ?>" class="btn btn-secondary">Kembali</a>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label class="form-label">Nama Tugas</label>
                                <input type="text" class="form-control" name="nama" required autocomplete="off" value="<?= $data['nama']; ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal Mulai</label>
                                <input type="date" class="form-control" name="tanggal_mulai" value="<?= $data['tanggal_mulai']; ?>" required autocomplete="off">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal Selesai</label>
                                <input type="date" class="form-control" name="tanggal_selesai" value="<?= $data['tanggal_selesai']; ?>" required autocomplete="off">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Keterangan</label>
                                <textarea name="keterangan" class="form-control" required><?= $data['keterangan']; ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">File Soal</label>
                                <input type="file" class="form-control" name="file">
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary float-end">Perbaharui</button>
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