<?php
include_once "library/inc.connection.php";
include_once "library/inc.library.php";

$barangSql = "SELECT * FROM barang WHERE stok<=10";
$barangQry = mysqli_query($koneksidb, $barangSql) or die ("Error query: ".mysqli_error($koneksidb));
if (mysqli_num_rows($barangQry)>=1) {
	echo "<div class='msgBox' style='color:#CC1C2C'>";
	echo "<span class='icon-warning'></span><hr style='margin:8px'>";
	echo "&nbsp;&nbsp; ".mysqli_num_rows($barangQry)." item(s) need to restock!";
	echo "</div><br>";
?>
<table width="600" cellspacing="1" cellpadding="3" class="table-list">
  <tr>
    <th width="21" nowrap="nowrap" scope="col">No</th>
    <th width="97" nowrap="nowrap" scope="col">Barcode</th>
    <th width="378" nowrap="nowrap" scope="col">Items Name</th>
    <th width="67" nowrap="nowrap" scope="col">Stock</th>
    <th>Restock</th>
  </tr>
<?php
$nomor = 0;
while ($barangData = mysqli_fetch_array($barangQry)) {
	$nomor++;
?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td nowrap="nowrap"><?php echo $barangData['barcode']; ?></td>
    <td><?php echo $barangData['nm_barang']; ?></td>
    <td align="center"><?php echo $barangData['stok']; ?></td>
    <td align="center"><a href="pembelian?kode=<?php echo $barangData['barcode']; ?>&sk=<?php echo $barangData['kd_supplier']; ?> Restock by <?php echo $_SESSION['SES_NAME']; ?>" target="_blank">Buy</a></td>
  </tr>
<?php
	}
?>
</table>
<?php
} else {
?>
<h2>Welcome <i><?php echo $_SESSION['SES_NAME'];?></i>!!</h2>
<h3>You have a lot of goods in the database, have a good day!!!</h3>
<?php
}
?>