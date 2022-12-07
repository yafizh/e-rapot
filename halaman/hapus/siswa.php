<?php
$data = $mysqli->query("SELECT * FROM siswa WHERE id=" . $_GET['id'])->fetch_assoc();
if ($mysqli->query("DELETE FROM siswa WHERE id=" . $_GET['id'])) {
    $_SESSION['hapus_data']['nama'] =  $data['nama'];
    echo "<script>location.href = '?h=siswa';</script>";
} else {
    echo "<script>alert('Hapus Data Gagal!')</script>";
    die($mysqli->error);
}
