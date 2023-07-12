<?php
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

    // Foto
    $target_dir = "uploads/";
    $foto = $_FILES['foto'];
    $imageFileType = strtolower(pathinfo($foto['name'], PATHINFO_EXTENSION));
    $target_file = $target_dir . Date("YmdHis") . '.' . $imageFileType;
    $uploadOk = 1;
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

    $cek_nis = $mysqli->query("SELECT nis FROM siswa WHERE nis='$nis'");
    if ($cek_nis->num_rows)
        $_SESSION['error'][] = "NIS $nis telah digunakan, NIS tidak dapat sama dengan siswa yang lain.";

    $cek_nisn = $mysqli->query("SELECT nisn FROM siswa WHERE nisn='$nisn'");
    if ($cek_nisn->num_rows)
        $_SESSION['error'][] = "NISN $nisn telah digunakan, NISN tidak dapat sama dengan siswa yang lain.";

    if ($uploadOk && empty($_SESSION['error'])) {

        if (!is_dir($target_dir)) mkdir($target_dir, 0700, true);
        if (move_uploaded_file($foto["tmp_name"], $target_file)) {
            $q = "
                INSERT INTO user (
                    username,
                    password 
                ) VALUES (
                    '$nis',
                    '$nis' 
                )
            ";
            $mysqli->query($q);
            $id_user = $mysqli->insert_id;

            $q = "
            INSERT INTO siswa (
                nis,
                nisn,
                nama,
                tempat_lahir,
                tanggal_lahir,
                jenis_kelamin,
                agama,
                alamat,
                nama_ayah,
                nama_ibu,
                pekerjaan_ayah,
                pekerjaan_ibu,
                foto,
                status  
            ) VALUES (
                '$nis',
                '$nisn',
                '$nama',
                '$tempat_lahir',
                '$tanggal_lahir',
                '$jenis_kelamin',
                '$agama',
                '$alamat',
                '$nama_ayah',
                '$nama_ibu',
                '$pekerjaan_ayah',
                '$pekerjaan_ibu',
                '$target_file',
                'Aktif' 
            )";
            $mysqli->query($q);
            $id_siswa = $mysqli->insert_id;

            $q = "
                INSERT INTO user_siswa (
                    id_user,
                    id_siswa
                ) VALUES (
                    '$id_user',
                    '$id_siswa'
                )
            ";
            $mysqli->query($q);

            $_SESSION['tambah_data']['id'] = $mysqli->insert_id;
            $_SESSION['tambah_data']['nama'] = $nama;
            echo "<script>location.href = '?h=siswa';</script>";
        } else echo "Sorry, there was an error uploading your file.";
    }
}
?>
<main class="content">
    <div class="container-fluid p-0">

        <div class="mb-3 text-center">
            <h1 class="h3 d-inline align-middle">Tambah Siswa</h1>
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
                                    <input type="text" class="form-control" name="nis" required autocomplete="off" value="<?= $_SESSION['old']['nis'] ?? ''; ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">NISN</label>
                                    <input type="text" class="form-control" name="nisn" required autocomplete="off" value="<?= $_SESSION['old']['nisn'] ?? ''; ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Nama</label>
                                    <input type="text" class="form-control" name="nama" required autocomplete="off" value="<?= $_SESSION['old']['nama'] ?? ''; ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tempat Lahir</label>
                                    <input type="text" class="form-control" name="tempat_lahir" required autocomplete="off" value="<?= $_SESSION['old']['tempat_lahir'] ?? ''; ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tanggal Lahir</label>
                                    <input type="date" class="form-control" name="tanggal_lahir" required value="<?= $_SESSION['old']['tanggal_lahir'] ?? ''; ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Jenis Kelamin</label>
                                    <div class="row ps-3 mt-2">
                                        <label class="form-check col-auto">
                                            <input name="jenis_kelamin" type="radio" class="form-check-input" <?= isset($_SESSION['old']['jenis_kelamin']) ? (($_SESSION['old']['jenis_kelamin'] === 'Laki - Laki') ? 'checked' : '') : 'checked'; ?> value="Laki - Laki">
                                            <span class="form-check-label">Laki - Laki</span>
                                        </label>
                                        <label class="form-check col">
                                            <input name="jenis_kelamin" type="radio" class="form-check-input" <?= isset($_SESSION['old']['jenis_kelamin']) ? (($_SESSION['old']['jenis_kelamin'] === 'Perempuan') ? 'checked' : '') : ''; ?> value="Perempuan">
                                            <span class="form-check-label">Perempuan</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Agama</label>
                                    <select name="agama" class="form-control" required>
                                        <option value="" disabled selected>Pilih Agama</option>
                                        <option <?= (($_SESSION['old']['agama'] ?? '') === 'Islam') ? 'selected' : ''; ?> value="Islam">Islam</option>
                                        <option <?= (($_SESSION['old']['agama'] ?? '') === 'Kristen') ? 'selected' : ''; ?> value="Kristen">Kristen</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label w-100">Foto</label>
                                    <input type="file" name="foto" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label w-100">Alamat</label>
                                    <textarea name="alamat" class="form-control" required><?= $_SESSION['old']['alamat'] ?? ''; ?></textarea>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama Ayah</label>
                                    <input type="text" class="form-control" name="nama_ayah" required autocomplete="off" value="<?= $_SESSION['old']['nama_ayah'] ?? ''; ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama Ibu</label>
                                    <input type="text" class="form-control" name="nama_ibu" required autocomplete="off" value="<?= $_SESSION['old']['nama_ibu'] ?? ''; ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Pekerjaan Ayah</label>
                                    <input type="text" class="form-control" name="pekerjaan_ayah" required autocomplete="off" value="<?= $_SESSION['old']['pekerjaan_ayah'] ?? ''; ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Pekerjaan Ibu</label>
                                    <input type="text" class="form-control" name="pekerjaan_ibu" required autocomplete="off" value="<?= $_SESSION['old']['pekerjaan_ibu'] ?? ''; ?>">
                                </div>
                            </div>
                            <a href="?h=siswa" class="btn btn-secondary float-start">Kembali</a>
                            <button type="submit" name="submit" class="btn btn-primary float-end">Tambah</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>