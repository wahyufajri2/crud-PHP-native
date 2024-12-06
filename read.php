<?php
include 'functions.php';
// Terhubung ke database MySQL
$pdo = pdo_connect_mysql();
// Dapatkan halaman melalui permintaan GET (param URL: halaman), jika tidak ada default halaman ke 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Jumlah catatan untuk ditampilkan di setiap halaman
$records_per_page = 5;


// Persiapkan pernyataan SQL dan dapatkan catatan dari tabel pasien kami, LIMIT akan menentukan halaman
$stmt = $pdo->prepare('SELECT * FROM pasien ORDER BY id LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page - 1) * $records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the records so we can display them in our template.
$pasien = $stmt->fetchAll(PDO::FETCH_ASSOC);


// Dapatkan jumlah total pasien, ini agar kita dapat menentukan apakah harus ada tombol selanjutnya dan sebelumnya
$num_pasien = $pdo->query('SELECT COUNT(*) FROM pasien')->fetchColumn();
?>


<?= template_header('Read') ?>

<div class="content read">
    <h2>Lihat Data Pasien</h2>
    <a href="create.php" class="create-contact">Tambah Data</a>
    <table>
        <thead>
            <tr class="text-center">
                <td>No</td>
                <td>No RM</td>
                <td>Nama</td>
                <td>Agama</td>
                <td>No. Telp</td>
                <td>Pekerjaan</td>
                <td>Aksi</td>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            <?php foreach ($pasien as $psn) : ?>
                <tr>
                    <td class="text-center"><?= $no; ?></td>
                    <td><?= $psn['no_rm']; ?></td>
                    <td><?= $psn['nama']; ?></td>
                    <td><?= $psn['agama']; ?></td>
                    <td><?= $psn['notelp']; ?></td>
                    <td><?= $psn['pekerjaan']; ?></td>
                    <td class="actions">
                        <a href="update.php?id_pasien=<?= $psn['id_pasien']; ?>" class="edit"><i class="fa-solid fa-pen"> Edit</i></a>
                        <a href="delete.php?id_pasien=<?= $psn['id_pasien']; ?>" class="trash"><i class="fa-solid fa-trash"> Hapus</i></a>
                    </td>
                </tr>
                <?php $no++; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="pagination">
        <?php if ($page > 1) : ?>
            <a href="read.php?page=<?= $page - 1 ?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
        <?php endif; ?>
        <?php if ($page * $records_per_page < $num_pasien) : ?>
            <a href="read.php?page=<?= $page + 1 ?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
        <?php endif; ?>
    </div>
</div>

<?= template_footer() ?>