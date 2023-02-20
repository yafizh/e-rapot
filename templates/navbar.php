<nav class="navbar navbar-expand navbar-light navbar-bg">
    <a class="sidebar-toggle js-sidebar-toggle">
        <i class="hamburger align-self-center"></i>
    </a>

    <div class="navbar-collapse collapse">
        <ul class="navbar-nav navbar-align">
            <li class="nav-item dropdown">
                <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
                    <i class="align-middle" data-feather="settings"></i>
                </a>

                <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                    <?php if (!is_null($_SESSION['user']['id_guru'])) : ?>
                        <img src="<?= $_SESSION['user']['foto']; ?>" onerror="imageError(this)" style="object-fit: cover;" class="avatar img-fluid rounded me-1" alt="Charles Hall" />
                    <?php endif; ?>
                    <span class="text-dark"><?= is_null($_SESSION['user']['id_guru']) ? 'ADMIN' : $_SESSION['user']['nama']; ?></span>
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    <?php if (!is_null($_SESSION['user']['id_guru'])) : ?>
                        <a class="dropdown-item" href="?"><i class="align-middle me-1" data-feather="home"></i> Menu Utama</a>
                        <a class="dropdown-item" href="?h=ganti_password"><i class="align-middle me-1" data-feather="settings"></i> Ganti Password</a>
                        <div class="dropdown-divider"></div>
                    <?php endif; ?>
                    <a class="dropdown-item" href="halaman/auth/logout.php">Log out</a>
                </div>
            </li>
        </ul>
    </div>
</nav>