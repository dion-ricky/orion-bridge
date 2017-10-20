<?php
include_once "library/inc.connection.php";
include_once "library/inc.library.php";
include_once "library/inc.seslogin.php";

?>
<h1>SALES DATA REPORTS</h1>
<a href="?page=Laporan"><i class="fa fa-arrow-left fa-fw"></i>Back</a><br><br>
<?php
$row = 50;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM penjualan";
$pageQry = mysqli_query($koneksidb, $pageSql) or die ("Error query: ".mysqli_error($koneksidb));
$jml = mysqli_num_rows($pageQry);
$max = ceil($jml/$row);

$cekSql = "SELECT * FROM penjualan";
$cekQry = mysqli_query($koneksidb, $cekSql) or die ("Error check query: ".mysqli_error($koneksidb));
if (mysqli_num_rows($cekQry)>=1) {
	$nomor = 0;
	$start = microtime(true);
	$mySql = "SELECT penjualan.*, pelanggan.nm_pelanggan, user.nm_user FROM penjualan JOIN pelanggan ON penjualan.kd_pelanggan=pelanggan.kd_pelanggan JOIN user ON penjualan.kd_user=user.kd_user ORDER BY penjualan.no_penjualan";
	$myQry = mysqli_query($koneksidb, $mySql) or die ("Error select query: ".mysqli_error($koneksidb));
	$end = microtime(true);
	$duration = $end - $start;
?>
<table width="800" cellspacing="1" cellpadding="3" style="border-collapse:collapse">
<tr>
  <td colspan="6" bgcolor="#EEEEEE">Showing total rows: <?php echo $jml; ?> (Query took <?php echo number_format($duration,4,'.',''); ?> seconds)</td>
  <td align="right" nowrap="nowrap" bgcolor="#EEEEEE">Page:
  <?php
  for ($h = 1; $h <= $max; $h++) {
	  $list[$h] = $row * $h - $row;
	  echo "<a href='?page=Laporan-Penjualan&hal=$list[$h]'>$h</a>,&nbsp;";
  }
  ?>
  </td>
  </tr>
</table>
<table width="800" cellspacing="1" cellpadding="3" class="table-list">
  <tr>
    <th width="20" nowrap="nowrap" scope="col">No</th>
    <th width="130" nowrap="nowrap" scope="col">Transaction Code</th>
    <th width="135" nowrap="nowrap" scope="col">Date of Transaction</th>
    <th width="165" nowrap="nowrap" scope="col">Customer</th>
    <th width="48" nowrap="nowrap" scope="col">Item(s)</th>
    <th width="148" nowrap="nowrap" scope="col">Operator</th>
    <th width="102" nowrap="nowrap" scope="col">Tools</th>
  </tr>
<?php
while ($myData = mysqli_fetch_array($myQry)) {
	$nomor++;
	$countSql = "SELECT COUNT(*) AS item FROM penjualan_item WHERE no_penjualan='$myData[no_penjualan]'";
	$countQry = mysqli_query($koneksidb, $countSql) or die ("Error count query: ".mysqli_error($koneksidb));
	$countData = mysqli_fetch_array($countQry);
?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td align="center"><?php echo $myData['no_penjualan']; ?></td>
    <td align="center"><?php echo IndonesiaTgl($myData['tgl_penjualan']); ?></td>
    <td nowrap="nowrap"><?php echo $myData['nm_pelanggan']; ?></td>
    <td align="center"><?php echo $countData['item']; ?></td>
    <td align="center"><?php echo $myData['nm_user']; ?></td>
    <td align="center"><a href="cetak/penjualan_nota.php?noNota=<?php echo $myData['no_penjualan'] ?>&noprint" target="_blank">Print</a></td>
  </tr>
<?php
}
?>
</table>
<?php
}
else {
	echo "No transaction record on database!";
}
?>