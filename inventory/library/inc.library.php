<?php
date_default_timezone_set("Asia/Jakarta");

function buatKode($a, $b) {
	global $koneksidb;
	mysqli_select_db($koneksidb, 'inventory') or die ("Database not found!");
	$tabel = $a;
	$inisial = $b;
	$query = "SELECT * FROM $tabel";
	$struktur = mysqli_query($koneksidb, $query);
	$fiield = mysqli_fetch_field_direct($struktur,0);
	$field = $fiield->name; // fix this, DONE
	
	// Atur panjang kode
	if($tabel=="barang") {
		$panjang = 7;
	} elseif($tabel=="pelanggan") {
		$panjang = 5;
	} elseif($tabel=="pembelian" || $tabel=="penjualan") {
		$panjang = 7;
	} else {
		$panjang = 4;
	}
	
	// Start query
	$qry = mysqli_query($koneksidb, "SELECT MAX(".$field.") FROM $tabel");
	$row = mysqli_fetch_array($qry);
	if ($row[0]=="") {
		$angka = 0;
	}
	else {
		$angka = substr($row[0], strlen($inisial));
	}
	$angka++;
	$angka = strval($angka);
	$pinisial = strlen($inisial);
	$pangka = strlen($angka);
	$tmp = "";
	for ($i=0; $i<($panjang-$pinisial-$pangka); $i++) {
		$tmp=$tmp."0";
	}
	return $inisial.$tmp.$angka;
} //End Of Function

function format_angka($angka) {
	$hasil = number_format($angka,0, ",",".");
	return $hasil;
}

function rupiah($uang) {
	$rupiah = "Rp."." ".$uang.",-";
	return $rupiah;
}

function IndonesiaTgl($tanggal) {
	$tgl = substr($tanggal,8,2);
	$bln = substr($tanggal,5,2);
	$thn = substr($tanggal,0,4);
	$awal = "$tgl-$bln-$thn";
	return $awal;
}

function InggrisTgl($tanggal) {
	$tgl = substr($tanggal,0,2);
	$bln = substr($tanggal,3,2);
	$thn = substr($tanggal,6,4);
	$awal = "$thn-$bln-$tgl";
	return $awal;
} //EOF
?>