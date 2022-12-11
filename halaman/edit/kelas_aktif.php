<?php
$kelas = $mysqli->query("SELECT * FROM kelas WHERE id=" . $_GET['id_kelas'])->fetch_assoc();
$data = $mysqli->query("SELECT * FROM kelas_aktif WHERE id=" . $_GET['id_kelas_aktif'])->fetch_assoc();
if (isset($_POST['submit'])) {
    $id_guru = $mysqli->real_escape_string($_POST['id_guru']);
    $nama = $mysqli->real_escape_string($_POST['nama']);
    $tahun_pelajaran = $mysqli->real_escape_string($_POST['tahun_pelajaran']);

    $q = "
        UPDATE kelas_aktif SET 
            id_guru='$id_guru',
            nama='$nama',  
            tahun_pelajaran='$tahun_pelajaran' 
        WHERE 
            id=" . $_GET['id_kelas_aktif'];

    if ($mysqli->query($q)) {
        $_SESSION['edit_data']['nama'] =  $nama;
        echo "<script>location.href = '?h=kelas_aktif&id_kelas=" . $_GET['id_kelas'] . "';</script>";
    } else {
        echo "<script>alert('Tambah Data Gagal!')</script>";
        die($mysqli->error);
    }
}
?>
<main class="content">
    <div class="container-fluid p-0">

        <div class="mb-3 text-center">
            <h1 class="h3 d-inline align-middle">Edit Kelas Aktif</h1>
        </div>

        <div class="row justify-content-center">
            <div class="col-12 col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="mb-3">
                                <label class="form-label">Kelas</label>
                                <input type="text" class="form-control" disabled value="<?= $kelas['nama']; ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Wali Kelas</label>
                                <?php $guru = $mysqli->query("SELECT * FROM guru WHERE id NOT IN (SELECT id_guru FROM kelas_aktif WHERE status='Aktif' AND id_guru != " . $data['id_guru'] . ") ORDER BY nama"); ?>
                                <select name="id_guru" required class="form-control choices-single">
                                    <?php while ($row = $guru->fetch_assoc()) : ?>
                                        <?php if ($data['id_guru'] == $row['id']) : ?>
                                            <option selected value="<?= $row['id']; ?>"><?= $row['nama'] ?></option>
                                        <?php else : ?>
                                            <option value="<?= $row['id']; ?>"><?= $row['nama'] ?></option>
                                        <?php endif; ?>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama Kelas</label>
                                <input type="text" class="form-control" name="nama" required autocomplete="off" value="<?= $data['nama']; ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tahun Pelajaran</label>
                                <input type="text" class="form-control" name="tahun_pelajaran" required autocomplete="off" value="<?= $data['tahun_pelajaran']; ?>">
                            </div>
                            <a href="?h=kelas_aktif&id_kelas=<?= $_GET['id_kelas']; ?>" class="btn btn-secondary float-start">Kembali<a>
                                    <button type="submit" name="submit" class="btn btn-primary float-end">Perbaharui</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>