<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.connection.php";
include_once "library/inc.library.php";

$filter = isset($_GET['filter']) ? $_GET['filter'] : 'SEMUA';
?>
<h1>SALES DATA REPORTS PER ITEM</h1>
<a href="?page=Laporan"><i class="fa fa-arrow-left fa-fw"></i>Back</a>
<form id="filter">
<table width="600" cellspacing="1" cellpadding="3">
  <tr>
    <td colspan="3" bgcolor="#EEEEEE">FILTER BY</td>
  </tr>
  <tr>
    <td width="99" nowrap="nowrap">Item Name</td>
    <td width="3">:</td>
    <td width="474">
      <select name="cmbFilter" autofocus id="cmbFilter" onChange="filterHandler()">
        <option value="SEMUA">....</option>
        <?php
		$barangSql = "SELECT * FROM barang";
		$barangQry = mysqli_query($koneksidb, $barangSql) or die ("Error list barang: ".mysqli_error($koneksidb));
		while($barangData = mysqli_fetch_array($barangQry)) {
			if($barangData['kd_barang'] == $filter) {
				$cek = "selected";
			} else { $cek = ""; }
			echo "<option value='$barangData[kd_barang]' $cek>$barangData[nm_barang]</option>";
		}
		?>
    </select></td>
  </tr>
</table>
</form>
<br>
<?php
if(isset($_GET['filter']) && $_GET['filter'] != "SEMUA") {
	$sql = "SELECT penjualan_item.*, penjualan.*, pelanggan.nm_pelanggan, user.nm_user FROM penjualan_item JOIN penjualan ON penjualan_item.no_penjualan=penjualan.no_penjualan JOIN pelanggan ON penjualan.kd_pelanggan=pelanggan.kd_pelanggan JOIN user ON penjualan.kd_user=user.kd_user WHERE kd_barang='$filter' ORDER BY penjualan_item.no_penjualan";
} else if(!isset($_GET['filter']) || $_GET['filter'] == "SEMUA") {
	$sql = "SELECT penjualan_item.*, penjualan.*, pelanggan.nm_pelanggan, user.nm_user FROM penjualan_item JOIN penjualan ON penjualan_item.no_penjualan=penjualan.no_penjualan JOIN pelanggan ON penjualan.kd_pelanggan=pelanggan.kd_pelanggan JOIN user ON penjualan.kd_user=user.kd_user ORDER BY penjualan_item.no_penjualan";
}
$start = microtime(true);
$qry = mysqli_query($koneksidb, $sql) or die ("Error select sql: ".mysqli_error($koneksidb));
$end = microtime(true);
$duration = $end - $start;
if(mysqli_num_rows($qry)>=1) {
	$nomor = 0;
?>
<table width="800" cellpadding="3" cellspacing="1">
<tr>
<td bgcolor="#EEEEEE">Showing total rows: <?php echo mysqli_num_rows($qry); ?> (Query took <?php echo number_format($duration,4,'.',''); ?> seconds)</td>
</tr>
</table>
<table width="800" cellspacing="1" cellpadding="3" class="table-list">
  <tr>
    <th width="20" nowrap="nowrap" scope="col">No</th>
    <th width="145" nowrap="nowrap" scope="col">Transaction Code</th>
    <th width="167" nowrap="nowrap" scope="col">Customer</th>
    <th width="66" nowrap="nowrap" scope="col">Item</th>
    <th width="104" nowrap="nowrap" scope="col">Price</th>
    <th width="30" nowrap="nowrap" scope="col">Disc</th>
    <th width="25" nowrap="nowrap" scope="col">Qty</th>
    <th width="140" nowrap="nowrap" scope="col">Operator</th>
    <th width="37" nowrap="nowrap" scope="col">Tools</th>
  </tr>
  <?php
  while($myData = mysqli_fetch_array($qry)) {
	  $nomor++;
  ?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td align="center"><?php echo $myData['no_penjualan']; ?></td>
    <td><?php echo $myData['nm_pelanggan']; ?></td>
    <td align="center"><a href='#' onClick="window.open('search_info.php?kode=<?php echo $myData['kd_barang']; ?>','','width=630,height=330,left=100,top=25','')"><?php echo $myData['kd_barang']; ?></a></td>
    <td><?php echo rupiah($myData['harga_jual']); ?></td>
    <td align="center" nowrap="nowrap"><?php echo $myData['diskon'].'%' ?></td>
    <td align="center"><?php echo $myData['jumlah']; ?></td>
    <td align="center"><?php echo $myData['nm_user']; ?></td>
    <td align="center"><a href="cetak/penjualan_nota.php?noNota=<?php echo $myData['no_penjualan']; ?>&noprint" target="_blank">Print</a></td>
  </tr>
  <?php
  }
  ?>
</table>
<?php
} else {
	$checkSql = "SELECT nm_barang FROM barang WHERE kd_barang='$filter'";
	$checkQry = mysqli_query($koneksidb, $checkSql) or die ("Error checking sql: ".mysqli_error($koneksidb));
	$checkData = mysqli_fetch_array($checkQry);
	if(mysqli_num_rows($checkQry)>=1) {
		echo "No transaction history of item '$checkData[nm_barang]' in the database";
	} else {
		echo "Item with items code '$filter' does not exist in the database";
	}
}
?>