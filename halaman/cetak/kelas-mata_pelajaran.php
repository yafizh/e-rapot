<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Mata Pelajaran Kelas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
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
    <h4 class="text-center my-3">Laporan Data Mata Pelajaran Kelas</h4>
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
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th class="align-middle text-center td-fit">No</th>
                    <th class="align-middle text-center td-fit">NIP</th>
                    <th class="align-middle text-center">Pengajar</th>
                    <th class="align-middle text-center">Mata Pelajaran</th>
                    <th class="align-middle text-center">Wali Kelas</th>
                </tr>
            </thead>
            <?php
            $q = "
                SELECT 
                    mpk.id,
                    mpk.kkm,
                    mp.nama mata_pelajaran,
                    g.nama pengajar,
                    g.nip 
                FROM 
                    mata_pelajaran_kelas mpk 
                INNER JOIN 
                    mata_pelajaran mp 
                ON 
                    mp.id=mpk.id_mata_pelajaran 
                INNER JOIN 
                    guru g 
                ON 
                    g.id=mpk.id_guru 
                WHERE 
                    mpk.id_kelas_aktif=" . $_GET['id'] . " 
                ORDER BY 
                    mp.nama 
            ";
            $result = $mysqli->query($q);
            $no = 1;
            ?>
            <tbody>
                <?php if ($result->num_rows) : ?>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td class="text-center td-fit"><?= $no++; ?></td>
                            <td class="text-center"><?= $row['nip']; ?></td>
                            <td class="text-center"><?= $row['pengajar']; ?></td>
                            <td class="text-center"><?= $row['mata_pelajaran']; ?></td>
                            <td class="text-center"><?= $row['kkm']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else : ?>
                    <tr>
                        <td class="text-center" colspan="5">Data Tidak Ada</td>
                    </tr>
                <?php endif; ?>
            </tbody>
            </tbody>
        </table>
    </main>
    <?php include_once('footer.php'); ?>
</body>

</html>