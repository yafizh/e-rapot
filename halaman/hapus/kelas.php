<?php
$data = $mysqli->query("SELECT * FROM kelas WHERE id=".$_GET['id'])->fetch_assoc();
if ($mysqli->query("DELETE FROM kelas WHERE id=" . $_GET['id'])) {
    $_SESSION['hapus_data'] =  $data['nama'];
    echo "<script>location.href = '?h=kelas';</script>";
} else {
    echo "<script>alert('Hapus Data Gagal!')</script>";
    die($mysqli->error);
}
