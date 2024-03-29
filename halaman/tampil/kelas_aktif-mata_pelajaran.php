<?php $kelas = $mysqli->query("SELECT * FROM kelas WHERE id=" . $_GET['id_kelas'])->fetch_assoc(); ?>
<?php $kelas_aktif = $mysqli->query("SELECT * FROM kelas_aktif WHERE id=" . $_GET['id_kelas_aktif'])->fetch_assoc(); ?>
<main class="content">
    <div class="container-fluid p-0">

        <div class="mb-3 d-flex justify-content-between">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <h1 class="h3 d-inline"><a href="?h=kelas_aktif&id_kelas=<?= $_GET['id_kelas']; ?>">Kelas <?= $kelas['nama']; ?></a></h1>
                    </li>
                    <li class="breadcrumb-item active">
                        <h1 class="h3 d-inline">Mata Pelajaran Kelas <?= $kelas_aktif['nama']; ?></h1>
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
                            <p>Berhasil menambah mata pelajaran <strong><?= $_SESSION['tambah_data']['nama']; ?></strong> pada kelas <?= $kelas_aktif['nama']; ?>.</p>
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
                            <p>Berhasil menghapus mata pelajaran <strong><?= $_SESSION['hapus_data']['nama']; ?></strong> pada kelas <?= $kelas_aktif['nama']; ?>.</p>
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
                                    <th class="text-center">NIP</th>
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
                                    mpk.rps,
                                    mp.nama mata_pelajaran,
                                    g.nama pengajar,
                                    g.nip 
                                FROM 
                                    mata_pelajaran_kelas mpk 
                                INNER JOIN 
                                    mata_pelajaran mp 
                                ON 
                                    mp.id=mpk.id_mata_pelajaran 
                                INNER JOIN 
                                    guru g 
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
                                            <td class="text-center td-fit"><?= $row['nip']; ?></td>
                                            <td><?= $row['pengajar']; ?></td>
                                            <td class="text-center"><?= $row['mata_pelajaran']; ?></td>
                                            <td class="text-center"><?= $row['kkm']; ?></td>
                                            <td class="text-center td-fit">
                                                <a href="<?= $row['rps'] ?>" target="_blank" class="btn btn-sm btn-info">RPS</a>
                                                <a href="?h=hapus_kelas_aktif-mata_pelajaran&id_kelas=<?= $_GET['id_kelas'] ?>&id_kelas_aktif=<?= $_GET['id_kelas_aktif'] ?>&id=<?= $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else : ?>
                                    <tr>
                                        <td class="text-center" colspan="6">Data Tidak Ada</td>
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