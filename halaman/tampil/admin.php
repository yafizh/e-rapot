<main class="content">
    <div class="container-fluid p-0">

        <div class="mb-3 d-flex justify-content-between">
            <h1 class="h3 d-inline align-middle">Data Admin</h1>
            <a href="?h=tambah_admin" class="btn btn-primary">Tambah</a>
        </div>

        <div class="row">
            <?php if (isset($_SESSION['tambah_data'])) : ?>
                <div class="col-12">
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <div class="alert-message">
                            <h4 class="alert-heading">Tambah Data Berhasil</h4>
                            <p>Berhasil menambah data admin dengan username <strong><?= $_SESSION['tambah_data']['username']; ?></strong>.</p>
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
                            <p>Berhasil memperbaharui data admin <strong><?= $_SESSION['edit_data']['username']; ?></strong>.</p>
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
                            <p>Berhasil menghapus data admin <strong><?= $_SESSION['hapus_data']['username']; ?></strong>.</p>
                            <hr>
                        </div>
                    </div>
                </div>
                <?php unset($_SESSION['hapus_data']); ?>
            <?php elseif (isset($_SESSION['ganti_password'])) : ?>
                <div class="col-12">
                    <div class="alert alert-success alert-dismissible delete" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <div class="alert-message">
                            <h4 class="alert-heading">Hapus Data Berhasil</h4>
                            <p>Berhasil memperbaharui password admin <strong><?= $_SESSION['ganti_password']['username']; ?></strong>.</p>
                            <hr>
                        </div>
                    </div>
                </div>
                <?php unset($_SESSION['ganti_password']); ?>
            <?php endif; ?>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped datatables-reponsive" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-center td-fit">No</th>
                                    <th class="text-center">Username</th>
                                    <th class="text-center td-fit">Aksi</th>
                                </tr>
                            </thead>
                            <?php
                            $result = $mysqli->query("SELECT * FROM user ORDER BY username");
                            $no = 1;
                            ?>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()) : ?>
                                    <tr>
                                        <td class="text-center td-fit"><?= $no++; ?></td>
                                        <td class="text-center"><?= $row['username']; ?></td>
                                        <td class="text-center td-fit">
                                            <a href="?h=ganti_password&id=<?= $row['id']; ?>" class="btn btn-sm btn-secondary">Ganti Password</a>
                                            <a href="?h=edit_admin&id=<?= $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                            <a href="?h=hapus_admin&id=<?= $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
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