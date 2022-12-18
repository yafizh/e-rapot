<?php $guru = $mysqli->query("SELECT * FROM guru WHERE id=" . $_SESSION['user']['id_guru'])->fetch_assoc(); ?>
<?php $semester = $mysqli->query("SELECT * FROM semester ORDER BY tingkat DESC")->fetch_all(MYSQLI_ASSOC); ?>
<?php
$q = "
    SELECT 
        ka.*,
        k.nama kelas  
    FROM 
        kelas_aktif ka 
    INNER JOIN 
        kelas k 
    ON 
        k.id=ka.id_kelas 
    WHERE 
        ka.id_guru=" . $_SESSION['user']['id_guru'] . " 
    ORDER BY 
        ka.tahun_pelajaran 
    DESC";
$riwayat_wali_kelas = $mysqli->query($q)->fetch_all(MYSQLI_ASSOC);
?>
<?php
$q = "
        SELECT 
            ka.*,
            k.nama AS kelas 
        FROM 
            kelas_aktif AS ka 
        INNER JOIN 
            kelas AS k 
        ON 
            k.id=ka.id_kelas 
        WHERE 
            ka.id=" . ($_GET['id_kelas_aktif'] ?? $riwayat_wali_kelas[0]['id']) . "
    ";
$kelas_aktif = $mysqli->query($q)->fetch_assoc(); ?>
<?php
$data = [];
$latest_semester = true;
foreach ($semester as $value) {
    $query = "
            SELECT 
                sk.id AS id_semester_kelas,
                ks.id,
                ks.status,
                s.id AS id_siswa,
                s.nama 
            FROM 
                kelas_siswa AS ks 
            INNER JOIN 
                siswa AS s 
            ON 
                s.id=ks.id_siswa 
            INNER JOIN 
                semester_kelas AS sk 
            ON 
                sk.id_kelas_siswa=ks.id  
            WHERE 
                ks.id_kelas_aktif=" . ($_GET['id_kelas_aktif'] ?? $riwayat_wali_kelas[0]['id']) . " 
                AND 
                sk.id_semester=" . $value['id'] . "
            ORDER BY 
                s.nama 
        ";
    $data[] = $mysqli->query($query)->fetch_all(MYSQLI_ASSOC);
}
?>
<main class="content">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-12 col-sm-6 col-md-5 col-xl-3">
                <div class="card mb-3">
                    <div class="card-body text-center">
                        <img src="<?= $guru['foto']; ?>" onerror="imageError(this)" class="img-fluid rounded-circle mb-2" width="180" height="180">
                        <h5 class="card-title mb-0"><?= $guru['nama']; ?></h5>
                        <div class="text-muted mb-2">Wali Kelas</div>
                    </div>
                    <hr class="my-0">
                    <div class="card-body">
                        <h5 class="h6 card-title text-center">Mata Pelajaran Kelas</h5>
                        <div class="text-center">
                            <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#modalMataPelajaran">Lihat Mata Pelajaran Kelas</button>
                            <div class="modal fade" id="modalMataPelajaran" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Mata Pelajaran Kelas <?= $kelas_aktif['kelas']; ?> <?= $kelas_aktif['nama']; ?> Tahun Pelajaran <?= $kelas_aktif['tahun_pelajaran']; ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body m-3">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">No</th>
                                                        <th class="text-center">NIP</th>
                                                        <th class="text-center">Pengajar</th>
                                                        <th class="text-center">Mata Pelajaran</th>
                                                        <th class="text-center">KKM</th>
                                                    </tr>
                                                </thead>
                                                <?php
                                                $q = "
                                                    SELECT 
                                                        mpk.id,
                                                        mpk.kkm,
                                                        mp.nama AS mata_pelajaran,
                                                        g.nama AS pengajar,
                                                        g.nip 
                                                    FROM 
                                                        mata_pelajaran_kelas AS mpk 
                                                    INNER JOIN 
                                                        mata_pelajaran AS mp 
                                                    ON 
                                                        mp.id=mpk.id_mata_pelajaran 
                                                    INNER JOIN 
                                                        guru AS g 
                                                    ON 
                                                        g.id=mpk.id_guru 
                                                    WHERE 
                                                        mpk.id_kelas_aktif=" . ($_GET['id_kelas_aktif'] ?? $riwayat_wali_kelas[0]['id']) . " 
                                                    ORDER BY 
                                                        mp.nama 
                                                ";
                                                $result = $mysqli->query($q);
                                                $no = 1;
                                                ?>
                                                <tbody>
                                                    <?php while ($row = $result->fetch_assoc()) : ?>
                                                        <tr>
                                                            <td class="text-center td-fit"><?= $no++; ?></td>
                                                            <td class="text-center td-fit"><?= $row['nip']; ?></td>
                                                            <td class="text-start"><?= $row['pengajar']; ?></td>
                                                            <td class="text-center"><?= $row['mata_pelajaran']; ?></td>
                                                            <td class="text-center td-fit"><?= $row['kkm']; ?></td>
                                                        </tr>
                                                    <?php endwhile; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="my-0">
                    <div class="card-body">
                        <h5 class="h6 card-title text-center">Riwayat Sebagai Wali Kelas</h5>
                        <table class="table table-hover" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th class="text-center">Tahun Pelajaran</th>
                                    <th class="text-center">Kelas</th>
                                </tr>
                            </thead>
                            <tbody id="riwayat_sebagai_wali_kelas">
                                <?php foreach ($riwayat_wali_kelas as $i => $value) : ?>
                                    <?php if (($_GET['id_kelas_aktif'] ?? $riwayat_wali_kelas[0]['id']) == $value['id']) : ?>
                                        <tr data-id_kelas_aktif="<?= $value['id']; ?>" style="background-color: #D9D9D9; cursor: pointer;">
                                            <td class="text-center"><?= $value['tahun_pelajaran']; ?></td>
                                            <td class="text-center">1 A</td>
                                        </tr>
                                    <?php else : ?>
                                        <tr data-id_kelas_aktif="<?= $value['id']; ?>" style="cursor: pointer;">
                                            <td class="text-center"><?= $value['tahun_pelajaran']; ?></td>
                                            <td class="text-center">1 A</td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </tbody>
                            <script>
                                document.querySelectorAll('#riwayat_sebagai_wali_kelas tr').forEach((element, index) => {
                                    element.addEventListener('click', () => {
                                        location.href = `index.php?id_kelas_aktif=${element.getAttribute('data-id_kelas_aktif')}`;
                                    });
                                });
                            </script>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md">
                <div class="row mb-3">
                    <div class="col">
                        <h1 class="h3 d-inline">Tahun Pelajaran <?= $kelas_aktif['tahun_pelajaran']; ?> Kelas <?= $kelas_aktif['kelas']; ?> <?= $kelas_aktif['nama']; ?></h1>
                    </div>
                </div>
                <div class="row">
                    <?php foreach ($data as $i => $siswa_kelas) : ?>
                        <!-- Jika Datanya kosong -->
                        <?php if (empty($siswa_kelas) && $i < (count($data) - 1)) : ?>
                            <?php continue; ?>
                        <?php endif; ?>
                        <div class="col-12 col-xl-6">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <h5 class="card-title mb-0 align-self-center">Semester <?= $semester[$i]['nama']; ?></h5>
                                    <div>
                                        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modalLihatPeringkatSemester<?= $semester[$i]['id']; ?>">
                                            Lihat Peringkat
                                        </button>
                                        <div class="modal fade" id="modalLihatPeringkatSemester<?= $semester[$i]['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Peringkat Siswa Semester <?= $semester[$i]['nama']; ?></h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body m-3">
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th class="text-center">NIS/NISN</th>
                                                                    <th class="text-center">Nama</th>
                                                                    <th class="text-center">Total Nilai</th>
                                                                    <th class="text-center">Rata - Rata</th>
                                                                    <th class="text-center">Peringkat</th>
                                                                    <th class="text-center">Rapot</th>
                                                                </tr>
                                                            </thead>
                                                            <?php
                                                            $q = "
                                                            SELECT 
                                                                s.nis,
                                                                s.nisn,
                                                                s.nama,
                                                                sk.id AS id_semester_kelas,
                                                                IFNULL(SUM(ns.nilai), 0) AS total_nilai, 
                                                                IFNULL((SUM(ns.nilai)/COUNT(ns.id)), 0) AS rata_rata 
                                                            FROM 
                                                                kelas_aktif AS ka 
                                                            INNER JOIN 
                                                                kelas_siswa AS ks 
                                                            ON 
                                                                ks.id_kelas_aktif=ka.id 
                                                            INNER JOIN 
                                                                siswa AS s 
                                                            ON 
                                                                s.id=ks.id_siswa 
                                                            LEFT JOIN 
                                                                semester_kelas AS sk 
                                                            ON 
                                                                sk.id_kelas_siswa=ks.id 
                                                            LEFT JOIN 
                                                                nilai_siswa AS ns 
                                                            ON 
                                                                ns.id_semester_kelas=sk.id 
                                                            WHERE
                                                                sk.id_semester=" . $semester[$i]['id'] . " 
                                                                AND 
                                                                ka.id=" . ($_GET['id_kelas_aktif'] ?? $riwayat_wali_kelas[0]['id']) . "
                                                            GROUP BY 
                                                                sk.id 
                                                            ORDER BY 
                                                                rata_rata DESC
                                                                ";
                                                            $result = $mysqli->query($q);
                                                            $peringkat = 1;
                                                            ?>
                                                            <tbody>
                                                                <?php while ($row = $result->fetch_assoc()) : ?>
                                                                    <tr>
                                                                        <td class="text-center"><?= $row['nis']; ?>/<?= $row['nisn']; ?></td>
                                                                        <td><?= $row['nama']; ?></td>
                                                                        <td class="text-center"><?= $row['total_nilai']; ?></td>
                                                                        <td class="text-center"><?= $row['rata_rata']; ?></td>
                                                                        <td class="text-center td-fit"><?= $peringkat++; ?></td>
                                                                        <td class="text-center td-fit">
                                                                            <a href="halaman/cetak/rapot.php?id_semester_kelas=<?= $row['id_semester_kelas']; ?>" class="btn btn-info btn-sm" target="_blank">Lihat</a>
                                                                        </td>
                                                                    </tr>
                                                                <?php endwhile; ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table class="table" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th class="text-center td-fit">No</th>
                                                <th class="text-center td-fit">NIS/NISN</th>
                                                <th class="text-center">Nama</th>
                                                <?php if ($latest_semester && $kelas_aktif['status'] == 'Aktif') : ?>
                                                    <th class="text-center td-fit">Aksi</th>
                                                <?php endif; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($semester as $value_semester) : ?>
                                                <?php
                                                $q = "
                                                SELECT 
                                                    sk.id AS id_semester_kelas,
                                                    ks.id,
                                                    ks.status,
                                                    s.id AS id_siswa,
                                                    s.nis,
                                                    s.nisn,
                                                    s.nama
                                                FROM 
                                                    kelas_siswa AS ks 
                                                INNER JOIN 
                                                    siswa AS s 
                                                ON 
                                                    s.id=ks.id_siswa 
                                                INNER JOIN 
                                                    semester_kelas AS sk 
                                                ON 
                                                    sk.id_kelas_siswa=ks.id  
                                                WHERE 
                                                    ks.id_kelas_aktif=" . ($_GET['id_kelas_aktif'] ?? $riwayat_wali_kelas[0]['id']) . " 
                                                    AND 
                                                    sk.id_semester=" . $value_semester['id'] . "
                                                ORDER BY 
                                                    s.nama 
                                                ";
                                                $result = $mysqli->query($q);
                                                $no = 1;
                                                ?>
                                                <?php if ($result->num_rows) : ?>
                                                    <?php while ($row = $result->fetch_assoc()) : ?>
                                                        <tr>
                                                            <td class="text-center td-fit"><?= $no++; ?></td>
                                                            <td class="text-center"><?= $row['nis']; ?>/<?= $row['nisn'] ?></td>
                                                            <td><?= $row['nama']; ?></td>
                                                            <?php if ($latest_semester && $kelas_aktif['status'] == 'Aktif') : ?>
                                                                <td class="text-center td-fit">
                                                                    <a href="?h=input_nilai&id_semester_kelas=<?= $row['id_semester_kelas']; ?>" class="btn btn-sm btn-info">Nilai</a>
                                                                </td>
                                                            <?php endif; ?>
                                                        </tr>
                                                    <?php endwhile; ?>
                                                    <?php break; ?>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <?php $latest_semester = false; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</main>