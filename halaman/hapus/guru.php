<?php
$data = $mysqli->query("SELECT * FROM guru WHERE id=" . $_GET['id'])->fetch_assoc();
if ($mysqli->query("DELETE FROM guru WHERE id=" . $_GET['id'])) {
    $_SESSION['hapus_data'] =  $data['nama'];
    echo "<script>location.href = '?h=guru';</script>";
} else {
    echo "<script>alert('Hapus Data Gagal!')</script>";
    die($mysqli->error);
}
