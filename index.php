<?php session_start(); ?>
<?php
$_SESSION['error'] = [];
$_SESSION['old'] = [];

?>
<?php require_once('functions/date.php'); ?>
<?php require_once('db/koneksi.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Aplikasi E-Rapot</title>
    <link rel="shortcut icon" href="assets/img/icons/kemenag.svg" />

    <link rel="stylesheet" href="assets/css/light.css">
    <link href="assets/css/font.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <style>
        .td-fit {
            width: 1%;
            white-space: nowrap;
        }

        .choices[data-type*="select-one"] select.choices__input {
            display: block !important;
            opacity: 0;
            pointer-events: none;
            position: absolute;
            left: 0;
            bottom: 0;
        }
    </style>
    <script>
        const imageError = (elm) => elm.setAttribute('src', 'assets/img/photos/no-product-image-400x400.png');
    </script>
</head>

<body>
    <div class="wrapper">
        <?php if (isset($_SESSION['user'])) : ?>
            <?php if (is_null($_SESSION['user']['id_guru'])) : ?>
                <?php include_once('templates/sidebar.php'); ?>
            <?php endif; ?>
        <?php endif; ?>
        <div class="main">
            <?php include_once('templates/navbar.php'); ?>
            <?php
            if (isset($_SESSION['user'])) {
                if (is_null($_SESSION['user']['id_guru'])) {
                    if (isset($_GET['h'])) {
                        switch ($_GET['h']) {
                                // Tampil
                            case "kelas":
                                include_once "halaman/tampil/kelas.php";
                                break;
                            case "semester":
                                include_once "halaman/tampil/semester.php";
                                break;
                            case "mata_pelajaran":
                                include_once "halaman/tampil/mata_pelajaran.php";
                                break;
                            case "guru":
                                include_once "halaman/tampil/guru.php";
                                break;
                            case "siswa":
                                include_once "halaman/tampil/siswa.php";
                                break;
                            case "kelas_aktif":
                                include_once "halaman/tampil/kelas_aktif.php";
                                break;
                            case "kelas_selesai":
                                include_once "halaman/tampil/kelas_selesai.php";
                                break;
                            case "admin":
                                include_once "halaman/tampil/admin.php";
                                break;
                            case "wali_kelas":
                                include_once "halaman/tampil/wali_kelas.php";
                                break;
                                // Lihat
                            case "lihat_guru":
                                include_once "halaman/lihat/guru.php";
                                break;
                            case "lihat_siswa":
                                include_once "halaman/lihat/siswa.php";
                                break;
                            case "lihat_kelas_aktif-siswa":
                                include_once "halaman/tampil/kelas_aktif-siswa.php";
                                break;
                            case "lihat_kelas_aktif-mata_pelajaran":
                                include_once "halaman/tampil/kelas_aktif-mata_pelajaran.php";
                                break;
                            case "lihat_kelas_selesai":
                                include_once "halaman/lihat/kelas_selesai.php";
                                break;
                                // Tambah
                            case "tambah_kelas":
                                include_once "halaman/tambah/kelas.php";
                                break;
                            case "tambah_semester":
                                include_once "halaman/tambah/semester.php";
                                break;
                            case "tambah_mata_pelajaran":
                                include_once "halaman/tambah/mata_pelajaran.php";
                                break;
                            case "tambah_guru":
                                include_once "halaman/tambah/guru.php";
                                break;
                            case "tambah_siswa":
                                include_once "halaman/tambah/siswa.php";
                                break;
                            case "tambah_kelas_aktif":
                                include_once "halaman/tambah/kelas_aktif.php";
                                break;
                            case "tambah_kelas_aktif-siswa":
                                include_once "halaman/tambah/kelas_aktif-siswa.php";
                                break;
                            case "tambah_kelas_aktif-mata_pelajaran":
                                include_once "halaman/tambah/kelas_aktif-mata_pelajaran.php";
                                break;
                            case "tambah_kelas_aktif-siswa-nilai":
                                include_once "halaman/tambah/kelas_aktif-siswa-nilai.php";
                                break;
                            case "tambah_kelas_aktif-semester_kelas":
                                include_once "halaman/tambah/kelas_aktif-semester_kelas.php";
                                break;
                            case "tambah_admin":
                                include_once "halaman/tambah/admin.php";
                                break;
                                // Edit
                            case "edit_kelas":
                                include_once "halaman/edit/kelas.php";
                                break;
                            case "edit_semester":
                                include_once "halaman/edit/semester.php";
                                break;
                            case "edit_mata_pelajaran":
                                include_once "halaman/edit/mata_pelajaran.php";
                                break;
                            case "edit_guru":
                                include_once "halaman/edit/guru.php";
                                break;
                            case "edit_siswa":
                                include_once "halaman/edit/siswa.php";
                                break;
                            case "edit_kelas_aktif":
                                include_once "halaman/edit/kelas_aktif.php";
                                break;
                            case "edit_admin":
                                include_once "halaman/edit/admin.php";
                                break;
                                // Hapus
                            case "hapus_kelas":
                                include_once "halaman/hapus/kelas.php";
                                break;
                            case "hapus_semester":
                                include_once "halaman/hapus/semester.php";
                                break;
                            case "hapus_mata_pelajaran":
                                include_once "halaman/hapus/mata_pelajaran.php";
                                break;
                            case "hapus_guru":
                                include_once "halaman/hapus/guru.php";
                                break;
                            case "hapus_siswa":
                                include_once "halaman/hapus/siswa.php";
                                break;
                            case "hapus_kelas_aktif":
                                include_once "halaman/hapus/kelas_aktif.php";
                                break;
                            case "hapus_kelas_aktif-siswa":
                                include_once "halaman/hapus/kelas_aktif-siswa.php";
                                break;
                            case "hapus_kelas_aktif-mata_pelajaran":
                                include_once "halaman/hapus/kelas_aktif-mata_pelajaran.php";
                                break;
                            case "hapus_admin":
                                include_once "halaman/hapus/admin.php";
                                break;
                                // Others
                            case "ganti_password":
                                include_once "halaman/auth/ganti_password.php";
                                break;
                                // Laporan
                            case "laporan_guru":
                                include_once "halaman/laporan/guru.php";
                                break;
                            case "laporan_siswa":
                                include_once "halaman/laporan/siswa.php";
                                break;
                            case "laporan_nilai_siswa":
                                include_once "halaman/laporan/.php";
                                break;
                            case "laporan_kelas_aktif":
                                include_once "halaman/laporan/kelas_aktif.php";
                                break;
                            case "laporan_kelas_selesai":
                                include_once "halaman/laporan/kelas_selesai.php";
                                break;
                            default:
                                include_once "beranda.php";
                        }
                    } else include_once "beranda.php";
                } else {
                    if (isset($_GET['h'])) {
                        switch ($_GET['h']) {
                            case "input_nilai":
                                include_once "halaman/wali_kelas/input_nilai.php";
                                break;
                            case "ganti_password":
                                include_once "halaman/auth/ganti_password.php";
                                break;
                            default:
                                include_once "halaman/wali_kelas/beranda.php";
                        }
                    } else include_once "halaman/wali_kelas/beranda.php";
                }
            } else
                echo "<script>location.href = 'halaman/auth/login.php'</script>";

            ?>
        </div>
    </div>
    <script src="assets/js/app.js"></script>
    <script src="assets/js/datatables.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Datatables Responsive
            $(".datatables-reponsive").DataTable({
                responsive: true
            });
            // Choices.js
            if (document.querySelector(".choices-single")) {
                document.querySelectorAll(".choices-single").forEach(element => {
                    new Choices(element);
                });
            }
            if (document.querySelector(".choices-multiple"))
                new Choices(document.querySelector(".choices-multiple"), {
                    removeItems: true,
                    removeItemButton: true,
                    placeholder: true,
                    placeholderValue: 'Pilih Siswa',
                    searchPlaceholderValue: 'Pilih Siswa',
                });
        });
    </script>
    <script>
        setTimeout(() => {
            if (document.querySelector('.alert.delete'))
                document.querySelector('.alert.delete').parentElement.remove()
        }, 5000);
    </script>
</body>

</html>