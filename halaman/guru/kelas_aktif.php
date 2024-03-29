<main class="content">
    <div class="container-fluid p-0">
        <h1 class="mb-3">Halaman Utama</h1>
        <div class="row">
            <?php include_once('templates/sidebar_guru.php'); ?>
            <div class="col-12 col-md">
                <?php include_once('templates/navigator_guru.php'); ?>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <table class="table" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center td-fit">No</th>
                                            <th class="text-center">Kelas</th>
                                            <th class="text-center">Mata Pelajaran</th>
                                            <th class="text-center td-fit">Aksi</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    $q = "
                                        SELECT 
                                            mpk.id,
                                            mpk.rps,
                                            mp.nama as mata_pelajaran,
                                            k.nama as kelas
                                        FROM 
                                            mata_pelajaran_kelas mpk 
                                        INNER JOIN 
                                            kelas_aktif ka 
                                        ON 
                                            ka.id=mpk.id_kelas_aktif 
                                        INNER JOIN 
                                            mata_pelajaran mp 
                                        ON 
                                            mp.id=mpk.id_mata_pelajaran 
                                        INNER JOIN 
                                            kelas k 
                                        ON 
                                            ka.id_kelas=k.id 
                                        WHERE 
                                            ka.status='Aktif' 
                                            AND 
                                            mpk.id_guru=" . $_SESSION['user']['id_guru'] . "
                                    ";

                                    $kelas_siswa = $mysqli->query($q);
                                    $no = 1;
                                    ?>
                                    <tbody>
                                        <?php if ($kelas_siswa->num_rows) : ?>
                                            <?php while ($row = $kelas_siswa->fetch_assoc()) : ?>
                                                <tr>
                                                    <td class="text-center td-fit"><?= $no++; ?></td>
                                                    <td class="text-center"><?= $row['kelas']; ?></td>
                                                    <td class="text-center"><?= $row['mata_pelajaran']; ?></td>
                                                    <td class="text-center td-fit">
                                                        <a href="<?= $row['rps']; ?>" target="_blank" class="btn btn-info btn-sm">RPS</a>
                                                        <a href="?h=mata_pelajaran&id=<?= $row['id']; ?>" class="btn btn-info btn-sm">Lihat</a>
                                                    </td>
                                                </tr>
                                            <?php endwhile; ?>
                                        <?php else : ?>
                                            <tr>
                                                <td colspan="4" class="text-center">Tidak Sedang Mengajar</td>
                                            </tr>
                                        <?php endif; ?>
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