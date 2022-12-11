<?php
$kelas = $mysqli->query("SELECT * FROM kelas WHERE id=" . $_GET['id_kelas'])->fetch_assoc();
if (isset($_POST['submit'])) {
    $id_guru = $mysqli->real_escape_string($_POST['id_guru']);
    $nama = $mysqli->real_escape_string($_POST['nama']);
    $tahun_pelajaran = $mysqli->real_escape_string($_POST['tahun_pelajaran']);

    $q = "
        INSERT INTO kelas_aktif (
            id_kelas, 
            id_guru, 
            nama, 
            tahun_pelajaran, 
            status
        ) VALUES (
            '" . $_GET['id_kelas'] . "',
            '$id_guru',
            '$nama', 
            '$tahun_pelajaran', 
            'Aktif'
        )";

    if ($mysqli->query($q)) {
        $_SESSION['tambah_data']['nama'] =  $nama;
        echo "<script>location.href = '?h=kelas_aktif&id_kelas=" . $_GET['id_kelas'] . "';</script>";
    } else {
        echo "<script>alert('Tambah Data Gagal!')</script>";
        die($mysqli->error);
    }
}
?>
<main class="content">
    <div class="container-fluid p-0">

        <div class="mb-3 text-center">
            <h1 class="h3 d-inline align-middle">Tambah Kelas Aktif</h1>
        </div>

        <div class="row justify-content-center">
            <div class="col-12 col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="mb-3">
                                <label class="form-label">Kelas</label>
                                <input type="text" class="form-control" disabled value="<?= $kelas['nama']; ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Wali Kelas</label>
                                <?php $guru = $mysqli->query("SELECT * FROM guru WHERE id NOT IN (SELECT id_guru FROM kelas_aktif WHERE status='Aktif') ORDER BY nama"); ?>
                                <select name="id_guru" required class="form-control choices-single">
                                    <option value="" selected disabled>Pilih Guru</option>
                                    <?php while ($row = $guru->fetch_assoc()) : ?>
                                        <option value="<?= $row['id']; ?>"><?= $row['nama'] ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama Kelas</label>
                                <input type="text" class="form-control" name="nama" required autocomplete="off">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tahun Pelajaran</label>
                                <input type="text" class="form-control" name="tahun_pelajaran" required autocomplete="off" value="<?= Date("Y"); ?>/<?= Date('Y', strtotime('+1 year')); ?>">
                            </div>
                            <a href="?h=kelas_aktif&id_kelas=<?= $_GET['id_kelas']; ?>" class="btn btn-secondary float-start">Kembali</a>
                            <button type="submit" name="submit" class="btn btn-primary float-end">Tambah</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>