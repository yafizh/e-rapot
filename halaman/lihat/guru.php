<?php
$query = "
    SELECT 
        g.*, 
        IFNULL(
            (SELECT id FROM kelas_aktif AS ka WHERE ka.id_guru=" . $_GET['id'] . " AND ka.status = 'Aktif'),
        0) AS wali_kelas
    FROM 
        guru AS g 
    WHERE g.id=" . $_GET['id'];
$data = $mysqli->query($query)->fetch_assoc(); ?>
<?php
$query = "
    SELECT DISTINCT 
        mp.nama 
    FROM 
        mata_pelajaran_kelas AS mpk 
    INNER JOIN 
        mata_pelajaran AS mp 
    ON 
        mp.id=mpk.id_mata_pelajaran
    INNER JOIN 
        kelas_aktif AS ka 
    ON 
        ka.id=mpk.id_kelas_aktif 
    WHERE 
        ka.status = 'Aktif' 
        AND 
        mpk.id_guru = " . $_GET['id'] . "
";
$mata_pelajaran_yang_dipegang = $mysqli->query($query);
?>
<main class="content">
    <div class="container-fluid p-0">

        <h1 class="h3 mb-3">Detail Guru</h1>

        <div class="row">
            <div class="col-md-4 col-xl-3">
                <div class="card mb-3">
                    <div class="card-header">
                    </div>
                    <div class="card-body text-center">
                        <img src="<?= $data['foto']; ?>" alt="Christina Mason" class="img-fluid rounded-circle mb-2" style="width: 128px; height: 128px; object-fit: cover;" />
                        <h5 class="card-title mb-0"><?= $data['nama']; ?></h5>
                        <div class="text-muted mb-2"><?= $data['wali_kelas'] ? 'Wali Kelas' : 'Guru'; ?></div>
                    </div>
                    <hr class="my-0" />
                    <div class="card-body">
                        <h5 class="h6 card-title">Mata Pelajaran Yang Dipegang</h5>
                        <?php while ($row = $mata_pelajaran_yang_dipegang->fetch_assoc()) : ?>
                            <a href="#" class="badge bg-primary me-1 my-1"><?= $row['nama']; ?></a>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>

            <div class="col-md-8 col-xl-9">
                <div class="card">
                    <div class="card-header">

                        <h5 class="card-title mb-0">Data Diri</h5>
                    </div>
                    <div class="card-body h-100">
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" class="form-control" value="<?= $data['nama']; ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tempat Lahir</label>
                            <input type="text" class="form-control" value="<?= $data['tempat_lahir']; ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="text" class="form-control" value="<?= indonesiaDate($data['tanggal_lahir']); ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jenis Kelamin</label>
                            <input type="text" class="form-control" value="<?= $data['jenis_kelamin']; ?>" disabled>
                        </div>
                        <div class="d-flex gap-1">
                            <a href="?h=guru" class="btn btn-secondary">Kembali</a>
                            <a href="?h=edit_guru&id=<?= $data['id']; ?>" class="btn btn-warning">Edit</a>
                            <a href="?h=hapus_guru&id=<?= $data['id']; ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>