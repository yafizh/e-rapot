<?php $semester = $mysqli->query("SELECT * FROM semester ORDER BY tingkat DESC")->fetch_all(MYSQLI_ASSOC); ?>
<?php $kelas_aktif = $mysqli->query("SELECT * FROM kelas_aktif WHERE id=" . $_GET['id_kelas_aktif'])->fetch_assoc(); ?>
<main class="content">
    <div class="container-fluid p-0">

        <div class="mb-3 d-flex justify-content-between">
            <h1 class="h3 d-inline align-middle">Data Siswa Kelas <?= $kelas_aktif['nama']; ?></h1>
            <a href="?h=kelas_aktif&id_kelas=<?= $_GET['id_kelas'] ?>" class="btn btn-secondary">Kembali</a>
        </div>

        <div class="row">
            <?php if (isset($_SESSION['tambah_data'])) : ?>
                <div class="col-12">
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <div class="alert-message">
                            <h4 class="alert-heading">Tambah Data Berhasil</h4>
                            <p>Berhasil menambah data kelas aktif dengan nama <strong><?= $_SESSION['tambah_data']['nama']; ?></strong>.</p>
                            <hr>
                        </div>
                    </div>
                </div>
                <?php unset($_SESSION['tambah_data']); ?>
            <?php elseif (isset($_SESSION['edit_data'])) : ?>
                <div class="col-12">
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <div class="alert-message">
                            <h4 class="alert-heading">Edit Data Berhasil</h4>
                            <p>Berhasil memperbaharui data kelas aktif <strong><?= $_SESSION['edit_data']['nama']; ?>.</p>
                            <hr>
                        </div>
                    </div>
                </div>
                <?php unset($_SESSION['edit_data']); ?>
            <?php elseif (isset($_SESSION['hapus_data'])) : ?>
                <div class="col-12">
                    <div class="alert alert-success alert-dismissible delete" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <div class="alert-message">
                            <h4 class="alert-heading">Hapus Data Berhasil</h4>
                            <p>Berhasil menghapus data kelas aktif <strong><?= $_SESSION['hapus_data']['nama']; ?></strong>.</p>
                            <hr>
                        </div>
                    </div>
                </div>
                <?php unset($_SESSION['hapus_data']); ?>
            <?php endif; ?>
            <?php foreach ($semester as $key => $value) : ?>
                <?php
                $query = "
                    SELECT 
                        sk.id AS id_semester_kelas,
                        ks.id,
                        ks.status,
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
                $result = $mysqli->query($query);
                $no = 1;
                ?>
                <?php if (!$result->num_rows && $key < (count($semester) - 1)) : ?>
                    <?php continue; ?>
                <?php endif; ?>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h5 class="card-title mb-0 align-self-center"><?= $value['nama']; ?></h5>
                            <div>
                                <a href="#" class="btn btn-info">Lihat Peringkat</a>
                                <a href="?h=tambah_kelas_aktif-siswa&id_kelas=<?= $_GET['id_kelas'] ?>&id_kelas_aktif=<?= $kelas_aktif['id']; ?>&id_semester=<?= $value['id']; ?>" class="btn btn-primary">Tambah Siswa</a>
                                <a href="#" class="btn btn-success">Semester Selesai</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center td-fit">No</th>
                                        <th class="text-center">Nama</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center td-fit">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = $result->fetch_assoc()) : ?>
                                        <tr>
                                            <td class="text-center td-fit"><?= $no++; ?></td>
                                            <td class="text-center"><?= $row['nama']; ?></td>
                                            <td class="text-center"><?= $row['status']; ?></td>
                                            <td class="text-center td-fit">
                                                <a href="?h=tambah_kelas_aktif-siswa-nilai&id_kelas=<?= $_GET['id_kelas'] ?>&id_kelas_aktif=<?= $_GET['id_kelas_aktif'] ?>&id_semester_kelas=<?= $row['id_semester_kelas'] ?>&id=<?= $row['id']; ?>" class="btn btn-sm btn-info">Nilai</a>
                                                <a href="?h=hapus_kelas_aktif-siswa&id_kelas=<?= $_GET['id_kelas'] ?>&id_kelas_aktif=<?= $_GET['id_kelas_aktif'] ?>&id=<?= $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>