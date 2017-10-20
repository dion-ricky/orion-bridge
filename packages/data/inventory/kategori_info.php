<?php
include_once "library/inc.library.php";
include_once "library/inc.connection.php";
if(isset($_GET['kode'])) {
	$kode = $_GET['kode'];
}
$sql = "SELECT * FROM kategori WHERE kd_kategori='$kode'";
$qry = mysqli_query($koneksidb, $sql) or die ("Error query kategori!: ".mysqli_error($koneksidb));
$data = mysqli_fetch_array($qry);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Category Info</title>
<link rel="stylesheet" href="styles/style.css">
<style>
body,html,h1,h2,h3,h4,h5 {
	font-family:Consolas, "Andale Mono", "Lucida Console", "Lucida Sans Typewriter", Monaco, "Courier New", monospace;
}
</style>
</head>

<body style="margin-left:5px; height:auto;">
<h2>Category Data [<?php echo $data['kd_kategori']; ?>]: </h2>
<br>
<table width="600" cellspacing="1" cellpadding="3" class="table-list-info">
  <tr>
    <td width="134" align="right" nowrap="nowrap"><strong>Code:</strong></td>
    <td class="hover" width="449"><?php echo $data['kd_kategori']; ?></td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap"><strong>Category:</strong></td>
    <td class="hover"><?php echo $data['nm_kategori']; ?></td>
  </tr>
</table>

  <?php
  $sql = "SELECT * FROM barang WHERE kd_kategori='$kode'";
  $qry = mysqli_query($koneksidb, $sql) or die ("Error query barang: ".mysqli_error($koneksidb));
  ?>
  <h3>Showing <?php echo mysqli_num_rows($qry); ?> Item(s) Under Category [<?php echo $data['nm_kategori']; ?>]:</h3>
  <?php
  if (mysqli_num_rows($qry)>=1) {
?>

<table width="600" cellspacing="1" cellpadding="3" class="table-list">
  <tr>
    <th width="29" nowrap="nowrap" scope="col">No.</th>
    <th width="100" nowrap="nowrap" scope="col">Item Code</th>
    <th width="100" nowrap="nowrap" scope="col">Barcode</th>
    <th width="175" nowrap="nowrap" scope="col">Item Name</th>
    <th width="158" nowrap="nowrap" scope="col">Info</th>
  </tr>
  <?php
  $nomor = 0;
  while ($myData = mysqli_fetch_array($qry)) {
	  $nomor++;
  ?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_barang']; ?></td>
    <td><?php echo $myData['barcode']; ?></td>
    <td nowrap="nowrap"><?php echo $myData['nm_barang']; ?></td>
    <td><?php echo $myData['keterangan']; ?></td>
  </tr>
  <?php } ?>
</table>
<?php
  }
?>

</body>
</html>