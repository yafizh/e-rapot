<main class="content">
    <div class="container-fluid p-0">
        <h1 class="mb-3">Halaman Utama</h1>
        <div class="row">
            <?php include_once('templates/sidebar_siswa.php'); ?>
            <div class="col-12 col-md">
                <?php include_once('templates/navigator_siswa.php'); ?>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <table class="table" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center td-fit">No</th>
                                            <th class="text-center">Mata Pelajaran</th>
                                            <th class="text-center td-fit">Aksi</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    $q = "
                                        SELECT 
                                            mpk.id,
                                            mp.nama
                                        FROM 
                                            kelas_siswa ks 
                                        INNER JOIN 
                                            kelas_aktif ka 
                                        ON 
                                            ka.id=ks.id_kelas_aktif 
                                        INNER JOIN 
                                            mata_pelajaran_kelas mpk 
                                        ON 
                                            ka.id=ks.id_kelas_aktif 
                                        INNER JOIN 
                                            mata_pelajaran mp 
                                        ON 
                                            mp.id=mpk.id_mata_pelajaran 
                                        WHERE 
                                            ks.status='Aktif'
                                    ";

                                    $kelas_siswa = $mysqli->query($q);
                                    $no = 1;
                                    ?>
                                    <tbody>
                                        <?php while ($row = $kelas_siswa->fetch_assoc()) : ?>
                                            <tr>
                                                <td class="text-center td-fit"><?= $no++; ?></td>
                                                <td class="text-center"><?= $row['nama']; ?></td>
                                                <td class="text-center td-fit">
                                                    <a href="?h=mata_pelajaran&id=<?= $row['id']; ?>" class="btn btn-info btn-sm">Lihat</a>
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
    </div>
</main>