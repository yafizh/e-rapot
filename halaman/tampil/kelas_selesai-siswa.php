<?php $kelas = $mysqli->query("SELECT * FROM kelas WHERE id=" . $_GET['id_kelas'])->fetch_assoc(); ?>
<?php $semester = $mysqli->query("SELECT * FROM semester ORDER BY tingkat DESC")->fetch_all(MYSQLI_ASSOC); ?>
<?php $kelas_aktif = $mysqli->query("SELECT * FROM kelas_aktif WHERE id=" . $_GET['id_kelas_aktif'])->fetch_assoc(); ?>
<?php
$data = [];
$latest_semester = true;
foreach ($semester as $key => $value) {
    $query = "
            SELECT 
                sk.id AS id_semester_kelas,
                ks.id,
                ks.status,
                s.id AS id_siswa,
                s.nama 
            FROM 
                kelas_siswa AS ks 
            INNER JOIN 
                siswa AS s 
            ON 
                s.id=ks.id_siswa 
            INNER JOIN 
                semester_kelas AS sk 
            ON 
                sk.id_kelas_siswa=ks.id  
            WHERE 
                ks.id_kelas_aktif=" . $_GET['id_kelas_aktif'] . " 
                AND 
                sk.id_semester=" . $value['id'] . "
            ORDER BY 
                s.nama 
        ";
    $data[] = $mysqli->query($query)->fetch_all(MYSQLI_ASSOC);
}
?>

<main class="content">
    <div class="container-fluid p-0">

        <div class="mb-3 d-flex justify-content-between">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <h1 class="h3 d-inline"><a href="?h=kelas_aktif&id_kelas=<?= $_GET['id_kelas']; ?>">Kelas <?= $kelas['nama']; ?></a></h1>
                    </li>
                    <li class="breadcrumb-item active">
                        <h1 class="h3 d-inline">Siswa Kelas <?= $kelas_aktif['nama']; ?></h1>
                    </li>
                </ol>
            </nav>
        </div>

        <div class="row">
            <?php if (isset($_SESSION['tambah_data'])) : ?>
                <div class="col-12">
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <div class="alert-message">
                            <h4 class="alert-heading">Tambah Data Berhasil</h4>
                            <p>Berhasil menambah data siswa.</p>
                            <hr>
                        </div>
                    </div>
                </div>
                <?php unset($_SESSION['tambah_data']); ?>
            <?php elseif (isset($_SESSION['hapus_data'])) : ?>
                <div class="col-12">
                    <div class="alert alert-success alert-dismissible delete" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <div class="alert-message">
                            <h4 class="alert-heading">Hapus Data Berhasil</h4>
                            <p>Berhasil menghapus siswa <strong><?= $_SESSION['hapus_data']['nama']; ?></strong>.</p>
                            <hr>
                        </div>
                    </div>
                </div>
                <?php unset($_SESSION['hapus_data']); ?>
            <?php endif; ?>
            <?php if ($kelas_aktif['status'] == 'Selesai') : ?>
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
                    </div>
                </div>
            <?php endif; ?>
            <?php foreach ($data as $key => $value) : ?>
                <?php if (!count($value) && $key < (count($data) - 1)) : ?>
                    <?php continue; ?>
                <?php endif; ?>
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h5 class="card-title mb-0 align-self-center">Semester <?= $semester[$key]['nama']; ?></h5>
                            <div>
                                <?php if ($latest_semester && $kelas_aktif['status'] == 'Aktif') : ?>
                                    <a href="?h=tambah_kelas_aktif-siswa&id_kelas=<?= $_GET['id_kelas'] ?>&id_kelas_aktif=<?= $kelas_aktif['id']; ?>&id_semester=<?= $semester[$key]['id']; ?>" class="btn btn-primary">Tambah Siswa</a>
                                    <a href="?h=tambah_kelas_aktif-semester_kelas&id_kelas=<?= $_GET['id_kelas'] ?>&id_kelas_aktif=<?= $kelas_aktif['id']; ?>&id_semester=<?= $semester[$key]['id']; ?>" class="btn btn-success">Semester Selesai</a>
                                    <?php $latest_semester = false; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center td-fit">No</th>
                                        <th class="text-center">Nama</th>
                                        <th class="text-center td-fit">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (count($value)) : ?>
                                        <?php foreach ($value as $index => $row) : ?>
                                            <tr>
                                                <td class="text-center td-fit"><?= ++$index; ?></td>
                                                <td><?= $row['nama']; ?></td>
                                                <td class="text-center td-fit">
                                                    <a href="?h=tambah_kelas_aktif-siswa-nilai&id_kelas=<?= $_GET['id_kelas'] ?>&id_kelas_aktif=<?= $_GET['id_kelas_aktif'] ?>&id_semester_kelas=<?= $row['id_semester_kelas'] ?>&id_siswa=<?= $row['id_siswa'] ?>&id=<?= $row['id']; ?>" class="btn btn-sm btn-info">Nilai</a>
                                                    <a href="?h=hapus_kelas_aktif-siswa&id_kelas=<?= $_GET['id_kelas'] ?>&id_kelas_aktif=<?= $_GET['id_kelas_aktif'] ?>&id=<?= $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td class="text-center" colspan="4">Data Tidak Ada</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="modal fade" id="semester<?= $value['tingkat']; ?>Selesai" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title"><?= $value['nama']; ?></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body m-3">
                                        <p class="mb-0">Dengan menyatakan <strong><?= $value['nama']; ?></strong> telah selesai, maka wali kelas tidak dapat lagi memberikan nilai kepada siswa yang berada di <strong><?= $value['nama']; ?></strong>.</p>
                                    </div>
                                    <div class="modal-footer">
                                        <!-- <input type="text" name="id_semester" hidden value="<?= $value['id']; ?>"> -->
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" name="submit" class="btn btn-primary">Selesai</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>