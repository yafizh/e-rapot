<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Barang Keluar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
    <?php include_once('header.php'); ?>
    <h4 class="text-center my-3">RAPOT</h4>
    <main class="p-3">
        <section class="mb-3">
            <div class="row">
                <div class="col-7">
                    <div class="row">
                        <div class="col-5">
                            Nama Peserta Didik
                        </div>
                        <div class="col-auto">:</div>
                        <div class="col">
                            Nurcholis
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-5">
                            Nomor Induk
                        </div>
                        <div class="col-auto">:</div>
                        <div class="col">
                            1232
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-5">
                            Nama Sekolah
                        </div>
                        <div class="col-auto">:</div>
                        <div class="col">
                            ABC
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="row">
                        <div class="col-6">
                            Kelas
                        </div>
                        <div class="col-auto">:</div>
                        <div class="col text-capitalize">
                            V <?= (new NumberFormatter("id", NumberFormatter::SPELLOUT))->format(1); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            Semester
                        </div>
                        <div class="col-auto">:</div>
                        <div class="col">
                            II (Dua)
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            Tahun Pelajaran
                        </div>
                        <div class="col-auto">:</div>
                        <div class="col">
                            2022/2023
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center align-middle no-td">No</th>
                    <th class="text-center align-middle">Mata Pelajaran</th>
                    <th class="text-center align-middle">KKM</th>
                    <th class="text-center align-middle" colspan="2">Nilai</th>
                    <th class="text-center align-middle">Catatan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "
                    SELECT 
                        ns.nilai,
                        mpk.kkm,
                        mp.nama AS mata_pelajaran 
                    FROM 
                        nilai_siswa AS ns 
                    INNER JOIN 
                        mata_pelajaran_kelas AS mpk 
                    ON 
                        mpk.id=ns.id_mata_pelajaran_kelas 
                    INNER JOIN 
                        mata_pelajaran AS mp 
                    ON 
                        mp.id=mpk.id_mata_pelajaran  
                    WHERE 
                        id_semester_kelas=" . $_GET['id_semester_kelas'];

                $data = $mysqli->query($query);
                $no = 1;
                ?>
                <?php if ($data->num_rows) : ?>
                    <?php while ($row = $data->fetch_assoc()) : ?>
                        <tr>
                            <td class="text-center align-middle"><?= $no++; ?></td>
                            <td class="align-middle"><?= $row['mata_pelajaran']; ?></td>
                            <td class="text-center align-middle"><?= $row['kkm']; ?></td>
                            <td class="text-center align-middle"><?= $row['nilai']; ?></td>
                            <td class="text-center align-middle">Tujuh Puluh</td>
                            <td class="text-center align-middle">Baik</td>
                        </tr>
                    <?php endwhile; ?>
                <?php else : ?>
                    <tr>
                        <td class="text-center" colspan="4">Tidak Ada Data</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>
</body>

</html>