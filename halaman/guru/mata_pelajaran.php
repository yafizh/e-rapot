<main class="content">
    <div class="container-fluid p-0">
        <h1 class="mb-3">Halaman Presensi dan Forum Diskusi</h1>
        <div class="row">
            <div class="col-12 col-md-5">
                <?php
                $q = "
                    SELECT  
                        *
                    FROM 
                        presensi_mata_pelajaran_kelas pmpk 
                    WHERE 
                        pmpk.id_mata_pelajaran_kelas=" . $_GET['id'] . " 
                    ORDER BY    
                        pmpk.tanggal DESC 
                ";
                $result = $mysqli->query($q);
                ?>
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h3>Presensi</h3>
                        <a href="?h=tambah_presensi&id=<?= $_GET['id']; ?>" class="btn btn-primary">Tambah Presensi</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">Tanggal</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()) : ?>
                                    <tr>
                                        <td class="text-center"><?= indoensiaDateWithDay($row['tanggal']); ?></td>
                                        <td class="text-center">
                                            <a href="?h=lihat_presensi&id=<?= $_GET['id'] ?>&idd=<?= $row['id'] ?>" class="btn btn-info btn-sm">Lihat</a>
                                            <a href="?h=edit_presensi&id=<?= $_GET['id'] ?>&idd=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                            <a href="?h=hapus_presensi&id=<?= $_GET['id'] ?>&idd=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin?')">Hapus</a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php
                $q = "
                    SELECT  
                        *
                    FROM 
                        tugas_mata_pelajaran_kelas pmpk 
                    WHERE 
                        pmpk.id_mata_pelajaran_kelas=" . $_GET['id'] . " 
                    ORDER BY 
                        pmpk.tanggal_mulai DESC 
                ";
                $result = $mysqli->query($q);
                ?>
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h3>Tugas</h3>
                        <a href="?h=tambah_tugas&id=<?= $_GET['id']; ?>" class="btn btn-primary">Tambah Tugas</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">Nama Tugas</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()) : ?>
                                    <tr>
                                        <td class="text-center"><?= $row['nama']; ?></td>
                                        <td class="text-center">
                                            <a href="?h=lihat_tugas&id=<?= $_GET['id'] ?>&idd=<?= $row['id'] ?>" class="btn btn-info btn-sm">Lihat</a>
                                            <a href="?h=edit_tugas&id=<?= $_GET['id'] ?>&idd=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                            <a href="?h=hapus_tugas&id=<?= $_GET['id'] ?>&idd=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin?')">Hapus</a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md bg-white">
                <div class="py-3 px-4 border-bottom">
                    <h4 class="mb-0">Forum Diskusi Kelas</h4>
                </div>
                <?php include_once('templates/forum_diskusi.php') ?>
            </div>
        </div>
    </div>
</main>