<?php $kelas = $mysqli->query("SELECT * FROM kelas WHERE id=" . $_GET['id_kelas'])->fetch_assoc(); ?>
<?php $kelas_aktif = $mysqli->query("SELECT * FROM kelas_aktif WHERE id=" . $_GET['id_kelas_aktif'])->fetch_assoc(); ?>
<?php $semester = $mysqli->query("SELECT * FROM semester ORDER BY tingkat DESC")->fetch_all(MYSQLI_ASSOC); ?>

<main class="content">
    <div class="container-fluid p-0">

        <div class="mb-3 d-flex justify-content-between">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <h1 class="h3 d-inline"><a href="?h=kelas_selesai&id_kelas=<?= $_GET['id_kelas']; ?>">Kelas <?= $kelas['nama']; ?></a></h1>
                    </li>
                    <li class="breadcrumb-item active">
                        <h1 class="h3 d-inline">Siswa Kelas <?= $kelas_aktif['nama']; ?></h1>
                    </li>
                </ol>
            </nav>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-6">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h5 class="card-title mb-0 align-self-center">Seluruh Semester</h5>
                                <div>
                                    <?php foreach ($semester as $value) : ?>
                                        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modalLihatPeringkatSemester<?= $value['nama']; ?>">
                                            Lihat Peringkat Semester <?= $value['nama']; ?>
                                        </button>
                                        <div class="modal fade" id="modalLihatPeringkatSemester<?= $value['nama']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Peringkat Siswa Semester <?= $value['nama']; ?></h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body m-3">
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th class="text-center">NIS/NISN</th>
                                                                    <th class="text-center">Nama</th>
                                                                    <th class="text-center">Total Nilai</th>
                                                                    <th class="text-center">Rata - Rata</th>
                                                                    <th class="text-center">Peringkat</th>
                                                                    <th class="text-center">Rapot</th>
                                                                </tr>
                                                            </thead>
                                                            <?php
                                                            $q = "
                                                            SELECT 
                                                                s.nis,
                                                                s.nisn,
                                                                s.nama,
                                                                sk.id AS id_semester_kelas,
                                                                SUM(ns.nilai) AS total_nilai, 
                                                                (SUM(ns.nilai)/COUNT(ns.id)) AS rata_rata 
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
                                                                ka.id=" . $_GET['id_kelas_aktif'] . "
                                                            GROUP BY 
                                                                sk.id 
                                                            ORDER BY 
                                                                rata_rata DESC
                                                        ";
                                                            $result = $mysqli->query($q);
                                                            $peringkat = 1;
                                                            ?>
                                                            <tbody>
                                                                <?php while ($row = $result->fetch_assoc()) : ?>
                                                                    <tr>
                                                                        <td class="text-center"><?= $row['nis']; ?>/<?= $row['nisn']; ?></td>
                                                                        <td><?= $row['nama']; ?></td>
                                                                        <td class="text-center"><?= $row['total_nilai']; ?></td>
                                                                        <td class="text-center"><?= $row['rata_rata']; ?></td>
                                                                        <td class="text-center td-fit"><?= $peringkat++; ?></td>
                                                                        <td class="text-center td-fit">
                                                                            <a href="halaman/cetak/rapot.php?id_semester_kelas=<?= $row['id_semester_kelas']; ?>" class="btn btn-info btn-sm" target="_blank">Lihat</a>
                                                                        </td>
                                                                    </tr>
                                                                <?php endwhile; ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center td-fit">No</th>
                                            <th class="text-center">NIS/NISN</th>
                                            <th class="text-center">Nama</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $query = "
                                                SELECT 
                                                    ks.id,
                                                    ks.status,
                                                    s.nama,
                                                    s.nis,
                                                    s.nisn  
                                                FROM 
                                                    kelas_siswa AS ks 
                                                INNER JOIN 
                                                    siswa AS s 
                                                ON 
                                                    s.id=ks.id_siswa 
                                                WHERE 
                                                    ks.id_kelas_aktif=" . $_GET['id_kelas_aktif'] . " 
                                                ORDER BY 
                                                    s.nama 
                                            ";
                                        $no = 1;
                                        $result = $mysqli->query($query);
                                        ?>
                                        <?php while ($row = $result->fetch_assoc()) : ?>
                                            <tr>
                                                <td class="text-center td-fit"><?= $no++; ?></td>
                                                <td class="text-center"><?= $row['nis']; ?>/<?= $row['nisn']; ?></td>
                                                <td><?= $row['nama']; ?></td>
                                                <td class="text-center"><?= $row['status']; ?></td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h5 class="card-title mb-0 align-self-center">Mata Pelajaran Kelas</h5>
                                <button type="button" class="btn btn-info invisible">Lihat Peringkat</button>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center td-fit">No</th>
                                            <th class="text-center">Pengajar</th>
                                            <th class="text-center">Mata Pelajaran</th>
                                            <th class="text-center">KKM</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    $query = "
                                        SELECT 
                                            mpk.id,
                                            mpk.kkm,
                                            mp.nama AS mata_pelajaran,
                                            g.nama AS pengajar
                                        FROM 
                                            mata_pelajaran_kelas AS mpk 
                                        INNER JOIN 
                                            mata_pelajaran AS mp 
                                        ON 
                                            mp.id=mpk.id_mata_pelajaran 
                                        INNER JOIN 
                                            guru AS g 
                                        ON 
                                            g.id=mpk.id_guru 
                                        WHERE 
                                            mpk.id_kelas_aktif=" . $_GET['id_kelas_aktif'] . " 
                                        ORDER BY 
                                            mp.nama 
                                    ";
                                    $result = $mysqli->query($query);
                                    $no = 1;
                                    ?>
                                    <tbody>
                                        <?php if ($result->num_rows) : ?>
                                            <?php while ($row = $result->fetch_assoc()) : ?>
                                                <tr>
                                                    <td class="text-center td-fit"><?= $no++; ?></td>
                                                    <td class="text-center"><?= $row['pengajar']; ?></td>
                                                    <td class="text-center"><?= $row['mata_pelajaran']; ?></td>
                                                    <td class="text-center"><?= $row['kkm']; ?></td>
                                                </tr>
                                            <?php endwhile; ?>
                                        <?php else : ?>
                                            <tr>
                                                <td class="text-center" colspan="4">Data Tidak Ada</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>