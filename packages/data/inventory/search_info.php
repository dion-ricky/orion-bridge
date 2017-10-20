<?php
include_once "library/inc.connection.php";
if(isset($_GET['kode'])) {
	$kode = $_GET['kode'];
	$alias = substr($kode,0,1);
	switch ($alias) {
		case 'B':
			include "barang_info.php"; break;
		case 'K':
			include "kategori_info.php"; break;
		case 'S':
			include "supplier_info.php"; break;
		case 'P':
			include "pelanggan_info.php"; break;
		default:
			echo "Invalid";
	}
}
?>