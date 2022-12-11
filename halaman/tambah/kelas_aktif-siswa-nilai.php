<?php
$siswa = $mysqli->query("SELECT * FROM siswa WHERE id=".$_GET['id_siswa'])->fetch_assoc();
$semester = $mysqli->query("SELECT semester.nama FROM semester_kelas INNER JOIN semester ON semester.id=semester_kelas.id_semester WHERE semester_kelas.id=".$_GET['id_semester_kelas'])->fetch_assoc();
if (isset($_POST['submit'])) {
    $mata_pelajaran_kelas = $_POST['mata_pelajaran_kelas'];
    $nilai = $_POST['nilai'];
    $izin = $mysqli->real_escape_string($_POST['izin']);
    $sakit = $mysqli->real_escape_string($_POST['sakit']);
    $tanpa_keterangan = $mysqli->real_escape_string($_POST['tanpa_keterangan']);
    $catatan = $mysqli->real_escape_string($_POST['catatan']);


    $q = "
        UPDATE semester_kelas SET 
            sakit=$sakit,
            izin=$izin,
            tanpa_keterangan=$tanpa_keterangan,
            catatan_wali_kelas='$catatan' 
        WHERE 
            id=" . $_GET['id_semester_kelas'] . " 
    ";

    if ($mysqli->query($q)) {
        $mysqli->query("DELETE FROM nilai_siswa WHERE id_semester_kelas=" . $_GET['id_semester_kelas']);
        for ($i = 0; $i < count($mata_pelajaran_kelas); $i++) {
            $q = "
            INSERT INTO nilai_siswa (
                id_semester_kelas,
                id_mata_pelajaran_kelas,
                nilai 
            ) VALUES (
                '" . $_GET['id_semester_kelas'] . "',
                '" . $mata_pelajaran_kelas[$i] . "',
                '" . $nilai[$i] . "' 
            )";
            $mysqli->query($q);
        }
        $_SESSION['tambah_data']['nama'] =  'ISI NANTI';
    } else {
        echo "<script>alert('Tambah Data Gagal!')</script>";
        die($mysqli->error);
    }
}
?>
<main class="content">
    <div class="container-fluid p-0">

        <div class="mb-3 text-center">
            <h1 class="h3 d-inline align-middle">Rapot <?= $siswa['nama']; ?> <?= $semester['nama']; ?></h1>
        </div>

        <div class="row justify-content-center">
            <div class="col-12 col-xl-8">
                <div class="card">
                    <div class="card-body">
                        <?php
                        $q = "
                            SELECT 
                                mpk.id AS id_mata_pelajaran_kelas,
                                mp.nama AS mata_pelajaran,
                                mpk.kkm,
                                IFNULL(
                                    (SELECT nilai FROM nilai_siswa AS ns WHERE ns.id_mata_pelajaran_kelas=mpk.id AND ns.id_semester_kelas=" . $_GET['id_semester_kelas'] . "),
                                    0  
                                ) AS nilai 
                            FROM 
                                mata_pelajaran_kelas AS mpk 
                            INNER JOIN 
                                mata_pelajaran AS mp 
                            ON 
                                mp.id=mpk.id_mata_pelajaran 
                            WHERE 
                                mpk.id_kelas_aktif=" . $_GET['id_kelas_aktif'] . " 
                        ";
                        $mata_pelajaran_kelas = $mysqli->query($q);

                        $semester_kelas = $mysqli->query("SELECT * FROM semester_kelas WHERE id=" . $_GET['id_semester_kelas'])->fetch_assoc();
                        ?>
                        <form action="" method="POST">
                            <div class="mb-3 row">
                                <label class="col-form-label col-sm-8 text-sm-start"><strong>Mata Pelajaran</strong></label>
                                <label class="col-form-label col-sm-2 text-sm-center"><strong>KKM</strong></label>
                                <label class="col-form-label col-sm-2 text-sm-center"><strong>Nilai</strong></label>
                            </div>
                            <?php while ($row = $mata_pelajaran_kelas->fetch_assoc()) : ?>
                                <div class="mb-3 row">
                                    <label class="col-form-label col-sm-8 text-sm-start"><?= $row['mata_pelajaran']; ?></label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control text-center" value="<?= $row['kkm']; ?>" disabled>
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="number" name="mata_pelajaran_kelas[]" value="<?= $row['id_mata_pelajaran_kelas']; ?>" required hidden>
                                        <input type="number" min="0" max="100" class="form-control text-center" name="nilai[]" value="<?= $row['nilai']; ?>" required>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                            <hr>
                            <div class="mb-3 row">
                                <label class="col-form-label col-sm-12 text-sm-start"><strong>Ketidakhadiran</strong></label>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-form-label col-sm-8 text-sm-start">Izin</label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control text-center" min="0" value="<?= $semester_kelas['izin'] ?? '0'; ?>" name="izin">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-form-label col-sm-8 text-sm-start">Sakit</label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control text-center" min="0" value="<?= $semester_kelas['sakit'] ?? '0'; ?>" name="sakit">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-form-label col-sm-8 text-sm-start">Tanpa Keterangan</label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control text-center" min="0" name="tanpa_keterangan" value="<?= $semester_kelas['tanpa_keterangan'] ?? '0'; ?>">
                                </div>
                            </div>
                            <hr>
                            <div class="mb-3 row">
                                <label class="col-form-label col-sm-12 text-sm-start">Catatan</label>
                                <div class="col-sm-12">
                                    <textarea name="catatan" class="form-control"><?= $semester_kelas['catatan_wali_kelas'] ?? ''; ?></textarea>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <div class="col-sm-6 text-sm-start">
                                    <a href="?h=lihat_kelas_aktif-siswa&id_kelas=<?= $_GET['id_kelas']; ?>&id_kelas_aktif=<?= $_GET['id_kelas_aktif']; ?>" class="btn btn-secondary">Kembali</a>
                                </div>
                                <div class="col-sm-6 text-sm-end">
                                    <button type="submit" name="submit" class="btn btn-primary">Perbaharui Data</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>