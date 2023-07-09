<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Grafik Jenis Kelamin Siswa</title>
    <link rel="shortcut icon" href="../../assets/img/icons/kemenag.svg" />
    <link href="../../assets/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/app.css">
    <style>
        @media print {
            @page {
                size: landscape
            }
        }
    </style>
</head>

<body>
    <?php include_once('header.php'); ?>
    <h4 class="text-center my-3">Laporan Grafik Jenis Kelamin Siswa</h4>
    <section class="p-3">
        <strong>
            <span style="width: 150px; display: inline-block;">Filter</span>
        </strong>
        <br>
        <span style="width: 150px; display: inline-block;">Kelas</span>
        <?php $kelas = $mysqli->query("SELECT nama FROM kelas WHERE id=" . (empty($_POST['kelas'] ?? '') ? 0 : $_POST['kelas']))->fetch_assoc(); ?>
        <span>: <?= !empty($_POST['kelas'] ?? '') ? $kelas['nama'] : 'Semua Kelas'; ?></span>
        <br>
        <span style="width: 150px; display: inline-block;">Tahun Pelajaran</span>
        <span>: <?= !empty($_POST['tahun_pelajaran'] ?? '') ? $_POST['tahun_pelajaran'] : 'Semua Tahun Pelajaran'; ?></span>
    </section>
    <main class="p-3">
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
                            animation: {
                                duration: 0
                            },
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
                                    gridLines: {
                                        color: "transparent",
                                    },
                                }, ],
                            },
                        },
                    });
                }
            });
        </script>
    </main>
    <?php include_once('footer.php'); ?>
    <script src="../../assets/js/app.js"></script>
</body>

</html>