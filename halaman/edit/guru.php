<?php
$data = $mysqli->query("SELECT * FROM guru WHERE id=" . $_GET['id'])->fetch_assoc();
if (isset($_POST['submit'])) {
    $nama = $mysqli->real_escape_string($_POST['nama']);
    $tempat_lahir = $mysqli->real_escape_string($_POST['tempat_lahir']);
    $tanggal_lahir = $mysqli->real_escape_string($_POST['tanggal_lahir']);
    $jenis_kelamin = $mysqli->real_escape_string($_POST['jenis_kelamin']);

    $_SESSION['old']['nama'] = $nama;
    $_SESSION['old']['tempat_lahir'] = $tempat_lahir;
    $_SESSION['old']['tanggal_lahir'] = $tanggal_lahir;
    $_SESSION['old']['jenis_kelamin'] = $jenis_kelamin;

    $foto = $_FILES['foto'];
    $uploadOk = 1;
    if ($foto['error'] != 4) {
        // Foto
        $target_dir = "uploads/";
        $imageFileType = strtolower(pathinfo($foto['name'], PATHINFO_EXTENSION));
        $target_file = $target_dir . Date("YmdHis") . '.' . $imageFileType;


        $check = getimagesize($foto["tmp_name"]);
        if (!$check) {
            $_SESSION['error'][] = "File yang diupload bukan gambar!";
            $uploadOk = 0;
        }

        if ($foto["size"] > 500000) {
            $_SESSION['error'][] = "Gambar terlalu besar!";
            $uploadOk = 0;
        }

        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"
        ) {
            $_SESSION['error'][] = "Hanya menerima gambar dengan format jpg, png, jpeg, dan gif.";
            $uploadOk = 0;
        }

        if (!is_dir($target_dir)) mkdir($target_dir, 0700, true);
        if (!move_uploaded_file($foto["tmp_name"], $target_file)) {
            echo "Sorry, there was an error uploading your file.";
        }
    } else $target_file = $data['foto'];


    if ($uploadOk) {
        $q = "
            UPDATE guru SET
                nama='$nama',
                tempat_lahir='$tempat_lahir',
                tanggal_lahir='$tanggal_lahir',
                jenis_kelamin='$jenis_kelamin',
                foto='$target_file' 
            WHERE 
                id=" . $_GET['id'] . "
            ";

        if ($mysqli->query($q)) {
            $_SESSION['edit_data']['id'] =  $data['id'];
            $_SESSION['edit_data']['nama'] =  $data['nama'];
            echo "<script>location.href = '?h=guru';</script>";
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
            <h1 class="h3 d-inline align-middle">Edit Guru</h1>
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
                                <label class="form-label">Nama</label>
                                <input type="text" class="form-control" name="nama" required autocomplete="off" value="<?= $_SESSION['old']['nama'] ?? $data['nama']; ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tempat Lahir</label>
                                <input type="text" class="form-control" name="tempat_lahir" required autocomplete="off" value="<?= $_SESSION['old']['tempat_lahir'] ?? $data['tempat_lahir']; ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control" name="tanggal_lahir" required value="<?= $_SESSION['old']['tanggal_lahir'] ?? $data['tanggal_lahir']; ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jenis Kelamin</label>
                                <div class="row ps-3">
                                    <label class="form-check col-auto">
                                        <input name="jenis_kelamin" type="radio" class="form-check-input" <?= isset($_SESSION['old']['jenis_kelamin']) ? (($_SESSION['old']['jenis_kelamin'] === 'Laki - Laki') ? 'checked' : '') : ($data['jenis_kelamin'] === 'Laki - Laki' ? 'checked' : ''); ?> value="Laki - Laki">
                                        <span class="form-check-label">Laki - Laki</span>
                                    </label>
                                    <label class="form-check col">
                                        <input name="jenis_kelamin" type="radio" class="form-check-input" <?= isset($_SESSION['old']['jenis_kelamin']) ? (($_SESSION['old']['jenis_kelamin'] === 'Perempuan') ? 'checked' : '') : ($data['jenis_kelamin'] === 'Perempuan' ? 'checked' : ''); ?> value="Perempuan">
                                        <span class="form-check-label">Perempuan</span>
                                    </label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label w-100">Foto</label>
                                <input type="file" name="foto">
                            </div>
                            <a href="?h=guru" class="btn btn-secondary float-start">Kembali</a>
                            <button type="submit" name="submit" class="btn btn-primary float-end">Perbaharui</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>