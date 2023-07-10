<?php
$data = $mysqli->query("SELECT * FROM buku_digital WHERE id=" . $_GET['id'])->fetch_assoc();
if ($mysqli->query("DELETE FROM buku_digital WHERE id=" . $_GET['id'])) {
    $_SESSION['hapus_data']['judul'] =  $data['judul'];
    echo "<script>location.href = '?h=buku_digital';</script>";
} else {
    echo "<script>alert('Hapus Data Gagal!')</script>";
    die($mysqli->error);
}
