<?php
$query = "SELECT * FROM buku_digital WHERE id=" . $_GET['id'];
$data = $mysqli->query($query)->fetch_assoc();
?>
<main class="content">
    <div class="container-fluid p-0">

        <h1 class="h3 mb-3">Detail Buku Digital</h1>

        <div class="row">
            <div class="col-12 col-md-6">
                <object class="w-100" data="https://media.geeksforgeeks.org/wp-content/cdn-uploads/20210101201653/PDF.pdf" width="800" height="500">
                </object>
            </div>

            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="card-body h-100">
                        <div class="mb-3">
                            <label class="form-label">Judul Buku</label>
                            <input type="text" class="form-control" value="<?= $data['judul']; ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Pengarang</label>
                            <input type="text" class="form-control" value="<?= $data['pengarang']; ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tahun Terbit</label>
                            <input type="text" class="form-control" value="<?= $data['tahun_terbit']; ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jumlah Halaman</label>
                            <input type="text" class="form-control" value="<?= $data['jumlah_halaman']; ?>" disabled>
                        </div>
                        <div class="d-flex gap-1">
                            <a href="?h=buku_digital" class="btn btn-secondary">Kembali</a>
                            <a href="?h=edit_buku_digital&id=<?= $data['id']; ?>" class="btn btn-warning">Edit</a>
                            <a href="?h=hapus_buku_digital&id=<?= $data['id']; ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>