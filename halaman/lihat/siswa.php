<?php
$query = "
    SELECT 
        s.*,
        IFNULL(
            (
                SELECT 
                    k.nama 
                FROM 
                    kelas_siswa AS ks 
                INNER JOIN 
                    kelas_aktif AS ka 
                ON 
                    ka.id=ks.id_kelas_aktif 
                INNER JOIN 
                    kelas AS k 
                ON 
                    k.id=ka.id_kelas 
                WHERE 
                    ks.id_siswa=" . $_GET['id'] . " 
                ORDER BY 
                    ks.id DESC 
                LIMIT 1
            ),
            0
        ) AS kelas  
    FROM 
        siswa AS s 
    WHERE s.id=" . $_GET['id'];
$data = $mysqli->query($query)->fetch_assoc(); ?>
<main class="content">
    <div class="container-fluid p-0">

        <h1 class="h3 mb-3">Detail Guru</h1>

        <div class="row">
            <div class="col-md-4 col-xl-3">
                <div class="card mb-3">
                    <div class="card-body text-center">
                        <img src="<?= $data['foto']; ?>" onerror="imageError(this)" class="img-fluid rounded-circle mb-2" style="width: 180px; height: 180px; object-fit:cover;" />
                        <h5 class="card-title mb-0 mt-3"><?= $data['nama']; ?></h5>
                        <div class="text-muted mb-2">
                            <?php if ($data['status'] == 'Alumni') : ?>
                                Telah Lulus
                            <?php elseif ($data['status'] == 'Aktif') : ?>
                                Sekarang: <?= empty($data['kelas']) ? 'Menunggu Pembagian Kelas' : 'Kelas ' . $data['kelas']; ?>
                            <?php elseif ($data['status'] == 'Tidak Aktif' && $data['status'] == 'Tidak Naik Kelas' || $data['status'] == 'Tidak Lulus') : ?>
                                Kelas Terakhir: <?= $data['kelas']; ?>
                            <?php elseif ($data['status'] == 'Lulus') : ?>
                                Telah Lulus
                            <?php else : ?>
                                Belum Memulai Proses Pembelajaran
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8 col-xl-9">
                <div class="card">
                    <div class="card-header">

                        <h5 class="card-title mb-0">Data Diri</h5>
                    </div>
                    <div class="card-body h-100">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">NIS</label>
                                <input type="text" class="form-control" value="<?= $data['nis']; ?>" disabled>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">NISN</label>
                                <input type="text" class="form-control" value="<?= $data['nisn']; ?>" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" class="form-control" value="<?= $data['nama']; ?>" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tempat Lahir</label>
                                <input type="text" class="form-control" value="<?= $data['tempat_lahir']; ?>" disabled>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="text" class="form-control" value="<?= indonesiaDate($data['tanggal_lahir']); ?>" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jenis Kelamin</label>
                                <input type="text" class="form-control" value="<?= $data['jenis_kelamin']; ?>" disabled>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Agama</label>
                                <input type="text" class="form-control" value="<?= $data['agama']; ?>" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Alamat</label>
                                <textarea class="form-control" disabled><?= $data['alamat']; ?></textarea>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Ayah</label>
                                <input type="text" class="form-control" value="<?= $data['nama_ayah'] ?>" disabled>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Ibu</label>
                                <input type="text" class="form-control" value="<?= $data['nama_ibu'] ?>" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Pekerjaan Ayah</label>
                                <input type="text" class="form-control" value="<?= $data['pekerjaan_ayah'] ?>" disabled>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Pekerjaan Ibu</label>
                                <input type="text" class="form-control" value="<?= $data['pekerjaan_ibu'] ?>" disabled>
                            </div>
                        </div>
                        <div class="d-flex gap-1">
                            <a href="?h=siswa<?= (isset($_GET['status']) ? '&status=Alumni' : '') ?>" class="btn btn-secondary">Kembali</a>
                            <a href="?h=edit_siswa&id=<?= $data['id']; ?>" class="btn btn-warning">Edit</a>
                            <a href="?h=hapus_siswa&id=<?= $data['id']; ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>