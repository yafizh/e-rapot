<main class="content">
    <div class="container-fluid p-0">

        <div class="mb-3 d-flex justify-content-between">
            <h1 class="h3 d-inline align-middle">Data Guru</h1>
            <a href="?h=tambah_guru" class="btn btn-primary">Tambah</a>
        </div>

        <div class="row">
            <?php if (isset($_SESSION['tambah_data'])) : ?>
                <div class="col-12">
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <div class="alert-message">
                            <h4 class="alert-heading">Tambah Data Berhasil</h4>
                            <p>Berhasil menambah data guru dengan nama <strong><?= $_SESSION['tambah_data']['nama']; ?></strong>.</p>
                            <hr>
                            <div class="btn-list">
                                <button class="btn btn-secondary" type="button" data-bs-dismiss="alert" aria-label="Close">Tutup</button>
                                <a href="?h=lihat_guru&id=<?= $_SESSION['tambah_data']['id']; ?>" class="btn btn-info">Lihat</a>
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
                            <p>Berhasil memperbaharui data guru <strong><?= $_SESSION['edit_data']['nama']; ?></strong>.</p>
                            <hr>
                            <div class="btn-list">
                                <button class="btn btn-secondary" type="button" data-bs-dismiss="alert" aria-label="Close">Tutup</button>
                                <a href="?h=lihat_guru&id=<?= $_SESSION['edit_data']['id']; ?>" class="btn btn-info">Lihat</a>
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
                            <p>Berhasil menghapus data guru <strong><?= $_SESSION['hapus_data']['nama']; ?></strong>.</p>
                            <hr>
                        </div>
                    </div>
                </div>
                <?php unset($_SESSION['hapus_data']); ?>
            <?php endif; ?>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id="datatables-reponsive" class="table table-striped" style="width:100%">
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
                            $result = $mysqli->query("SELECT * FROM guru ORDER BY nama");
                            $no = 1;
                            ?>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()) : ?>
                                    <tr>
                                        <td class="text-center td-fit"><?= $no++; ?></td>
                                        <td class="text-center"><?= $row['nama']; ?></td>
                                        <td class="text-center"><?= $row['tempat_lahir']; ?></td>
                                        <td class="text-center"><?= $row['tanggal_lahir']; ?></td>
                                        <td class="text-center"><?= $row['jenis_kelamin']; ?></td>
                                        <td class="text-center td-fit">
                                            <a href="?h=lihat_guru&id=<?= $row['id']; ?>" class="btn btn-sm btn-info">Lihat</a>
                                            <a href="?h=edit_guru&id=<?= $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                            <a href="?h=hapus_guru&id=<?= $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
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