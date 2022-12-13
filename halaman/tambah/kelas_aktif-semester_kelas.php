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
    $q = "
        UPDATE kelas_siswa SET 
            status='Tidak Aktif' 
        WHERE 
            id_kelas_aktif=" . $_GET['id_kelas_aktif'] . "
            AND 
            id NOT IN (" . implode(',', $id_kelas_siswa) . ")
        ";
    if ($mysqli->query($q)) {
        foreach ($id_kelas_siswa as $key => $value) {
            $q = "
            INSERT INTO semester_kelas (
                id_kelas_siswa, 
                id_semester
            ) VALUES (
                " . $value . ",
                " . $semester_selanjutnya['id'] . " 
            )";
            if (!$mysqli->query($q)) die($mysqli->error);
        }
    } else
        die($mysqli->error);


    echo "<script>location.href = '?h=lihat_kelas_aktif-siswa&id_kelas=" . $_GET['id_kelas'] . "&id_kelas_aktif=" . $_GET['id_kelas_aktif'] . "';</script>";
}
if (isset($_POST['kelas_selesai'])) {
    $id_kelas_siswa_checkbox = $_POST['id_kelas_siswa_checkbox'];
    $id_kelas_siswa = $_POST['id_kelas_siswa'];
    $id_siswa = $_POST['id_siswa'];

    try {
        $mysqli->begin_transaction();

        $q = "
        UPDATE kelas_siswa SET 
            status='Tidak Naik Kelas' 
        WHERE 
            id_kelas_aktif=" . $_GET['id_kelas_aktif'] . "
            AND 
            id NOT IN (" . implode(',', $id_kelas_siswa_checkbox) . ")";
        $mysqli->query($q);

        $q = "
        UPDATE kelas_siswa SET 
            status='Naik Kelas' 
        WHERE 
            id_kelas_aktif=" . $_GET['id_kelas_aktif'] . "
            AND 
            id IN (" . implode(',', $id_kelas_siswa_checkbox) . ")";
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
        foreach ($id_kelas_siswa_checkbox as $key => $value) {
            $q = "INSERT INTO kelas_siswa (
                id_kelas_aktif,
                id_siswa,
                status 
            ) VALUES (
                '" . $id_kelas_aktif . "',
                '" . $id_siswa[array_search($value, $id_kelas_siswa)] . "',
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

        $mysqli->commit();
    } catch (\Throwable $e) {
        $mysqli->rollback();
        throw $e; // but the error must be handled anyway
    };


    echo "<script>location.href = '?h=lihat_kelas_aktif-siswa&id_kelas=" . $_GET['id_kelas'] . "&id_kelas_aktif=" . $_GET['id_kelas_aktif'] . "';</script>";
}

if (isset($_POST['lulus'])) {
    $id_kelas_siswa_checkbox = $_POST['id_kelas_siswa_checkbox'];
    $id_kelas_siswa = $_POST['id_kelas_siswa'];
    $id_siswa = $_POST['id_siswa'];

    try {
        $mysqli->begin_transaction();
        foreach ($id_kelas_siswa_checkbox as $key => $value) {
            $q = "
                UPDATE siswa SET 
                    status='Alumni' 
                WHERE  
                    id=" . $id_siswa[array_search($value, $id_kelas_siswa)];
            $mysqli->query($q);
        }

        $q = "
        UPDATE kelas_siswa SET 
            status='Tidak Lulus' 
        WHERE 
            id_kelas_aktif=" . $_GET['id_kelas_aktif'] . "
            AND 
            id NOT IN (" . implode(',', $id_kelas_siswa_checkbox) . ")";
        $mysqli->query($q);

        $q = "
        UPDATE kelas_siswa SET 
            status='Lulus' 
        WHERE 
            id_kelas_aktif=" . $_GET['id_kelas_aktif'] . "
            AND 
            id IN (" . implode(',', $id_kelas_siswa_checkbox) . ")";
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
        throw $e; // but the error must be handled anyway
    };


    echo "<script>location.href = '?h=lihat_kelas_aktif-siswa&id_kelas=" . $_GET['id_kelas'] . "&id_kelas_aktif=" . $_GET['id_kelas_aktif'] . "';</script>";
}
?>
<main class="content">
    <div class="container-fluid p-0">

        <div class="mb-3 text-center">
            <h1 class="h3 d-inline align-middle">Siswa Kelas <?= $kelas_aktif['kelas']; ?> <?= $kelas_aktif['nama_kelas']; ?> Semester <?= $semester['nama']; ?></h1>
        </div>

        <div class="row justify-content-center">
            <?php if ($kelas_selanjutnya || $semester_selanjutnya) : ?>
                <?php if ($semester_selanjutnya) : ?>
                    <div class="col-12 col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <?php
                                $q = "
                                SELECT 
                                    sk.id AS id_semester_kelas,
                                    ks.id AS id_kelas_siswa,
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
                                    ks.id=sk.id_kelas_siswa  
                                WHERE 
                                    ks.id_kelas_aktif=" . $_GET['id_kelas_aktif'] . " 
                                    AND 
                                    sk.id_semester=" . $_GET['id_semester'] . "
                                ORDER BY 
                                    s.nama 
                            ";
                                $result = $mysqli->query($q);
                                $no = 1;
                                ?>
                                <form action="" method="POST">
                                    <table class="table table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th class="text-center td-fit">No</th>
                                                <th class="text-center">Nama</th>
                                                <th class="text-center td-fit">Lanjut Semester</th>
                                                <th class="text-center td-fit">Rapot <?= $semester['nama']; ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($row = $result->fetch_assoc()) : ?>
                                                <tr>
                                                    <td class="text-center td-fit"><?= $no++; ?></td>
                                                    <td><?= $row['nama']; ?></td>
                                                    <td class="text-center">
                                                        <input class="form-check-input" type="checkbox" name="id_kelas_siswa[]" value="<?= $row['id_kelas_siswa']; ?>" checked>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="halaman/cetak/rapot.php?id_semester_kelas=<?= $row['id_semester_kelas']; ?>" class="btn btn-info btn-sm" target="_blank">Lihat</a>
                                                    </td>
                                                </tr>
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                    <a href="?h=lihat_kelas_aktif-siswa&id_kelas=<?= $_GET['id_kelas'] ?>&id_kelas_aktif=<?= $_GET['id_kelas_aktif'] ?>" class="btn btn-secondary float-start">Kembali</a>
                                    <button type="submit" name="semester_selesai" class="btn btn-success float-end">Semester Selesai</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php else : ?>
                    <div class="col-12 col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <?php
                                $q = "
                                SELECT
                                    s.id AS id_siswa,
                                    ks.id AS id_kelas_siswa,
                                    s.nama 
                                FROM 
                                    kelas_siswa AS ks
                                INNER JOIN 
                                    siswa AS s 
                                ON 
                                    s.id=ks.id_siswa 
                                WHERE 
                                    ks.id_kelas_aktif=" . $_GET['id_kelas_aktif'] . " 
                                ORDER BY 
                                    s.nama 
                            ";
                                $result = $mysqli->query($q);
                                $no = 1;
                                ?>
                                <form action="" method="POST">
                                    <table class="table table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th class="text-center td-fit">No</th>
                                                <th class="text-center">Nama</th>
                                                <th class="text-center td-fit">Naik Kelas</th>
                                                <th class="text-center">Rapot</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($row = $result->fetch_assoc()) : ?>
                                                <tr>
                                                    <td class="text-center td-fit"><?= $no++; ?></td>
                                                    <td><?= $row['nama']; ?></td>
                                                    <td class="text-center">
                                                        <input class="form-check-input" type="checkbox" name="id_kelas_siswa_checkbox[]" value="<?= $row['id_kelas_siswa']; ?>" checked>
                                                        <input type="text" name="id_kelas_siswa[]" value="<?= $row['id_kelas_siswa']; ?>" hidden>
                                                        <input type="text" name="id_siswa[]" value="<?= $row['id_siswa']; ?>" hidden>
                                                    </td>
                                                    <td class="text-center td-fit">
                                                        <?php
                                                        $q = "
                                                        SELECT 
                                                            sk.id,
                                                            s.nama  
                                                        FROM 
                                                            semester_kelas AS sk 
                                                        INNER JOIN 
                                                            semester AS s 
                                                        ON 
                                                            s.id=sk.id_semester 
                                                        WHERE 
                                                            sk.id_semester <= " . $semester['id'] . " 
                                                            AND 
                                                            sk.id_kelas_siswa = " . $row['id_kelas_siswa'] . " 
                                                        ORDER BY 
                                                            s.id ASC
                                                        ";
                                                        $result2 = $mysqli->query($q);
                                                        ?>
                                                        <?php while ($row2 = $result2->fetch_assoc()) : ?>
                                                            <a href="halaman/cetak/rapot.php?id_semester_kelas=<?= $row['id_kelas_siswa']; ?>" class="btn btn-info btn-sm" target="_blank">Semester <?= $row2['nama']; ?></a>
                                                        <?php endwhile; ?>
                                                    </td>
                                                </tr>
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                    <a href="?h=lihat_kelas_aktif-siswa&id_kelas=<?= $_GET['id_kelas'] ?>&id_kelas_aktif=<?= $_GET['id_kelas_aktif'] ?>" class="btn btn-secondary float-start">Kembali</a>
                                    <button type="submit" name="kelas_selesai" class="btn btn-success float-end">Kelas Selesai</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php else : ?>
                <div class="col-12 col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <?php
                            $q = "
                                SELECT
                                    s.id AS id_siswa,
                                    ks.id AS id_kelas_siswa,
                                    s.nama 
                                FROM 
                                    kelas_siswa AS ks
                                INNER JOIN 
                                    siswa AS s 
                                ON 
                                    s.id=ks.id_siswa 
                                WHERE 
                                    ks.id_kelas_aktif=" . $_GET['id_kelas_aktif'] . " 
                                ORDER BY 
                                    s.nama 
                            ";
                            $result = $mysqli->query($q);
                            $no = 1;
                            ?>
                            <form action="" method="POST">
                                <table class="table table-striped" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center td-fit">No</th>
                                            <th class="text-center">Nama</th>
                                            <th class="text-center td-fit">Lulus</th>
                                            <th class="text-center">Rapot</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = $result->fetch_assoc()) : ?>
                                            <tr>
                                                <td class="text-center td-fit"><?= $no++; ?></td>
                                                <td><?= $row['nama']; ?></td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" name="id_kelas_siswa_checkbox[]" value="<?= $row['id_kelas_siswa']; ?>" checked>
                                                    <input type="text" name="id_kelas_siswa[]" value="<?= $row['id_kelas_siswa']; ?>" hidden>
                                                    <input type="text" name="id_siswa[]" value="<?= $row['id_siswa']; ?>" hidden>
                                                </td>
                                                <td class="text-center td-fit">
                                                    <?php
                                                    $q = "
                                                        SELECT 
                                                            sk.id,
                                                            s.nama  
                                                        FROM 
                                                            semester_kelas AS sk 
                                                        INNER JOIN 
                                                            semester AS s 
                                                        ON 
                                                            s.id=sk.id_semester 
                                                        WHERE 
                                                            sk.id_semester <= " . $semester['id'] . " 
                                                            AND 
                                                            sk.id_kelas_siswa = " . $row['id_kelas_siswa'] . " 
                                                        ORDER BY 
                                                            s.id ASC
                                                        ";
                                                    $result2 = $mysqli->query($q);
                                                    ?>
                                                    <?php while ($row2 = $result2->fetch_assoc()) : ?>
                                                        <a href="halaman/cetak/rapot.php?id_semester_kelas=<?= $row['id_kelas_siswa']; ?>" class="btn btn-info btn-sm" target="_blank">Semester <?= $row2['nama']; ?></a>
                                                    <?php endwhile; ?>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                                <a href="?h=lihat_kelas_aktif-siswa&id_kelas=<?= $_GET['id_kelas'] ?>&id_kelas_aktif=<?= $_GET['id_kelas_aktif'] ?>" class="btn btn-secondary float-start">Kembali</a>
                                <button type="submit" name="lulus" class="btn btn-success float-end">Lulus</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

    </div>
</main>