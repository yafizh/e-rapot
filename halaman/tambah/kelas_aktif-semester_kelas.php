<?php
$q = "
    SELECT 
        ka.id, 
        k.nama AS kelas, 
        ka.nama AS nama_kelas,
        ka.id_guru, 
        g.nama AS wali_kelas, 
        ka.tahun_pelajaran  
    FROM 
        kelas_aktif AS ka 
    INNER JOIN 
        kelas AS k 
    ON 
        k.id=ka.id_kelas 
    INNER JOIN 
        guru AS g 
    ON 
        g.id=ka.id_guru 
    WHERE 
        ka.id=" . $_GET['id_kelas_aktif'];
$kelas_aktif = $mysqli->query($q)->fetch_assoc();

$semua_semester = $mysqli->query("SELECT * FROM semester ORDER BY tingkat DESC")->fetch_all(MYSQLI_ASSOC);
$semester = $mysqli->query("SELECT * FROM semester WHERE id=" . $_GET['id_semester'])->fetch_assoc();
foreach ($semua_semester as $key => $value) {
    $semester_sekarang = $value['nama'];
    if ($semester['id'] == $value['id'] && $key == 0) {
        $semester_selanjutnya = false;
        break;
    }

    if ($semester['id'] == $value['id']) {
        $semester_selanjutnya = $semua_semester[$key - 1];
        break;
    }
}

$semua_kelas = $mysqli->query("SELECT * FROM kelas ORDER BY tingkat DESC")->fetch_all(MYSQLI_ASSOC);
foreach ($semua_kelas as $key => $value) {
    if ($_GET['id_kelas'] == $value['id'] && $key == 0) {
        $kelas_selanjutnya = false;
        break;
    }

    if ($_GET['id_kelas'] == $value['id']) {
        $kelas_selanjutnya = $semua_kelas[$key - 1];
        break;
    }
}



