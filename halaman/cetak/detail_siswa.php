<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Detail Siswa</title>
    <link rel="shortcut icon" href="../../assets/img/icons/kemenag.svg" />
    <link href="../../assets/css/bootstrap.css" rel="stylesheet">
    <style>
        @media print {
            @page {
                size: potrait
            }
        }
    </style>
</head>

<body>
    <?php include_once('header.php'); ?>
    <h4 class="text-center my-3">Laporan Data Siswa</h4>
    <main class="p-3 d-flex justify-content-center">
        <?php
        $row = $mysqli->query("SELECT * FROM siswa WHERE id=" . $_GET['id'])->fetch_assoc();

        ?>
        <table class="table table-bordered" style="width: 75%;">
            <tr>
                <td colspan="2" class="text-center">
                    <img src="../../<?= $row['foto']; ?>" style="width: 20rem; aspect-ratio: 1; object-fit: cover;">
                </td>
            </tr>
            <tr>
                <td>NIS/NISN</td>
                <td><?= $row['nis'] ?>/<?= $row['nisn'] ?></td>
            </tr>
            <tr>
                <td>Nama</td>
                <td><?= $row['nama'] ?></td>
            </tr>
            <tr>
                <td>Tempat Lahir</td>
                <td><?= $row['tempat_lahir'] ?></td>
            </tr>
            <tr>
                <td>Tanggal Lahir</td>
                <td>
                    <?= indonesiaDate($row['tanggal_lahir']); ?>
                </td>
            </tr>
            <tr>
                <td>Jenis Kelamin</td>
                <td><?= $row['jenis_kelamin'] ?></td>
            </tr>
        </table>
    </main>
    <?php include_once('footer.php'); ?>
</body>

</html>