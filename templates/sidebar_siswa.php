<?php $siswa = $mysqli->query("SELECT * FROM siswa WHERE id=" . $_SESSION['user']['id_siswa'])->fetch_assoc(); ?>
<?php
$q = "
    SELECT 
        k.nama kelas,
        (
            SELECT 
                s.nama
            FROM 
                semester_kelas sk 
            INNER JOIN 
                semester s 
            ON 
                s.id=sk.id_semester 
            WHERE 
                sk.id_kelas_siswa=ks.id 
            ORDER BY 
                s.tingkat DESC 
            LIMIT 1
        ) semester
    FROM 
        kelas_siswa ks 
    INNER JOIN 
        kelas_aktif ka 
    ON 
        ka.id=ks.id_kelas_aktif 
    INNER JOIN 
        kelas k 
    ON 
        k.id=ka.id_kelas 
    WHERE 
        ks.id_siswa=" . $siswa['id'] . " 
        AND 
        ks.status='aktif'
    ";
$kelas = $mysqli->query($q)->fetch_assoc();
?>
<div class="col-12 col-sm-6 col-md-5 col-xl-3">
    <div class="card mb-3">
        <div class="card-body text-center">
            <img src="<?= $siswa['foto']; ?>" onerror="imageError(this)" class="img-fluid rounded-circle mb-2" style="width: 180px; height: 180px; object-fit: cover;">
            <h5 class="card-title mb-2"><?= $siswa['nama']; ?></h5>
            <div class="text-muted mb-0"><?= is_null($kelas['kelas']) ? '' : ('Kelas ' . $kelas['kelas']); ?></div>
            <div class="text-muted mb-2"><?= is_null($kelas['semester']) ? '' : ('Semester ' . $kelas['semester']); ?></div>
        </div>
    </div>
</div>