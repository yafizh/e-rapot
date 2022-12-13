<?php $kelas_aktif = $mysqli->query("SELECT * FROM kelas_aktif WHERE id=" . $_GET['id_kelas_aktif'])->fetch_assoc(); ?>
<main class="content">
    <div class="container-fluid p-0">

        <div class="mb-3 d-flex justify-content-between">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <h1 class="h3 d-inline"><a href="?h=kelas_aktif&id_kelas=<?= $_GET['id_kelas']; ?>">Kelas Aktif</a></h1>
                    </li>
                    <li class="breadcrumb-item active">
                        <h1 class="h3 d-inline">Mata Pelajaran <?= $kelas_aktif['nama']; ?></h1>
                    </li>
                </ol>
            </nav>
            <a href="?h=tambah_kelas_aktif-mata_pelajaran&id_kelas=<?= $_GET['id_kelas'] ?>&id_kelas_aktif=<?= $kelas_aktif['id']; ?>" class="btn btn-primary">Tambah</a>
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
                                    <th class="text-center">Pengajar</th>
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
                                            <td class="text-center td-fit">
                                                <a href="?h=hapus_kelas_aktif-mata_pelajaran&id_kelas=<?= $_GET['id_kelas'] ?>&id_kelas_aktif=<?= $_GET['id_kelas_aktif'] ?>&id=<?= $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else : ?>
                                    <tr>
                                        <td class="text-center" colspan="5">Data Tidak Ada</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>