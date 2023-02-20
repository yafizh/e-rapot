<?php
$data = $mysqli->query("SELECT * FROM siswa WHERE id=" . $_GET['id'])->fetch_assoc();
if (isset($_POST['submit'])) {
    $nis = $mysqli->real_escape_string($_POST['nis']);
    $nisn = $mysqli->real_escape_string($_POST['nisn']);
    $nama = $mysqli->real_escape_string($_POST['nama']);
    $tempat_lahir = $mysqli->real_escape_string($_POST['tempat_lahir']);
    $tanggal_lahir = $mysqli->real_escape_string($_POST['tanggal_lahir']);
    $jenis_kelamin = $mysqli->real_escape_string($_POST['jenis_kelamin']);
    $agama = $mysqli->real_escape_string($_POST['agama']);
    $alamat = $mysqli->real_escape_string($_POST['alamat']);
    $nama_ayah = $mysqli->real_escape_string($_POST['nama_ayah']);
    $nama_ibu = $mysqli->real_escape_string($_POST['nama_ibu']);
    $pekerjaan_ayah = $mysqli->real_escape_string($_POST['pekerjaan_ayah']);
    $pekerjaan_ibu = $mysqli->real_escape_string($_POST['pekerjaan_ibu']);

    $_SESSION['old']['nis'] = $nis;
    $_SESSION['old']['nisn'] = $nisn;
    $_SESSION['old']['nama'] = $nama;
    $_SESSION['old']['tempat_lahir'] = $tempat_lahir;
    $_SESSION['old']['tanggal_lahir'] = $tanggal_lahir;
    $_SESSION['old']['jenis_kelamin'] = $jenis_kelamin;
    $_SESSION['old']['agama'] = $agama;
    $_SESSION['old']['alamat'] = $alamat;
    $_SESSION['old']['nama_ayah'] = $nama_ayah;
    $_SESSION['old']['nama_ibu'] = $nama_ibu;
    $_SESSION['old']['pekerjaan_ayah'] = $pekerjaan_ayah;
    $_SESSION['old']['pekerjaan_ibu'] = $pekerjaan_ibu;

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

        // if ($foto["size"] > 500000) {
        //     $_SESSION['error'][] = "Gambar terlalu besar!";
        //     $uploadOk = 0;
        // }

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

    $cek_nis = $mysqli->query("SELECT nis FROM siswa WHERE nis='$nis' AND id !=" . $_GET['id']);
    if ($cek_nis->num_rows)
        $_SESSION['error'][] = "NIS $nis telah digunakan, NIS tidak dapat sama dengan siswa yang lain.";

    $cek_nisn = $mysqli->query("SELECT nisn FROM siswa WHERE nisn='$nisn' AND id !=" . $_GET['id']);
    if ($cek_nisn->num_rows)
        $_SESSION['error'][] = "NISN $nisn telah digunakan, NISN tidak dapat sama dengan siswa yang lain.";

    if ($uploadOk && empty($_SESSION['error'])) {
        $q = "
            UPDATE siswa SET
                nis='$nis',
                nisn='$nisn',
                nama='$nama',
                tempat_lahir='$tempat_lahir',
                tanggal_lahir='$tanggal_lahir',
                jenis_kelamin='$jenis_kelamin',
                agama='$agama',
                alamat='$alamat',
                nama_ayah='$nama_ayah',
                nama_ibu='$nama_ibu',
                pekerjaan_ayah='$pekerjaan_ayah',
                pekerjaan_ibu='$pekerjaan_ibu',
                foto='$target_file' 
            WHERE 
                id=" . $_GET['id'] . "
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
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">NIS</label>
                                    <input type="text" class="form-control" name="nis" required autocomplete="off" value="<?= $_SESSION['old']['nis'] ?? $data['nis']; ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">NISN</label>
                                    <input type="text" class="form-control" name="nisn" required autocomplete="off" value="<?= $_SESSION['old']['nisn'] ?? $data['nisn']; ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Nama</label>
                                    <input type="text" class="form-control" name="nama" required autocomplete="off" value="<?= $_SESSION['old']['nama'] ?? $data['nama']; ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tempat Lahir</label>
                                    <input type="text" class="form-control" name="tempat_lahir" required autocomplete="off" value="<?= $_SESSION['old']['tempat_lahir'] ?? $data['tempat_lahir']; ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tanggal Lahir</label>
                                    <input type="date" class="form-control" name="tanggal_lahir" required value="<?= $_SESSION['old']['tanggal_lahir'] ?? $data['tanggal_lahir']; ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Jenis Kelamin</label>
                                    <div class="row ps-3 mt-2">
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
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Agama</label>
                                    <select name="agama" class="form-control" required>
                                        <option value="" disabled selected>Pilih Agama</option>
                                        <option <?= (($_SESSION['old']['agama'] ?? $data['agama']) === 'Islam') ? 'selected' : ''; ?> value="Islam">Islam</option>
                                        <option <?= (($_SESSION['old']['agama'] ?? $data['agama']) === 'Kristen') ? 'selected' : ''; ?> value="Kristen">Kristen</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label w-100">Foto</label>
                                    <input type="file" name="foto">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label w-100">Alamat</label>
                                    <textarea name="alamat" class="form-control" required><?= $_SESSION['old']['alamat'] ?? $data['alamat']; ?></textarea>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama Ayah</label>
                                    <input type="text" class="form-control" name="nama_ayah" required autocomplete="off" value="<?= $_SESSION['old']['nama_ayah'] ?? $data['nama_ayah']; ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama Ibu</label>
                                    <input type="text" class="form-control" name="nama_ibu" required autocomplete="off" value="<?= $_SESSION['old']['nama_ibu'] ?? $data['nama_ibu']; ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Pekerjaan Ayah</label>
                                    <input type="text" class="form-control" name="pekerjaan_ayah" required autocomplete="off" value="<?= $_SESSION['old']['pekerjaan_ayah'] ?? $data['pekerjaan_ayah']; ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Pekerjaan Ibu</label>
                                    <input type="text" class="form-control" name="pekerjaan_ibu" required autocomplete="off" value="<?= $_SESSION['old']['pekerjaan_ibu'] ?? $data['pekerjaan_ibu']; ?>">
                                </div>
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