<?php
$data = $mysqli->query("SELECT * FROM sub_kelas WHERE id=" . $_GET['id'])->fetch_assoc();
if ($mysqli->query("DELETE FROM sub_kelas WHERE id=" . $_GET['id'])) {
    $_SESSION['hapus_data']['nama'] =  $data['nama'];
    echo "<script>location.href = '?h=lihat_kelas&id=" . $data['id_kelas'] . "';</script>";
} else {
    echo "<script>alert('Hapus Data Gagal!')</script>";
    die($mysqli->error);
}
