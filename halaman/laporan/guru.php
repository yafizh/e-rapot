<main class="content">
    <div class="container-fluid p-0">

        <div class="mb-3 d-flex justify-content-between">
            <h1 class="h3 d-inline align-middle">Laporan Guru</h1>
        </div>

        <div class="row">
            <div class="col-12 col-md-8">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-center td-fit">No</th>
                                    <th class="text-center">NIP</th>
                                    <th class="text-center">Nama</th>
                                    <th class="text-center">Tempat Lahir</th>
                                    <th class="text-center">Tanggal Lahir</th>
                                    <th class="text-center">Jenis Kelamin</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <?php
                            $q = "
                                SELECT 
                                    *,
                                    IF(
                                        (SELECT id_guru FROM kelas_aktif ka WHERE ka.id_guru=g.id AND ka.status='Aktif'),
                                        'Wali Kelas',
                                        'Guru'
                                    ) status
                                FROM 
                                    guru g
                            ";
                            if (isset($_POST['submit'])) {
                                $q .= "
                                    WHERE 
                                        IF(
                                            (SELECT id_guru FROM kelas_aktif ka WHERE ka.id_guru=g.id AND ka.status='Aktif'),
                                            'Wali Kelas',
                                            'Guru'
                                        ) = '" . $_POST['status'] . "'
                                ";
                            }
                            $result = $mysqli->query($q);
                            $no = 1;
                            ?>
                            <tbody>
                                <?php if ($result->num_rows) : ?>
                                    <?php while ($row = $result->fetch_assoc()) : ?>
                                        <tr>
                                            <td class="text-center td-fit"><?= $no++; ?></td>
                                            <td class="text-center"><?= $row['nip']; ?></td>
                                            <td class="text-center"><?= $row['nama']; ?></td>
                                            <td class="text-center"><?= $row['tempat_lahir']; ?></td>
                                            <td class="text-center"><?= indonesiaDate($row['tanggal_lahir']); ?></td>
                                            <td class="text-center"><?= $row['jenis_kelamin']; ?></td>
                                            <td class="text-center"><?= $row['status']; ?></td>
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
                                <label class="form-label">Status</label>
                                <select class="form-control" name="status" required>
                                    <option value="" selected disabled>Semua</option>
                                    <option value="Guru" <?= ($_POST['status'] ?? '') == 'Guru' ? 'selected' : ''; ?>>Guru</option>
                                    <option value="Wali Kelas" <?= ($_POST['status'] ?? '') == 'Wali Kelas' ? 'selected' : ''; ?>>Wali Kelas</option>
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
                        <form id="form-cetak" action="halaman/cetak/guru.php" method="POST" target="_blank">
                            <?php if (isset($_POST['submit'])) : ?>
                                <input type="text" hidden name="status" value="<?= $_POST['status']; ?>">
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