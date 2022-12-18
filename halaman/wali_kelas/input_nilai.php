<?php
$q = "
    SELECT 
        s.nisn,
        s.nis,
        s.nama,
        s.foto,
        sk.*, 
        se.nama AS semester,
        ka.id AS id_kelas_aktif  
    FROM 
        semester_kelas AS sk 
    INNER JOIN 
        semester AS se 
    ON 
        se.id=sk.id_semester  
    INNER JOIN 
        kelas_siswa AS ks 
    ON 
        ks.id=sk.id_kelas_siswa 
    INNER JOIN 
        kelas_aktif AS ka 
    ON 
        ka.id=ks.id_kelas_aktif 
    INNER JOIN 
        siswa AS s 
    ON 
        s.id=ks.id_siswa 
    WHERE 
        sk.id=" . $_GET['id_semester_kelas'] . " 
";
$data = $mysqli->query($q)->fetch_assoc();
if (isset($_POST['submit'])) {
    $mata_pelajaran_kelas = $_POST['mata_pelajaran_kelas'] ?? [];
    $nilai = $_POST['nilai'] ?? [];
    $izin = $mysqli->real_escape_string($_POST['izin']);
    $sakit = $mysqli->real_escape_string($_POST['sakit']);
    $tanpa_keterangan = $mysqli->real_escape_string($_POST['tanpa_keterangan']);
    $catatan = $mysqli->real_escape_string($_POST['catatan']);

    try {
        $mysqli->begin_transaction();

        $q = "
            UPDATE semester_kelas SET 
                sakit=$sakit,
                izin=$izin,
                tanpa_keterangan=$tanpa_keterangan,
                catatan_wali_kelas='$catatan' 
            WHERE 
                id=" . $_GET['id_semester_kelas'] . " 
        ";
        $mysqli->query($q);

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

        $mysqli->commit();
        $_SESSION['berhasil'] = true;
    } catch (\Throwable $e) {
        $mysqli->rollback();
        throw $e;
    };
}
?>
<main class="content">
    <div class="container-fluid p-0">

        <div class="mb-3 text-center">
            <h1 class="h3 d-inline align-middle">INPUT NILAI RAPOT SISWA</h1>
        </div>

        <div class="row justify-content-center">
        <div class="col-12 col-sm-6 col-md-5 col-xl-3">
                <div class="card mb-3">
                    <div class="card-body text-center">
                        <img src="<?= $data['foto']; ?>" onerror="imageError(this)" class="img-fluid rounded-circle mb-2" width="254" height="254">
                        <h5 class="card-title mb-0 mt-3"><?= $data['nama']; ?></h5>
                        <div class="text-muted mb-2"><?= $data['nis']; ?>/<?= $data['nisn']; ?></div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-xl-8">
                <?php if (isset($_SESSION['berhasil'])) : ?>
                    <div class="col-12">
                        <div class="alert delete alert-success alert-dismissible" role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-message">
                                <h4 class="alert-heading">Berhasil.</h4>
                                <p>Berhasil menyimpan data nilai rapot siswa.</p>
                                <hr>
                            </div>
                        </div>
                    </div>
                    <?php unset($_SESSION['berhasil']); ?>
                <?php endif; ?>
                <div class="card">
                    <div class="card-header">
                        Semester <?= $data['semester']; ?>
                    </div>
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
                                mpk.id_kelas_aktif=" . $data['id_kelas_aktif'] . " 
                        ";
                        $mata_pelajaran_kelas = $mysqli->query($q);
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
                                    <input type="number" class="form-control text-center" min="0" value="<?= $data['izin'] ?? '0'; ?>" name="izin">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-form-label col-sm-8 text-sm-start">Sakit</label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control text-center" min="0" value="<?= $data['sakit'] ?? '0'; ?>" name="sakit">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-form-label col-sm-8 text-sm-start">Tanpa Keterangan</label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control text-center" min="0" name="tanpa_keterangan" value="<?= $data['tanpa_keterangan'] ?? '0'; ?>">
                                </div>
                            </div>
                            <hr>
                            <div class="mb-3 row">
                                <label class="col-form-label col-sm-12 text-sm-start">Catatan</label>
                                <div class="col-sm-12">
                                    <textarea name="catatan" class="form-control"><?= $data['catatan_wali_kelas'] ?? ''; ?></textarea>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <div class="col-sm-6 text-sm-start">
                                    <a href="?" class="btn btn-secondary">Kembali</a>
                                </div>
                                <div class="col-sm-6 text-sm-end">
                                    <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>