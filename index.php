<?php session_start(); ?>
<?php
$_SESSION['error'] = [];
$_SESSION['old'] = []; 
?>
<?php require_once('db/koneksi.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Aplikasi E-Rapot</title>
    <link rel="shortcut icon" href="assets/images/favicon.png" />

    <link rel="stylesheet" href="assets/css/light.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        .td-fit {
            width: 1%;
            white-space: nowrap;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <?php include_once('templates/sidebar.php'); ?>
        <div class="main">
            <?php include_once('templates/navbar.php'); ?>
            <?php
            if (isset($_GET['h'])) {
                switch ($_GET['h']) {
                        // Tampil
                    case "kelas":
                        include_once "halaman/tampil/kelas.php";
                        break;
                    case "mata_pelajaran":
                        include_once "halaman/tampil/mata_pelajaran.php";
                        break;
                    case "guru":
                        include_once "halaman/tampil/guru.php";
                        break;
                        // Lihat
                    case "lihat_guru":
                        include_once "halaman/tampil/guru.php";
                        break;
                        // Tambah
                    case "tambah_kelas":
                        include_once "halaman/tambah/kelas.php";
                        break;
                    case "tambah_mata_pelajaran":
                        include_once "halaman/tambah/mata_pelajaran.php";
                        break;
                    case "tambah_guru":
                        include_once "halaman/tambah/guru.php";
                        break;
                        // Edit
                    case "edit_kelas":
                        include_once "halaman/edit/kelas.php";
                        break;
                    case "edit_mata_pelajaran":
                        include_once "halaman/edit/mata_pelajaran.php";
                        break;
                    case "edit_guru":
                        include_once "halaman/edit/guru.php";
                        break;
                        // Hapus
                    case "hapus_kelas":
                        include_once "halaman/hapus/kelas.php";
                        break;
                    case "hapus_mata_pelajaran":
                        include_once "halaman/hapus/mata_pelajaran.php";
                        break;
                    case "hapus_guru":
                        include_once "halaman/hapus/guru.php";
                        break;
                    default:
                        include_once "beranda.php";
                }
            } else include_once "beranda.php";
            ?>
        </div>
    </div>
    <script src="assets/js/app.js"></script>
    <script src="assets/js/datatables.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Datatables Responsive
            $("#datatables-reponsive").DataTable({
                responsive: true
            });
        });
    </script>
    <script>
        setTimeout(() => {
            document.querySelector('.alert.delete').parentElement.remove()
        }, 5000);
    </script>
</body>

</html>