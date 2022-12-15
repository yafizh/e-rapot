<?php $kelas = $mysqli->query("SELECT * FROM kelas WHERE id=" . $_GET['id_kelas'])->fetch_assoc(); ?>
<?php $kelas_aktif = $mysqli->query("SELECT * FROM kelas_aktif WHERE id=" . $_GET['id_kelas_aktif'])->fetch_assoc(); ?>

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
                                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#semesterSelesai">Lihat Peringkat</button>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center td-fit">No</th>
                                            <th class="text-center">Nama</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Rapot</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $query = "
                                                SELECT 
                                                    ks.id,
                                                    ks.status,
                                                    s.nama 
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
                                                <td><?= $row['nama']; ?></td>
                                                <td class="text-center"><?= $row['status']; ?></td>
                                                <td class="text-center td-fit">
                                                    <?php
                                                    $q = "
                                                            SELECT 
                                                                sk.id,
                                                                s.nama  
                                                            FROM 
                                                                semester_kelas AS sk 
                                                            INNER JOIN 
                                                                semester AS s 
                                                            ON 
                                                                s.id=sk.id_semester 
                                                            WHERE 
                                                                sk.id_kelas_siswa = " . $row['id'] . " 
                                                            ORDER BY 
                                                                s.tingkat ASC
                                                            ";
                                                    $result2 = $mysqli->query($q);
                                                    ?>
                                                    <?php while ($row2 = $result2->fetch_assoc()) : ?>
                                                        <a href="halaman/cetak/rapot.php?id_semester_kelas=<?= $row2['id']; ?>" class="btn btn-info btn-sm" target="_blank">Semester <?= $row2['nama']; ?></a>
                                                    <?php endwhile; ?>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                                <div class="modal fade" id="semesterSelesai" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Seluruh Semester</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body m-3">
                                                <table class="table table-bordered" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">Nama</th>
                                                            <th class="text-center td-fit">Ranking</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $query = "
                                                                SELECT 
                                                                    s.nama 
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
                                                        $result = $mysqli->query($query);
                                                        ?>
                                                        <?php while ($row = $result->fetch_assoc()) : ?>
                                                            <tr>
                                                                <td><?= $row['nama']; ?></td>
                                                                <td></td>
                                                            </tr>
                                                        <?php endwhile; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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