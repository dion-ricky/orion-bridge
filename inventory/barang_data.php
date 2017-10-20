<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.library.php";

$row = 50;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM barang";
$pageQry = mysqli_query($koneksidb, $pageSql) or die ("Error listing: ".mysqli_error($koneksidb));
$jml = mysqli_num_rows($pageQry);
$max = ceil($jml/$row);

?>
<table width="700" cellspacing="1" cellpadding="3">
  <tr>
    <td colspan="2" align="left"><h1>ITEMS DATA</h1></td>
  </tr>
  <tr>
    <td colspan="2"><a href="?page=Barang-Add">Add Data</a></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><table width="100%" cellspacing="1" cellpadding="3" class="table-list">
      <tr >
        <th width="5%" scope="col">No</th>
        <th width="10%" scope="col">Code</th>
        <th width="12%" scope="col">Barcode</th>
        <th width="24%" scope="col">Item Name</th>
        <th width="9%" scope="col">Stock</th>
        <th width="11%" scope="col">Purchase Price</th>
        <th width="11%" scope="col">Selling Price</th>
        <th colspan="2" scope="col">Tools</th>
        </tr>
        <?php
		$mySql = "SELECT * FROM barang ORDER BY kd_barang ASC LIMIT $hal,$row";
		$myQry = mysqli_query($koneksidb, $mySql) or die ("Error listing: ".mysqli_error($koneksidb));
		$nomor = 0;
		while ($myData = mysqli_fetch_array($myQry)) {
			$nomor++;
			$Kode = $myData['kd_barang'];
		?>
      <tr>
        <td align="center"><?php echo $nomor; ?></td>
        <td nowrap="nowrap"><?php echo $Kode; ?></td>
        <td nowrap="nowrap"><?php echo $myData['barcode']; ?></td>
        <td nowrap="nowrap"><?php echo $myData['nm_barang']; ?></td>
        <td><?php echo $myData['stok']; ?></td>
        <td nowrap="nowrap"><?php echo rupiah(format_angka($myData['harga_beli'])); ?></td>
        <td nowrap="nowrap"><?php echo rupiah(format_angka($myData['harga_jual'])); ?></td>
        <td width="10%" align="center"><a href="?page=Barang-Edit&Kode=<?php echo $Kode; ?>">Edit</a></td>
        <td width="8%" align="center"><a href="?page=Barang-Delete&Kode=<?php echo $Kode; ?>" onClick="return confirm('Are you sure you want to delete item <?php echo $Kode; ?>?')">Delete</a></td>
      </tr>
      <?php
	  }
	  ?>
    </table></td>
  </tr>
  <tr>
    <td width="521">Total Data: <?php echo $jml; ?></td>
    <td width="162" align="right">Page:
    <?php
	for ($h = 1; $h <= $max; $h++) {
		$list[$h] = $row * $h - $row;
		echo "<a href='?page=Barang-Data&hal=$list[$h]'>$h</a>";
		if($h<$max){
			echo ", ";
		}
	}
	?>
    </td>
  </tr>
</table>
