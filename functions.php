<?php
function pdo_connect_mysql()
{
	$DATABASE_HOST = 'localhost';
	$DATABASE_USER = 'root';
	$DATABASE_PASS = '';
	$DATABASE_NAME = 'crud_php';
	try {
		return new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8mb4', $DATABASE_USER, $DATABASE_PASS);
	} catch (PDOException $exception) {
		// Jika ada kesalahan dengan koneksi, hentikan skrip dan tampilkan kesalahan.
		exit('Gagal terhubung ke basis data!');
	}
}
function template_header($title)
{
	echo <<<EOT
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Halaman $title</title>
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="shortcut icon" href="rumah-sakit.png" type="image/x-icon">
		<script src="https://kit.fontawesome.com/4cb062cd87.js" crossorigin="anonymous"></script>
	</head>
	<body>
    <nav class="navtop">
    	<div>
    		<h1>Kelola Data Pasien</h1>
            <a href="index.php"><i class="fas fa-home"></i>Home</a>
    		<a href="read.php"><i class="fa-solid fa-hospital-user"></i>Data Pasien</a>
    	</div>
    </nav>
EOT;
}
function template_footer()
{
	echo <<<EOT
<footer class="sticky-footer">
	<div class="container">
		<div class="copyright">
			<span>Kelompok 4 | JWD PNC</span>
		</div>
	</div>
</footer>
    </body>
</html>
EOT;
}
