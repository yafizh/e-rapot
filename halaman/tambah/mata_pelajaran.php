<?php
if (isset($_POST['submit'])) {
    $nama = $mysqli->real_escape_string($_POST['nama']);
    $kkm = $mysqli->real_escape_string($_POST['kkm']);

    $q = "INSERT INTO mata_pelajaran (nama, kkm) VALUES ('$nama', '$kkm')";

    if ($mysqli->query($q)) {
        $_SESSION['tambah_data']['nama'] =  $nama;
        echo "<script>location.href = '?h=mata_pelajaran';</script>";
    } else {
        echo "<script>alert('Tambah Data Gagal!')</script>";
        die($mysqli->error);
    }
}
?>
<main class="content">
    <div class="container-fluid p-0">

        <div class="mb-3 text-center">
            <h1 class="h3 d-inline align-middle">Tambah Mata Pelajaran</h1>
        </div>

        <div class="row justify-content-center">
            <div class="col-12 col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="mb-3">
                                <label class="form-label">Nama Mata Pelajaran</label>
                                <input type="text" class="form-control" name="nama" required autocomplete="off">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">KKM</label>
                                <input type="number" class="form-control" name="kkm" required autocomplete="off">
                            </div>
                            <a href="?h=mata_pelajaran" class="btn btn-secondary float-start">Kembali</a>
                            <button type="submit" name="submit" class="btn btn-primary float-end">Tambah</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>