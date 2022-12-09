<?php
$kelas_aktif = $mysqli->query("SELECT ka.id, ka.nama, g.nama AS wali_kelas FROM kelas_aktif AS ka INNER JOIN guru AS g ON g.id=ka.id_guru WHERE ka.id=" . $_GET['id_kelas_aktif'])->fetch_assoc();
if (isset($_POST['submit'])) {
    $id_siswa = $mysqli->real_escape_string($_POST['id_siswa']);

    $q = "
        INSERT INTO kelas_siswa (
            id_kelas_aktif,
            id_siswa
        ) VALUES (
            '" . $kelas_aktif['id'] . "',
            '$id_siswa'
        )";

    if ($mysqli->query($q)) {
        $_SESSION['tambah_data']['nama'] =  'ISI NANTI';
        echo "<script>location.href = '?h=lihat_kelas_aktif-siswa&id=" . $kelas_aktif['id'] . "';</script>";
    } else {
        echo "<script>alert('Tambah Data Gagal!')</script>";
        die($mysqli->error);
    }
}
?>
<main class="content">
    <div class="container-fluid p-0">

        <div class="mb-3 text-center">
            <h1 class="h3 d-inline align-middle">Tambah Siswa Kelas <?= $kelas_aktif['nama']; ?></h1>
        </div>

        <div class="row justify-content-center">
            <div class="col-12 col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="mb-3">
                                <label class="form-label">Kelas</label>
                                <input type="text" disabled class="form-control" value="<?= $kelas_aktif['nama']; ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Wali Kelas</label>
                                <input type="text" disabled class="form-control" value="<?= $kelas_aktif['wali_kelas']; ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Siswa</label>
                                <?php
                                $query = "
                                    SELECT 
                                        * 
                                    FROM 
                                        siswa 
                                    WHERE 
                                        id NOT IN (SELECT id_siswa FROM kelas_siswa AS ks INNER JOIN kelas_aktif AS ka ON ka.id=ks.id_kelas_aktif WHERE ka.status='Aktif') 
                                    ORDER BY 
                                        nama";
                                $siswa = $mysqli->query($query); ?>
                                <select name="id_siswa" required class="form-control">
                                    <option value="" selected disabled>Pilih Siswa</option>
                                    <?php while ($row = $siswa->fetch_assoc()) : ?>
                                        <option value="<?= $row['id']; ?>"><?= $row['nama'] ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <a href="?h=lihat_kelas_aktif-siswa&id=<?= $_GET['id_kelas_aktif'] ?>" class="btn btn-secondary float-start">Kembali</a>
                            <button type="submit" name="submit" class="btn btn-primary float-end">Tambah</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>