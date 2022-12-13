<?php
$q = "
    SELECT 
        ka.id, 
        k.nama AS kelas, 
        ka.nama AS nama_kelas, 
        g.nama AS wali_kelas 
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

if (isset($_POST['submit'])) {
    $id_siswa = $_POST['id_siswa'];

    $siswa_dalam_kelas['result'] = $mysqli->query("SELECT * FROM kelas_siswa WHERE id_kelas_aktif=" . $_GET['id_kelas_aktif']);
    $siswa_dalam_kelas['data'] = [];
    while ($row = $siswa_dalam_kelas['result']->fetch_assoc()) {
        $siswa_dalam_kelas['data'][] = $row['id_siswa'];
    }

    foreach ($id_siswa as $key => $value) {
        if (!in_array($value, $siswa_dalam_kelas['data'])) {
            $q = "
            INSERT INTO kelas_siswa (
                id_kelas_aktif,
                id_siswa,
                status 
            ) VALUES (
                '" . $kelas_aktif['id'] . "',
                '$value',
                'Aktif' 
            )";

            if ($mysqli->query($q)) {
                $q = "INSERT INTO semester_kelas (id_kelas_siswa, id_semester) VALUES (" . $mysqli->insert_id . ", " . $_GET['id_semester'] . ")";
                if (!$mysqli->query($q)) die($mysqli->error);
            } else
                die($mysqli->error);
        } else {
            $q = "
                UPDATE kelas_siswa SET
                    status='Aktif' 
                WHERE 
                    id_kelas_aktif='" . $kelas_aktif['id'] . "' 
                    AND 
                    id_siswa='$value'";

            if ($mysqli->query($q)) {
                $q = "
                    INSERT INTO semester_kelas (
                        id_kelas_siswa, 
                        id_semester
                    ) VALUES (
                        (SELECT id FROM kelas_siswa WHERE id_kelas_aktif=" . $kelas_aktif['id'] . " AND id_siswa=$value), 
                        " . $_GET['id_semester'] . "
                    )";
                if (!$mysqli->query($q)) die($mysqli->error);
            } else
                die($mysqli->error);
        }
    }

    $_SESSION['tambah_data'] =  true;
    echo "<script>location.href = '?h=lihat_kelas_aktif-siswa&id_kelas=" . $_GET['id_kelas'] . "&id_kelas_aktif=" . $_GET['id_kelas_aktif'] . "';</script>";
}
?>
<main class="content">
    <div class="container-fluid p-0">

        <div class="mb-3 text-center">
            <h1 class="h3 d-inline align-middle">Tambah Siswa Kelas <?= $kelas_aktif['kelas']; ?> <?= $kelas_aktif['nama_kelas']; ?></h1>
        </div>

        <div class="row justify-content-center">
            <div class="col-12 col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="mb-3">
                                <label class="form-label">Kelas</label>
                                <input type="text" disabled class="form-control" value="<?= $kelas_aktif['kelas']; ?> <?= $kelas_aktif['nama_kelas']; ?>">
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
                                        id NOT IN (SELECT id_siswa FROM kelas_siswa WHERE status='Aktif') 
                                        AND 
                                        id IN (SELECT id FROM siswa WHERE status='Aktif') 
                                    ORDER BY 
                                        nama";
                                $siswa = $mysqli->query($query); ?>
                                <select name="id_siswa[]" required class="form-control choices-multiple" multiple>
                                    <?php while ($row = $siswa->fetch_assoc()) : ?>
                                        <option value="<?= $row['id']; ?>"><?= $row['nama'] ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <a href="?h=lihat_kelas_aktif-siswa&id_kelas=<?= $_GET['id_kelas'] ?>&id_kelas_aktif=<?= $_GET['id_kelas_aktif'] ?>" class="btn btn-secondary float-start">Kembali</a>
                            <button type="submit" name="submit" class="btn btn-primary float-end">Tambah</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>