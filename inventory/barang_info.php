<?php
include_once "library/inc.library.php";
include_once "library/inc.connection.php";
if(isset($_GET['kode'])) {
	$kode = $_GET['kode'];
}
$sql = "SELECT * FROM barang WHERE kd_barang='$kode'";
$qry = mysqli_query($koneksidb, $sql) or die ("Error query barang!: ".mysqli_error($koneksidb));
$data = mysqli_fetch_array($qry);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Item Info</title>
<link rel="stylesheet" href="styles/style.css">
<style>
body,html,h1,h2,h3,h4,h5 {
	font-family:Consolas, "Andale Mono", "Lucida Console", "Lucida Sans Typewriter", Monaco, "Courier New", monospace;
}
</style>
</head>

<body style="margin-left:5px; height:auto;">
<h2>Items Data [<?php echo $data['barcode']; ?>]: </h2>
<br>
<table width="600" cellspacing="1" cellpadding="3" class="table-list-info">
  <tr>
    <td width="108" align="right" nowrap="nowrap"><strong>Barcode:</strong></td>
    <td class="hover" width="475"><?php echo $data['barcode']; ?></td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><strong>Item Code:</strong></td>
    <td class="hover"><?php echo $data['kd_barang']; ?></td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><strong>Item Name:</strong></td>
    <td class="hover"><?php echo $data['nm_barang']; ?></td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><strong>Stock:</strong></td>
    <td class="hover"><?php echo $data['stok'].' '.$data['satuan']; ?></td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><strong>Purchase Price:</strong></td>
    <td class="hover"><?php echo rupiah(format_angka($data['harga_beli'])); ?></td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><strong>Selling Price:</strong></td>
    <td class="hover"><?php echo rupiah(format_angka($data['harga_jual'])); ?></td>
  </tr>
</table>

</body>
</html>