<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="#">
            <span class="align-middle">E-RAPOT</span>
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-item <?= isset($_GET['h']) ? (($_GET['h'] == "") ? "active" : "")  : "active" ?>">
                <a class="sidebar-link" href="index.html">
                    <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
                </a>
            </li>

            <li class="sidebar-header">
                Data User
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="?h=admin">
                    <i class="align-middle" data-feather="user-plus"></i> <span class="align-middle">Admin</span>
                </a>
            </li>

            <li class="sidebar-header">
                Data Master
            </li>
            <li class="sidebar-item <?php 
             if (isset($_GET['h'])) {
                if ($_GET['h'] == "kelas") echo "active";
                else if ($_GET['h'] == "lihat_kelas") echo "active";
                else if ($_GET['h'] == "tambah_kelas") echo "active";
                else if ($_GET['h'] == "edit_kelas") echo "active";
                else if ($_GET['h'] == "tambah_sub_kelas") echo "active";
                else if ($_GET['h'] == "edit_sub_kelas") echo "active";
            }
            ?>">
                <a class="sidebar-link" href="?h=kelas">
                    <i class="align-middle" data-feather="user"></i> <span class="align-middle">Kelas</span>
                </a>
            </li>
            <li class="sidebar-item <?php 
            if (isset($_GET['h'])) {
                if ($_GET['h'] == "mata_pelajaran") echo "active";
                else if ($_GET['h'] == "tambah_mata_pelajaran") echo "active";
                else if ($_GET['h'] == "edit_mata_pelajaran") echo "active";
            }
            ?>">
                <a class="sidebar-link" href="?h=mata_pelajaran">
                    <i class="align-middle" data-feather="log-in"></i> <span class="align-middle">Mata Pelajaran</span>
                </a>
            </li>

            <li class="sidebar-header">
                Data Guru
            </li>
            <li class="sidebar-item <?php 
             if (isset($_GET['h'])) {
                if ($_GET['h'] == "guru") echo "active";
                else if ($_GET['h'] == "tambah_guru") echo "active";
                else if ($_GET['h'] == "edit_guru") echo "active";
            }
            ?>">
                <a class="sidebar-link" href="?h=guru">
                    <i class="align-middle" data-feather="book"></i> <span class="align-middle">Guru</span>
                </a>
            </li>

            <li class="sidebar-header">
                Data Siswa
            </li>
            <li class="sidebar-item <?php 
             if (isset($_GET['h'])) {
                if ($_GET['h'] == "siswa" && ($_GET['status'] ?? '') !== 'Alumni') echo "active";
                else if ($_GET['h'] == "tambah_siswa" && ($_GET['status'] ?? '') !== 'Alumni') echo "active";
                else if ($_GET['h'] == "edit_siswa" && ($_GET['status'] ?? '') !== 'Alumni') echo "active";
            }
            ?>">
                <a class="sidebar-link" href="?h=siswa">
                    <i class="align-middle" data-feather="square"></i> <span class="align-middle">Siswa</span>
                </a>
            </li>
            <li class="sidebar-item <?php 
            if (isset($_GET['h'])) {
                if ($_GET['h'] == "siswa" && ($_GET['status'] ?? '') === 'Alumni') echo "active";
                else if ($_GET['h'] == "tambah_siswa" && ($_GET['status'] ?? '') === 'Alumni') echo "active";
                else if ($_GET['h'] == "edit_siswa" && ($_GET['status'] ?? '') === 'Alumni') echo "active";
            }
            ?>">
                <a class="sidebar-link" href="?h=siswa&status=Alumni">
                    <i class="align-middle" data-feather="square"></i> <span class="align-middle">Alumni</span>
                </a>
            </li>

            <li class="sidebar-header">
                Data Kelas
            </li>
            <li class="sidebar-item <?php 
             if (isset($_GET['h'])) {
                if ($_GET['h'] == "kelas_aktif") echo "active";
                else if ($_GET['h'] == "tambah_kelas_aktif") echo "active";
                else if ($_GET['h'] == "edit_kelas_aktif") echo "active";
            }
            ?>">
                <a class="sidebar-link" href="?h=kelas_aktif">
                    <i class="align-middle" data-feather="book"></i> <span class="align-middle">Kelas Aktif</span>
                </a>
            </li>

            <li class="sidebar-header">
                Laporan
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="#">
                    <i class="align-middle" data-feather="bar-chart-2"></i> <span class="align-middle">1</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="#">
                    <i class="align-middle" data-feather="map"></i> <span class="align-middle">2</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="#">
                    <i class="align-middle" data-feather="map"></i> <span class="align-middle">3</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="#">
                    <i class="align-middle" data-feather="map"></i> <span class="align-middle">4</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="#">
                    <i class="align-middle" data-feather="map"></i> <span class="align-middle">5</span>
                </a>
            </li>
        </ul>
    </div>
</nav>