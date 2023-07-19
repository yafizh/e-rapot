<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Presensi</title>
    <link rel="shortcut icon" href="../../assets/img/icons/kemenag.svg" />
    <link href="../../assets/css/bootstrap.css" rel="stylesheet">
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
    <?php
    $q = "
        SELECT 
            k.nama kelas,
            mp.nama mata_pelajaran
        FROM 
            mata_pelajaran_kelas mpk 
        INNER JOIN 
            mata_pelajaran mp 
        ON 
            mp.id=mpk.id_mata_pelajaran 
        INNER JOIN 
            kelas_aktif ka 
        ON 
            ka.id=mpk.id_kelas_aktif 
        INNER JOIN 
            kelas k 
        ON 
            k.id=ka.id_kelas 
        WHERE 
            mpk.id=" . $_GET['id'] . "
    ";
    $report = $mysqli->query($q)->fetch_assoc();

    $report2 = $mysqli->query("SELECT tanggal FROM presensi_mata_pelajaran_kelas WHERE id=" . $_GET['idd'])->fetch_assoc();
    ?>
    <h4 class="text-center my-3">Laporan Presensi</h4>
    <section class="p-3">
        <strong>
            <span style="width: 150px; display: inline-block;">Filter</span>
        </strong>
        <br>
        <span style="width: 150px; display: inline-block;">Kelas</span>
        <span>: <?= $report['kelas']; ?></span>
        <br>
        <span style="width: 150px; display: inline-block;">Mata Pelajaran</span>
        <span>: <?= $report['mata_pelajaran']; ?></span>
        <br>
        <span style="width: 150px; display: inline-block;">Tanggal</span>
        <span>: <?= indoensiaDateWithDay($report2['tanggal']); ?></span>
    </section>
    <main class="p-3">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="align-middle text-center td-fit">No</th>
                    <th class="align-middle text-center">NIS/NISN</th>
                    <th class="align-middle text-center">Nama</th>
                    <th class="align-middle text-center">Status Kehadiran</th>
                </tr>
            </thead>
            <?php
            $q = "
            SELECT 
                s.nis,
                s.nisn,
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
                ) as status
            FROM 
                mata_pelajaran_kelas mpk  
            INNER JOIN 
                kelas_aktif ka 
            ON 
                ka.id=mpk.id_kelas_aktif 
            INNER JOIN 
                kelas_siswa ks 
            ON 
                ks.id_kelas_aktif=ka.id  
            INNER JOIN 
                siswa s 
            ON 
                s.id=ks.id_siswa 
            WHERE 
                mpk.id='" . $_GET['id'] . "' 
            ";
            $result = $mysqli->query($q);
            $no = 1;
            ?>
            <tbody>
                <?php if ($result->num_rows) : ?>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td class="align-middle text-center td-fit"><?= $no++; ?></td>
                            <td class="align-middle text-center"><?= $row['nis']; ?>/<?= $row['nisn']; ?></td>
                            <td class="align-middle text-center"><?= $row['nama']; ?></td>
                            <td class="align-middle text-center"><?= is_null($row['status']) ? 'Tidak Hadir' : 'Hadir'; ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else : ?>
                    <tr>
                        <td class="text-center" colspan="4">Data Tidak Ada</td>
                    </tr>
                <?php endif; ?>
            </tbody>
            </tbody>
        </table>
    </main>
    <?php
    $q = "
            SELECT 
                g.nip,
                g.nama
            FROM 
                mata_pelajaran_kelas mpk 
            INNER JOIN 
                guru g 
            ON 
                g.id=mpk.id_guru 
            WHERE 
                mpk.id=" . $_GET['id'] . "
        ";
    $guru = $mysqli->query($q)->fetch_assoc();
    ?>
    <footer class="d-flex justify-content-end p-3">
        <div class="text-center">
            <h6>Ampah, <?= indonesiaDate(Date('Y-m-d')); ?></h6>
            <br><br><br><br><br>
            <h6 class="mb-0"><?= $guru['nama']; ?></h6>
            <div style="border: 1px solid black; width: 16rem;"></div>
            <h6><?= $guru['nip']; ?></h6>
        </div>
    </footer>
    <script src="../../assets/js/bootstrap.js"></script>
    <script>
        window.print();
    </script>
</body>

</html>