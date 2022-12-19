<main class="content">
    <div class="container-fluid p-0">

        <div class="mb-3 d-flex justify-content-between">
            <h1 class="h3 d-inline align-middle">Laporan Kelas Selesai</h1>
        </div>

        <div class="row">
            <div class="col-12 col-md-8">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-center td-fit">No</th>
                                    <th class="text-center td-fit">Tahun Pelajaran</th>
                                    <th class="text-center td-fit">Nama Kelas</th>
                                    <th class="text-center td-fit">NIP</th>
                                    <th class="text-center">Wali Kelas</th>
                                    <th class="text-center td-fit">Jumlah Siswa</th>
                                    <th class="text-center td-fit">Cetak</th>
                                </tr>
                            </thead>
                            <?php
                            $q = "
                            SELECT 
                                ka.id,
                                k.nama AS kelas,
                                ka.nama,
                                ka.tahun_pelajaran,
                                g.nip,
                                g.nama AS wali_kelas,
                                (SELECT COUNT(id) FROM kelas_siswa AS ks WHERE ks.id_kelas_aktif=ka.id AND status!='Tidak Aktif') AS jumlah_siswa 
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
                                ka.status='Selesai' 
                                ";
                            if (!empty($_POST['kelas'] ?? ''))
                                $q .= " AND k.id=" . $_POST['kelas'];

                            if (!empty($_POST['tahun_pelajaran'] ?? ''))
                                $q .= " AND ka.tahun_pelajaran = '" . $_POST['tahun_pelajaran'] . "'";

                            $q .= " ORDER BY ka.tahun_pelajaran, ka.nama";
                            $result = $mysqli->query($q);
                            $no = 1;
                            ?>
                            <tbody>
                                <?php if ($result->num_rows) : ?>
                                    <?php while ($row = $result->fetch_assoc()) : ?>
                                        <tr>
                                            <td class="text-center td-fit"><?= $no++; ?></td>
                                            <td class="text-center td-fit"><?= $row['tahun_pelajaran']; ?></td>
                                            <td class="text-center td-fit">Kelas <?= $row['kelas']; ?> <?= $row['nama']; ?></td>
                                            <td class="text-center td-fit"><?= $row['nip']; ?></td>
                                            <td><?= $row['wali_kelas']; ?></td>
                                            <td class="text-center td-fit"><?= $row['jumlah_siswa']; ?></td>
                                            <td class="text-center td-fit">
                                                <a target="_blank" href="halaman/cetak/kelas-ranking_siswa.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-secondary">Peringkat</a>
                                                <a target="_blank" href="halaman/cetak/kelas-siswa.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-success">Siswa</a>
                                                <a target="_blank" href="halaman/cetak/kelas-mata_pelajaran.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-info">Mata Pelajaran</a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else : ?>
                                    <tr>
                                        <td class="text-center" colspan="7">Data Tidak Ada</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Filter</h5>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <?php $result = $mysqli->query("SELECT * FROM kelas"); ?>
                                <label class="form-label">Kelas</label>
                                <select class="form-control" name="kelas">
                                    <option value="" selected disabled>Semua Kelas</option>
                                    <?php while ($row = $result->fetch_assoc()) : ?>
                                        <option value="<?= $row['id']; ?>" <?= ($_POST['kelas'] ?? '') == $row['id'] ? 'selected' : ''; ?>>Kelas <?= $row['nama']; ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <?php $result = $mysqli->query("SELECT DISTINCT tahun_pelajaran FROM kelas_aktif WHERE status='Selesai'"); ?>
                                <label class="form-label">Tahun Pelajaran</label>
                                <select class="form-control" name="tahun_pelajaran">
                                    <option value="" selected disabled>Semua Tahun Pelajaran</option>
                                    <?php while ($row = $result->fetch_assoc()) : ?>
                                        <option value="<?= $row['tahun_pelajaran']; ?>" <?= ($_POST['tahun_pelajaran'] ?? '') == $row['tahun_pelajaran'] ? 'selected' : ''; ?>><?= $row['tahun_pelajaran']; ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="" class="btn btn-secondary">Reset Filter</a>
                                <div class="d-flex gap-1">
                                    <button type="submit" name="submit" class="btn btn-info">Filter</button>
                                    <button id="cetak" type="button" class="btn btn-success">Cetak</button>
                                </div>
                            </div>
                        </form>
                        <form id="form-cetak" action="halaman/cetak/kelas_aktif.php" method="POST" target="_blank">
                            <?php if (!empty($_POST['kelas'] ?? '')) : ?>
                                <input type="text" hidden name="kelas" value="<?= $_POST['kelas']; ?>">
                            <?php endif; ?>
                            <?php if (!empty($_POST['tahun_pelajaran'] ?? '')) : ?>
                                <input type="text" hidden name="tahun_pelajaran" value="<?= $_POST['tahun_pelajaran']; ?>">
                            <?php endif; ?>
                        </form>
                        <script>
                            document.querySelector('#cetak').addEventListener('click', () => document.querySelector('#form-cetak').submit());
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>