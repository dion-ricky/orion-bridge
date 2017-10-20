<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.connection.php";
include_once "library/inc.library.php";

$dataSupplier = isset($_GET['filter']) ? $_GET['filter'] : 'SEMUA';
?>
<h1>ITEM DATA REPORTS PER SUPPLIER</h1>
<a href="?page=Laporan"><i class="fa fa-arrow-left fa-fw"></i>Back</a>
<form action="<?php $_SERVER['PHP_SELF']; ?>" target="_self">
  <table width="500" cellspacing="1" cellpadding="3">
    <tr>
      <td colspan="3" bgcolor="#EEEEEE">FILTER BY</td>
    </tr>
    <tr>
      <td width="119" nowrap="nowrap">Supplier Name</td>
      <td width="3">:</td>
      <td width="354">
        <select name="cmbFilter" autofocus id="cmbFilter" onChange="filterHandler()">
        <option value="SEMUA">....</option>
        <?php
		$dataSql = "SELECT * FROM supplier ORDER BY kd_supplier";
		$dataQry = mysqli_query($koneksidb, $dataSql) or die ("Error query: ".mysqli_error($koneksidb));
		while ($dataRow = mysqli_fetch_array($dataQry)) {
			if ($dataRow['kd_supplier'] == $dataSupplier) {
				$cek = "selected";
			} else { $cek = ""; }
			echo "<option value='$dataRow[kd_supplier]' $cek>$dataRow[nm_supplier]</option>";
		}
		?>
      </select></td>
    </tr>
  </table>
</form>
<br>
<?php
if (isset($_GET['filter']) && $_GET['filter'] != "SEMUA") {
	$getSql = "SELECT barang.*, supplier.nm_supplier FROM barang JOIN supplier ON barang.kd_supplier=supplier.kd_supplier WHERE barang.kd_supplier='$dataSupplier' ORDER BY supplier.kd_supplier";
} else if(!isset($_GET['filter']) || $_GET['filter'] == "SEMUA") {
	$getSql = "SELECT barang.*, supplier.nm_supplier FROM barang JOIN supplier ON barang.kd_supplier=supplier.kd_supplier ORDER BY supplier.kd_supplier";
}
	$start = microtime(true);
	$getQry = mysqli_query($koneksidb, $getSql) or die ("Error get query: ".mysqli_error($koneksidb));
	$end = microtime(true);
	$duration = $end - $start;
	if(mysqli_num_rows($getQry)>=1) {
		$nomor = 0;
?>
<table width="700" cellpadding="3" cellspacing="1">
<tr>
<td colspan="7" bgcolor="#EEEEEE">Showing total rows: <?php echo mysqli_num_rows($getQry); ?> item(s) (Query took <?php echo number_format($duration,4,'.',''); ?> seconds)</td>
</tr>
</table>
<table width="700" cellspacing="1" cellpadding="3" class="table-list">
  <tr>
    <th width="20" nowrap="nowrap" scope="col">No</th>
    <th width="81" nowrap="nowrap" scope="col">Code</th>
    <th width="75" nowrap="nowrap" scope="col">Barcode</th>
    <th width="179" nowrap="nowrap" scope="col">Item Name</th>
    <th width="118" nowrap="nowrap" scope="col">Supplier</th>
    <th width="40" nowrap="nowrap" scope="col">Stock</th>
    <th width="135" nowrap="nowrap" scope="col">Selling Price</th>
  </tr>
<?php
		while($getData = mysqli_fetch_array($getQry)) {
			$nomor++;
?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $getData['kd_barang']; ?></td>
    <td><?php echo $getData['barcode']; ?></td>
    <td><?php echo $getData['nm_barang']; ?></td>
    <td><?php echo $getData['nm_supplier']; ?></td>
    <td><?php echo $getData['stok']; ?></td>
    <td><?php echo rupiah(format_angka($getData['harga_jual'])); ?></td>
  </tr>
<?php
		}
?>
</table>
<?php
	} else {
		$supplierSql = "SELECT nm_supplier FROM supplier WHERE kd_supplier='$dataSupplier'";
		$supplierQry = mysqli_query($koneksidb, $supplierSql) or die ("Error query supplier: ".mysqli_error($koneksidb));
		$supplierData = mysqli_fetch_array($supplierQry);
		if(mysqli_num_rows($supplierQry)>=1) {
			echo "No items associated under supplier '".$supplierData['nm_supplier']."'<br>";
		} else {
			echo "Supplier with code '$dataSupplier' does not exists in the database";
		}
	}
?>