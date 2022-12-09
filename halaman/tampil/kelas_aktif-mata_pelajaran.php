<?php $kelas_aktif = $mysqli->query("SELECT * FROM kelas_aktif WHERE id=" . $_GET['id_kelas_aktif'])->fetch_assoc(); ?>
<main class="content">
    <div class="container-fluid p-0">

        <div class="mb-3 d-flex justify-content-between">
            <h1 class="h3 d-inline align-middle">Data Mata Pelajaran Kelas <?= $kelas_aktif['nama']; ?></h1>
            <div>
                <a href="?h=kelas_aktif&id_kelas=<?= $_GET['id_kelas'] ?>" class="btn btn-secondary">Kembali</a>
                <a href="?h=tambah_kelas_aktif-mata_pelajaran&id_kelas=<?= $_GET['id_kelas'] ?>&id_kelas_aktif=<?= $kelas_aktif['id']; ?>" class="btn btn-primary">Tambah</a>
            </div>
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
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-center td-fit">No</th>
                                    <th class="text-center">Mata Pelajaran</th>
                                    <th class="text-center">KKM</th>
                                    <th class="text-center td-fit">Aksi</th>
                                </tr>
                            </thead>
                            <?php
                            $query = "
                                SELECT 
                                    mpk.id,
                                    mpk.kkm,
                                    mp.nama
                                FROM 
                                    mata_pelajaran_kelas AS mpk 
                                INNER JOIN 
                                    mata_pelajaran AS mp 
                                ON 
                                    mp.id=mpk.id_mata_pelajaran 
                                WHERE 
                                    mpk.id_kelas_aktif=" . $_GET['id_kelas_aktif'] . " 
                                ORDER BY 
                                    mp.nama 
                            ";
                            $result = $mysqli->query($query);
                            $no = 1;
                            ?>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()) : ?>
                                    <tr>
                                        <td class="text-center td-fit"><?= $no++; ?></td>
                                        <td class="text-center"><?= $row['nama']; ?></td>
                                        <td class="text-center"><?= $row['kkm']; ?></td>
                                        <td class="text-center td-fit">
                                            <a href="?h=hapus_kelas_aktif-mata_pelajaran&id_kelas=<?= $_GET['id_kelas'] ?>&id_kelas_aktif=<?= $_GET['id_kelas_aktif'] ?>&id=<?= $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
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