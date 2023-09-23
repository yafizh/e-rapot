<?php
$query = "SELECT * FROM tugas_mata_pelajaran_kelas tmpk WHERE id=" . $_GET['idd'];
$data = $mysqli->query($query)->fetch_assoc();

if (isset($_POST['submit'])) {
    $target_dir = "uploads/file_jawaban";
    $file = $_FILES['file'];
    $imageFileType = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $target_file = $target_dir . Date("YmdHis") . '.' . $imageFileType;
    $uploadOk = 1;

    if ($uploadOk) {
        if (!is_dir($target_dir)) mkdir($target_dir, 0700, true);
        if (move_uploaded_file($file["tmp_name"], $target_file)) {
            if ($mysqli->query("SELECT * FROM tugas_siswa WHERE id_tugas_mata_pelajaran_kelas=" . $_GET['idd'])->num_rows) {
                $q = "
                UPDATE tugas_siswa SET 
                    tanggal_waktu='" . Date("Y-m-d H:i:s") . "',
                    file='" . $target_file . "'
                WHERE 
                    id_siswa = '" . $_SESSION['user']['id_siswa'] . "' 
                    AND 
                    id_tugas_mata_pelajaran_kelas ='" . $_GET['idd'] . "'";
            } else {
                $q = "
                INSERT INTO tugas_siswa (
                    id_siswa,
                    id_tugas_mata_pelajaran_kelas,
                    tanggal_waktu,
                    file
                ) VALUES (
                    '" . $_SESSION['user']['id_siswa'] . "',
                    '" . $_GET['idd'] . "', 
                    '" . Date("Y-m-d H:i:s") . "', 
                    '" . $target_file . "'
                )";
            }
            if ($mysqli->query($q)) {
                echo "<script>location.href = '?h=lihat_tugas&id=" . $_GET['id'] . "';</script>";
            } else {
                echo "<script>alert('Tambah Data Gagal!')</script>";
                die($mysqli->error);
            }
        }
    }
}
?>
<main class="content">
    <div class="container-fluid p-0">
        <h1 class="mb-3">Halaman Pengumpulan Jawaban</h1>

        <div class="row justify-content-center">
            <div class="col-12">
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
            </div>
            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Tugas</label>
                            <input type="text" class="form-control" value="<?= $data['nama']; ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Mulai</label>
                            <input type="text" class="form-control" value="<?= indoensiaDateWithDay($data['tanggal_mulai']) ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Selesai</label>
                            <input type="text" class="form-control" value="<?= indoensiaDateWithDay($data['tanggal_selesai']); ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Keterangan</label>
                            <textarea class="form-control" disabled><?= $data['keterangan'] ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">File Soal</label>
                            <br>
                            <a href="">Soal</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label class="form-label">File Soal</label>
                                <input type="file" class="form-control" name="file" required>
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary float-end">Upload Jawaban</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>