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
    <?php
    $q = "
        SELECT 
            s.nama,
            u.terakhir_login 
        FROM 
            siswa s 
        INNER JOIN 
            user_siswa us 
        ON 
            us.id_siswa=s.id 
        INNER JOIN 
            user u 
        ON 
            u.id=us.id_user";
    $data = $mysqli->query($q);
    $start_date = new DateTime(Date("Y-m-d H:i:s"));
    ?>
    <div class="card">
        <div class="card-header">Pengguna Aktif</div>
        <div class="card-body">
            <?php while ($row = $data->fetch_assoc()) : ?>
                <?php
                if (is_null($row['terakhir_login'])) {
                    $since_start = false;
                } else {
                    $since_start = $start_date->diff(new DateTime($row['terakhir_login']));
                }
                ?>
                <?php if (($since_start->i ?? 10) < 5) : ?>
                    <div>
                        <h5 class="mb-0"><?= $row['nama']; ?></h5>
                        <?php if ($since_start->i == 0) : ?>
                            <h6 class="text-muted">baru saja</h6>
                        <?php else : ?>
                            <h6 class="text-muted"><?= $since_start->i; ?> menit yang lalu</h6>
                        <?php endif; ?>
                    </div>
                    <hr>
                <?php endif; ?>
            <?php endwhile; ?>
        </div>
    </div>
</div>