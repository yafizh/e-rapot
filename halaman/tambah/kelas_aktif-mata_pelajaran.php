<?php
$kelas = $mysqli->query("SELECT * FROM kelas WHERE id=" . $_GET['id_kelas'])->fetch_assoc();

$q = "
    SELECT 
        ka.id, 
        ka.nama, 
        g.nama AS wali_kelas 
    FROM 
        kelas_aktif AS ka 
    INNER JOIN 
        guru AS g 
    ON 
        g.id=ka.id_guru 
    WHERE ka.id=" . $_GET['id_kelas_aktif'];
$kelas_aktif = $mysqli->query($q)->fetch_assoc();

$q = "
    SELECT 
        * 
    FROM 
        mata_pelajaran 
    WHERE 
        id NOT IN (SELECT id_mata_pelajaran FROM mata_pelajaran_kelas WHERE id_kelas_aktif=" . $_GET['id_kelas_aktif'] . ") 
    ORDER BY nama";
$mata_pelajaran = $mysqli->query($q)->fetch_all(MYSQLI_ASSOC);
if (isset($_POST['submit'])) {
    $id_guru = $mysqli->real_escape_string($_POST['id_guru']);
    $id_mata_pelajaran = $mysqli->real_escape_string($_POST['id_mata_pelajaran']);
    $nama_mata_pelajaran = null;
    $kkm_mata_pelajaran = null;
    foreach ($mata_pelajaran as $row) {
        if ($row['id'] == $id_mata_pelajaran) {
            $nama_mata_pelajaran = $row['nama'];
            $kkm_mata_pelajaran = $row['kkm'];
            break;
        }
    }

    // RPS
    $target_dir = "uploads/rps/";
    $rps = $_FILES['rps'];
    $imageFileType = strtolower(pathinfo($rps['name'], PATHINFO_EXTENSION));
    $target_file = $target_dir . Date("YmdHis") . '.' . $imageFileType;

    if (!is_dir($target_dir)) mkdir($target_dir, 0700, true);
    move_uploaded_file($rps["tmp_name"], $target_file);

    $q = "
        INSERT INTO mata_pelajaran_kelas (
            id_kelas_aktif,
            id_mata_pelajaran,
            id_guru,
            kkm,
            rps
        ) VALUES (
            '" . $kelas_aktif['id'] . "',
            '$id_mata_pelajaran',
            '$id_guru', 
            '$kkm_mata_pelajaran',
            '$target_file'
        )";

    if ($mysqli->query($q)) {
        $_SESSION['tambah_data']['nama'] =  $nama_mata_pelajaran;
        echo "<script>location.href = '?h=lihat_kelas_aktif-mata_pelajaran&id_kelas=" . $_GET['id_kelas'] . "&id_kelas_aktif=" . $kelas_aktif['id'] . "';</script>";
    } else {
        echo "<script>alert('Tambah Data Gagal!')</script>";
        die($mysqli->error);
    }
}
?>
<main class="content">
    <div class="container-fluid p-0">

        <div class="mb-3 text-center">
            <h1 class="h3 d-inline align-middle">Tambah Mata Pelajaran Kelas <?= $kelas['nama']; ?> <?= $kelas_aktif['nama']; ?></h1>
        </div>

        <div class="row justify-content-center">
            <div class="col-12 col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label class="form-label">Kelas</label>
                                <input type="text" disabled class="form-control" value="<?= $kelas['nama']; ?> <?= $kelas_aktif['nama']; ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Wali Kelas</label>
                                <input type="text" disabled class="form-control" value="<?= $kelas_aktif['wali_kelas']; ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Mata Pelajaran</label>
                                <select name="id_mata_pelajaran" required class="form-control choices-single">
                                    <option value="" selected disabled>Pilih Mata Pelajaran</option>
                                    <?php foreach ($mata_pelajaran as $row) : ?>
                                        <option value="<?= $row['id']; ?>"><?= $row['nama'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Pengajar</label>
                                <?php $guru = $mysqli->query("SELECT * FROM guru ORDER BY nama"); ?>
                                <select name="id_guru" required class="form-control choices-single">
                                    <option value="" selected disabled>Pilih Pengajar</option>
                                    <?php while ($row = $guru->fetch_assoc()) : ?>
                                        <option value="<?= $row['id']; ?>"><?= $row['nama'] ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">RPS</label>
                                <input type="file" class="form-control" name="rps" required autocomplete="off">
                            </div>
                            <a href="?h=lihat_kelas_aktif-mata_pelajaran&id_kelas=<?= $_GET['id_kelas'] ?>&id_kelas_aktif=<?= $_GET['id_kelas_aktif'] ?>" class="btn btn-secondary float-start">Kembali</a>
                            <button type="submit" name="submit" class="btn btn-primary float-end">Tambah</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>