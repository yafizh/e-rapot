<?php
$data = $mysqli->query("SELECT * FROM siswa WHERE id=" . $_GET['id'])->fetch_assoc();
if (isset($_POST['submit'])) {
    $nama = $mysqli->real_escape_string($_POST['nama']);
    $tempat_lahir = $mysqli->real_escape_string($_POST['tempat_lahir']);
    $tanggal_lahir = $mysqli->real_escape_string($_POST['tanggal_lahir']);
    $jenis_kelamin = $mysqli->real_escape_string($_POST['jenis_kelamin']);
    $status = $mysqli->real_escape_string($_POST['status']);

    $_SESSION['old']['nama'] = $nama;
    $_SESSION['old']['tempat_lahir'] = $tempat_lahir;
    $_SESSION['old']['tanggal_lahir'] = $tanggal_lahir;
    $_SESSION['old']['jenis_kelamin'] = $jenis_kelamin;
    $_SESSION['old']['status'] = $status;

    $foto = $_FILES['foto'];
    $uploadOk = 1;
    if ($foto['error'] != 4) {
        // Foto
        $target_dir = "uploads/";
        $imageFileType = strtolower(pathinfo($foto['name'], PATHINFO_EXTENSION));
        $target_file = $target_dir . Date("YmdHis") . '.' . $imageFileType;


        $check = getimagesize($foto["tmp_name"]);
        if (!$check) {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        if ($foto["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"
        ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        if (!is_dir($target_dir)) mkdir($target_dir, 0700, true);
        if (!move_uploaded_file($foto["tmp_name"], $target_file)) {
            echo "Sorry, there was an error uploading your file.";
        }
    } else $target_file = $data['foto'];


    if ($uploadOk) {
        $q = "
            UPDATE siswa SET
                nama='$nama',
                tempat_lahir='$tempat_lahir',
                tanggal_lahir='$tanggal_lahir',
                jenis_kelamin='$jenis_kelamin',
                foto='$target_file',
                status='$status' 
            ";

        if ($mysqli->query($q)) {
            $_SESSION['edit_data']['id'] =  $data['id'];
            $_SESSION['edit_data']['nama'] =  $data['nama'];
            echo "<script>location.href = '?h=siswa';</script>";
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
            <h1 class="h3 d-inline align-middle">Edit Siswa</h1>
        </div>

        <div class="row justify-content-center">
            <div class="col-12 col-xl-6">
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
                                <label class="form-label">Status</label>
                                <select name="status" class="form-control">
                                    <option <?= ($_SESSION['old']['status'] ?? $data['status']) === 'Aktif' ? 'selected' : ''; ?> value="Aktif">Aktif</option>
                                    <option <?= ($_SESSION['old']['status'] ?? $data['status']) === 'Alumni' ? 'selected' : ''; ?> value="Alumni">Alumni</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label w-100">Foto</label>
                                <input type="file" name="foto">
                                <small class="form-text text-muted">Example block-level help text
                                    here.</small>
                            </div>
                            <a href="?h=siswa" class="btn btn-secondary float-start">Kembali</a>
                            <button type="submit" name="submit" class="btn btn-primary float-end">Perbaharui</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>