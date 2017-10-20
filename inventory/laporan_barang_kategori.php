<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.connection.php";
include_once "library/inc.library.php";

$dataKategori = isset($_GET['filter']) ? $_GET['filter'] : 'SEMUA';
?>
<h1>ITEM DATA REPORTS PER CATEGORY</h1>
<a href="?page=Laporan"><i class="fa fa-arrow-left fa-fw"></i>Back</a>
<form action="<?php $_SERVER['PHP_SELF']; ?>" target="_self">
  <table width="500" cellspacing="1" cellpadding="3">
    <tr>
      <td colspan="3" bgcolor="#EEEEEE">FILTER BY</td>
    </tr>
    <tr>
      <td width="63" nowrap="nowrap">Category</td>
      <td width="3">:</td>
      <td width="410">
        <select name="cmbFilter" autofocus id="cmbFilter" onChange="filterHandler()">
        <option value="SEMUA">....</option>
        <?php
		$dataSql = "SELECT * FROM kategori ORDER BY kd_kategori";
		$dataQry = mysqli_query($koneksidb, $dataSql) or die ("Error query: ".mysqli_error($koneksidb));
		while ($dataRow = mysqli_fetch_array($dataQry)) {
			if ($dataRow['kd_kategori'] == $dataKategori) {
				$cek = "selected";
			} else { $cek = ""; }
			echo "<option value='$dataRow[kd_kategori]' $cek>$dataRow[nm_kategori]</option>";
		}
		?>
      </select></td>
    </tr>
  </table>
</form>
<br>
<?php
if (isset($_GET['filter']) && $_GET['filter'] != "SEMUA") {
	$getSql = "SELECT barang.*, kategori.nm_kategori FROM barang JOIN kategori ON barang.kd_kategori=kategori.kd_kategori WHERE barang.kd_kategori='$dataKategori' ORDER BY kategori.kd_kategori";
} else if(!isset($_GET['filter']) || $_GET['filter'] == "SEMUA") {
	$getSql = "SELECT barang.*, kategori.nm_kategori FROM barang JOIN kategori ON barang.kd_kategori=kategori.kd_kategori ORDER BY kategori.kd_kategori";
}
$start = microtime(true);
$getQry = mysqli_query($koneksidb, $getSql) or die ("Error get query: ".mysqli_error($koneksidb));
$end = microtime(true);
$duration = $end - $start;
if(mysqli_num_rows($getQry)>=1) {
	$nomor = 0;
?>
<table width="700" cellspacing="1" cellpadding="3">
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
    <th width="102" nowrap="nowrap" scope="col">Category</th>
    <th width="56" nowrap="nowrap" scope="col">Stock</th>
    <th width="135" nowrap="nowrap" scope="col">Selling Price</th>
  </tr>
<?php
		while($getData = mysqli_fetch_array($getQry)) {
			$nomor++;
?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $getData['kd_barang']; ?></td>
    <td nowrap="nowrap"><?php echo $getData['barcode']; ?></td>
    <td><?php echo $getData['nm_barang']; ?></td>
    <td><?php echo $getData['nm_kategori']; ?></td>
    <td><?php echo $getData['stok']; ?></td>
    <td><?php echo rupiah(format_angka($getData['harga_jual'])); ?></td>
  </tr>
<?php
		}
?>
</table>
<?php
	} else {
		$kategoriSql = "SELECT nm_kategori FROM kategori WHERE kd_kategori='$dataKategori'";
		$kategoriQry = mysqli_query($koneksidb, $kategoriSql) or die ("Error query kategori: ".mysqli_error($koneksidb));
		$kategoriData = mysqli_fetch_array($kategoriQry);
		if(mysqli_num_rows($kategoriQry)>=1) {
			echo "No items associated under category '".$kategoriData['nm_kategori']."'<br>";
		} else {
			echo "Category with code '$dataKategori' does not exists in the database!";
		}
	}
?>