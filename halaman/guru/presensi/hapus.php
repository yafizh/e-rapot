<?php
if ($mysqli->query("DELETE FROM presensi_mata_pelajaran_kelas WHERE id=" . $_GET['idd'])) {
    echo "<script>location.href = '?h=mata_pelajaran&id=" . $_GET['id'] . "';</script>";
} else {
    echo "<script>alert('Hapus Data Gagal!')</script>";
    die($mysqli->error);
}
