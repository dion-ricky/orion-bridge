<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.connection.php";
include_once "library/inc.library.php";

$dateFrom = isset($_POST['dateFrom']) ? $_POST['dateFrom'] : date('Y-m-d');
$dateUntil = isset($_POST['dateUntil']) ? $_POST['dateUntil'] : date('Y-m-d');
$maxDate = date('Y-m-d');
?>
<h1>PURCHASE DATA REPORTS PER PERIOD</h1>
<a href="?page=Laporan"><i class="fa fa-arrow-left fa-fw"></i>Back</a>
<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" target="_self" id="filter" name="filter">
<table width="500" cellspacing="1" cellpadding="3">
  <tr>
    <td colspan="5" bgcolor="#EEEEEE">FILTER BY</td>
    </tr>
  <tr>
    <td width="92" nowrap="nowrap">Period</td>
    <td width="3">:</td>
    <td width="144">
      <input name="dateFrom" type="date" id="dateFrom" max="<?php echo $maxDate; ?>" value="<?php echo $dateFrom; ?>" onChange="filterPeriod()"></td>
    <td width="18">until</td>
    <td width="305">
      <input type="date" name="dateUntil" id="dateUntil" max="<?php echo $maxDate; ?>" value="<?php echo $dateUntil; ?>" onChange="filterPeriod()"></td>
  </tr>
</table>
</form>
<br>
<?php
	$mySql = "SELECT pembelian.*, supplier.nm_supplier, user.nm_user FROM pembelian JOIN supplier ON pembelian.kd_supplier=supplier.kd_supplier JOIN user ON pembelian.kd_user=user.kd_user WHERE pembelian.tgl_pembelian BETWEEN '$dateFrom' AND '$dateUntil' ORDER BY pembelian.no_pembelian";
	$start = microtime(true);
	$myQry = mysqli_query($koneksidb, $mySql) or die ("Error select query: ".mysqli_error($koneksidb));
	$end = microtime(true);
	$duration = $end - $start;
	if (mysqli_num_rows($myQry)>=1) {
		$nomor = 0;
?>
<span><i>Query took <?php echo number_format($duration,4,'.',''); ?> seconds</i></span>
<table width="800" cellspacing="1" cellpadding="3" class="table-list">
  <tr>
    <th width="20" nowrap="nowrap" scope="col">No</th>
    <th width="125" nowrap="nowrap" scope="col">Transaction Code</th>
    <th width="125" nowrap="nowrap" scope="col">Date of Transaction</th>
    <th width="179" nowrap="nowrap" scope="col">Supplier</th>
    <th width="130" nowrap="nowrap" scope="col">Information</th>
    <th width="132" nowrap="nowrap" scope="col">Operator</th>
    <th width="37" nowrap="nowrap" scope="col">Tools</th>
  </tr>
<?php
while ($myData = mysqli_fetch_array($myQry)) {
	$nomor++;
?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td align="center"><?php echo $myData['no_pembelian']; ?></td>
    <td align="center"><?php echo IndonesiaTgl($myData['tgl_pembelian']); ?></td>
    <td><?php echo $myData['nm_supplier']; ?></td>
    <td><?php echo $myData['keterangan']; ?></td>
    <td align="center"><?php echo $myData['nm_user']; ?></td>
    <td align="center"><a href="cetak/pembelian_cetak.php?noNota=<?php echo $myData['no_pembelian']; ?>" target="_blank">Print</a></td>
  </tr>
<?php
}
?>
</table>
<?php
	}
	else {
		if($dateFrom == $dateUntil) {
			echo "No transaction records in database on $dateFrom";
		} else {
			echo "No transaction records in the database for period $dateFrom until $dateUntil";
		}
	}
?>