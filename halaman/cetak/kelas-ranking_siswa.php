<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Peringkat Siswa</title>
    <link rel="shortcut icon" href="../../assets/img/icons/kemenag.svg" />
    <link href="../../assets/css/bootstrap.css" rel="stylesheet">
</head>

<body>
    <?php include_once('header.php'); ?>
    <?php
    $q = "
        SELECT 
            ka.id,
            k.nama AS kelas,
            ka.nama,
            ka.tahun_pelajaran,
            g.nip,
            g.nama AS wali_kelas 
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
            ka.id=" . $_GET['id'] . "
        ";
    $kelas_aktif = $mysqli->query($q)->fetch_assoc();
    $no = 1;
    ?>
    <h4 class="text-center my-3">Laporan Peringkat Siswa</h4>
    <section class="p-3">
        <span style="width: 150px; display: inline-block;">Wali Kelas</span>
        <span>: <?= $kelas_aktif['nip'] ?>/<?= $kelas_aktif['wali_kelas'] ?></span>
        <br>
        <span style="width: 150px; display: inline-block;">Kelas</span>
        <span>: Kelas <?= $kelas_aktif['kelas'] ?> <?= $kelas_aktif['nama'] ?></span>
        <br>
        <span style="width: 150px; display: inline-block;">Tahun Pelajaran</span>
        <span>: <?= $kelas_aktif['tahun_pelajaran']; ?></span>
    </section>
    <main class="p-3">
        <table class="table table-bordered">
            <?php $semester = $mysqli->query("SELECT * FROM semester ORDER BY tingkat")->fetch_all(MYSQLI_ASSOC); ?>
            <thead>
                <tr>
                    <th rowspan="2" class="align-middle text-center td-fit">No</th>
                    <th rowspan="2" class="align-middle text-center td-fit">NIS/NISN</th>
                    <th rowspan="2" class="align-middle text-center">Nama</th>
                    <?php foreach ($semester as $row) : ?>
                        <th class="align-middle text-center td-fit" colspan="3">Semester <?= $row['nama']; ?></th>
                    <?php endforeach; ?>
                </tr>
                <tr>
                    <?php foreach ($semester as $row) : ?>
                        <th class="align-middle text-center td-fit">Total Nilai</th>
                        <th class="align-middle text-center td-fit">Rata - Rata</th>
                        <th class="align-middle text-center td-fit">Peringkat</th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <?php
            $peringkat = [];
            foreach ($semester as $key => $value) {
                $q = "
                SELECT 
                    s.id,
                    IFNULL(SUM(ns.nilai), 0) AS total_nilai, 
                    IFNULL((SUM(ns.nilai)/COUNT(ns.id)), 0) AS rata_rata 
                FROM 
                    kelas_aktif AS ka 
                INNER JOIN 
                    kelas_siswa AS ks 
                ON 
                    ks.id_kelas_aktif=ka.id 
                INNER JOIN 
                    siswa AS s 
                ON 
                    s.id=ks.id_siswa 
                LEFT JOIN 
                    semester_kelas AS sk 
                ON 
                    sk.id_kelas_siswa=ks.id 
                LEFT JOIN 
                    nilai_siswa AS ns 
                ON 
                    ns.id_semester_kelas=sk.id 
                WHERE
                    sk.id_semester=" . $value['id'] . " 
                    AND 
                    ka.id=" . $_GET['id'] . "
                GROUP BY 
                    sk.id 
                ORDER BY 
                    rata_rata DESC
            ";
                $peringkat[] = $mysqli->query($q)->fetch_all(MYSQLI_ASSOC);
            }

            $q = "
            SELECT 
                s.id,
                s.nis,
                s.nisn,
                s.nama  
            FROM 
                kelas_siswa ks 
            INNER JOIN 
                siswa s 
            ON 
                s.id=ks.id_siswa 
            WHERE 
                ks.id_kelas_aktif=" . $_GET['id'] . " 
                ";
            $data = $mysqli->query($q)->fetch_all(MYSQLI_ASSOC);

            foreach ($peringkat as $array_peringkat) {
                foreach ($array_peringkat as $key_peringkat => $value_peringkat) {
                    foreach ($data as $key => $value) {
                        if ($value['id'] == $value_peringkat['id']) {
                            $data[$key]['peringkat'][] = [
                                'total_nilai' => $value_peringkat['total_nilai'],
                                'rata_rata' => $value_peringkat['rata_rata'],
                                'peringkat' => $key_peringkat + 1
                            ];
                            break;
                        }
                    }
                }
            }
            ?>
            <tbody>
                <?php if (count($data)) : ?>
                    <?php foreach ($data as $row) : ?>
                        <tr>
                            <td class="align-middle text-center td-fit"><?= $no++; ?></td>
                            <td class="align-middle text-center td-fit"><?= $row['nis']; ?>/<?= $row['nisn']; ?></td>
                            <td class="align-middle"><?= $row['nama']; ?></td>
                            <?php foreach ($row['peringkat'] as $value) : ?>
                                <td class="align-middle text-center td-fit"><?= $value['total_nilai'] ?></td>
                                <td class="align-middle text-center td-fit"><?= $value['rata_rata'] ?></td>
                                <td class="align-middle text-center td-fit"><?= $value['peringkat'] ?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td class="text-center" colspan="4">Data Tidak Ada</td>
                    </tr>
                <?php endif; ?>
            </tbody>
            </tbody>
        </table>
    </main>
    <?php include_once('footer.php'); ?>
</body>

</html>