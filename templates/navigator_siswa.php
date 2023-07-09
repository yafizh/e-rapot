<div class="row mb-3">
    <div class="col">
        <a href="?" class="btn <?= isset($_GET['h']) ? 'btn-light bg-white' : 'btn-primary'; ?>">Kelas Aktif</a>
        <a href="?h=buku_digital" class="btn <?= ($_GET['h'] ?? '') == 'buku_digital' ? 'btn-primary' : 'btn-light bg-white'; ?>">Buku Digital</a>
        <a href="?h=kelas_selesai" class="btn <?= ($_GET['h'] ?? '') == 'buku_digital' ? 'btn-primary' : 'btn-light bg-white'; ?>">Kelas Selesai</a>
    </div>
</div>