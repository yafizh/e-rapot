<?php
$q = "
    SELECT 
        * 
    FROM 
        kelas_aktif 
    WHERE 
        id_guru=" . $_SESSION['user']['id_guru'] . " 
        AND 
        status='Aktif'
";
$wali_kelas = $mysqli->query($q)->fetch_assoc();
?>
<div class="row mb-3">
    <div class="col">
        <a href="?" class="btn <?= isset($_GET['h']) ? 'btn-light bg-white' : 'btn-primary'; ?>">Kelas Aktif</a>
        <a href="?h=buku_digital" class="btn <?= ($_GET['h'] ?? '') == 'buku_digital' ? 'btn-primary' : 'btn-light bg-white'; ?>">Buku Digital</a>
        <?php if ($wali_kelas) : ?>
            <a href="?h=wali_kelas" class="btn <?= ($_GET['h'] ?? '') == 'wali_kelas' ? 'btn-primary' : 'btn-light bg-white'; ?>">Wali Kelas</a>
        <?php endif; ?>
        <!-- <a href="?h=kelas_selesai" class="btn <?= ($_GET['h'] ?? '') == 'buku_digital' ? 'btn-primary' : 'btn-light bg-white'; ?>">Kelas Selesai</a> -->
    </div>
</div>