<?php
$data = $mysqli->query("SELECT * FROM kelas_aktif WHERE id=" . $_GET['id_kelas_aktif'])->fetch_assoc();
$user_guru = $mysqli->query("SELECT * FROM user_guru WHERE id_guru=" . $data['id_guru'])->fetch_assoc();
if ($mysqli->query("DELETE FROM kelas_aktif WHERE id=" . $_GET['id_kelas_aktif']) && $mysqli->query("DELETE FROM user WHERE id=" . $user_guru['id_user'])) {
    $_SESSION['hapus_data']['nama'] =  $data['nama'];
    echo "<script>location.href = '?h=kelas_aktif&id_kelas=" . $data['id_kelas'] . "';</script>";
} else {
    echo "<script>alert('Hapus Data Gagal!')</script>";
    die($mysqli->error);
}
