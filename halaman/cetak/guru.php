<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Guru</title>
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
    <h4 class="text-center my-3">Laporan Data Guru</h4>
    <section class="p-3">
        <strong>
            <span style="width: 150px; display: inline-block;">Filter</span>
        </strong>
        <br>
        <span style="width: 150px; display: inline-block;">Jabatan</span>
        <span>: <?= $_POST['jabatan'] ?? 'Semua Jabatan'; ?></span>
    </section>
    <main class="p-3">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center align-middle no-td">No</th>
                    <th class="text-center align-middle">NIP</th>
                    <th class="text-center align-middle">Nama</th>
                    <th class="text-center align-middle">Jabatan</th>
                    <th class="text-center align-middle">Tempat Lahir</th>
                    <th class="text-center align-middle">Tanggal Lahir</th>
                    <th class="text-center align-middle">Jenis Kelamin</th>
                </tr>
            </thead>
            <?php
            $q = "SELECT * FROM guru";
            if (isset($_POST['jabatan']))
                $q .= " WHERE jabatan= '" . $_POST['jabatan'] . "'";

            $result = $mysqli->query($q);
            $no = 1;
            ?>
            <tbody>
                <?php if ($result->num_rows) : ?>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td class="text-center align-middle td-fit"><?= $no++; ?></td>
                            <td class="text-center align-middle"><?= $row['nip']; ?></td>
                            <td class="text-center align-middle"><?= $row['nama']; ?></td>
                            <td class="text-center align-middle"><?= $row['jabatan']; ?></td>
                            <td class="text-center align-middle"><?= $row['tempat_lahir']; ?></td>
                            <td class="text-center align-middle"><?= indonesiaDate($row['tanggal_lahir']); ?></td>
                            <td class="text-center align-middle"><?= $row['jenis_kelamin']; ?></td>
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