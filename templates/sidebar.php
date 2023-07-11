<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="#">
            <span class="align-middle">APLIKASI E-LEARNING</span>
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-item <?= isset($_GET['h']) ? (($_GET['h'] == "") ? "active" : "")  : "active" ?>">
                <a class="sidebar-link" href="?">
                    <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
                </a>
            </li>

            <li class="sidebar-header">
                Data User
            </li>
            <li class="sidebar-item <?php
                                    if (isset($_GET['h'])) {
                                        if ($_GET['h'] == "admin") echo "active";
                                        else if ($_GET['h'] == "tambah_admin") echo "active";
                                        else if ($_GET['h'] == "edit_admin") echo "active";
                                    }
                                    ?>">
                <a class="sidebar-link" href="?h=admin">
                    <i class="align-middle" data-feather="user-plus"></i> <span class="align-middle">Admin</span>
                </a>
            </li>
            <!-- <li class="sidebar-item <?= (($_GET['h'] ?? '') == "wali_kelas") ? "active" : ''; ?>">
                <a class="sidebar-link" href="?h=wali_kelas">
                    <i class="align-middle" data-feather="user-plus"></i> <span class="align-middle">Wali Kelas</span>
                </a>
            </li> -->

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
                    <i class="fa-regular fa-calendar-minus"></i> <span class="align-middle">Semester</span>
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
                    <i class="fa-solid fa-book"></i> <span class="align-middle">Mata Pelajaran</span>
                </a>
            </li>
            <li class="sidebar-item <?php
                                    if (isset($_GET['h'])) {
                                        if ($_GET['h'] == "buku_digital") echo "active";
                                        else if ($_GET['h'] == "tambah_buku_digital") echo "active";
                                        else if ($_GET['h'] == "edit_buku_digital") echo "active";
                                    }
                                    ?>">
                <a class="sidebar-link" href="?h=buku_digital">
                    <i class="fa-solid fa-book"></i> <span class="align-middle">Buku Digital</span>
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
                                        else if ($_GET['h'] == "lihat_guru") echo "active";
                                    }
                                    ?>">
                <a class="sidebar-link" href="?h=guru">
                    <i class="fa-solid fa-users"></i> <span class="align-middle">Guru</span>
                </a>
            </li>

            <li class="sidebar-item <?= in_array(($_GET['h'] ?? ''), ['siswa', 'tambah_siswa', 'edit_siswa', 'lihat_siswa']) ? 'active' : '' ?>">
                <a data-bs-target="#siswa" data-bs-toggle="collapse" class="sidebar-link <?= in_array(($_GET['h'] ?? ''), ['siswa', 'tambah_siswa', 'edit_siswa', 'lihat_siswa']) ? '' : 'collapsed' ?>">
                    <i class="fa-solid fa-users-line"></i> <span class="align-middle">Siswa</span>
                </a>
                <ul id="siswa" class="sidebar-dropdown list-unstyled collapse <?= in_array(($_GET['h'] ?? ''), ['siswa', 'tambah_siswa', 'edit_siswa', 'lihat_siswa']) ? 'show' : '' ?>" data-bs-parent="#sidebar">
                    <li class="sidebar-item <?= (in_array(($_GET['h'] ?? ''), ['siswa', 'tambah_siswa', 'edit_siswa', 'lihat_siswa']) && ($_GET['status'] ?? '') != 'Alumni') ? 'active' : '' ?>">
                        <a href="?h=siswa" class="sidebar-link">Aktif</a>
                    </li>
                    <li class="sidebar-item <?= (in_array(($_GET['h'] ?? ''), ['siswa', 'lihat_siswa']) && ($_GET['status'] ?? '') == 'Alumni') ? 'active' : '' ?>">
                        <a href="?h=siswa&status=Alumni" class="sidebar-link">Telah Lulus</a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-item <?= in_array(($_GET['h'] ?? ''), ['kelas_aktif', 'tambah_kelas_aktif', 'edit_kelas_aktif', 'lihat_kelas_aktif-siswa', 'tambah_kelas_aktif-siswa', 'tambah_kelas_aktif-siswa-nilai', 'tambah_kelas_aktif-semester_kelas', 'lihat_kelas_aktif-mata_pelajaran']) ? 'active' : '' ?>">
                <a data-bs-target="#kelas_aktif" data-bs-toggle="collapse" class="sidebar-link <?= in_array(($_GET['h'] ?? ''), ['kelas_aktif', 'tambah_kelas_aktif', 'edit_kelas_aktif', 'lihat_kelas_aktif-siswa', 'tambah_kelas_aktif-siswa', 'tambah_kelas_aktif-siswa-nilai', 'tambah_kelas_aktif-semester_kelas', 'lihat_kelas_aktif-mata_pelajaran']) ? '' : 'collapsed' ?>">
                    <i class="fa-solid fa-user-tie"></i> <span class="align-middle">Kelas Aktif</span>
                </a>
                <ul id="kelas_aktif" class="sidebar-dropdown list-unstyled collapse <?= in_array(($_GET['h'] ?? ''), ['kelas_aktif', 'tambah_kelas_aktif', 'edit_kelas_aktif', 'lihat_kelas_aktif-siswa', 'tambah_kelas_aktif-siswa', 'tambah_kelas_aktif-siswa-nilai', 'tambah_kelas_aktif-semester_kelas', 'lihat_kelas_aktif-mata_pelajaran']) ? 'show' : '' ?>" data-bs-parent="#sidebar">
                    <?php $result = $mysqli->query("SELECT * FROM kelas ORDER BY tingkat"); ?>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <li class="sidebar-item <?= (in_array(($_GET['h'] ?? ''), ['kelas_aktif', 'tambah_kelas_aktif', 'edit_kelas_aktif', 'lihat_kelas_aktif-siswa', 'tambah_kelas_aktif-siswa', 'tambah_kelas_aktif-siswa-nilai', 'tambah_kelas_aktif-semester_kelas', 'lihat_kelas_aktif-mata_pelajaran']) && ($_GET['id_kelas'] ?? '') == $row['id']) ? 'active' : '' ?>">
                            <a href="?h=kelas_aktif&id_kelas=<?= $row['id']; ?>" class="sidebar-link">Kelas <?= $row['nama']; ?></a>
                        </li>
                    <?php endwhile; ?>
                </ul>
            </li>
            <li class="sidebar-item <?= in_array(($_GET['h'] ?? ''), ['kelas_selesai', 'lihat_kelas_selesai']) ? 'active' : '' ?>">
                <a data-bs-target="#kelas_selesai" data-bs-toggle="collapse" class="sidebar-link <?= in_array(($_GET['h'] ?? ''), ['kelas_selesai', 'lihat_kelas_selesai']) ? '' : 'collapsed' ?>">
                    <i class="fa-solid fa-user-graduate"></i> <span class="align-middle">Kelas Selesai</span>
                </a>
                <ul id="kelas_selesai" class="sidebar-dropdown list-unstyled collapse <?= in_array(($_GET['h'] ?? ''), ['kelas_selesai', 'lihat_kelas_selesai']) ? 'show' : '' ?>" data-bs-parent="#sidebar">
                    <?php $result = $mysqli->query("SELECT * FROM kelas ORDER BY tingkat"); ?>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <li class="sidebar-item <?= (in_array(($_GET['h'] ?? ''), ['kelas_selesai', 'lihat_kelas_selesai']) && ($_GET['id_kelas'] ?? '') == $row['id']) ? 'active' : '' ?>">
                            <a href="?h=kelas_selesai&id_kelas=<?= $row['id']; ?>" class="sidebar-link">Kelas <?= $row['nama']; ?></a>
                        </li>
                    <?php endwhile; ?>
                </ul>
            </li>
            <li class="sidebar-header">
                Laporan
            </li>
            <li class="sidebar-item <?= ($_GET['h'] ?? '') == 'laporan_guru' ? 'active' : ''; ?>">
                <a class="sidebar-link" href="?h=laporan_guru">
                    <i class="fas fa-file-pdf"></i> <span class="align-middle">Guru</span>
                </a>
            </li>
            <li class="sidebar-item <?= ($_GET['h'] ?? '') == 'laporan_siswa' ? 'active' : ''; ?>">
                <a class="sidebar-link" href="?h=laporan_siswa">
                    <i class="fas fa-file-pdf"></i> <span class="align-middle">Siswa</span>
                </a>
            </li>
            <li class="sidebar-item <?= ($_GET['h'] ?? '') == 'laporan_kelas_aktif' ? 'active' : ''; ?>">
                <a class="sidebar-link" href="?h=laporan_kelas_aktif">
                    <i class="fas fa-file-pdf"></i> <span class="align-middle">Kelas Aktif</span>
                </a>
            </li>
            <li class="sidebar-item <?= ($_GET['h'] ?? '') == 'laporan_kelas_selesai' ? 'active' : ''; ?>">
                <a class="sidebar-link" href="?h=laporan_kelas_selesai">
                    <i class="fas fa-file-pdf"></i> <span class="align-middle">Kelas Selesai</span>
                </a>
            </li>
            <li class="sidebar-item <?= ($_GET['h'] ?? '') == 'laporan_grafik_jenis_kelamin_siswa' ? 'active' : ''; ?>">
                <a class="sidebar-link" href="?h=laporan_grafik_jenis_kelamin_siswa">
                    <i class="fas fa-file-pdf"></i> <span class="align-middle">Grafik Jenis Kelamin Siswa</span>
                </a>
            </li>
        </ul>
    </div>
</nav>