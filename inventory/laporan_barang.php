<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.connection.php";
include_once "library/inc.library.php";
?>
<h1>ITEM DATA REPORTS</h1>
<a href="?page=Laporan"><i class="fa fa-arrow-left fa-fw"></i>Back</a><br><br>
<?php
$row = 50;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$start = microtime(true);
$pageSql = "SELECT * FROM barang";
$pageQry = mysqli_query($koneksidb, $pageSql) or die ("Error query: ".mysqli_error($koneksidb));
$end = microtime(true);
$duration = $end - $start;
$jml = mysqli_num_rows($pageQry);
$max = ceil($jml/$row);
?>
<table width="800" cellspacing="1" cellpadding="3" style="border-collapse:collapse">
  <tr>
  <td colspan="6" bgcolor="#EEEEEE">Showing total rows: <?php echo $jml; ?> (Query took <?php echo number_format($duration,4,'.',''); ?> seconds)</td>
  <td align="right" nowrap="nowrap" bgcolor="#EEEEEE">Page:
  <?php
  for ($h = 1; $h <= $max; $h++) {
	  $list[$h] = $row * $h - $row;
	  echo "<a href='?page=Laporan-Barang&hal=$list[$h]'>$h</a>";
	  if($h<$max){
		echo ",&nbsp;";
	  }
  }
  ?>
  </td>
  </tr>
</table>
<table width="800" cellspacing="1" cellpadding="3" class="table-list">
  <tr>
    <th width="20" scope="col">No</th>
    <th width="88" scope="col">Code</th>
    <th width="97" scope="col">Barcode</th>
    <th width="209" scope="col">Item Name</th>
    <th width="122" scope="col">Category</th>
    <th width="61" scope="col">Stock</th>
    <th width="151" scope="col">Selling Price</th>
  </tr>
  <?php
  $mySql = "SELECT barang.*, kategori.nm_kategori FROM barang LEFT JOIN kategori ON barang.kd_kategori=kategori.kd_kategori ORDER BY barang.kd_barang ASC LIMIT $hal, $row";
  $myQry = mysqli_query($koneksidb, $mySql) or die ("Error query: ".mysqli_error($koneksidb));
  $nomor = $hal;
  while ($myData = mysqli_fetch_array($myQry)) {
	  $nomor++;
  ?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td nowrap="nowrap"><?php echo $myData['kd_barang']; ?></td>
    <td nowrap="nowrap"><?php echo $myData['barcode']; ?></td>
    <td nowrap="nowrap"><?php echo $myData['nm_barang']; ?></td>
    <td nowrap="nowrap"><?php echo $myData['nm_kategori']; ?></td>
    <td><?php echo $myData['stok']; ?></td>
    <td><?php echo rupiah(format_angka($myData['harga_jual'])); ?></td>
  </tr>
  <?php } ?>
  <tr>
  <td colspan="6" bgcolor="#EEEEEE">Showing total rows: <?php echo $jml; ?></td>
  <td align="right" nowrap="nowrap" bgcolor="#EEEEEE">Page:
  <?php
  for ($h = 1; $h <= $max; $h++) {
	  $list[$h] = $row * $h - $row;
	  echo "<a href='?page=Laporan-Barang&hal=$list[$h]'>$h</a>";
	  if($h<$max){
			echo ",&nbsp;";
	  }
  }
  ?>
  </td>
  </tr>
</table>
