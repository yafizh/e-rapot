<?php

if (isset($_POST['submit'])) {
    $nilai = $_POST['nilai'];
    $id_siswa = $_POST['id_siswa'];

    $check = $mysqli->query("SELECT * FROM tugas_siswa WHERE id_siswa=$id_siswa AND id_tugas_mata_pelajaran_kelas=" . $_GET['idd']);
    if ($check->num_rows) {
        $a = $check->fetch_assoc();
        $mysqli->query("UPDATE tugas_siswa SET nilai=$nilai WHERE id=" . $a['id']);
    } else {
        $mysqli->query("INSERT INTO tugas_siswa VALUES (NULL, $id_siswa, " . $_GET['idd'] . ", '" . Date("Y-m-d") . "', NULL, $nilai)");
    }
}

?>
<main class="content">
    <div class="container-fluid p-0">
        <h1 class="mb-3">Halaman Tugas</h1>
        <div class="row">
            <div class="col-12">
                <?php
                $q = "
                    SELECT 
                        s.nis,
                        s.nisn,
                        s.nama,
                        ks.id_siswa,
                        (
                            SELECT 
                                ps.file
                            FROM 
                                tugas_siswa ps 
                            WHERE 
                                ps.id_siswa=s.id  
                                AND 
                                ps.id_tugas_mata_pelajaran_kelas=" . $_GET['idd'] . " 
                        ) file,
                        (
                            SELECT 
                                ps.nilai
                            FROM 
                                tugas_siswa ps 
                            WHERE 
                                ps.id_siswa=s.id  
                                AND 
                                ps.id_tugas_mata_pelajaran_kelas=" . $_GET['idd'] . " 
                        ) nilai
                    FROM 
                        kelas_siswa ks 
                    INNER JOIN 
                        siswa s 
                    ON 
                        s.id=ks.id_siswa 
                    INNER JOIN 
                        kelas_aktif ka 
                    ON 
                        ka.id=ks.id_kelas_aktif 
                    INNER JOIN 
                        mata_pelajaran_kelas mpk 
                    ON 
                        mpk.id_kelas_aktif=ka.id 
                    INNER JOIN 
                        tugas_mata_pelajaran_kelas pmpk 
                    ON 
                        pmpk.id_mata_pelajaran_kelas=mpk.id 
                    WHERE 
                        mpk.id=" . $_GET['id'] . " 
                        AND 
                        pmpk.id=" . $_GET['idd'] . "
                ";
                $result = $mysqli->query($q);
                $no = 1;
                ?>
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h3>Tugas Siswa</h3>
                        <div class="d-flex gap-2">
                            <a href="halaman/cetak/tugas.php?id=<?= $_GET['idd']; ?>" target="_blank" class="btn btn-info">Cetak</a>
                            <a href="?h=mata_pelajaran&id=<?= $_GET['id']; ?>" class="btn btn-secondary">Kembali</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">NIS/NISN</th>
                                    <th class="text-center">Nama</th>
                                    <th class="text-center">Jawaban</th>
                                    <th class="text-center">Nilai</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()) : ?>
                                    <tr>
                                        <td class="text-center"><?= $no++; ?></td>
                                        <td class="text-center"><?= $row['nis']; ?>/<?= $row['nisn']; ?></td>
                                        <td class="text-center"><?= $row['nama']; ?></td>
                                        <td class="text-center">
                                            <?php if (is_null($row['file'])) : ?>
                                                <span class="badge rounded-pill text-bg-danger">Belum Mengumpulkan</span>
                                            <?php else : ?>
                                                <a href="<?= $row['file'] ?>" target="_blank">File</a>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center" style="width: 8.2rem;">
                                            <form action="" method="POST">
                                                <input type="text" name="id_siswa" value="<?= $row['id_siswa'] ?>" hidden>
                                                <input type="text" class="form-control text-center" name="nilai" value="<?= is_null($row['nilai']) ? 0 : $row['nilai']; ?>">
                                                <button type="submit" name="submit" class="btn btn-info btn-sm">Perbaharui Nilai</button>
                                            </form>
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
</main>