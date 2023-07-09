<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Siswa</title>
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
    <h4 class="text-center my-3">Laporan Data Siswa</h4>
    <section class="p-3">
        <strong>
            <span style="width: 150px; display: inline-block;">Filter</span>
        </strong>
        <br>
        <span style="width: 150px; display: inline-block;">Status</span>
        <span>: <?= isset($_POST['status']) ? ($_POST['status'] == 'Alumni' ? 'Telah Lulus' : $_POST['status']) : 'Semua Status'; ?></span>
    </section>
    <main class="p-3">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="align-middle text-center td-fit">No</th>
                    <th class="align-middle text-center">NIS/NISN</th>
                    <th class="align-middle text-center">Nama</th>
                    <th class="align-middle text-center">Tempat Lahir</th>
                    <th class="align-middle text-center">Tanggal Lahir</th>
                    <th class="align-middle text-center">Jenis Kelamin</th>
                    <th class="align-middle text-center">Status</th>
                </tr>
            </thead>
            <?php
            $q = "SELECT * FROM siswa";
            if (isset($_POST['status'])) 
                $q .= " WHERE status = '" . $_POST['status'] . "'";

            $q .= " ORDER BY nama";
            $result = $mysqli->query($q);
            $no = 1;
            ?>
            <tbody>
                <?php if ($result->num_rows) : ?>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td class="align-middle text-center td-fit"><?= $no++; ?></td>
                            <td class="align-middle text-center"><?= $row['nis']; ?>/<?= $row['nisn']; ?></td>
                            <td class="align-middle"><?= $row['nama']; ?></td>
                            <td class="align-middle text-center"><?= $row['tempat_lahir']; ?></td>
                            <td class="align-middle text-center"><?= indonesiaDate($row['tanggal_lahir']); ?></td>
                            <td class="align-middle text-center"><?= $row['jenis_kelamin']; ?></td>
                            <td class="align-middle text-center"><?= $row['status'] == 'Alumni' ? 'Telah Lulus' : $row['status']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else : ?>
                    <tr>
                        <td class="text-center" colspan="7">Data Tidak Ada</td>
                    </tr>
                <?php endif; ?>
            </tbody>
            </tbody>
        </table>
    </main>
    <?php include_once('footer.php'); ?>
</body>

</html>