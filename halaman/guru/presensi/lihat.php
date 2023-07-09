<main class="content">
    <div class="container-fluid p-0">
        <h1 class="mb-3">Halaman Presensi dan Forum Diskusi</h1>
        <div class="row">
            <div class="col-12 col-md-5">
                <?php
                $q = "
                    SELECT 
                        s.nama,
                        (
                            SELECT 
                                ps.id 
                            FROM 
                                presensi_siswa ps 
                            WHERE 
                                ps.id_siswa=s.id  
                                AND 
                                ps.id_presensi_mata_pelajaran_kelas=" . $_GET['idd'] . " 
                        ) status  
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
                        presensi_mata_pelajaran_kelas pmpk 
                    ON 
                        pmpk.id_mata_pelajaran_kelas=mpk.id 
                    WHERE 
                        mpk.id=" . $_GET['id'] . " 
                        AND 
                        pmpk.id=" . $_GET['idd'] . "
                ";
                $result = $mysqli->query($q);
                ?>
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h3>Presensi Siswa</h3>
                        <div>
                            <a href="halaman/cetak/presensi.php?id=<?= $_GET['id']; ?>&idd=<?= $_GET['idd']; ?>" target="_blank" class="btn btn-info">Cetak</a>
                            <a href="?h=mata_pelajaran&id=<?= $_GET['id']; ?>" class="btn btn-secondary">Kembali</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">Nama</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()) : ?>
                                    <tr>
                                        <td class="text-center"><?= $row['nama']; ?></td>
                                        <td class="text-center">
                                            <?php if (is_null($row['status'])) : ?>
                                                <span class="badge rounded-pill text-bg-danger">Tidak Hadir</span>
                                            <?php else : ?>
                                                <span class="badge rounded-pill text-bg-success">Hadir</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md bg-white">
                <div class="py-3 px-4 border-bottom">
                    <h4 class="mb-0">Forum Diskusi Kelas</h4>
                </div>
                <?php include_once('templates/forum_diskusi.php') ?>

            </div>
        </div>
    </div>
</main>