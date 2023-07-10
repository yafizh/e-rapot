<?php
$data = $mysqli->query("SELECT * FROM buku_digital WHERE id=" . $_GET['id'])->fetch_assoc();
if (isset($_POST['submit'])) {
    $judul = $mysqli->real_escape_string($_POST['judul']);
    $pengarang = $mysqli->real_escape_string($_POST['pengarang']);
    $tahun_terbit = $mysqli->real_escape_string($_POST['tahun_terbit']);
    $jumlah_halaman = $mysqli->real_escape_string($_POST['jumlah_halaman']);

    $file = $_FILES['file'];
    $foto = $_FILES['foto'];
    $uploadOk = 1;
    if ($file['error'] != 4) {
        // File
        $target_dir = "uploads/buku-digital";
        $imageFileType = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $target_file = $target_dir . Date("YmdHis") . '.' . $imageFileType;

        if ($imageFileType != "pdf") {
            $_SESSION['error'][] = "Hanya menerima file dengan format pdf.";
            $uploadOk = 0;
        }

        if (!is_dir($target_dir)) mkdir($target_dir, 0700, true);
        if (!move_uploaded_file($file["tmp_name"], $target_file)) {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        $target_file = $data['file'];
    }

    if ($foto['error'] != 4) {
        // File
        $target_dir_foto = "uploads/foto-buku-digital";
        $imageFileTypeFoto = strtolower(pathinfo($foto['name'], PATHINFO_EXTENSION));
        $target_file_foto = $target_dir_foto . Date("YmdHis") . '.' . $imageFileTypeFoto;


        if (!is_dir($target_dir_foto)) mkdir($target_dir_foto, 0700, true);
        if (!move_uploaded_file($foto["tmp_name"], $target_file_foto)) {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        $target_file_foto = $data['foto'];
    }


    if ($uploadOk) {
        $q = "
        UPDATE buku_digital SET 
            judul='$judul', 
            pengarang='$pengarang', 
            tahun_terbit='$tahun_terbit', 
            jumlah_halaman='$jumlah_halaman',
            file='$target_file',
            foto='$target_file_foto'
        WHERE
            id=" . $data['id'] . "
        ";

        if ($mysqli->query($q)) {
            $_SESSION['edit_data']['judul'] =  $judul;
            echo "<script>location.href = '?h=buku_digital';</script>";
        } else {
            echo "<script>alert('Edit Data Gagal!')</script>";
            die($mysqli->error);
        }
    }
}
?>
<main class="content">
    <div class="container-fluid p-0">

        <div class="mb-3 text-center">
            <h1 class="h3 d-inline align-middle">Edit Buku Digital</h1>
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
                                <input type="text" class="form-control" name="judul" required autocomplete="off" value="<?= $data['judul']; ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Pengarang</label>
                                <input type="text" class="form-control" name="pengarang" required autocomplete="off" value="<?= $data['pengarang']; ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tahun Terbit</label>
                                <input type="number" min="0" max="100" class="form-control" name="tahun_terbit" required autocomplete="off" value="<?= $data['tahun_terbit']; ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jumlah Halaman</label>
                                <input type="number" min="0" max="100" class="form-control" name="jumlah_halaman" required autocomplete="off" value="<?= $data['jumlah_halaman']; ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label w-100">File Buku Digital</label>
                                <input type="file" name="file">
                            </div>
                            <div class="mb-3">
                                <label class="form-label w-100">Foto Buku Digital</label>
                                <input type="file" name="foto">
                            </div>
                            <a href="?h=buku_digital" class="btn btn-secondary float-start">Kembali</a>
                            <button type="submit" name="submit" class="btn btn-primary float-end">Perbaharui</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>