<?php
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

$noNota = $_GET['noNota'];

$mySql = "SELECT penjualan.*, user.nm_user FROM penjualan LEFT JOIN user ON penjualan.kd_user=user.kd_user WHERE no_penjualan='$noNota'";
$myQry = mysqli_query($koneksidb, $mySql) or die ("Error query #01: ".mysqli_error($koneksidb));
$kolomData = mysqli_fetch_array($myQry);

?>
<!doctype html>
<html moznomarginboxes mozdisallowselectionprint>
<head>
<meta charset="utf-8">
<title>SALES TRANSACTION</title>
<link rel="stylesheet" href="../styles/font-awesome.css">
<script src="../script/script.js"></script>
<?php if(!isset($_GET['noprint'])) { ?>
<script type="text/javascript">
window.print();
window.onfocus=function() { window.close();}
</script>
<?php } ?>
</head>

<body id="body">
<style>
a {
	color:#17a086 !important;
	text-decoration:none;
}
@media print {
	@page {margin:0}
	body {margin:1.6cm}
}
</style>
<div id="print">
<table width="430" cellspacing="1" cellpadding="3">
  <tr>
    <td colspan="6" align="center"><b>Toko CITRA</b><br>
    Ds. Plumpung, Desa Bakung Pringgodani,<br>
    Kec. Balongbendo, Kab. Sidoarjo, Jawa Timur, 61263<br>(031)-88913518</td>
  </tr>
  <tr>
    <td colspan="2">No Nota: <?php echo $kolomData['no_penjualan']; ?></td>
    <td colspan="4"><?php echo $kolomData['tgl_penjualan']; ?></td>
  </tr>
  <tr>
    <td width="26" nowrap="nowrap" bgcolor="#F5F5F5"><b>No</b></td>
    <td width="181" nowrap="nowrap" bgcolor="#F5F5F5"><b>Daftar Barang</b></td>
    <td width="37" nowrap="nowrap" bgcolor="#F5F5F5"><strong>Harga</strong></td>
    <td width="27" nowrap="nowrap" bgcolor="#F5F5F5"><strong>Disc</strong></td>
    <td width="23" nowrap="nowrap" bgcolor="#F5F5F5"><strong>Qty</strong></td>
    <td width="91" nowrap="nowrap" bgcolor="#F5F5F5"><strong>Total(Rp)</strong></td>
  </tr>
  <?php
  $notaSql = "SELECT penjualan_item.*, barang.nm_barang FROM penjualan_item LEFT JOIN barang ON penjualan_item.kd_barang=barang.kd_barang WHERE penjualan_item.no_penjualan='$noNota' ORDER BY barang.kd_barang ASC";
  $notaQry = mysqli_query($koneksidb, $notaSql) or die ("Error nota query: ".mysqli_error($koneksidb));
  $nomor = 0; $hargaDiskon = 0; $totalBayar = 0; $jumlahBarang = 0; $uangKembali = 0;
  while ($notaData = mysqli_fetch_array($notaQry)) {
	  $nomor++;
	  $hargaDiskon = $notaData['harga_jual'] - ($notaData['harga_jual'] * $notaData['diskon'] / 100);
	  $subTotal = $notaData['jumlah'] * $hargaDiskon;
	  $totalBayar = $totalBayar + $subTotal;
	  $jumlahBarang = $jumlahBarang + $notaData['jumlah'];
	  $uangKembali = $kolomData['uang_bayar'] - $totalBayar;
  ?>
  <tr>
    <td><?php echo $nomor; ?></td>
    <td><?php echo $notaData['nm_barang']; ?></td>
    <td><?php echo format_angka($notaData['harga_jual']); ?></td>
    <td><?php echo $notaData['diskon']; ?></td>
    <td><?php echo $notaData['jumlah']; ?></td>
    <td><?php echo format_angka($subTotal); ?></td>
  </tr>
  <?php
  }
  ?>
  <tr>
    <td colspan="3" align="right"><strong>Total Belanja (Rp) :</strong></td>
    <td colspan="3" bgcolor="#F5F5F5"><?php echo format_angka($totalBayar); ?></td>
  </tr>
  <tr>
    <td colspan="3" align="right"><strong>Uang Bayar (Rp) :</strong></td>
    <td colspan="3"><?php echo format_angka($kolomData['uang_bayar']); ?></td>
  </tr>
  <tr>
    <td colspan="3" align="right"><strong>Uang Kembali (Rp) :</strong></td>
    <td colspan="3"><?php echo format_angka($uangKembali); ?></td>
  </tr>
  <tr>
    <td colspan="6">Cashier: <?php echo $kolomData['nm_user']; ?></td>
  </tr>
</table>
</div>
</body>
<?php if(!isset($_GET['noprint'])) { ?>
<script>
document.getElementById('body').addEventListener('load',window.print());
</script>
<?php } else { echo "<span><a href='' onClick='cetak()'><i class='fa fa-print fa-fw'></i> Print</a></span>"; }?>
</html>