if (isset($_POST['semester_selesai'])) {
    $id_kelas_siswa = $_POST['id_kelas_siswa'];
    $id_kelas_siswa_lanjut_semester = [];
    foreach ($id_kelas_siswa as $i => $id) {
        if ($_POST['siswa' . $i]) {
            $id_kelas_siswa_lanjut_semester[] = $id;
        }
    }

    try {
        $mysqli->begin_transaction();

        $q = "
        UPDATE kelas_siswa SET 
            status='Tidak Aktif' 
        WHERE 
            id_kelas_aktif=" . $_GET['id_kelas_aktif'] . "
            AND 
            id NOT IN (" . implode(',', $id_kelas_siswa_lanjut_semester) . ")
        ";
        $mysqli->query($q);

        foreach ($id_kelas_siswa_lanjut_semester as $id) {
            $q = "
            INSERT INTO semester_kelas (
                id_kelas_siswa, 
                id_semester
            ) VALUES (
                " . $id . ",
                " . $semester_selanjutnya['id'] . " 
            )";
            $mysqli->query($q);
        }

        $mysqli->commit();
        echo "<script>location.href = '?h=lihat_kelas_aktif-siswa&id_kelas=" . $_GET['id_kelas'] . "&id_kelas_aktif=" . $_GET['id_kelas_aktif'] . "';</script>";
    } catch (\Throwable $e) {
        $mysqli->rollback();
        throw $e;
    };
}
if (isset($_POST['kelas_selesai'])) {
    $id_kelas_siswa = $_POST['id_kelas_siswa'] ?? [];
    $id_siswa = $_POST['id_siswa'] ?? [];
    $id_kelas_siswa_naik_kelas = [];
    $id_siswa_naik_kelas = [];
    for ($i = 0; $i < count($id_kelas_siswa); $i++) {
        if ($_POST['siswa' . $i]) {
            $id_kelas_siswa_naik_kelas[] = $id_kelas_siswa[$i];
            $id_siswa_naik_kelas[] = $id_siswa[$i];
        }
    }

    try {
        $mysqli->begin_transaction();

        $q = "
        UPDATE kelas_siswa SET 
            status='Tidak Naik Kelas' 
        WHERE 
            id_kelas_aktif=" . $_GET['id_kelas_aktif'] . "
            AND 
            id NOT IN (" . implode(',', $id_kelas_siswa_naik_kelas) . ")";
        $mysqli->query($q);

        $q = "
        UPDATE kelas_siswa SET 
            status='Naik Kelas' 
        WHERE 
            id_kelas_aktif=" . $_GET['id_kelas_aktif'] . "
            AND 
            id IN (" . implode(',', $id_kelas_siswa_naik_kelas) . ")";
        $mysqli->query($q);

        $q = "
        UPDATE kelas_aktif SET 
            status='Selesai' 
        WHERE 
            id=" . $_GET['id_kelas_aktif'];
        $mysqli->query($q);

        $tahun_pelajaran = (explode('/', $kelas_aktif['tahun_pelajaran'])[1]) . '/' . ((explode('/', $kelas_aktif['tahun_pelajaran'])[1]) + 1);
        $q = "
        INSERT INTO kelas_aktif (
            id_kelas,
            id_guru,
            nama,
            tahun_pelajaran,
            status 
        ) VALUES (
            " . $kelas_selanjutnya['id'] . ",
            " . $kelas_aktif['id_guru'] . ", 
            '" . $kelas_aktif['nama_kelas'] . "', 
            '$tahun_pelajaran', 
            'Aktif' 
        )
        ";
        $mysqli->query($q);

        $id_kelas_aktif = $mysqli->insert_id;
        foreach ($id_siswa_naik_kelas as $key => $value) {
            $q = "INSERT INTO kelas_siswa (
                id_kelas_aktif,
                id_siswa,
                status 
            ) VALUES (
                '" . $id_kelas_aktif . "',
                '" . $value . "',
                'Aktif' 
            )";
            $mysqli->query($q);

            $q = "
            INSERT INTO semester_kelas (
                id_kelas_siswa, 
                id_semester
            ) VALUES (
                " . $mysqli->insert_id . ",
                " . $semua_semester[count($semua_semester) - 1]['id'] . " 
            )";
            $mysqli->query($q);
        }

        $q = "
        INSERT INTO mata_pelajaran_kelas (
            id_kelas_aktif,
            id_mata_pelajaran,
            id_guru,
            kkm 
        ) SELECT 
            " . $id_kelas_aktif . ",
            id_mata_pelajaran, 
            id_guru,
            kkm 
        FROM 
            mata_pelajaran_kelas 
        WHERE 
            id_kelas_aktif=" . $_GET['id_kelas_aktif'] . "
        ";
        $mysqli->query($q);

        $mysqli->commit();
        echo "<script>location.href = '?h=kelas_aktif&id_kelas=" . $kelas_selanjutnya['id'] . "';</script>";
        exit;
    } catch (\Throwable $e) {
        $mysqli->rollback();
        throw $e;
    };


    echo "<script>location.href = '?h=lihat_kelas_aktif-siswa&id_kelas=" . $_GET['id_kelas'] . "&id_kelas_aktif=" . $_GET['id_kelas_aktif'] . "';</script>";
}

