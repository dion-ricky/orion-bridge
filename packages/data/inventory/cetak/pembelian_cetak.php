<?php
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

if($_GET) {
	$noNota = $_GET['noNota'];
	
	$mySql = "SELECT pembelian.*, supplier.nm_supplier, user.nm_user FROM pembelian LEFT JOIN supplier ON pembelian.kd_supplier=supplier.kd_supplier LEFT JOIN user ON pembelian.kd_user=user.kd_user WHERE pembelian.no_pembelian='$noNota'";
	$myQry = mysqli_query($koneksidb, $mySql) or die ("Error query#01: ".mysqli_error($koneksidb));
	$kolomData = mysqli_fetch_array($myQry);
} else {
	echo "Nomor Transaksi Tidak Terbaca";
	exit;
}
?>
<html moznomarginboxes mozdisallowselectionprint>
<head>
<link rel="stylesheet" href="../styles/font-awesome.css">
<link rel="stylesheet" href="../styles/style.css">
<script src="../script/script.js"></script>
</head>
<body style="margin-left:5px; margin-top:5px;">
<div id="print">
<style>
@media print {
	@page { margin:0 }
	body {margin:1.6cm}
}
</style>
<h2>PEMBELIAN BARANG</h2>
<table width="500" cellspacing="1" cellpadding="3">
  <tr>
    <td width="122" nowrap="nowrap"><strong>No. Pembelian</strong></td>
    <td width="6">:</td>
    <td width="348"><?php echo $kolomData['no_pembelian']; ?></td>
  </tr>
  <tr>
    <td nowrap="nowrap"><strong>Tgl. Pembelian</strong></td>
    <td>:</td>
    <td><?php echo IndonesiaTgl($kolomData['tgl_pembelian']); ?></td>
  </tr>
  <tr>
    <td nowrap="nowrap"><strong>Supplier</strong></td>
    <td>:</td>
    <td><?php echo $kolomData['nm_supplier']; ?></td>
  </tr>
  <tr>
    <td nowrap="nowrap"><strong>Keterangan</strong></td>
    <td>:</td>
    <td><?php echo $kolomData['keterangan']; ?></td>
  </tr>
  <tr>
    <td nowrap="nowrap"><strong>Operator</strong></td>
    <td>:</td>
    <td><?php echo $kolomData['nm_user']; ?></td>
  </tr>
</table>
<table width="600" cellspacing="1" cellpadding="3">
  <tr>
    <td colspan="6"><strong>DAFTAR BARANG</strong></td>
  </tr>
  <tr>
    <td bgcolor="#F5F5F5"><strong>No</strong></td>
    <td bgcolor="#F5F5F5"><strong>Kode</strong></td>
    <td bgcolor="#F5F5F5"><strong>Nama Barang</strong></td>
    <td bgcolor="#F5F5F5"><strong>Harga Beli</strong></td>
    <td bgcolor="#F5F5F5"><strong>Jumlah</strong></td>
    <td bgcolor="#F5F5F5"><strong>Harga Total</strong></td>
  </tr>
  <?php
  $subTotalBeli = 0;
  $grandTotalBeli = 0;
  $qtyItem = 0;
  
  $mySql = "SELECT pembelian_item.*, barang.nm_barang, kategori.nm_kategori FROM pembelian_item LEFT JOIN barang ON pembelian_item.kd_barang=barang.kd_barang LEFT JOIN kategori ON barang.kd_kategori=kategori.kd_kategori WHERE pembelian_item.no_pembelian='$noNota' ORDER BY pembelian_item.kd_barang";
  $myQry = mysqli_query($koneksidb, $mySql) or die ("Error query#02: ".mysqli_error($koneksidb));
  $nomor = 0;
  while ($myData = mysqli_fetch_array($myQry)) {
	  $qtyItem = $qtyItem + $myData['jumlah'];
	  $subTotalBeli = $myData['harga_beli'] * $myData['jumlah'];
	  $grandTotalBeli = $grandTotalBeli + $subTotalBeli;
	  $nomor++;
  ?>
  <tr>
    <td><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_barang']; ?></td>
    <td><?php echo $myData['nm_barang']; ?></td>
    <td><?php echo format_angka($myData['harga_beli']); ?></td>
    <td><?php echo $myData['jumlah']; ?></td>
    <td><?php echo format_angka($subTotalBeli); ?></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="4" align="right" bgcolor="#F5F5F5">Grand Total (Rp) :</td>
    <td bgcolor="#F5F5F5"><?php echo format_angka($qtyItem); ?></td>
    <td bgcolor="#F5F5F5"><?php echo format_angka($grandTotalBeli); ?></td>
  </tr>
</table>
</div>
<span><a href="" onClick="cetak()"><i class="fa fa-print fa-fw"></i></a></span>
</body>
</html>