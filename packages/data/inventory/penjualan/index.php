<?php
session_start();
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $_SESSION['SES_NAME']; ?> / Sales Transaction</title>
<link rel="stylesheet" type="text/css" href="../styles/style.css">
</head>

<body>
<?php
if(isset($_GET['page'])) {
	switch($_GET['page']) {
		case 'Penjualan':
			if(!file_exists("penjualan.php")) die ("Empty page!");
			include "penjualan.php"; break;
		
		case 'Search':
			if(!file_exists("search.php")) die ("Empty page!");
			include "search.php"; break;
			
		case 'Pencarian-Barang':
			if(!file_exists("search.php")) die ("Empty page!");
			include "search.php"; break;
			
		case 'Daftar-Penjualan':
			if(!file_exists("daftar_penjualan.php")) die ("Empty page!");
			include "daftar_penjualan.php"; break;
	}
} else {
	include "penjualan.php";
}
?>
</body>
</html>