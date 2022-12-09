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
                                        else if ($_GET['h'] == "tambah_kelas") echo "active";
                                        else if ($_GET['h'] == "edit_kelas") echo "active";
                                    }
                                    ?>">
                <a class="sidebar-link" href="?h=kelas">
                    <i class="align-middle" data-feather="user"></i> <span class="align-middle">Kelas</span>
                </a>
            </li>
            <li class="sidebar-item <?php
                                    if (isset($_GET['h'])) {
                                        if ($_GET['h'] == "semester") echo "active";
                                        else if ($_GET['h'] == "tambah_semester") echo "active";
                                        else if ($_GET['h'] == "edit_semester") echo "active";
                                    }
                                    ?>">
                <a class="sidebar-link" href="?h=semester">
                    <i class="align-middle" data-feather="user"></i> <span class="align-middle">Semester</span>
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
                Data Sekolah
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

            <li class="sidebar-item <?= in_array(($_GET['h'] ?? ''), ['siswa', 'tambah_siswa', 'edit_siswa']) ? 'active' : '' ?>">
                <a data-bs-target="#siswa" data-bs-toggle="collapse" class="sidebar-link <?= in_array(($_GET['h'] ?? ''), ['siswa', 'tambah_siswa', 'edit_siswa']) ? '' : 'collapsed' ?>">
                    <i class="align-middle" data-feather="corner-right-down"></i> <span class="align-middle">Siswa</span>
                </a>
                <ul id="siswa" class="sidebar-dropdown list-unstyled collapse <?= in_array(($_GET['h'] ?? ''), ['siswa', 'tambah_siswa', 'edit_siswa']) ? 'show' : '' ?>" data-bs-parent="#sidebar">
                    <li class="sidebar-item <?= (in_array(($_GET['h'] ?? ''), ['siswa', 'tambah_siswa', 'edit_siswa']) && ($_GET['status'] ?? '') != 'Alumni') ? 'active' : '' ?>">
                        <a href="?h=siswa" class="sidebar-link">Aktif</a>
                    </li>
                    <li class="sidebar-item <?= (in_array(($_GET['h'] ?? ''), ['siswa', 'tambah_siswa', 'edit_siswa']) && ($_GET['status'] ?? '') == 'Alumni') ? 'active' : '' ?>">
                        <a href="?h=siswa&status=Alumni" class="sidebar-link">Alumni</a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-item <?= in_array(($_GET['h'] ?? ''), ['kelas_aktif', 'tambah_kelas_aktif', 'edit_kelas_aktif', 'lihat_kelas_aktif-siswa', 'tambah_kelas_aktif-siswa', 'tambah_kelas_aktif-siswa-nilai', 'lihat_kelas_aktif-mata_pelajaran']) ? 'active' : '' ?>">
                <a data-bs-target="#kelas_aktif" data-bs-toggle="collapse" class="sidebar-link <?= in_array(($_GET['h'] ?? ''), ['kelas_aktif', 'tambah_kelas_aktif', 'edit_kelas_aktif', 'lihat_kelas_aktif-siswa', 'tambah_kelas_aktif-siswa', 'tambah_kelas_aktif-siswa-nilai', 'lihat_kelas_aktif-mata_pelajaran']) ? '' : 'collapsed' ?>">
                    <i class="align-middle" data-feather="corner-right-down"></i> <span class="align-middle">Kelas</span>
                </a>
                <ul id="kelas_aktif" class="sidebar-dropdown list-unstyled collapse <?= in_array(($_GET['h'] ?? ''), ['kelas_aktif', 'tambah_kelas_aktif', 'edit_kelas_aktif', 'lihat_kelas_aktif-siswa', 'tambah_kelas_aktif-siswa', 'tambah_kelas_aktif-siswa-nilai', 'lihat_kelas_aktif-mata_pelajaran']) ? 'show' : '' ?>" data-bs-parent="#sidebar">
                    <?php $result = $mysqli->query("SELECT * FROM kelas ORDER BY tingkat"); ?>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <li class="sidebar-item <?= (($_GET['id_kelas'] ?? '') == $row['id']) ? 'active' : '' ?>">
                            <a href="?h=kelas_aktif&id_kelas=<?= $row['id']; ?>" class="sidebar-link">Kelas <?= $row['nama']; ?></a>
                        </li>
                    <?php endwhile; ?>
                </ul>
            </li>
            <!-- <li class="sidebar-item">
                <a data-bs-target="#multi" data-bs-toggle="collapse" class="sidebar-link collapsed">
                    <i class="align-middle" data-feather="corner-right-down"></i> <span class="align-middle">Multi Level</span>
                </a>
                <ul id="multi" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                        <a data-bs-target="#multi-2" data-bs-toggle="collapse" class="sidebar-link collapsed">Two Levels</a>
                        <ul id="multi-2" class="sidebar-dropdown list-unstyled collapse">
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="#">Item 1</a>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="#">Item 2</a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-item">
                        <a data-bs-target="#multi-3" data-bs-toggle="collapse" class="sidebar-link collapsed">Three Levels</a>
                        <ul id="multi-3" class="sidebar-dropdown list-unstyled collapse">
                            <li class="sidebar-item">
                                <a data-bs-target="#multi-3-1" data-bs-toggle="collapse" class="sidebar-link collapsed">Item 1</a>
                                <ul id="multi-3-1" class="sidebar-dropdown list-unstyled collapse">
                                    <li class="sidebar-item">
                                        <a class="sidebar-link" href="#">Item 1</a>
                                    </li>
                                    <li class="sidebar-item">
                                        <a class="sidebar-link" href="#">Item 2</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="#">Item 2</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li> -->
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