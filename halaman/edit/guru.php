<?php
$data = $mysqli->query("SELECT * FROM guru WHERE id=" . $_GET['id'])->fetch_assoc();
if (isset($_POST['submit'])) {
    $nip = $mysqli->real_escape_string($_POST['nip']);
    $nama = $mysqli->real_escape_string($_POST['nama']);
    $jabatan = $mysqli->real_escape_string($_POST['jabatan']);
    $tempat_lahir = $mysqli->real_escape_string($_POST['tempat_lahir']);
    $tanggal_lahir = $mysqli->real_escape_string($_POST['tanggal_lahir']);
    $jenis_kelamin = $mysqli->real_escape_string($_POST['jenis_kelamin']);

    $_SESSION['old']['nip'] = $nip;
    $_SESSION['old']['nama'] = $nama;
    $_SESSION['old']['jabatan'] = $jabatan;
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


    if ($uploadOk) {
        $validasi_nip = $mysqli->query("SELECT nip FROM guru WHERE nip='$nip' AND id !=" . $data['id']);
        if ($validasi_nip->num_rows)
            $_SESSION['error'][] = "NIP telah digunakan, NIP tidak dapat sama dengan guru yang lain.";

        $validasi_wali_kelas = $mysqli->query("SELECT * FROM kelas_aktif WHERE status='Aktif' AND id_guru=" . $data['id']);
        if ($validasi_wali_kelas->num_rows)
            $_SESSION['error'][] = "Jabatan tidak dapat diganti karena guru sedang menjadi wali kelas pada sebuah kelas aktif.";

        if (!$validasi_nip->num_rows && !$validasi_wali_kelas->num_rows) {
            try {
                $mysqli->begin_transaction();
                $user_guru = $mysqli->query("SELECT * FROM user_guru WHERE id_guru=" . $_GET['id']);
                if ($user_guru->num_rows)
                    $mysqli->query("UPDATE user SET username='$nip' WHERE id=" . $user_guru->fetch_assoc()['id_user']);

                $q = "
                UPDATE guru SET
                    nip='$nip',
                    nama='$nama',
                    jabatan='$jabatan',
                    tempat_lahir='$tempat_lahir',
                    tanggal_lahir='$tanggal_lahir',
                    jenis_kelamin='$jenis_kelamin',
                    foto='$target_file' 
                WHERE 
                    id=" . $_GET['id'] . "
                ";
                $mysqli->query($q);

                $mysqli->commit();

                $_SESSION['edit_data']['id'] =  $data['id'];
                $_SESSION['edit_data']['nama'] =  $data['nama'];
                echo "<script>location.href = '?h=guru';</script>";
            } catch (\Throwable $e) {
                $mysqli->rollback();
                throw $e;
            };
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
                                <label class="form-label">NIP</label>
                                <input type="text" class="form-control" name="nip" required autocomplete="off" value="<?= $_SESSION['old']['nip'] ?? $data['nip']; ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" class="form-control" name="nama" required autocomplete="off" value="<?= $_SESSION['old']['nama'] ?? $data['nama']; ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jabatan</label>
                                <select name="jabatan" class="form-control" required>
                                    <option value="Guru" <?= ($_SESSION['old']['nama'] ?? $data['jabatan']) == 'Guru' ? 'selected' : ''; ?>>Guru</option>
                                    <?php $result = $mysqli->query("SELECT * FROM guru WHERE jabatan='Kepala Sekolah' AND id !=" . $data['id']); ?>
                                    <?php if (!$result->num_rows) : ?>
                                        <option value="Kepala Sekolah" <?= ($_SESSION['old']['nama'] ?? $data['jabatan']) == 'Kepala Sekolah' ? 'selected' : ''; ?>>Kepala Sekolah</option>
                                    <?php endif; ?>
                                    <option value="Wali Kelas" <?= ($_SESSION['old']['nama'] ?? $data['jabatan']) == 'Wali Kelas' ? 'selected' : ''; ?>>Wali Kelas</option>
                                </select>
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