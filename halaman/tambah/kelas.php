<?php
if (isset($_POST['submit'])) {
    $nama = $mysqli->real_escape_string($_POST['nama']);

    $q = "INSERT INTO kelas (nama) VALUES ('$nama')";

    if ($mysqli->query($q)) {
        $_SESSION['tambah_data'] =  $mysqli->insert_id;
        echo "<script>location.href = '?h=kelas';</script>";
    } else {
        echo "<script>alert('Tambah Data Gagal!')</script>";
        die($mysqli->error);
    }
}
?>
<main class="content">
    <div class="container-fluid p-0">

        <div class="mb-3 text-center">
            <h1 class="h3 d-inline align-middle">Tambah Kelas</h1>
        </div>

        <div class="row justify-content-center">
            <div class="col-12 col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="mb-3">
                                <label class="form-label">Nama Kelas</label>
                                <input type="text" class="form-control" name="nama" required autofocus autocomplete="off">
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary float-end">Tambah</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>