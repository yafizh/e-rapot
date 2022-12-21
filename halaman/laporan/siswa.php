<main class="content">
    <div class="container-fluid p-0">

        <div class="mb-3 d-flex justify-content-between">
            <h1 class="h3 d-inline align-middle">Laporan Siswa</h1>
        </div>

        <div class="row">
            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="card-header pb-0">
                        <h5 class="card-title mb-0">Filter</h5>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="mb-3">
                                <label class="form-label">Status Siswa</label>
                                <select class="form-control" name="status" required>
                                    <option value="" selected disabled>Semua</option>
                                    <option value="Aktif" <?= ($_POST['status'] ?? '') == 'Aktif' ? 'selected' : ''; ?>>Aktif</option>
                                    <option value="Alumni" <?= ($_POST['status'] ?? '') == 'Alumni' ? 'selected' : ''; ?>>Telah Lulus</option>
                                </select>
                            </div>
                            <div class="d-flex justify-content-end gap-1">
                                <a href="" class="btn btn-secondary">Reset Filter</a>
                                <button type="submit" name="submit" class="btn btn-info">Filter</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="card-header pb-0">
                        <h5 class="card-title mb-0">Hasil Filter</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label d-block">Status Siswa:</label>
                            <input type="text" disabled class="form-control" value="<?= empty($_POST['status'] ?? '') ? 'Semua' : $_POST['status']; ?>">
                        </div>
                        <div class="d-flex justify-content-end">
                            <form action="halaman/cetak/siswa.php" method="POST" target="_blank">
                                <?php if (isset($_POST['submit'])) : ?>
                                    <input type="text" hidden name="status" value="<?= $_POST['status']; ?>">
                                <?php endif; ?>
                                <button type="submit" class="btn btn-success">Cetak</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-center td-fit">No</th>
                                    <th class="text-center">NIS/NISN</th>
                                    <th class="text-center">Nama</th>
                                    <th class="text-center">Tempat Lahir</th>
                                    <th class="text-center">Tanggal Lahir</th>
                                    <th class="text-center">Jenis Kelamin</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <?php
                            $q = "SELECT * FROM siswa";
                            if (isset($_POST['submit'])) {
                                $q .= " WHERE status = '" . $_POST['status'] . "'";
                            }

                            $q .= " ORDER BY nama";
                            $result = $mysqli->query($q);
                            $no = 1;
                            ?>
                            <tbody>
                                <?php if ($result->num_rows) : ?>
                                    <?php while ($row = $result->fetch_assoc()) : ?>
                                        <tr>
                                            <td class="text-center td-fit"><?= $no++; ?></td>
                                            <td class="text-center"><?= $row['nis']; ?>/<?= $row['nisn']; ?></td>
                                            <td><?= $row['nama']; ?></td>
                                            <td class="text-center"><?= $row['tempat_lahir']; ?></td>
                                            <td class="text-center"><?= indonesiaDate($row['tanggal_lahir']); ?></td>
                                            <td class="text-center"><?= $row['jenis_kelamin']; ?></td>
                                            <td class="text-center"><?= $row['status'] == 'Alumni' ? 'Telah Lulus' : $row['status']; ?></td>
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
        </div>
    </div>
</main>