<main class="content">
    <div class="container-fluid p-0">

        <div class="mb-3 d-flex justify-content-between">
            <h1 class="h3 d-inline align-middle">Laporan Presensi Guru</h1>
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
                                <label class="form-label">Dari Tanggal</label>
                                <input type="date" class="form-control" name="dari_tanggal" value="<?= $_POST['dari_tanggal'] ?? ''; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Sampai Tanggal</label>
                                <input type="date" class="form-control" name="sampai_tanggal" value="<?= $_POST['sampai_tanggal'] ?? ''; ?>" required>
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
                            <label class="form-label d-block">Dari Tanggal</label>
                            <input type="text" disabled class="form-control" value="<?= isset($_POST['dari_tanggal']) ? indoensiaDateWithDay($_POST['dari_tanggal']) : ''; ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label d-block">Sampai Tanggal</label>
                            <input type="text" disabled class="form-control" value="<?= isset($_POST['sampai_tanggal']) ? indoensiaDateWithDay($_POST['sampai_tanggal']) : ''; ?>">
                        </div>
                        <div class="d-flex justify-content-end">
                            <form action="halaman/cetak/presensi_guru.php" method="POST" target="_blank">
                                <?php if (isset($_POST['submit'])) : ?>
                                    <input type="text" hidden name="dari_tanggal" value="<?= $_POST['dari_tanggal']; ?>">
                                    <input type="text" hidden name="sampai_tanggal" value="<?= $_POST['sampai_tanggal']; ?>">
                                    <button type="submit" class="btn btn-success">Cetak</button>
                                <?php endif; ?>
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
                                    <th class="text-center">Tanggal</th>
                                    <th class="text-center">NIP</th>
                                    <th class="text-center">Nama</th>
                                    <th class="text-center">Jam Masuk</th>
                                    <th class="text-center">Jam Pulang</th>
                                </tr>
                            </thead>
                            <?php
                            $data = [];
                            if (isset($_POST['dari_tanggal']) && isset($_POST['sampai_tanggal'])) {
                                $guru = $mysqli->query("SELECT * FROM guru ORDER BY nama")->fetch_all(MYSQLI_ASSOC);
                                $dari_tanggal = new DateTime($_POST['dari_tanggal']);
                                $dari_tanggal->sub(new DateInterval('P1D'));

                                $sampai_tanggal = new DateTime($_POST['sampai_tanggal']);
                                while ($dari_tanggal->format("Y-m-d") != $sampai_tanggal->format("Y-m-d")) {
                                    foreach ($guru as $value) {
                                        $q = "
                                            SELECT 
                                                masuk,
                                                keluar
                                            FROM 
                                                presensi_guru 
                                            WHERE 
                                                id_guru=" . $value['id'] . " 
                                                AND 
                                                tanggal='" . $sampai_tanggal->format("Y-m-d") . "'
                                        ";
                                        $result = $mysqli->query($q)->fetch_assoc();
                                        $data[] = [
                                            'tanggal'     => $sampai_tanggal->format("Y-m-d"),
                                            'nip'         => $value['nip'],
                                            'nama'        => $value['nama'],
                                            'jam_masuk'   => !is_null($result) ? (explode(":", $result['masuk'])[0] . ":" . explode(":", $result['masuk'])[1]) : 'Tidak Mengisi',
                                            'jam_pulang'  => !is_null($result) ? (explode(":", $result['keluar'])[0] . ":" . explode(":", $result['keluar'])[1]) : 'Tidak Mengisi',
                                        ];
                                    }
                                    $sampai_tanggal->sub(new DateInterval('P1D'));
                                }
                            }
                            $no = 1;
                            ?>
                            <tbody>
                                <?php if (count($data)) : ?>
                                    <?php foreach ($data as $datum) : ?>
                                        <tr>
                                            <td class="text-center td-fit"><?= $no++; ?></td>
                                            <td class="text-center"><?= indoensiaDateWithDay($datum['tanggal']); ?></td>
                                            <td class="text-center"><?= $datum['nip']; ?></td>
                                            <td class="text-center"><?= $datum['nama']; ?></td>
                                            <td class="text-center"><?= $datum['jam_masuk']; ?></td>
                                            <td class="text-center"><?= $datum['jam_pulang']; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak Ada Data</td>
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