if (isset($_POST['lulus'])) {
    $id_kelas_siswa = $_POST['id_kelas_siswa'];
    $id_siswa = $_POST['id_siswa'];
    $id_kelas_siswa_lulus = [];
    $id_siswa_lulus = [];
    for ($i = 0; $i < count($id_kelas_siswa); $i++) {
        if ($_POST['siswa' . $i]) {
            $id_kelas_siswa_lulus[] = $id_kelas_siswa[$i];
            $id_siswa_lulus[] = $id_siswa[$i];
        }
    }

    try {
        $mysqli->begin_transaction();
        $user_guru = $mysqli->query("SELECT * FROM user_guru WHERE id_guru=" . $kelas_aktif['id_guru'])->fetch_assoc();
        $mysqli->query("DELETE FROM user WHERE id=" . $user_guru['id_user']);

        $q = "
        UPDATE siswa SET 
            status='Alumni' 
        WHERE  
            id IN (" . implode(',', $id_siswa_lulus) . ")";
        $mysqli->query($q);

        $q = "
        UPDATE kelas_siswa SET 
            status='Tidak Lulus' 
        WHERE 
            id_kelas_aktif=" . $_GET['id_kelas_aktif'] . "
            AND 
            id NOT IN (" . implode(',', $id_kelas_siswa_lulus) . ")";
        $mysqli->query($q);

        $q = "
        UPDATE kelas_siswa SET 
            status='Lulus' 
        WHERE 
            id_kelas_aktif=" . $_GET['id_kelas_aktif'] . "
            AND 
            id IN (" . implode(',', $id_kelas_siswa_lulus) . ")";
        $mysqli->query($q);

        $q = "
        UPDATE kelas_aktif SET 
            status='Selesai' 
        WHERE 
            id=" . $_GET['id_kelas_aktif'];
        $mysqli->query($q);

        $mysqli->commit();
    } catch (\Throwable $e) {
        $mysqli->rollback();
        throw $e;
    };


    echo "<script>location.href = '?h=lihat_kelas_selesai&id_kelas=" . $_GET['id_kelas'] . "&id_kelas_aktif=" . $_GET['id_kelas_aktif'] . "';</script>";
}
?>
<main class="content">
    <div class="container-fluid p-0">

        <div class="mb-3 text-center">
            <h1 class="h3 d-inline align-middle">Siswa Kelas <?= $kelas_aktif['kelas']; ?> <?= $kelas_aktif['nama_kelas']; ?> Semester <?= $semester['nama']; ?></h1>
        </div>

        <div class="row justify-content-center">
            <div class="col-12 col-xl-10">
                <div class="card">
                    <div class="card-body">
                        <?php
                        $q = "
                            SELECT 
                                sk.id id_semester_kelas,
                                ks.id id_kelas_siswa,
                                s.id id_siswa, 
                                s.nama, 
                                s.nis, 
                                s.nisn 
                            FROM 
                                kelas_siswa ks 
                            INNER JOIN 
                                siswa s 
                            ON 
                                s.id=ks.id_siswa 
                            INNER JOIN 
                                semester_kelas sk 
                            ON 
                                ks.id=sk.id_kelas_siswa  
                            WHERE 
                                ks.id_kelas_aktif=" . $_GET['id_kelas_aktif'] . " 
                                AND 
                                sk.id_semester=" . $_GET['id_semester'] . "
                            ORDER BY 
                                s.nama 
                            ";
                        $result = $mysqli->query($q);
                        $no = 0;
                        ?>
                        <form action="" method="POST">
                            <table class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center td-fit">No</th>
                                        <th class="text-center">NIS/NISN</th>
                                        <th class="text-center">Nama</th>
                                        <?php if ($kelas_selanjutnya || $semester_selanjutnya) : ?>
                                            <?php if ($semester_selanjutnya) : ?>
                                                <th class="text-center td-fit">Lanjut Semester</th>
                                            <?php else : ?>
                                                <th class="text-center td-fit">Naik Kelas</th>
                                            <?php endif; ?>
                                        <?php else : ?>
                                            <th class="text-center td-fit">Lulus</th>
                                        <?php endif; ?>
                                        <th class="text-center td-fit">Rapot</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = $result->fetch_assoc()) : ?>
                                        <tr>
                                            <td class="text-center td-fit"><?= ++$no; ?></td>
                                            <td class="text-center"><?= $row['nis']; ?>/<?= $row['nisn']; ?></td>
                                            <td><?= $row['nama']; ?></td>
                                            <td class="text-center td-fit">
                                                <label class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="siswa<?= $no - 1 ?>" value="0">
                                                    <span class="form-check-label">
                                                        Tidak
                                                    </span>
                                                </label>
                                                <label class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="siswa<?= $no - 1 ?>" value="1" checked>
                                                    <span class="form-check-label">
                                                        Ya
                                                    </span>
                                                </label>
                                                <input type="text" name="id_kelas_siswa[]" value="<?= $row['id_kelas_siswa']; ?>" hidden>
                                                <input type="text" name="id_siswa[]" value="<?= $row['id_siswa']; ?>" hidden>
                                            </td>
                                            <td class="text-center td-fit">
                                                <a href="halaman/cetak/rapot.php?id_semester_kelas=<?= $row['id_semester_kelas']; ?>" class="btn btn-info btn-sm" target="_blank">Semester <?= $semester_sekarang; ?></a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                            <a href="?h=lihat_kelas_aktif-siswa&id_kelas=<?= $_GET['id_kelas'] ?>&id_kelas_aktif=<?= $_GET['id_kelas_aktif'] ?>" class="btn btn-secondary float-start">Kembali</a>

                            <?php if ($kelas_selanjutnya || $semester_selanjutnya) : ?>
                                <?php if ($semester_selanjutnya) : ?>
                                    <input type="text" name="semester_selesai" value="1" hidden>
                                    <button type="button" class="btn btn-success float-end" data-bs-toggle="modal" data-bs-target="#modalSemesterSelesai" data-semester="<?= $semester['nama']; ?>">Semester Selesai</button>
                                <?php else : ?>
                                    <input type="text" name="kelas_selesai" value="1" hidden>
                                    <button type="button" class="btn btn-success float-end" data-bs-toggle="modal" data-bs-target="#modalKelasSelesai" data-kelas="<?= $kelas_aktif['kelas']; ?>">Kelas Selesai</button>
                                <?php endif; ?>
                            <?php else : ?>
                                <input type="text" name="lulus" value="1" hidden>
                                <button type="button" class="btn btn-success float-end" data-bs-toggle="modal" data-bs-target="#modalKelasSelesai" data-kelas="<?= $kelas_aktif['kelas']; ?>">Lulus</button>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>
