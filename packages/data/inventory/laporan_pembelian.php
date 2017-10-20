<?php
include_once "library/inc.connection.php";
include_once "library/inc.library.php";
include_once "library/inc.seslogin.php";

?>
<h1>PURCHASE DATA REPORTS</h1>
<a href="?page=Laporan"><i class="fa fa-arrow-left fa-fw"></i>Back</a><br><br>
<?php
$row = 50;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM pembelian";
$pageQry = mysqli_query($koneksidb, $pageSql) or die ("Error query: ".mysqli_error($koneksidb));
$jml = mysqli_num_rows($pageQry);
$max = ceil($jml/$row);

$cekSql = "SELECT * FROM pembelian";
$cekQry = mysqli_query($koneksidb, $cekSql) or die ("Error check query: ".mysqli_error($koneksidb));
if (mysqli_num_rows($cekQry)>=1) {
	$nomor = 0;
	$start = microtime(true);
	$mySql = "SELECT pembelian.*, supplier.nm_supplier, user.nm_user FROM pembelian JOIN supplier ON pembelian.kd_supplier=supplier.kd_supplier JOIN user ON pembelian.kd_user=user.kd_user ORDER BY pembelian.no_pembelian";
	$myQry = mysqli_query($koneksidb, $mySql) or die ("Error select query: ".mysqli_error($koneksidb));
	$end = microtime(true);
	$duration = $end - $start;
?>
<table width="800" cellpadding="3" cellspacing="1" style="border-collapse:collapse">
<tr>
  <td colspan="6" bgcolor="#EEEEEE">Showing total <?php echo $jml; ?> row(s) (Query took <?php echo number_format($duration,4,'.',''); ?> seconds)</td>
  <td align="right" nowrap="nowrap" bgcolor="#EEEEEE">Page:
  <?php
  for ($h = 1; $h <= $max; $h++) {
	  $list[$h] = $row * $h - $row;
	  echo "<a href='?page=Laporan-Pembelian&hal=$list[$h]'>$h</a>,&nbsp;";
  }
  ?>
  </td>
  </tr>
</table>
<table width="800" cellspacing="1" cellpadding="3" class="table-list">
  <tr>
    <th width="20" nowrap="nowrap" scope="col">No</th>
    <th width="95" nowrap="nowrap" scope="col">Transaction Code</th>
    <th width="99" nowrap="nowrap" scope="col">Date of Transaction</th>
    <th width="236" nowrap="nowrap" scope="col">Supplier</th>
    <th width="48" nowrap="nowrap" scope="col">Item(s)</th>
    <th width="149" nowrap="nowrap" scope="col">Operator</th>
    <th width="101" nowrap="nowrap" scope="col">Tools</th>
  </tr>
<?php
while ($myData = mysqli_fetch_array($myQry)) {
	$nomor++;
	$countSql = "SELECT COUNT(*) AS item FROM pembelian_item WHERE no_pembelian='$myData[no_pembelian]'";
	$countQry = mysqli_query($koneksidb, $countSql) or die ("Error count query: ".mysqli_error($koneksidb));
	$countData = mysqli_fetch_array($countQry);
?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td align="center"><?php echo $myData['no_pembelian']; ?></td>
    <td align="center"><?php echo IndonesiaTgl($myData['tgl_pembelian']); ?></td>
    <td nowrap="nowrap"><?php echo $myData['nm_supplier']; ?></td>
    <td align="center"><?php echo $countData['item']; ?></td>
    <td align="center"><?php echo $myData['nm_user']; ?></td>
    <td align="center"><a href="cetak/pembelian_cetak.php?noNota=<?php echo $myData['no_pembelian'] ?>" target="_blank">Print</a></td>
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