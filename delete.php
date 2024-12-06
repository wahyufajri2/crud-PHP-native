<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Periksa apakah kontak ID_pasien ada
if (isset($_GET['id_pasien'])) {
    // Pilih catatan yang akan dihapus
    $stmt = $pdo->prepare('SELECT * FROM pasien WHERE id_pasien = ?');
    $stmt->execute([$_GET['id_pasien']]);
    $pasien = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$pasien) {
        exit('Kontak tidak ada dengan ID_pasien itu!');
    }
    // Pastikan pengguna mengonfirmasi sebelum penghapusan
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // Pengguna mengklik tombol "Ya", hapus catatan
            $stmt = $pdo->prepare('DELETE FROM pasien WHERE id_pasien = ?');
            $stmt->execute([$_GET['id_pasien']]);
            $msg = 'Anda telah menghapus data pasien!';
        } else {
            // Pengguna mengklik tombol "Tidak", mengarahkan mereka kembali ke halaman baca
            header('Location: read.php');
            exit;
        }
    }
} else {
    exit('Tidak ada ID_pasien yang ditentukan!');
}
?>


<?=template_header('Delete')?>

<div class="content delete">
	<h2>Hapus Data Pasien<?=$pasien['id_pasien']?></h2>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
	<p>Anda yakin ingin menghapus pasien?<?=$pasien['id_pasien']?>?</p>
    <div class="yesno">
        <a href="delete.php?id_pasien=<?=$pasien['id_pasien']?>&confirm=yes">Iya</a>
        <a href="delete.php?id_pasien=<?=$pasien['id_pasien']?>&confirm=no">Batal</a>
    </div>
    <?php endif; ?>
</div>

<?=template_footer()?>