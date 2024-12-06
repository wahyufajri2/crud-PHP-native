<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Periksa apakah kontak id_pasien ada, misal update.php?id_pasien=1 akan mendapatkan data pasien dengan id_pasien 1
if (isset($_GET['id_pasien'])) {
    if (!empty($_POST)) {
        // Bagian ini mirip dengan create.php, tetapi sebagai gantinya kita mengupdate record dan bukan insert
        $id_pasien = isset($_POST['id_pasien']) ? $_POST['id_pasien'] : NULL;
        $no_rm = isset($_POST['no_rm']) ? $_POST['no_rm'] : NULL;
        $nama = isset($_POST['nama']) ? $_POST['nama'] : '';
        $agama = isset($_POST['agama']) ? $_POST['agama'] : '';
        $notelp = isset($_POST['notelp']) ? $_POST['notelp'] : '';
        $pekerjaan = isset($_POST['pekerjaan']) ? $_POST['pekerjaan'] : '';

        // Perbarui catatan
        $stmt = $pdo->prepare('UPDATE kontak SET id_pasien = ?, no_rm = ?, nama = ?, agama = ?, notelp = ?, pekerjaan = ? WHERE id_pasien = ?');
        $stmt->execute([$id_pasien, $no_rm, $nama, $agama, $notelp, $pekerjaan, $_GET['id_pasien']]);
        $msg = 'Updated Successfully!';
    }
    // Dapatkan data pasien dari tabel pasien
    $stmt = $pdo->prepare('SELECT * FROM kontak WHERE id_pasien = ?');
    $stmt->execute([$_GET['id_pasien']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        exit('Data pasien tidak ada dengan ID_pasien itu!');
    }
} else {
    exit('Tidak ada ID_pasien yang ditentukan!');
}
?>



<?= template_header('Read') ?>

<div class="content update">
    <h2>Edit Data Pasien<?= $contact['id_pasien'] ?></h2>
    <form action="update.php?id_pasien=<?= $contact['id_pasien'] ?>" method="post">
        <label for="id_pasien">ID_pasien</label>
        <input type="text" name="id_pasien" value="<?= $contact['id_pasien'] ?>" id_pasien="id_pasien">
        <label for="no_rm">NO RM</label>
        <input type="number" name="no_rm" value="<?= $contact['no_rm'] ?>" no_rm="no_rm">
        <label for="nama">Nama</label>
        <input type="text" name="nama" value="<?= $contact['nama'] ?>" id_pasien="nama">
        <label for="agama">Agama</label>
        <input type="text" name="agama" value="<?= $contact['agama'] ?>" id_pasien="agama">
        <label for="notelp">No. Telp</label>
        <input type="text" name="notelp" value="<?= $contact['notelp'] ?>" id_pasien="notelp">
        <label for="pekerjaan">Pekerjaan</label>
        <input type="text" name="pekerjaan" value="<?= $contact['pekerjaan'] ?>" id_pasien="title">
        <input type="submit" value="Update">
    </form>
    <?php if ($msg) : ?>
        <p><?= $msg ?></p>
    <?php endif; ?>
</div>

<?= template_footer() ?>