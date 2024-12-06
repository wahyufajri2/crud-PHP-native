<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Periksa apakah data POST tidak kosong
if (!empty($_POST)) {
    // Posting data tidak kosong masukkan catatan baru
    // Atur variabel yang akan disisipkan, kita harus memeriksa apakah variabel POST ada jika tidak kita dapat mengaturnya menjadi kosong
    $id_pasien = isset($_POST['id_pasien']) && !empty($_POST['id_pasien']) && $_POST['id_pasien'] != 'auto' ? $_POST['id_pasien'] : NULL;
    // Periksa apakah variabel "nama" POST ada, jika tidak default nilainya kosong, pada dasarnya sama untuk semua variabel
    $no_rm = isset($_POST['no_rm']) ? $_POST['no_rm'] : '';
    $nama = isset($_POST['nama']) ? $_POST['nama'] : '';
    $agama = isset($_POST['agama']) ? $_POST['agama'] : '';
    $notelp = isset($_POST['notelp']) ? $_POST['notelp'] : '';
    $pekerjaan = isset($_POST['pekerjaan']) ? $_POST['pekerjaan'] : '';

    // Masukkan catatan baru ke dalam tabel pasien
    $stmt = $pdo->prepare('INSERT INTO pasien VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->execute([$id_pasien, $no_rm, $nama, $agama, $notelp, $pekerjaan]);
    // Pesan keluaran
    $msg = 'Berhasil Dibuat!';
}
?>


<?= template_header('Create') ?>

<div class="content update">
    <h2>Tambah Data Pasien</h2>
    <form action="create.php" method="post">
        <label for="id_pasien">ID Pasien</label>
        <input type="text" name="id_pasien" value="auto" id="id_pasien">
        <label for="no_rm">No RM</label>
        <input type="number" name="no_rm" id="no_rm">
        <label for="nama">Nama</label>
        <input type="text" name="nama" id="nama">
        <label for="agama">Agama</label>
        <input type="text" name="agama" id="agama">
        <label for="notelp">No. Telp</label>
        <input type="text" name="notelp" id="notelp">
        <label for="pekerjaan">Pekerjaan</label>
        <input type="text" name="pekerjaan" id="pekerjaan">
        <input type="submit" value="Create">
    </form>
    <?php if ($msg) : ?>
        <p><?= $msg ?></p>
    <?php endif; ?>
</div>

<?= template_footer() ?>