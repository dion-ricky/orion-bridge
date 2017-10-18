<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.connection.php";
include_once "library/inc.library.php";

$filter = isset($_GET['filter']) ? $_GET['filter'] : 'SEMUA';
?>
<h1>SALES DATA REPORTS PER CUSTOMER</h1>
<a href="?page=Laporan"><i class="fa fa-arrow-left fa-fw"></i>Back</a>
<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" target="_self">
  <table width="600" cellspacing="1" cellpadding="3">
    <tr>
      <td colspan="3" bgcolor="#EEEEEE">FILTER BY</td>
    </tr>
    <tr>
      <td width="130" nowrap="nowrap">Customer Name</td>
      <td width="3">:</td>
      <td width="443">
        <select name="cmbFilter" autofocus id="cmbFilter" onChange="filterHandler()">
          <option value="SEMUA">....</option>
          <?php
		  $sql = "SELECT * FROM pelanggan";
		  $qry = mysqli_query($koneksidb, $sql) or die ("Error list pelanggan: ".mysqli_error($koneksidb));
		  while ($data = mysqli_fetch_array($qry)) {
			  if($data['kd_pelanggan'] == $filter) {
				  $cek = "selected";
			  } else { $cek = ""; }
			  echo "<option value='$data[kd_pelanggan]' $cek>$data[nm_pelanggan]</option>";
		  }
		  ?>
      </select></td>
    </tr>
  </table>
</form>
<br>
<?php
if($filter == "SEMUA") {
	$sql = "SELECT penjualan.*, pelanggan.nm_pelanggan, user.nm_user FROM penjualan JOIN pelanggan ON penjualan.kd_pelanggan=pelanggan.kd_pelanggan JOIN user ON penjualan.kd_user=user.kd_user ORDER BY penjualan.no_penjualan";
} else {
	$sql = "SELECT penjualan.*, pelanggan.nm_pelanggan, user.nm_user FROM penjualan JOIN pelanggan ON penjualan.kd_pelanggan=pelanggan.kd_pelanggan JOIN user ON penjualan.kd_user=user.kd_user WHERE penjualan.kd_pelanggan='$filter' ORDER BY penjualan.no_penjualan";
}
$start = microtime(true);
$qry = mysqli_query($koneksidb, $sql) or die ("Error query listing: ".mysqli_error($koneksidb));
$end = microtime(true);
$duration = $end - $start;
if(mysqli_num_rows($qry)>=1) {
?>
<table width="800" cellspacing="1" cellpadding="3">
<tr>
<td bgcolor="#EEEEEE">Showing total rows: <?php echo mysqli_num_rows($qry); ?> (Query took <?php echo number_format($duration,4,'.',''); ?> seconds)</td>
</tr>
</table>
<table width="800" cellspacing="1" cellpadding="3" class="table-list">
  <tr>
    <th width="20" nowrap="nowrap" scope="col">No</th>
    <th width="120" nowrap="nowrap" scope="col">Transaction Code</th>
    <th width="130" nowrap="nowrap" scope="col">Date of Transaction</th>
    <th width="165" nowrap="nowrap" scope="col">Customer</th>
    <th width="126" nowrap="nowrap" scope="col">Information</th>
    <th width="150" nowrap="nowrap" scope="col">Operator</th>
    <th width="37" nowrap="nowrap" scope="col">Tools</th>
  </tr>
<?php
$nomor = 0;
while ($data = mysqli_fetch_array($qry)) {
	$nomor++;
?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td align="center"><?php echo $data['no_penjualan']; ?></td>
    <td align="center"><?php echo $data['tgl_penjualan']; ?></td>
    <td><?php echo $data['nm_pelanggan']; ?></td>
    <td><?php echo $data['keterangan']; ?></td>
    <td align="center"><?php echo $data['nm_user']; ?></td>
    <td align="center"><a href="cetak/penjualan_cetak.php?noNota=<?php echo $data['no_penjualan']; ?>&noprint" target="_blank">Print</a></td>
  </tr>
<?php } ?>
</table>
<?php
}
else {
	$errorSql = "SELECT nm_pelanggan FROM pelanggan WHERE kd_pelanggan='$filter'";
	$errorQry = mysqli_query($koneksidb, $errorSql) or die ("Error no trx: ".mysqli_error($koneksidb));
	$errorData = mysqli_fetch_array($errorQry);
	if(mysqli_num_rows($errorQry)>=1) {
		echo "No transaction history associated with customer '".$errorData['nm_pelanggan']."'";
	} else {
		echo "Customer with customer code '".$filter."' does not exist in the database!";
	}
}
?>
