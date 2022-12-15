<?php
$data = $mysqli->query("SELECT * FROM user WHERE id=" . $_GET['id'])->fetch_assoc();
if ($mysqli->query("DELETE FROM user WHERE id=" . $_GET['id'])) {
    $_SESSION['hapus_data']['username'] =  $data['username'];
    echo "<script>location.href = '?h=admin';</script>";
} else {
    echo "<script>alert('Hapus Data Gagal!')</script>";
    die($mysqli->error);
}
