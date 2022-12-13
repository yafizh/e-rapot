<?php
$kelas = $mysqli->query("SELECT * FROM kelas WHERE id=" . $_GET['id_kelas'])->fetch_assoc();
$kelas_aktif = $mysqli->query("SELECT ka.id, ka.nama, g.nama AS wali_kelas FROM kelas_aktif AS ka INNER JOIN guru AS g ON g.id=ka.id_guru WHERE ka.id=" . $_GET['id_kelas_aktif'])->fetch_assoc();
if (isset($_POST['submit'])) {
    $id_guru = $mysqli->real_escape_string($_POST['id_guru']);
    $id_mata_pelajaran = $mysqli->real_escape_string($_POST['id_mata_pelajaran']);
    $kkm = $mysqli->real_escape_string($_POST['kkm']);

    $q = "
        INSERT INTO mata_pelajaran_kelas (
            id_kelas_aktif,
            id_mata_pelajaran,
            id_guru,
            kkm 
        ) VALUES (
            '" . $kelas_aktif['id'] . "',
            '$id_mata_pelajaran',
            '$id_guru', 
            '$kkm' 
        )";

    if ($mysqli->query($q)) {
        $_SESSION['tambah_data']['nama'] =  'ISI NANTI';
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
                        <form action="" method="POST">
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
                                <?php $mata_pelajaran = $mysqli->query("SELECT * FROM mata_pelajaran WHERE id NOT IN (SELECT id_mata_pelajaran FROM mata_pelajaran_kelas WHERE id_kelas_aktif=" . $_GET['id_kelas_aktif'] . ") ORDER BY nama"); ?>
                                <select name="id_mata_pelajaran" required class="form-control choices-single">
                                    <option value="" selected disabled>Pilih Mata Pelajaran</option>
                                    <?php while ($row = $mata_pelajaran->fetch_assoc()) : ?>
                                        <option value="<?= $row['id']; ?>"><?= $row['nama'] ?></option>
                                    <?php endwhile; ?>
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
                                <label class="form-label">KKM</label>
                                <input type="number" name="kkm" class="form-control">
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