<?php
if($_GET) {	
	switch($_GET['page']) {
		case '':
			if(!file_exists ("main.php")) die (include "404.php");
			include "main.php"; break;
			
		case 'Halaman-Utama':
			if(!file_exists ("main.php")) die (include "404.php");
			include "main.php"; break;
			
		case 'Login':
			if(!file_exists ("login.php")) die (include "404.php");
			include "login.php"; break;
		
		case 'Login-Validasi':
			if(!file_exists ("login_validasi.php")) die (include "404.php");
			include "login_validasi.php"; break;
			
		case 'Logout':
			if(!file_exists ("logout.php")) die (include "404.php");
			include "logout.php"; break;
		
		case 'User-Data':
			if(!file_exists ("user_data.php")) die (include "404.php");			// USER
			include "user_data.php"; break;
			
		case 'User-Add':
			if(!file_exists("user_add.php")) die (include "404.php");
			include "user_add.php"; break;
			
		case 'User-Delete':
			if(!file_exists("user_delete.php")) die (include "404.php");
			include "user_delete.php"; break;
			
		case 'User-Edit':
			if(!file_exists("user_edit.php")) die (include "404.php");
			include "user_edit.php"; break;
			
		case 'Pelanggan-Data':
			if(!file_exists ("pelanggan_data.php")) die (include "404.php");	// Pelanggan Data
			include "pelanggan_data.php"; break;
			
		case 'Pelanggan-Add' :
			if(!file_exists ("pelanggan_add.php")) die (include "404.php");		// Pelanggan Add
			include "pelanggan_add.php"; break;
			
		case 'Pelanggan-Edit':
			if(!file_exists("pelanggan_edit.php")) die (include "404.php");		// Pelanggan Edit
			include "pelanggan_edit.php"; break;
			
		case 'Pelanggan-Delete':
			if(!file_exists("pelanggan_delete.php")) die (include "404.php");	// Pelanggan Delete
			include "pelanggan_delete.php"; break;
		
		case 'Kategori-Data':
			if(!file_exists ("kategori_data.php")) die (include "404.php");		// Kategori
			include "kategori_data.php"; break;
		
		case 'Kategori-Add':
			if(!file_exists ("kategori_add.php")) die (include "404.php");
			include "kategori_add.php"; break;
			
		case 'Kategori-Delete':
			if(!file_exists ("kategori_delete.php")) die (include "404.php");
			include "kategori_delete.php"; break;
		
		case 'Kategori-Edit':
			if(!file_exists ("kategori_edit.php")) die (include "404.php");
			include "kategori_edit.php"; break;
			
		case 'Supplier-Data':
			if(!file_exists ("supplier_data.php")) die (include "404.php");		// Supplier
			include "supplier_data.php"; break;
			
		case 'Supplier-Add':
			if(!file_exists("supplier_add.php")) die (include "404.php");
			include "supplier_add.php"; break;
			
		case 'Supplier-Edit':
			if(!file_exists("supplier_edit.php")) die (include "404.php");
			include "supplier_edit.php"; break;
			
		case 'Supplier-Delete':
			if(!file_exists("supplier_delete.php")) die (include "404.php");
			include "supplier_delete.php"; break;
			
		case 'Barang-Data':
			if(!file_exists ("barang_data.php")) die (include "404.php");		// BARANG
			include "barang_data.php"; break;
			
		case 'Barang-Add':
			if(!file_exists ("barang_add.php")) die (include "404.php");
			include "barang_add.php"; break;
			
		case 'Barang-Edit':
			if(!file_exists ("barang_edit.php")) die (include "404.php");
			include "barang_edit.php"; break;
			
		case 'Barang-Delete':
			if(!file_exists("barang_delete.php")) die (include "404.php");
			include "barang_delete.php"; break;
		
		case 'Pencarian':
			if(!file_exists ("search.php")) die (include "404.php");
			include "search.php"; break;
			
		case 'Search':	
			if(!file_exists ("search.php")) die (include "404.php");
			include "search.php"; break;
			
		case 'Laporan':
			if(!file_exists ("menu_laporan.php")) die (include "404.php");
			include "menu_laporan.php"; break;
		
		case 'Laporan-User':
			if(!file_exists("laporan_user.php")) die (include "404.php");
			include "laporan_user.php"; break;
			
		case 'Laporan-Supplier':
			if(!file_exists("laporan_supplier.php")) die (include "404.php");
			include "laporan_supplier.php"; break;
			
		case 'Laporan-Pelanggan':
			if(!file_exists("laporan_pelanggan.php")) die (include "404.php");
			include "laporan_pelanggan.php"; break;
			
		case 'Laporan-Kategori':
			if(!file_exists("laporan_kategori.php")) die (include "404.php");
			include "laporan_kategori.php"; break;
			
		case 'Laporan-Barang':
			if(!file_exists("laporan_barang.php")) die (include "404.php");
			include "laporan_barang.php"; break;
			
		case 'Laporan-Barang-per-Kategori':
			if(!file_exists("laporan_barang_kategori.php")) die (include "404.php");	
			include "laporan_barang_kategori.php"; break;
			
		case 'Laporan-Barang-per-Supplier':
			if(!file_exists("laporan_barang_supplier.php")) die (include "404.php");	
			include "laporan_barang_supplier.php"; break;
			
		case 'Laporan-Pembelian':
			if(!file_exists("laporan_pembelian.php")) die (include "404.php");
			include "laporan_pembelian.php"; break;
			
		case 'Laporan-Pembelian-per-Periode':
			if(!file_exists("laporan_pembelian_periode.php")) die (include "404.php");
			include "laporan_pembelian_periode.php"; break;
			
		case 'Laporan-Pembelian-per-Supplier':
			if(!file_exists("laporan_pembelian_supplier.php")) die (include "404.php");
			include "laporan_pembelian_supplier.php"; break;
			
		case 'Laporan-Penjualan':
			if(!file_exists("laporan_penjualan.php")) die (include "404.php");
			include "laporan_penjualan.php"; break;
			
		case 'Laporan-Penjualan-per-Periode':
			if(!file_exists("laporan_penjualan_periode.php")) die (include "404.php");
			include "laporan_penjualan_periode.php"; break;
			
		case 'Laporan-Penjualan-per-Pelanggan':
			if(!file_exists("laporan_penjualan_pelanggan.php")) die (include "404.php");
			include "laporan_penjualan_pelanggan.php"; break;
			
		case 'Laporan-Penjualan-per-Barang':
			if(!file_exists("laporan_penjualan_barang.php")) die (include "404.php");
			include "laporan_penjualan_barang.php"; break;
			
		case 'Logout':
			if(!file_exists ("logout.php")) die (include "404.php");
			include "logout.php"; break;
			
		default:
			include "404.php"; break;
	}
} else {
include "main.php";
}
?>