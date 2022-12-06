<?php
$data = $mysqli->query("SELECT * FROM mata_pelajaran WHERE id=".$_GET['id'])->fetch_assoc();
if (isset($_POST['submit'])) {
    $nama = $mysqli->real_escape_string($_POST['nama']);

    $q = "UPDATE mata_pelajaran SET nama='$nama' WHERE id=" . $_GET['id'];

    if ($mysqli->query($q)) {
        $_SESSION['edit_data']['nama']['before'] =  $data['nama'];
        $_SESSION['edit_data']['nama']['after'] =  $nama;
        echo "<script>location.href = '?h=mata_pelajaran';</script>";
    } else {
        echo "<script>alert('Edit Data Gagal!')</script>";
        die($mysqli->error);
    }
}
?>
<main class="content">
    <div class="container-fluid p-0">

        <div class="mb-3 text-center">
            <h1 class="h3 d-inline align-middle">Edit Mata Pelajaran</h1>
        </div>

        <div class="row justify-content-center">
            <div class="col-12 col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="mb-3">
                                <label class="form-label">Nama Mata Pelajaran</label>
                                <input type="text" class="form-control" name="nama" required autocomplete="off" value="<?= $data['nama']; ?>">
                            </div>
                            <a href="?h=mata_pelajaran" class="btn btn-secondary float-start">Kembali</a>
                            <button type="submit" name="submit" class="btn btn-primary float-end">Perbaharui</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>