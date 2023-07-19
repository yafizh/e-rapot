<main class="content">
    <div class="container-fluid p-0">

        <div class="mb-3 d-flex justify-content-between">
            <h1 class="h3 d-inline align-middle">Laporan Grafik Jenis Kelamin Siswa</h1>
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
                                <?php $result = $mysqli->query("SELECT DISTINCT tahun_pelajaran FROM kelas_aktif WHERE status='Aktif'"); ?>
                                <label class="form-label">Tahun Pelajaran</label>
                                <select class="form-control" name="tahun_pelajaran">
                                    <option value="" selected disabled>Semua Tahun Pelajaran</option>
                                    <?php while ($row = $result->fetch_assoc()) : ?>
                                        <option value="<?= $row['tahun_pelajaran']; ?>" <?= ($_POST['tahun_pelajaran'] ?? '') == $row['tahun_pelajaran'] ? 'selected' : ''; ?>><?= $row['tahun_pelajaran']; ?></option>
                                    <?php endwhile; ?>
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
                            <label class="form-label d-block">Kelas:</label>
                            <?php $kelas = $mysqli->query("SELECT nama FROM kelas WHERE id=" . (empty($_POST['kelas'] ?? '') ? 0 : $_POST['kelas']))->fetch_assoc(); ?>
                            <input type="text" disabled class="form-control" value="<?= empty($_POST['kelas'] ?? '') ? 'Semua Kelas' : $kelas['nama']; ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label d-block">Tahun Pelajaran:</label>
                            <input type="text" disabled class="form-control" value="<?= empty($_POST['tahun_pelajaran'] ?? '') ? 'Semua Tahun Pelajaran' : $_POST['tahun_pelajaran']; ?>">
                        </div>
                        <div class="d-flex justify-content-end">
                            <form action="halaman/cetak/grafik_jenis_kelamin_siswa.php" method="POST" target="_blank">
                                <?php if (!empty($_POST['kelas'] ?? '')) : ?>
                                    <input type="text" hidden name="kelas" value="<?= $_POST['kelas']; ?>">
                                <?php endif; ?>
                                <?php if (!empty($_POST['tahun_pelajaran'] ?? '')) : ?>
                                    <input type="text" hidden name="tahun_pelajaran" value="<?= $_POST['tahun_pelajaran']; ?>">
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
                        <?php
                        $q = "
                            SELECT 
                                (
                                    SELECT 
                                        COUNT(ks.id) 
                                    FROM 
                                        kelas_siswa AS ks 
                                    INNER JOIN 
                                        siswa AS s 
                                    ON 
                                        s.id=ks.id_siswa 
                                    WHERE 
                                        ks.id_kelas_aktif=ka.id 
                                        AND 
                                        ks.status!='Tidak Aktif' 
                                        AND 
                                        s.jenis_kelamin = 'Laki - Laki' 
                                ) AS laki_laki,
                                (
                                    SELECT 
                                        COUNT(ks.id) 
                                    FROM 
                                        kelas_siswa AS ks 
                                    INNER JOIN 
                                        siswa s 
                                    ON 
                                        s.id=ks.id_siswa 
                                    WHERE 
                                        ks.id_kelas_aktif=ka.id 
                                        AND 
                                        ks.status!='Tidak Aktif' 
                                        AND 
                                        s.jenis_kelamin = 'Perempuan' 
                                ) AS perempuan  
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
                                ka.status='Aktif' 
                                ";
                        if (!empty($_POST['kelas'] ?? ''))
                            $q .= " AND k.id=" . $_POST['kelas'];

                        if (!empty($_POST['tahun_pelajaran'] ?? ''))
                            $q .= " AND ka.tahun_pelajaran = '" . $_POST['tahun_pelajaran'] . "'";

                        $result = $mysqli->query($q);
                        $data = $result->fetch_all(MYSQLI_ASSOC);
                        $no = 1;
                        ?>
                        <canvas style="height: 20rem;" id="chartjs-bar"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const chartData = JSON.parse('<?= json_encode($data); ?>');
        if (chartData.length) {
            // Bar chart
            new Chart(document.getElementById("chartjs-bar"), {
                type: "bar",
                data: {
                    labels: [
                        "Laki - Laki",
                        "Perempuan"
                    ],
                    datasets: [{
                        label: 'Jumlah',
                        backgroundColor: [
                            'rgb(1,163,229)', 'rgb(255,99,190)'
                        ],
                        borderColor: window.theme.primary,
                        data: [chartData[0].laki_laki, chartData[0].perempuan],
                        barPercentage: 0.75,
                        categoryPercentage: 0.5,
                    }, ],
                },
                options: {
                    maintainAspectRatio: false,
                    legend: {
                        display: false,
                    },
                    scales: {
                        yAxes: [{
                            gridLines: {
                                display: false,
                            },
                            stacked: false,
                            ticks: {
                                // stepSize: 20,
                                beginAtZero: true
                            },
                        }, ],
                        xAxes: [{
                            stacked: false,
                            // gridLines: {
                            //     color: "transparent",
                            // },
                        }, ],
                    },
                },
            });
        }
    });
</script>