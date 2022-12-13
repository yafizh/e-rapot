<main class="content">
    <div class="container-fluid p-0">

        <div class="mb-3 d-flex justify-content-between">
            <h1 class="h3 d-inline align-middle">Data Siswa</h1>
            <?php if (($_GET['status'] ?? '') !== 'Alumni') : ?>
                <a href="?h=tambah_siswa" class="btn btn-primary">Tambah</a>
            <?php endif; ?>
        </div>

        <div class="row">
            <?php if (isset($_SESSION['tambah_data'])) : ?>
                <div class="col-12">
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <div class="alert-message">
                            <h4 class="alert-heading">Tambah Data Berhasil</h4>
                            <p>Berhasil menambah data siswa dengan nama <strong><?= $_SESSION['tambah_data']['nama']; ?></strong>.</p>
                            <hr>
                            <div class="btn-list">
                                <button class="btn btn-secondary" type="button" data-bs-dismiss="alert" aria-label="Close">Tutup</button>
                                <a href="?h=lihat_siswa&id=<?= $_SESSION['tambah_data']['id']; ?>" class="btn btn-info">Lihat</a>
                            </div>
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
                            <p>Berhasil memperbaharui data siswa <strong><?= $_SESSION['edit_data']['nama']; ?></strong>.</p>
                            <hr>
                            <div class="btn-list">
                                <button class="btn btn-secondary" type="button" data-bs-dismiss="alert" aria-label="Close">Tutup</button>
                                <a href="?h=lihat_siswa&id=<?= $_SESSION['edit_data']['id']; ?>" class="btn btn-info">Lihat</a>
                            </div>
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
                            <p>Berhasil menghapus data siswa <strong><?= $_SESSION['hapus_data']['nama']; ?></strong>.</p>
                            <hr>
                        </div>
                    </div>
                </div>
                <?php unset($_SESSION['hapus_data']); ?>
            <?php endif; ?>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped datatables-reponsive" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-center td-fit">No</th>
                                    <th class="text-center">Nama</th>
                                    <th class="text-center">Tempat Lahir</th>
                                    <th class="text-center">Tanggal Lahir</th>
                                    <th class="text-center">Jenis Kelamin</th>
                                    <th class="text-center td-fit">Aksi</th>
                                </tr>
                            </thead>
                            <?php
                            if (($_GET['status'] ?? '') == 'Alumni') {
                                $q = "
                                    SELECT DISTINCT
                                        s.*  
                                    FROM 
                                        siswa AS s 
                                    INNER JOIN 
                                        kelas_siswa AS ks 
                                    ON 
                                        ks.id_siswa=s.id 
                                    WHERE 
                                        ks.status='Lulus'
                                ";
                                $result = $mysqli->query($q);
                            } else
                                $result = $mysqli->query("SELECT * FROM siswa ORDER BY nama");
                            $no = 1;
                            ?>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()) : ?>
                                    <tr>
                                        <td class="text-center td-fit"><?= $no++; ?></td>
                                        <td class="text-center"><?= $row['nama']; ?></td>
                                        <td class="text-center"><?= $row['tempat_lahir']; ?></td>
                                        <td class="text-center"><?= indonesiaDate($row['tanggal_lahir']); ?></td>
                                        <td class="text-center"><?= $row['jenis_kelamin']; ?></td>
                                        <td class="text-center td-fit">
                                            <a href="?h=lihat_siswa&id=<?= $row['id']; ?>" class="btn btn-sm btn-info">Lihat</a>
                                            <a href="?h=edit_siswa&id=<?= $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                            <a href="?h=hapus_siswa&id=<?= $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>