<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RAPOT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <style>
        .td-fit {
            width: 1%;
            white-space: nowrap;
        }

        @media print {
            .pagebreak {
                page-break-before: always;
            }
        }
    </style>
</head>

<body>
    <?php include_once('../../db/koneksi.php'); ?>
    <?php include_once('../../functions/predikat.php'); ?>
    <?php include_once('../../functions/number.php'); ?>
    <?php date_default_timezone_set('Asia/Kuala_Lumpur'); ?>
    <?php
    $q = "
        SELECT 
            g.nip AS nip_wali_kelas, 
            g.nama AS wali_kelas, 
            sk.id, 
            s.nis,
            s.nisn,
            s.nama AS nama_siswa,
            k.nama AS kelas, 
            ka.nama AS nama_kelas, 
            semester.nama AS semester,
            ka.tahun_pelajaran,
            sk.sakit,
            sk.izin,
            sk.tanpa_keterangan,
            sk.catatan_wali_kelas 
        FROM 
            semester_kelas AS sk 
        INNER JOIN 
            semester 
        ON 
            semester.id=sk.id_semester 
        INNER JOIN 
            kelas_siswa AS ks 
        ON 
            ks.id=sk.id_kelas_siswa 
        INNER JOIN  
            siswa AS s 
        ON 
            s.id=ks.id_siswa 
        INNER JOIN 
            kelas_aktif AS ka 
        ON 
            ka.id=ks.id_kelas_aktif 
        INNER JOIN 
            guru AS g 
        ON 
            g.id=ka.id_guru 
        INNER JOIN 
            kelas AS k 
        ON 
            k.id=ka.id_kelas 
        WHERE 
            sk.id=" . $_GET['id_semester_kelas'] . "
    ";
    $data = $mysqli->query($q)->fetch_assoc();
    ?>
    <section class="p-3">
        <h4 class="text-center my-3">CAPAIAN HASIL BELAJAR</h4>
        <section class="mb-3">
            <div class="row">
                <div class="col-7">
                    <div class="row">
                        <div style="width: 11rem;" class="pe-0">
                            Nama Sekolah
                        </div>
                        <div class="col-auto p-0">:</div>
                        <div class="col">
                            ABC
                        </div>
                    </div>
                    <div class="row">
                        <div style="width: 11rem;" class="pe-0">
                            Alamat
                        </div>
                        <div class="col-auto p-0">:</div>
                        <div class="col">
                            ABC
                        </div>
                    </div>
                    <div class="row">
                        <div style="width: 11rem;" class="pe-0">
                            Nama Peserta Didik
                        </div>
                        <div class="col-auto p-0">:</div>
                        <div class="col">
                            <?= $data['nama_siswa']; ?>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="row">
                        <div style="width: 8rem;" class="pe-0">
                            Kelas
                        </div>
                        <div class="col-auto p-0">:</div>
                        <div class="col">
                            <?= numberToRomanRepresentation($data['kelas']) ?> <?= $data['nama_kelas']; ?>
                        </div>
                    </div>
                    <div class="row">
                        <div style="width: 8rem;" class="pe-0">
                            Semester
                        </div>
                        <div class="col-auto p-0">:</div>
                        <div class="col">
                            <?= $data['semester']; ?>
                        </div>
                    </div>
                    <div class="row">
                        <div style="width: 8rem;" class="pe-0">
                            Tahun Pelajaran
                        </div>
                        <div class="col-auto p-0">:</div>
                        <div class="col">
                            <?= $data['tahun_pelajaran']; ?>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row">
                        <div style="width: 11rem;" class="pe-0">
                            No. Induk / NISN
                        </div>
                        <div class="col-auto p-0">:</div>
                        <div class="col">
                            <?= $data['nis']; ?>/<?= $data['nisn']; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th rowspan="2" class="text-center align-middle td-fit">No</th>
                    <th rowspan="2" class="text-center align-middle">Mata Pelajaran</th>
                    <th rowspan="2" class="text-center align-middle">KKM</th>
                    <th class="text-center align-middle" colspan="2">Nilai</th>
                    <th rowspan="2" class="text-center align-middle">Catatan</th>
                </tr>
                <tr>
                    <th class="text-center align-middle">Angka</th>
                    <th class="text-center align-middle">Predikat</th>
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

                $result = $mysqli->query($query);
                $no = 1;
                ?>
                <?php if ($result->num_rows) : ?>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td class="text-center align-middle td-fit"><?= $no++; ?></td>
                            <td class="align-middle"><?= $row['mata_pelajaran']; ?></td>
                            <td class="text-center align-middle"><?= $row['kkm']; ?></td>
                            <td class="text-center align-middle"><?= $row['nilai']; ?></td>
                            <td class="text-center align-middle"><?= predikatHuruf($row['kkm'], $row['nilai']); ?></td>
                            <td class="text-center align-middle"><?= predikatKata(predikatHuruf($row['kkm'], $row['nilai'])); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else : ?>
                    <tr>
                        <td class="text-center" colspan="4">Tidak Ada Data</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

    </section>
    <div class="pagebreak"></div>
    <section class="p-3">
        <h4 class="text-center my-3">CATATAN AKHIR SEMESTER</h4>
        <ol>
            <li>Ketidakhadiran</li>
            <table class="table table-bordered mt-3" style="width: 25rem;">
                <tbody>
                    <tr>
                        <td style="width: 10rem;">Sakit</td>
                        <td class="td-fit">:</td>
                        <td class="text-center" style="width: 5rem;"><?= $data['sakit']; ?></td>
                        <td style="width: 5rem;">Hari</td>
                    </tr>
                    <tr>
                        <td style="width: 10rem;">Izin</td>
                        <td class="td-fit">:</td>
                        <td class="text-center" style="width: 5rem;"><?= $data['izin']; ?></td>
                        <td style="width: 5rem;">Hari</td>
                    </tr>
                    <tr>
                        <td style="width: 10rem;">Tanpa Keterangan</td>
                        <td class="td-fit">:</td>
                        <td class="text-center" style="width: 5rem;"><?= $data['tanpa_keterangan']; ?></td>
                        <td style="width: 5rem;">Hari</td>
                    </tr>
                </tbody>
            </table>
            <li>Catatan Wali Kelas</li>
            <div class="border d-flex justify-content-center align-items-center mt-3" style="height: 10rem;"><?= $data['catatan_wali_kelas']; ?></div>
        </ol>

        <div class="row">
            <div class="col-6 text-center">Mengetahui</div>
            <div class="col-6 text-center"></div>
            <div class="col-6 text-center">Orang Tua Wali</div>
            <div class="col-6 text-center">Wali Kelas</div>
        </div>
        <br><br><br><br><br>
        <div class="row">
            <div class="col-6 text-center">Nama Orang Tua Wali</div>
            <div class="col-6 text-center"><?= $data['wali_kelas']; ?></div>
            <div class="col-6 text-center"></div>
            <div class="col-6">
                <div class="row justify-content-center">
                    <div class="col-5 border border-dark"></div>
                </div>
            </div>
            <div class="col-6 text-center"></div>
            <div class="col-6 text-center">NIP. <?= $data['nip_wali_kelas']; ?></div>
        </div>
        <br><br><br><br><br>
        <div class="row">
            <div class="col-12 text-center">Kepala Sekolah</div>
        </div>
        <br><br><br><br><br>
        <div class="row justify-content-center">
            <div class="col-12 text-center">Nama Kepala Sekolah</div>
            <div class="col-3 border border-dark"></div>
            <div class="col-12 text-center">NIP. 12345</div>
        </div>

    </section>
</body>

</html>