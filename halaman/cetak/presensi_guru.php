<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Presensi Guru</title>
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
    <h4 class="text-center my-3">Laporan Presensi Guru</h4>
    <section class="p-3">
        <strong>
            <span style="width: 150px; display: inline-block;">Filter</span>
        </strong>
        <br>
        <span style="width: 150px; display: inline-block;">Dari Tanggal</span>
        <span>: <?= indoensiaDateWithDay($_POST['dari_tanggal']); ?></span>
        <br>
        <span style="width: 150px; display: inline-block;">Sampai Tanggal</span>
        <span>: <?= indoensiaDateWithDay($_POST['sampai_tanggal']); ?></span>
    </section>
    <main class="p-3">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="align-middle text-center td-fit">No</th>
                    <th class="align-middle text-center">Tanggal</th>
                    <th class="align-middle text-center">NIP</th>
                    <th class="align-middle text-center">Nama</th>
                    <th class="align-middle text-center">Jam Masuk</th>
                    <th class="align-middle text-center">Jam Pulang</th>
                </tr>
            </thead>
            <?php
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
            $no = 1;
            ?>
            <tbody>
                <?php foreach ($data as $datum) : ?>
                    <tr>
                        <td class="align-middle text-center td-fit"><?= $no++; ?></td>
                        <td class="align-middle text-center"><?= indoensiaDateWithDay($datum['tanggal']); ?></td>
                        <td class="align-middle text-center"><?= $datum['nip']; ?></td>
                        <td class="align-middle text-center"><?= $datum['nama']; ?></td>
                        <td class="align-middle text-center"><?= $datum['jam_masuk']; ?></td>
                        <td class="align-middle text-center"><?= $datum['jam_pulang']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            </tbody>
        </table>
    </main>
    <?php include_once('footer.php'); ?>
</body>

</html>