<div class="modal fade" id="modalSemesterSelesai" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body m-3">
                <p class="mb-0"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button id="btn-semester-selesai" type="button" class="btn btn-primary">Mengerti</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalKelasSelesai" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body m-3">
                <p class="mb-0"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button id="btn-kelas-selesai" type="button" class="btn btn-primary">Mengerti</button>
            </div>
        </div>
    </div>
</div>
<script>
    if (document.querySelector("button[data-bs-target='#modalSemesterSelesai']")) {
        document.querySelector("button[data-bs-target='#modalSemesterSelesai']").addEventListener('click', function() {
            document.querySelector('#modalSemesterSelesai .modal-body p').innerHTML = `
            Dengan menyatakan <strong>Semester ${this.getAttribute('data-semester')}</strong> telah selesai, maka wali kelas tidak dapat lagi mengisi rapot kepada seluruh siswa yang berada di <strong>Semester ${this.getAttribute('data-semester')}</strong>.
        `;
            document.querySelector("#btn-semester-selesai").addEventListener('click', () => document.querySelector('form').submit());
        });
    }
    if (document.querySelector("button[data-bs-target='#modalKelasSelesai']")) {
        document.querySelector("button[data-bs-target='#modalKelasSelesai']").addEventListener('click', function() {
            document.querySelector('#modalKelasSelesai .modal-body p').innerHTML = `
            Dengan menyatakan <strong>Kelas ${this.getAttribute('data-kelas')}</strong> telah selesai, maka wali kelas tidak dapat lagi mengisi rapot kepada seluruh siswa yang berada di <strong>Kelas ${this.getAttribute('data-kelas')}</strong>.
        `;
            document.querySelector("#btn-kelas-selesai").addEventListener('click', () => document.querySelector('form').submit());
        });
    }
</script>