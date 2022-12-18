<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Kelas Aktif</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
    <?php include_once('header.php'); ?>
    <h4 class="text-center my-3">Laporan Data Kelas Aktif</h4>
    <section class="p-3">
        <strong>
            <span style="width: 150px; display: inline-block;">Filter</span>
        </strong>
        <br>
        <span style="width: 150px; display: inline-block;">Kelas</span>
        <span>: <?= !empty($_POST['kelas'] ?? '') ? ("Kelas " . $_POST['kelas']) : 'Semua Kelas'; ?></span>
        <br>
        <span style="width: 150px; display: inline-block;">Tahun Pelajaran</span>
        <span>: <?= !empty($_POST['tahun_pelajaran'] ?? '') ? $_POST['tahun_pelajaran'] : 'Semua Tahun Pelajaran'; ?></span>
    </section>
    <main class="p-3">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th class="align-middle text-center td-fit">No</th>
                    <th class="align-middle text-center td-fit">Tahun Pelajaran</th>
                    <th class="align-middle text-center td-fit">Nama Kelas</th>
                    <th class="align-middle text-center td-fit">NIP</th>
                    <th class="align-middle text-center">Wali Kelas</th>
                    <th class="align-middle text-center td-fit">Jumlah Siswa</th>
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
                status='Aktif' 
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
                            <td class="align-middle text-center td-fit"><?= $no++; ?></td>
                            <td class="align-middle text-center td-fit"><?= $row['tahun_pelajaran']; ?></td>
                            <td class="align-middle text-center td-fit">Kelas <?= $row['kelas']; ?> <?= $row['nama']; ?></td>
                            <td class="align-middle text-center td-fit"><?= $row['nip']; ?></td>
                            <td class="align-middle"><?= $row['wali_kelas']; ?></td>
                            <td class="align-middle text-center td-fit"><?= $row['jumlah_siswa']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else : ?>
                    <tr>
                        <td class="text-center" colspan="6">Data Tidak Ada</td>
                    </tr>
                <?php endif; ?>
            </tbody>
            </tbody>
        </table>
    </main>
    <?php include_once('footer.php'); ?>
</body>

</html>