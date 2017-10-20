<?php
include_once "library/inc.connection.php";
include_once "library/inc.library.php";

if(isset($_GET['kode'])){
	$kode = $_GET['kode'];
}
$sql = "SELECT * FROM supplier WHERE kd_supplier='$kode'";
$qry = mysqli_query($koneksidb, $sql) or die ("Error query supplier: ".mysqli_error($koneksidb));
$data = mysqli_fetch_array($qry);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Supplier Info</title>
<link rel="stylesheet" href="styles/style.css">
<style>
body,html,h1,h2,h3,h4,h5 {
	font-family:Consolas, "Andale Mono", "Lucida Console", "Lucida Sans Typewriter", Monaco, "Courier New", monospace;
}
</style>
</head>

<body style="margin-left:5px; height:auto;">
<h2>Supplier Data [<?php echo $kode; ?>]:</h2>
<table width="600" cellspacing="1" cellpadding="3" class="table-list-info">
  <tr>
    <td width="105" align="right" nowrap="nowrap"><strong>Supplier Code:</strong></td>
    <td class="hover" width="478"><?php echo $data['kd_supplier']; ?></td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><strong>Supplier Name:</strong></td>
    <td class="hover"><?php echo $data['nm_supplier']; ?></td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><strong>Address:</strong></td>
    <td class="hover"><?php echo $data['alamat']; ?></td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><strong>Telephone:</strong></td>
    <td class="hover"><?php echo $data['no_telepon']; ?></td>
  </tr>
</table>
<?php
$sql = "SELECT * FROM pembelian WHERE kd_supplier='$kode'";
$qry = mysqli_query($koneksidb, $sql) or die ("Error query transaksi: ".mysqli_error($koneksidb));
?>
<h3><?php echo mysqli_num_rows($qry); ?> Transaction History Associated with Supplier [<?php echo $data['nm_supplier']; ?>]:</h3>
<?php
if(mysqli_num_rows($qry)>=1) {
?>
<table width="600" cellspacing="1" cellpadding="3" class="table-list">
  <tr>
    <th width="29" nowrap="nowrap" scope="col">No</th>
    <th width="119" nowrap="nowrap" scope="col">Transaction No.</th>
    <th width="155" nowrap="nowrap" scope="col">Date of Trans.</th>
    <th width="171" nowrap="nowrap" scope="col">Info</th>
    <th width="88" nowrap="nowrap" scope="col">Operator</th>
  </tr>
  <?php
  $nomor = 0;
  while ($myData = mysqli_fetch_array($qry)) {
	  $userSql = "SELECT nm_user FROM user WHERE kd_user='$myData[kd_user]'";
	  $userQry = mysqli_query($koneksidb, $userSql);
	  $userData = mysqli_fetch_array($userQry);
	  $nomor++;
  ?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['no_pembelian']; ?></td>
    <td><?php echo IndonesiaTgl($myData['tgl_pembelian']); ?></td>
    <td><?php echo $myData['keterangan']; ?></td>
    <td align="center"><?php echo $userData['nm_user']; ?></td>
  </tr>
  <?php } ?>
</table>
<?php
}
?>
</body>
</html>