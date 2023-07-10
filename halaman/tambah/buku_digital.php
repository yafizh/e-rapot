<?php
if (isset($_POST['submit'])) {
    $judul = $mysqli->real_escape_string($_POST['judul']);
    $pengarang = $mysqli->real_escape_string($_POST['pengarang']);
    $tahun_terbit = $mysqli->real_escape_string($_POST['tahun_terbit']);
    $jumlah_halaman = $mysqli->real_escape_string($_POST['jumlah_halaman']);

    // File
    $target_dir = "uploads/buku-digital/";
    $target_dir_foto = "uploads/foto-buku-digital/";
    $file = $_FILES['file'];
    $foto = $_FILES['foto'];
    $imageFileType = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $imageFileTypeFoto = strtolower(pathinfo($foto['name'], PATHINFO_EXTENSION));
    $target_file = $target_dir . Date("YmdHis") . '.' . $imageFileType;
    $target_file_foto = $target_dir_foto . Date("YmdHis") . '.' . $imageFileTypeFoto;
    $uploadOk = 1;

    if ($imageFileType != "pdf") {
        $_SESSION['error'][] = "Hanya menerima file dengan format pdf.";
        $uploadOk = 0;
    }

    if ($uploadOk) {
        if (!is_dir($target_dir)) mkdir($target_dir, 0700, true);
        if (!is_dir($target_dir_foto)) mkdir($target_dir_foto, 0700, true);
        if (move_uploaded_file($file["tmp_name"], $target_file) && move_uploaded_file($foto["tmp_name"], $target_file_foto)) {
            $q = "
                INSERT INTO buku_digital (
                    judul, 
                    pengarang, 
                    tahun_terbit, 
                    jumlah_halaman,
                    file,
                    foto 
                ) VALUES (
                    '$judul', 
                    '$pengarang', 
                    '$tahun_terbit', 
                    '$jumlah_halaman',
                    '$target_file',
                    '$target_file_foto'
                )";

            if ($mysqli->query($q)) {
                $_SESSION['tambah_data']['judul'] =  $judul;
                echo "<script>location.href = '?h=buku_digital';</script>";
            } else {
                echo "<script>alert('Tambah Data Gagal!')</script>";
                die($mysqli->error);
            }
        } else
            echo "Sorry, there was an error uploading your file.";
    }
}
?>
<main class="content">
    <div class="container-fluid p-0">

        <div class="mb-3 text-center">
            <h1 class="h3 d-inline align-middle">Tambah Buku Digital</h1>
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
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label class="form-label">Judul Buku</label>
                                <input type="text" class="form-control" name="judul" required autocomplete="off">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Pengarang</label>
                                <input type="text" class="form-control" name="pengarang" required autocomplete="off">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tahun Terbit</label>
                                <input type="number" min="0" max="100" class="form-control" name="tahun_terbit" required autocomplete="off">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jumlah Halaman</label>
                                <input type="number" min="0" max="100" class="form-control" name="jumlah_halaman" required autocomplete="off">
                            </div>
                            <div class="mb-3">
                                <label class="form-label w-100">File Buku Digital</label>
                                <input type="file" name="file" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label w-100">Foto</label>
                                <input type="file" name="foto" required>
                            </div>
                            <a href="?h=buku_digital" class="btn btn-secondary float-start">Kembali</a>
                            <button type="submit" name="submit" class="btn btn-primary float-end">Tambah</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>