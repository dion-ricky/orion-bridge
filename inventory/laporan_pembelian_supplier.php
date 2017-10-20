<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.connection.php";
include_once "library/inc.library.php";

$filter = isset($_GET['filter']) ? $_GET['filter'] : 'SEMUA';
?>
<h1>PURCHASE DATA REPORTS PER SUPPLIER</h1>
<a href="?page=Laporan"><i class="fa fa-arrow-left fa-fw"></i>Back</a>
<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" target="_self">
  <table width="600" cellspacing="1" cellpadding="3">
    <tr>
      <td colspan="3" bgcolor="#EEEEEE">FILTER BY</td>
    </tr>
    <tr>
      <td width="118" nowrap="nowrap">Supplier Name</td>
      <td width="3">:</td>
      <td width="455">
        <select name="cmbFilter" autofocus id="cmbFilter" onChange="filterHandler()">
          <option value="SEMUA">....</option>
          <?php
		  $sql = "SELECT * FROM supplier";
		  $qry = mysqli_query($koneksidb, $sql) or die ("Error list supplier: ".mysqli_error($koneksidb));
		  while ($data = mysqli_fetch_array($qry)) {
			  if($data['kd_supplier'] == $filter) {
				  $cek = "selected";
			  } else { $cek = ""; }
			  echo "<option value='$data[kd_supplier]' $cek>$data[nm_supplier]</option>";
		  }
		  ?>
      </select></td>
    </tr>
  </table>
</form>
<br>
<?php
if($filter == "SEMUA") {
	$sql = "SELECT pembelian.*, supplier.nm_supplier, user.nm_user FROM pembelian JOIN supplier ON pembelian.kd_supplier=supplier.kd_supplier JOIN user ON pembelian.kd_user=user.kd_user ORDER BY pembelian.no_pembelian";
} else {
	$sql = "SELECT pembelian.*, supplier.nm_supplier, user.nm_user FROM pembelian JOIN supplier ON pembelian.kd_supplier=supplier.kd_supplier JOIN user ON pembelian.kd_user=user.kd_user WHERE pembelian.kd_supplier='$filter' ORDER BY pembelian.no_pembelian";
}
$start = microtime(true);
$qry = mysqli_query($koneksidb, $sql) or die ("Error query listing: ".mysqli_error($koneksidb));
$end = microtime(true);
$duration = $end - $start;
if(mysqli_num_rows($qry)>=1) {
?>
<span><i>Query took <?php echo number_format($duration,4,'.',''); ?> seconds</i></span>
<table width="800" cellspacing="1" cellpadding="3" class="table-list">
  <tr>
    <th width="20" nowrap="nowrap" scope="col">No</th>
    <th width="120" nowrap="nowrap" scope="col">Transaction Code</th>
    <th width="130" nowrap="nowrap" scope="col">Date of Transaction</th>
    <th width="165" nowrap="nowrap" scope="col">Supplier</th>
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
    <td align="center"><?php echo $data['no_pembelian']; ?></td>
    <td align="center"><?php echo $data['tgl_pembelian']; ?></td>
    <td><?php echo $data['nm_supplier']; ?></td>
    <td><?php echo $data['keterangan']; ?></td>
    <td align="center"><?php echo $data['nm_user']; ?></td>
    <td align="center"><a href="cetak/pembelian_cetak.php?noNota=<?php echo $data['no_pembelian']; ?>" target="_blank">Print</a></td>
  </tr>
<?php } ?>
</table>
<?php
}
else {
	$errorSql = "SELECT nm_supplier FROM supplier WHERE kd_supplier='$filter'";
	$errorQry = mysqli_query($koneksidb, $errorSql) or die ("Error no trx: ".mysqli_error($koneksidb));
	$errorData = mysqli_fetch_array($errorQry);
	if(mysqli_num_rows($errorQry)>=1) {
		echo "No transaction history associated with supplier '".$errorData['nm_supplier']."'";
	} else {
		echo "Supplier with supplier code '".$filter."' does not exist in the database!";
	}
}
?>
