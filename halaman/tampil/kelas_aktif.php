<?php $kelas = $mysqli->query("SELECT * FROM kelas WHERE id=" . $_GET['id_kelas'])->fetch_assoc(); ?>
<main class="content">
    <div class="container-fluid p-0">

        <div class="mb-3 d-flex justify-content-between align-items-center">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item active">
                        <h1 class="h3 d-inline">Kelas <?= $kelas['nama']; ?></h1>
                    </li>
                </ol>
            </nav>
            <a href="?h=tambah_kelas_aktif&id_kelas=<?= $_GET['id_kelas']; ?>" class="btn btn-primary align-self-start">Tambah</a>
        </div>

        <div class="row">
            <?php if (isset($_SESSION['tambah_data'])) : ?>
                <div class="col-12">
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <div class="alert-message">
                            <h4 class="alert-heading">Tambah Data Berhasil</h4>
                            <p>Berhasil menambah kelas aktif dengan nama <strong><?= $_SESSION['tambah_data']['nama']; ?></strong>.</p>
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
                            <p>Berhasil memperbaharui kelas aktif <strong><?= $_SESSION['edit_data']['nama']; ?></strong>.</p>
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
                            <p>Berhasil menghapus kelas aktif <strong><?= $_SESSION['hapus_data']['nama']; ?></strong>.</p>
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
                                    <th class="text-center td-fit">Tahun Pelajaran</th>
                                    <th class="text-center td-fit">Nama Kelas</th>
                                    <th class="text-center td-fit">NIP</th>
                                    <th class="text-center">Wali Kelas</th>
                                    <th class="text-center td-fit">Jumlah Siswa</th>
                                    <th class="text-center td-fit">Aksi</th>
                                </tr>
                            </thead>
                            <?php
                            $query = "
                                SELECT 
                                    ka.id,
                                    k.nama AS kelas,
                                    ka.nama,
                                    ka.tahun_pelajaran,
                                    g.nip,
                                    g.nama AS wali_kelas,
                                    (SELECT COUNT(id) FROM kelas_siswa AS ks WHERE ks.id_kelas_aktif=ka.id AND status!='Tidak Aktif') AS jumlah_siswa 
                                FROM 
                                    kelas_aktif AS ka 
                                INNER JOIN 
                                    kelas AS k 
                                ON 
                                    k.id=ka.id_kelas 
                                INNER JOIN 
                                    guru AS g 
                                ON 
                                    g.id=ka.id_guru 
                                WHERE 
                                    k.id=" . $_GET['id_kelas'] . " 
                                    AND 
                                    ka.status = 'Aktif' 
                                ORDER BY 
                                    ka.tahun_pelajaran, ka.nama";
                            $result = $mysqli->query($query);
                            $kelas_before = '';
                            ?>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()) : ?>
                                    <tr>
                                        <td class="text-center td-fit"><?= $row['tahun_pelajaran']; ?></td>
                                        <td class="text-center td-fit"><?= $row['nama']; ?></td>
                                        <td class="text-center td-fit"><?= $row['nip']; ?></td>
                                        <td><?= $row['wali_kelas']; ?></td>
                                        <td class="text-center td-fit"><?= $row['jumlah_siswa']; ?></td>
                                        <td class="text-center td-fit">
                                            <a href="?h=lihat_kelas_aktif-siswa&id_kelas=<?= $_GET['id_kelas']; ?>&id_kelas_aktif=<?= $row['id']; ?>" class="btn btn-sm btn-success">Lihat Siswa</a>
                                            <a href="?h=lihat_kelas_aktif-mata_pelajaran&id_kelas=<?= $_GET['id_kelas']; ?>&id_kelas_aktif=<?= $row['id']; ?>" class="btn btn-sm btn-info">Lihat Mata Pelajaran</a>
                                            <a href="?h=edit_kelas_aktif&id_kelas=<?= $_GET['id_kelas']; ?>&id_kelas_aktif=<?= $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                            <a href="?h=hapus_kelas_aktif&id_kelas=<?= $_GET['id_kelas']; ?>&id_kelas_aktif=<?= $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
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