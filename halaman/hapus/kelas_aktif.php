<?php
$data = $mysqli->query("SELECT * FROM kelas_aktif WHERE id=" . $_GET['id'])->fetch_assoc();
if ($mysqli->query("DELETE FROM kelas_aktif WHERE id=" . $_GET['id'])) {
    $_SESSION['hapus_data']['nama'] =  $data['nama'];
    echo "<script>location.href = '?h=kelas_aktif&id_kelas=" . $data['id_kelas'] . "';</script>";
} else {
    echo "<script>alert('Hapus Data Gagal!')</script>";
    die($mysqli->error);
}
